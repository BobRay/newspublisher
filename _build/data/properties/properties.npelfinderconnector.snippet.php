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
    'desc' => 'browser_base_path_desc',
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
    'desc' => 'browser_base_url_desc',
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
    'desc' => 'browser_start_path_desc',
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
    'desc' => 'browser_start_url_desc',
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
    'desc' => 'disable_commands_desc',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => 'archive, download, cut, copy, paste, duplicate, edit, open, mkdir, mkfile, netmount, netunmount, rm, rename, quicklook, upload, view',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'driver' => 
  array (
    'name' => 'driver',
    'desc' => 'driver_desc',
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
    'desc' => 'locale_desc',
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
    'desc' => 'tmb_path_desc',
    'type' => 'textfield',
    'options' => 
    array (
    ),
    'value' => '.tmb',
    'lexicon' => 'newspublisher:properties',
    'area' => '',
  ),
  'uploadAllow' => 
  array (
    'name' => 'uploadAllow',
    'desc' => 'upload_allow_desc',
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
    'desc' => 'upload_allow_overwrite_desc',
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
    'desc' => 'upload_max_size',
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

