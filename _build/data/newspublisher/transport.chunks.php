<?php
/**
 * chunks transport file for NewsPublisher extra
 *
 * Copyright 2013-2017 by Bob Ray <https://bobsguides.com>
 * Created on 07-11-2014
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
  'name' => 'npFieldErrorTpl',
  'description' => 'Tpl chunk used to display field-specific errors above each NewsPublisher field',
  'properties' => NULL,
), '', true, true);
$chunks[1]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npfielderrortpl.chunk.tpl'));

$chunks[2] = $modx->newObject('modChunk');
$chunks[2]->fromArray(array (
  'id' => 2,
  'property_preprocess' => false,
  'name' => 'npTabsJsTpl',
  'description' => 'Tpl chunk with JavaScript for NewsPublisher Tabs',
  'properties' => NULL,
), '', true, true);
$chunks[2]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nptabsjs.chunk.tpl'));

$chunks[3] = $modx->newObject('modChunk');
$chunks[3]->fromArray(array (
  'id' => 3,
  'property_preprocess' => false,
  'name' => 'npErrorTpl',
  'description' => 'Tpl chunk for use in displaying errors listed at the top of the NewsPublisher form.',
  'properties' => NULL,
), '', true, true);
$chunks[3]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nperrortpl.chunk.tpl'));

$chunks[4] = $modx->newObject('modChunk');
$chunks[4]->fromArray(array (
  'id' => 4,
  'property_preprocess' => false,
  'name' => 'npTabsJsMinTpl',
  'description' => 'Tpl chunk with Minimized JavaScript for NewsPublisher Tabs',
  'properties' => NULL,
), '', true, true);
$chunks[4]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nptabsjs.min.chunk.tpl'));

$chunks[5] = $modx->newObject('modChunk');
$chunks[5]->fromArray(array (
  'id' => 5,
  'property_preprocess' => false,
  'name' => 'npImageTpl',
  'description' => 'Tpl chunk for NewsPublisher image TVs',
  'properties' => 
  array (
  ),
), '', true, true);
$chunks[5]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npimagetpl.chunk.tpl'));

$chunks[6] = $modx->newObject('modChunk');
$chunks[6]->fromArray(array (
  'id' => 6,
  'property_preprocess' => false,
  'name' => 'npFileTpl',
  'description' => 'Tpl chunk for NewsPublisher file TVs',
  'properties' => 
  array (
  ),
), '', true, true);
$chunks[6]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npfiletpl.chunk.tpl'));

$chunks[7] = $modx->newObject('modChunk');
$chunks[7]->fromArray(array (
  'id' => 7,
  'property_preprocess' => false,
  'name' => 'npIntTpl',
  'description' => 'Tpl chunk for NewsPublisher integer fields',
  'properties' => NULL,
), '', true, true);
$chunks[7]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npinttpl.chunk.tpl'));

$chunks[8] = $modx->newObject('modChunk');
$chunks[8]->fromArray(array (
  'id' => 8,
  'property_preprocess' => false,
  'name' => 'npListOuterTpl',
  'description' => 'Outer Tpl chunk for NewsPublisher listbox TVs',
  'properties' => NULL,
), '', true, true);
$chunks[8]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nplistoutertpl.chunk.tpl'));

$chunks[9] = $modx->newObject('modChunk');
$chunks[9]->fromArray(array (
  'id' => 9,
  'property_preprocess' => false,
  'name' => 'npListOptionTpl',
  'description' => 'Inner Tpl chunk for NewsPublisher listbox TVs (used for each option)',
  'properties' => NULL,
), '', true, true);
$chunks[9]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nplistoptiontpl.chunk.tpl'));

$chunks[10] = $modx->newObject('modChunk');
$chunks[10]->fromArray(array (
  'id' => 10,
  'property_preprocess' => false,
  'name' => 'npTextAreaTpl',
  'description' => 'Tpl chunk for NewsPublisher textarea and richtext fields and TVs',
  'properties' => NULL,
), '', true, true);
$chunks[10]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nptextareatpl.chunk.tpl'));

$chunks[11] = $modx->newObject('modChunk');
$chunks[11]->fromArray(array (
  'id' => 11,
  'property_preprocess' => false,
  'name' => 'npTextTpl',
  'description' => 'Tpl chunk for NewsPublisher one-line text fields and TVs; also used as a default tpl for unhandled TV types',
  'properties' => NULL,
), '', true, true);
$chunks[11]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nptexttpl.chunk.tpl'));

$chunks[12] = $modx->newObject('modChunk');
$chunks[12]->fromArray(array (
  'id' => 12,
  'property_preprocess' => false,
  'name' => 'npBoolTpl',
  'description' => 'Tpl chunk for NewsPublisher boolean (Yes/No) fields',
  'properties' => 
  array (
  ),
), '', true, true);
$chunks[12]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npbooltpl.chunk.tpl'));

$chunks[13] = $modx->newObject('modChunk');
$chunks[13]->fromArray(array (
  'id' => 13,
  'property_preprocess' => false,
  'name' => 'npDateTpl',
  'description' => 'Tpl chunk for NewsPublisher date fields and date TVs',
  'properties' => NULL,
), '', true, true);
$chunks[13]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npdatetpl.chunk.tpl'));

$chunks[14] = $modx->newObject('modChunk');
$chunks[14]->fromArray(array (
  'id' => 14,
  'property_preprocess' => false,
  'name' => 'npOptionTpl',
  'description' => 'Inner Tpl chunk for NewsPublisher checkbox and radio TVs (used for each option)',
  'properties' => NULL,
), '', true, true);
$chunks[14]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npoptiontpl.chunk.tpl'));

$chunks[15] = $modx->newObject('modChunk');
$chunks[15]->fromArray(array (
  'id' => 15,
  'property_preprocess' => false,
  'name' => 'npOptionOuterTpl',
  'description' => 'Outer Tpl chunk for NewsPublisher checkbox and radio TVs',
  'properties' => NULL,
), '', true, true);
$chunks[15]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npoptionoutertpl.chunk.tpl'));

$chunks[16] = $modx->newObject('modChunk');
$chunks[16]->fromArray(array (
  'id' => 16,
  'property_preprocess' => false,
  'name' => 'npOuterTpl',
  'description' => 'Outer Tpl chunk for entire NewsPublisher form',
  'properties' => 
  array (
  ),
), '', true, true);
$chunks[16]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npoutertpl.chunk.tpl'));

$chunks[17] = $modx->newObject('modChunk');
$chunks[17]->fromArray(array (
  'id' => 17,
  'property_preprocess' => false,
  'name' => 'npRichtextTpl',
  'description' => 'Tpl chunk for richtext TVs',
  'properties' => 
  array (
  ),
), '', true, true);
$chunks[17]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nprichtexttpl.chunk.tpl'));

return $chunks;
