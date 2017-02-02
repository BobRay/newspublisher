<?php
/**
 * Properties file for npElFinderConnector snippet
 *
 * Copyright 2013-2017 by Bob Ray <http://bobsguides.com>
 * Created on 02-02-2017
 *
 * @package newspublisher
 * @subpackage build
 */




$properties = array (
  'browserBasePath' => 
  array (
    'name' => 'browserBasePath',
    'desc' => 'browser_base_path_desc~~Users can browse below this directory, but not above it. Must match browserBaseURL setting.',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => '[[++base_path]]assets',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'browserBaseURL' => 
  array (
    'name' => 'browserBaseURL',
    'desc' => 'browser_base_url_desc~~Users can browse below this URL, but not above it. Must Match browserBasePath settins.',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => '[[++base_url]]assets',
    'lexicon' => 'newsputblisher:properties',
    'area' => '',
  ),
  'browserStartPath' => 
  array (
    'name' => 'browserStartPath',
    'desc' => 'browser_start_path_desc~~Set this to start the browser in a directory below the browserBasePath. Must Match browserStart URL. Default: browserBasePath.',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => '',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'browserStartURL' => 
  array (
    'name' => 'browserStartURL',
    'desc' => 'browser_start_url_desc~~Set this to start browsing in a directory below browserBaseURL. Must match browserStartPath. Required only if browserStartPath is set.',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => '',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'disableCommands' => 
  array (
    'name' => 'disableCommands',
    'desc' => 'disable_commands_desc~~Comma-separated list of commands to disable. To enable a command, delete it from the list.
<br><br>
<b>Default:</b> archive, download\', cut, copy, paste, duplicate, edit, open, mkdir, mkfile, netmount, netunmount, rm, rename, quicklook, upload, view.
<br><br>
<b>Possible Commands:</b> archive, back, chmod, colwidth, copy, cut, download, duplicate, edit, extract, forward, fullscreen, getfile, help, home, info, 
mkdir, mkfile, netmount, netunmount, open, opendir, paste, places, quicklook, reload, rename, resize, rm,  search, sort, up, upload, view. ',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => 'archive, download\', cut, copy, paste, duplicate, edit, open, mkdir, mkfile, netmount, netunmount, rm, rename, quicklook, upload, view',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'driver' => 
  array (
    'name' => 'driver',
    'desc' => 'driver_desc~~Driver type for file browser (for future use).',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => 'LocalFileSystem',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'locale' => 
  array (
    'name' => 'locale',
    'desc' => 'locale_desc~~Locale setting. Will use MODX locale System Setting if empty.',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => '',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'tmbPath' => 
  array (
    'name' => 'tmbPath',
    'desc' => 'tmb_path_desc~~path to directory to store thumbnails on upload; default: .tmb',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => '.tmb',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'tmbSize' => 
  array (
    'name' => 'tmbSize',
    'desc' => 'tmb_size_desc~~Size of thumbnails in pixels. This only works when uploading. To change it, delete thumbs and re-upload.',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => '150',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'uploadAllow' => 
  array (
    'name' => 'uploadAllow',
    'desc' => 'upload_allow_desc~~Comma-separated list of mime types to allow; default: image, text/plain.',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => '',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'uploadAllowOverwrite' => 
  array (
    'name' => 'uploadAllowOverwrite',
    'desc' => 'upload_allow_overwrite_desc~~Allow overwriting of existing files when uploading; Default: true.',
    'type' => 'combo-boolean',
    'options' => 
    array (
    ),
    'value' => true,
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'uploadMaxSize' => 
  array (
    'name' => 'uploadMaxSize',
    'desc' => 'upload_max_size~~Maximum upload file size. This size is per files. Can be set as number or string with unit 10M, 500K, 1G. Note you still have to configure PHP files upload limits. Default: 0 (use PHP max size).',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => '0',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
);

return $properties;

