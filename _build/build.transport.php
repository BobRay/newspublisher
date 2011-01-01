<?php
/**
 * NewsPublisher
 *
 * @package NewsPublisher
 * @version 1.0.0
 * @release Beta1
 * @author Bob Ray <http://bobsguides.com>
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

/* define sources */
$root = dirname(dirname(__FILE__)) . '/';
$sources= array (
    'root' => $root,
    'build' => $root . '_build/',
    'source_core' => $root . 'core/components/newspublisher',
    'source_assets' => $root . 'assets/components/newspublisher',
);
unset($root);

/* instantiate MODx */
require_once $sources['build'].'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');
$modx->setLogLevel(xPDO::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

/* set package info */
define('PKG_NAME','newspublisher');
define('PKG_VERSION','1.0.0');
define('PKG_RELEASE','Beta1');

/* load builder */
$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace('newspublisher',false,true,'{core_path}components/newspublisher/');

/* create snippet objects */

$modx->log(xPDO::LOG_LEVEL_INFO,'Adding in snippet: Newspublisher'); flush();
$snippet= $modx->newObject('modSnippet');
$snippet->set('name', 'NewsPublisher');
$snippet->set('description', '<strong>'.PKG_VERSION.'-'.PKG_RELEASE.'</strong> A front-end resource editing snippet for MODx Revolution');
//$snippet->set('category', 0);
$snippet->set('snippet', file_get_contents($sources['build'] . '/elements/newspublisher.snippet.php'));
$properties = include $sources['build'].'data/properties.newspublisher.php';
if (!is_array($properties)) $modx->log(modX::LOG_LEVEL_FATAL,'No properties returned for NewsPublisher.');
$snippet->setProperties($properties);
unset($properties);


/* create a transport vehicle for the data object */
$vehicle = $builder->createVehicle($snippet,array(
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'name',
));
$vehicle->resolve('file',array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));
$vehicle->resolve('file',array(
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';",
));
$builder->putVehicle($vehicle);

/* create snippet objects */

$modx->log(xPDO::LOG_LEVEL_INFO,'Adding in snippet: NpEditThisButton'); flush();
$snippet= $modx->newObject('modSnippet');
$snippet->set('name', 'NpEditThisButton');
$snippet->set('description', '<strong>'.PKG_VERSION.'-'.PKG_RELEASE.'</strong> An edit button for NewsPublisher in MODx Revolution');
//$snippet->set('category', 0);
$snippet->set('snippet', file_get_contents($sources['build'] . '/elements/npeditthisbutton.snippet.php'));
$properties = include $sources['build'].'data/properties.npeditthisbutton.php';
if (!is_array($properties)) $modx->log(modX::LOG_LEVEL_FATAL,'No properties returned for NpEditThisButton.');
$snippet->setProperties($properties);
unset($properties);


/* create a transport vehicle for the data object */
$vehicle = $builder->createVehicle($snippet,array(
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'name',
));
$builder->putVehicle($vehicle);

/* now pack in the license file, readme.txt and setup options */
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['source_core'] . '/docs/license.txt'),
    'readme' => file_get_contents($sources['source_core'] . '/docs/readme.txt'),
));

/* zip up the package */
$builder->pack();

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

$modx->log(xPDO::LOG_LEVEL_INFO, "Package Built.");
$modx->log(xPDO::LOG_LEVEL_INFO, "Execution time: {$totalTime}");
exit();
