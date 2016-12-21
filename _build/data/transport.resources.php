<?php
/**
 * resources transport file for NewsPublisher extra
 *
 * Copyright 2013-2015 by Bob Ray <http://bobsguides.com>
 * Created on 12-20-2016
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
/* @var xPDOObject[] $resources */


$resources = array();

$resources[1] = $modx->newObject('modResource');
$resources[1]->fromArray(array (
  'id' => 1,
  'pagetitle' => 'npElFinderConnector',
  'alias' => 'npelfinderconnector',
  'context_key' => 'web',
  'template' => 'npElFinderConnectorTemplate',
  'richtext' => false,
  'published' => true,
  'class_key' => 'modDocument',
  'hidemenu' => '0',
  'cacheable' => '1',
  'searchable' => '1',
), '', true, true);
$resources[1]->setContent(file_get_contents($sources['data'].'resources/npelfinderconnector.content.html'));

return $resources;
