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
  'key' => 'np_elfinder_theme',
  'name' => 'NewsPublisher elFinder Theme',
  'description' => 'setting_np_elfinder_theme_desc',
  'namespace' => 'newspublisher',
  'xtype' => 'textfield',
  'value' => 'osx',
  'area' => 'newspublisher',
), '', true, true);
return $systemSettings;
