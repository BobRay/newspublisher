<?php
error_reporting(0); // Set E_ALL for debugging

// load composer autoload before load elFinder autoload If you need composer
//require './vendor/autoload.php';

// elFinder autoload
// require './autoload.php';
$assetsPath = $modx->getOption('np.assets_path', null, $modx->getOption('assets_path', null) . 'components/newspublisher/');

// require 'C:/xampp/htdocs/addons/assets/mycomponents/newspublisher/assets/components/newspublisher/elfinder/php/autoload.php';

require $assetsPath . 'elfinder/php/autoload.php';
// ===============================================

// Enable FTP connector netmount
elFinder::$netDrivers['ftp'] = 'FTP';
// ===============================================

/**
 * # Dropbox volume driver need `composer require dropbox-php/dropbox-php:dev-master@dev`
 *  OR "dropbox-php's Dropbox" and "PHP OAuth extension" or "PEAR's HTTP_OAUTH package"
 * * dropbox-php: http://www.dropbox-php.com/
 * * PHP OAuth extension: http://pecl.php.net/package/oauth
 * * PEAR's HTTP_OAUTH package: http://pear.php.net/package/http_oauth
 *  * HTTP_OAUTH package require HTTP_Request2 and Net_URL2
 */
// // Required for Dropbox.com connector support
// // On composer
// elFinder::$netDrivers['dropbox'] = 'Dropbox';
// // OR on pear
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDropbox.class.php';

// // Dropbox driver need next two settings. You can get at https://www.dropbox.com/developers
// define('ELFINDER_DROPBOX_CONSUMERKEY',    '');
// define('ELFINDER_DROPBOX_CONSUMERSECRET', '');
// define('ELFINDER_DROPBOX_META_CACHE_PATH',''); // optional for `options['metaCachePath']`
// ===============================================

// // Required for Google Drive network mount
// // Installation by composer
// // `composer require google/apiclient:^2.0`
// // Enable network mount
// elFinder::$netDrivers['googledrive'] = 'GoogleDrive';
// // GoogleDrive Netmount driver need next two settings. You can get at https://console.developers.google.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL?cmd=netmount&protocol=googledrive&host=1"
// define('ELFINDER_GOOGLEDRIVE_CLIENTID',     '');
// define('ELFINDER_GOOGLEDRIVE_CLIENTSECRET', '');
// // Required case of without composer
// define('ELFINDER_GOOGLEDRIVE_GOOGLEAPICLIENT', '/path/to/google-api-php-client/vendor/autoload.php');
// ===============================================

// // Required for Google Drive network mount with Flysystem
// // Installation by composer
// // `composer require nao-pon/flysystem-google-drive:~1.1 nao-pon/elfinder-flysystem-driver-ext`
// // Enable network mount
// elFinder::$netDrivers['googledrive'] = 'FlysystemGoogleDriveNetmount';
// // GoogleDrive Netmount driver need next two settings. You can get at https://console.developers.google.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL?cmd=netmount&protocol=googledrive&host=1"
// define('ELFINDER_GOOGLEDRIVE_CLIENTID',     '');
// define('ELFINDER_GOOGLEDRIVE_CLIENTSECRET', '');
// ===============================================

// // Required for One Drive network mount
// //  * cURL PHP extension required
// //  * HTTP server PATH_INFO supports required
// // Enable network mount
// elFinder::$netDrivers['onedrive'] = 'OneDrive';
// // GoogleDrive Netmount driver need next two settings. You can get at https://dev.onedrive.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL/netmount/onedrive/1"
// define('ELFINDER_ONEDRIVE_CLIENTID',     '');
// define('ELFINDER_ONEDRIVE_CLIENTSECRET', '');
// ===============================================

// // Required for Box network mount
// //  * cURL PHP extension required
// // Enable network mount
// elFinder::$netDrivers['box'] = 'Box';
// // Box Netmount driver need next two settings. You can get at https://developer.box.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL"
// define('ELFINDER_BOX_CLIENTID',     '');
// define('ELFINDER_BOX_CLIENTSECRET', '');
// ===============================================

/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume) {
    return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
        ? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
        :  null;                                    // else elFinder decide it itself
}

