<?php
/**
 * chunks transport file for NewsPublisher extra
 *
 * Copyright 2013-2025 Bob Ray <https://bobsguides.com>
 * Created on 02-06-2017
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
/* @var xPDOObject[] $chunks */


$chunks = array();

$chunks[1] = $modx->newObject('modChunk');
$chunks[1]->fromArray(array (
  'id' => 1,
  'property_preprocess' => false,
  'name' => 'npTinymceInitTpl',
  'description' => 'Javascript configuration code for TinyMCE in Newspublisher',
  'properties' => 
  array (
  ),
), '', true, true);
$chunks[1]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nptinymceinittpl.chunk.tpl'));

return $chunks;
