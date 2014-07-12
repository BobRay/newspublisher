<?php
/**
 * chunks transport file for NewsPublisher extra
 *
 * Copyright 2013 by Bob Ray <http://bobsguides.com>
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
  'description' => 'Tpl for Yes/No fields in NewsPublisher',
  'name' => 'npBoolTpl',
), '', true, true);
$chunks[1]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npbooltpl.chunk.tpl'));

$chunks[2] = $modx->newObject('modChunk');
$chunks[2]->fromArray(array (
  'id' => 2,
  'description' => 'Tpl for date fields in NewsPublisher',
  'name' => 'npDateTpl',
), '', true, true);
$chunks[2]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npdatetpl.chunk.tpl'));

$chunks[3] = $modx->newObject('modChunk');
$chunks[3]->fromArray(array (
  'id' => 3,
  'description' => 'Tpl for error messages in NewsPublisher',
  'name' => 'npErrorTpl',
), '', true, true);
$chunks[3]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nperrortpl.chunk.tpl'));

$chunks[4] = $modx->newObject('modChunk');
$chunks[4]->fromArray(array (
  'id' => 4,
  'description' => 'Tpl for field error messages in NewsPublisher',
  'name' => 'npFieldErrorTpl',
), '', true, true);
$chunks[4]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npfielderrortpl.chunk.tpl'));

$chunks[5] = $modx->newObject('modChunk');
$chunks[5]->fromArray(array (
  'id' => 5,
  'description' => 'Tpl for file fields in NewsPublisher',
  'name' => 'npFileTpl',
), '', true, true);
$chunks[5]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npfiletpl.chunk.tpl'));

$chunks[6] = $modx->newObject('modChunk');
$chunks[6]->fromArray(array (
  'id' => 6,
  'description' => 'Tpl for image fields in NewsPublisher',
  'name' => 'npImageTpl',
), '', true, true);
$chunks[6]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npimagetpl.chunk.tpl'));

$chunks[7] = $modx->newObject('modChunk');
$chunks[7]->fromArray(array (
  'id' => 7,
  'description' => 'Tpl for integer fields in NewsPublisher',
  'name' => 'npIntTpl',
), '', true, true);
$chunks[7]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npinttpl.chunk.tpl'));

$chunks[8] = $modx->newObject('modChunk');
$chunks[8]->fromArray(array (
  'id' => 8,
  'description' => 'Outer Tpl NewsPublisher form',
  'name' => 'npOuterTpl',
), '', true, true);
$chunks[8]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npoutertpl.chunk.tpl'));

$chunks[9] = $modx->newObject('modChunk');
$chunks[9]->fromArray(array (
  'id' => 9,
  'description' => 'JS for NewsPublisher tabs',
  'name' => 'npTabsJsTpl',
), '', true, true);
$chunks[9]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nptabsjs.chunk.tpl'));

$chunks[10] = $modx->newObject('modChunk');
$chunks[10]->fromArray(array (
  'id' => 10,
  'description' => 'Minimized JS for NewsPublisher tabs',
  'name' => 'npTabsJsMinTpl',
), '', true, true);
$chunks[10]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nptabsjs.min.chunk.tpl'));

$chunks[11] = $modx->newObject('modChunk');
$chunks[11]->fromArray(array (
  'id' => 11,
  'description' => 'Tpl for textarea fields in NewsPublisher',
  'name' => 'npTextAreaTpl',
), '', true, true);
$chunks[11]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nptextareatpl.chunk.tpl'));

$chunks[12] = $modx->newObject('modChunk');
$chunks[12]->fromArray(array (
  'id' => 12,
  'description' => 'Tpl for text input fields in NewsPublisher',
  'name' => 'npTextTpl',
), '', true, true);
$chunks[12]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nptexttpl.chunk.tpl'));

$chunks[13] = $modx->newObject('modChunk');
$chunks[13]->fromArray(array (
  'id' => 13,
  'description' => 'Tpl for individual list options in NewsPublisher',
  'name' => 'npListOptionTpl',
), '', true, true);
$chunks[13]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nplistoptiontpl.chunk.tpl'));

$chunks[14] = $modx->newObject('modChunk');
$chunks[14]->fromArray(array (
  'id' => 14,
  'description' => 'Outer Tpl for list options in NewsPublisher',
  'name' => 'npListOuterTpl',
), '', true, true);
$chunks[14]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/nplistoutertpl.chunk.tpl'));

$chunks[15] = $modx->newObject('modChunk');
$chunks[15]->fromArray(array (
  'id' => 15,
  'description' => 'Outer Tpl for list-options in NewsPublisher',
  'name' => 'npOptionOuterTpl',
), '', true, true);
$chunks[15]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npoptionoutertpl.chunk.tpl'));

$chunks[16] = $modx->newObject('modChunk');
$chunks[16]->fromArray(array (
  'id' => 16,
  'description' => 'Tpl for individual options in NewsPublisher',
  'name' => 'npOptionTpl',
), '', true, true);
$chunks[16]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npoptiontpl.chunk.tpl'));

return $chunks;
