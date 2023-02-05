<?php
/**
 * systemSettings transport file for NewsPublisher extra
 *
 * Copyright 2013-2023 Bob Ray <https://bobsguides.com>
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
  'key' => 'np_media_source_var',
  'value' => 'media_source',
  'xtype' => 'textfield',
  'namespace' => 'newspublisher',
  'area' => 'elFinder',
  'name' => 'setting_np_media_source_var',
  'description' => 'setting_np_media_source_var_desc',
), '', true, true);
$systemSettings[2] = $modx->newObject('modSystemSetting');
$systemSettings[2]->fromArray(array (
  'key' => 'np_elfinder_theme',
  'value' => 'osx',
  'xtype' => 'textfield',
  'namespace' => 'newspublisher',
  'area' => 'elFinder',
  'name' => 'setting_np_elfinder_theme',
  'description' => 'setting_np_elfinder_theme_desc',
), '', true, true);
$systemSettings[3] = $modx->newObject('modSystemSetting');
$systemSettings[3]->fromArray(array (
  'key' => 'np_elfinder_remember_last_dir',
  'value' => '0',
  'xtype' => 'combo-boolean',
  'namespace' => 'newspublisher',
  'area' => 'elFinder',
  'name' => 'setting_np_elfinder_remember_last_dir',
  'description' => 'setting_np_elfinder_remember_last_dir_desc',
), '', true, true);
$systemSettings[4] = $modx->newObject('modSystemSetting');
$systemSettings[4]->fromArray(array (
  'key' => 'np_elfinder_tmb_size',
  'value' => '48',
  'xtype' => 'textfield',
  'namespace' => 'newspublisher',
  'area' => 'elFinder',
  'name' => 'setting_np_elfinder_tmb_size',
  'description' => 'setting_np_elfinder_tmb_size_desc',
), '', true, true);
$systemSettings[5] = $modx->newObject('modSystemSetting');
$systemSettings[5]->fromArray(array (
  'key' => 'np_elfinder_width',
  'value' => '80',
  'xtype' => 'textfield',
  'namespace' => 'newspublisher',
  'area' => 'elFinder',
  'name' => 'setting_np_elfinder_width',
  'description' => 'setting_np_elfinder_width_desc',
), '', true, true);
$systemSettings[6] = $modx->newObject('modSystemSetting');
$systemSettings[6]->fromArray(array (
  'key' => 'np_elfinder_height',
  'value' => '80',
  'xtype' => 'textfield',
  'namespace' => 'newspublisher',
  'area' => 'elFinder',
  'name' => 'setting_np_elfinder_height',
  'description' => 'setting_np_elfinder_height_desc',
), '', true, true);
$systemSettings[7] = $modx->newObject('modSystemSetting');
$systemSettings[7]->fromArray(array (
  'key' => 'np_tinymce_skin',
  'value' => 'modxPericles',
  'xtype' => 'textfield',
  'namespace' => 'newspublisher',
  'area' => 'TinyMCE',
  'name' => 'setting_np_tinymce_skin',
  'description' => 'setting_np_tinymce_skin_desc',
), '', true, true);
$systemSettings[8] = $modx->newObject('modSystemSetting');
$systemSettings[8]->fromArray(array (
  'key' => 'np_login_id',
  'value' => '',
  'xtype' => 'textfield',
  'namespace' => 'newspublisher',
  'area' => 'NewsPublisher',
  'name' => 'setting_np_login_id',
  'description' => 'setting_np_login_id_desc',
), '', true, true);
$systemSettings[9] = $modx->newObject('modSystemSetting');
$systemSettings[9]->fromArray(array (
  'key' => 'np_login_redirect',
  'value' => '1',
  'xtype' => 'combo-boolean',
  'namespace' => 'newspublisher',
  'area' => 'NewsPublisher',
  'name' => 'setting_np_login_redirect',
  'description' => 'setting_np_login_redirect_desc',
), '', true, true);
return $systemSettings;