if ((!$modx->user->hasSessionContext($modx->context->get('key'))) && (!$modx->user->get('sudo'))) {
    die('Unauthorized');
}

if (!$modx->hasPermission('file_manager') && (!$modx->user->get("sudo"))) {
    die ('Unauthorized File Manager');
}

// Documentation for connector options:
// https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options

/* @var $scriptProperties array */

$path='';
$url = '';
$startPath = '';

$driver = $modx->getOption('driver', $scriptProperties, 'LocalFileSystem', true);
$mediaSourceId =  $modx->getOption('media_source', $_GET, null, true);
unset($_GET['media_source']);


if ($mediaSourceId !== null) {
    $ms = $modx->getObject('modMediaSource', (int) $mediaSourceId);
    if ($ms) {
        $ms->initialize();
        $bases = $ms->getBases();
        $path = $bases['path'];
        $url =  $bases['url'];
        $startPath = $path;
    }
}

if (empty($path)) {
    $path = $modx->getOption('browserBasePath', $scriptProperties, $modx->getOption('base_path') . 'assets', true);
}
if (empty($startPath)) {
    $startPath = $modx->getOption('browserStartPath', $scriptProperties, $path, true);
}
if (empty($url)) {
    $url = $modx->getOption('browserStartURL', $scriptProperties, $modx->getOption('base_url') . 'assets', true);
}

// Remove any trailing slashes
$path = rtrim($path, '/\\');
$startPath = rtrim($path, '/\\');
$url = rtrim($url, '/\\');

$locale = $modx->getOption('locale', $scriptProperties, $modx->getOption('locale', null), true);

$tmbSize = $modx->getOption('tmbSize', null, 150, true); // System Setting
$tmbCrop = false;
$tmbPath = $modx->getOption('tmbPath', $scriptProperties, '.tmb');
$uploadOverwrite = $modx->getOption('uploadAllowOverwrite', $scriptProperties, true, true);
$uploadAllow = $modx->getOption('uploadAllow', $scriptProperties, '', true); // Mimetype `image` and `text/plain` allowed to upload
if (!empty($uploadAllow)) {
    $uploadAllow = array_map('trim', explode(',', $uploadAllow));
} else {
    $uploadAllow = array('image', 'text/plain');
}

$uploadMaxSize = $modx->getOption('uploadMaxSize', $scriptProperties, 0, true);
$disable = $modx->getOption('disableCommands', $scriptProperties, '', true);

if (!empty($disable)) {
   $disabledCommands = array_map('trim', explode(',', $disable));
} else {
   $disabledCommands = array('archive', 'download', 'cut', 'copy', 'paste', 'duplicate', 'edit', 'open', 'mkdir', 'mkfile', 'netmount', 'netunmount', 'rm', 'rename', 'quicklook',     'upload', 'view');
}

/* Possible commands:  'archive', 'back', 'chmod', 'colwidth', 'copy', 'cut', 'download', 'duplicate',
    'edit', 'extract', 'forward', 'fullscreen', 'getfile', 'help', 'home', 'info',
    'mkdir', 'mkfile', 'netmount', 'netunmount', 'open', 'opendir', 'paste', 'places',
    'quicklook', 'reload', 'rename', 'resize', 'rm', 'search', 'sort', 'up', 'upload', 'view' */


$opts = array(

    'roots' => array(
        array(
            'driver'            => $driver,             // driver for accessing file system (REQUIRED)
            'path'              => $path,
            'startPath'         => $startPath,
            'URL'               => $url,
            'uploadOverwrite'   => $uploadOverwrite,
            'uploadDeny'        => array('all'),        // All Mimetypes not allowed to upload
            'uploadAllow'       => $uploadAllow,
            'uploadOrder'       => array('deny', 'allow'),
            'tmbSize'           => $tmbSize,
            'tmbCrop'           => false,
            'tmbPath'           => $tmbPath,
            'accessControl'     => 'access',            // disable and hide dot starting files (OPTIONAL)
            'acceptedName'      => '/^[^\.].*$/',
            'disabled'          => $disabledCommands,
        )
    ),
    
);

if (!empty($locale)) {
    $opts['locale'] = $locale;
}
// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();
return '';