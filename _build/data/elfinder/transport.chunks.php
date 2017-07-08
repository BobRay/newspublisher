<?php
/**
 * chunks transport file for NewsPublisher extra
 *
 * Copyright 2013-2017 Bob Ray <https://bobsguides.com>
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
/* @var xPDOObject[] $chunks */


$chunks = array();

$chunks[1] = $modx->newObject('modChunk');
$chunks[1]->fromArray(array (
  'id' => 1,
  'description' => 'Loaded by ElFinderContent snippet into npElFinder resource.',
  'name' => 'npElFinderContent',
), '', true, true);
$chunks[1]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/npelfindercontent.chunk.tpl'));

return $chunks;
