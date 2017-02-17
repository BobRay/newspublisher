<?php
/**
 * systemSettings transport file for NewsPublisher extra
 *
 * Copyright 2013-2017 by Bob Ray <http://bobsguides.com>
 * Created on 02-09-2017
 *
 * @package newspublisher
 * @subpackage build
 */

if (! function_exists('stripPhpTags')) {
    function stripPhpTags($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<' . '?' . 'php', '', $o);
        $o = str_replace('?>', '', $o);
        $o = trim($o);
        return $o;
    }
}
/* @var $modx modX */
/* @var $sources array */
/* @var xPDOObject[] $systemSettings */


$systemSettings = array();

$systemSettings[1] = $modx->newObject('modSystemSetting');
$systemSettings[1]->fromArray(array (
  'key' => 'np_tinymce_skin',
  'value' => 'modxPericles',
  'xtype' => 'textfield',
  'namespace' => 'newspublisher',
  'area' => 'TinyMCE',
  'name' => 'TinyMCE skin',
  'description' => 'setting_np_tinymce_skin_desc',
), '', true, true);
$systemSettings[2] = $modx->newObject('modSystemSetting');
$systemSettings[2]->fromArray(array (
  'key' => 'np_elfinder_tmb_size',
  'value' => '150',
  'xtype' => 'textfield',
  'namespace' => 'newspublisher',
  'area' => 'elFinder',
  'name' => 'elFinder Thumb Size',
  'description' => 'setting_np_elfinder_tmb_size_desc',
), '', true, true);
$systemSettings[3] = $modx->newObject('modSystemSetting');
$systemSettings[3]->fromArray(array (
  'key' => 'np_elfinder_remember_last_dir',
  'value' => 'false',
  'xtype' => 'combo-boolean',
  'namespace' => 'newspublisher',
  'area' => 'elFinder',
  'name' => 'elFinder remember last dir',
  'description' => 'setting_np_elfinder_remember_last_dir_desc',
), '', true, true);
$systemSettings[4] = $modx->newObject('modSystemSetting');
$systemSettings[4]->fromArray(array (
  'key' => 'np_elfinder_theme',
  'value' => 'osx',
  'xtype' => 'textfield',
  'namespace' => 'newspublisher',
  'area' => 'elFinder',
  'name' => 'elFinder Theme',
  'description' => 'setting_np_elfinder_theme_desc',
), '', true, true);
return $systemSettings;
