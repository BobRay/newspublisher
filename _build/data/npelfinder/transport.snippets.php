<?php
/**
 * snippets transport file for NewsPublisher extra
 *
 * Copyright 2013-2017 by Bob Ray <https://bobsguides.com>
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
/* @var xPDOObject[] $snippets */


$snippets = array();

$snippets[1] = $modx->newObject('modSnippet');
$snippets[1]->fromArray(array (
  'id' => 1,
  'property_preprocess' => true,
  'name' => 'npElFinderConnector',
  'description' => 'Runs from a tag on the npElFinderConnector resource.',
), '', true, true);
$snippets[1]->setContent(file_get_contents($sources['source_core'] . '/elements/snippets/npelfinderconnector.snippet.php'));


$properties = include $sources['data'].'properties/properties.npelfinderconnector.snippet.php';
$snippets[1]->setProperties($properties);
unset($properties);

$snippets[2] = $modx->newObject('modSnippet');
$snippets[2]->fromArray(array (
  'id' => 2,
  'property_preprocess' => false,
  'name' => 'npElFinderContent',
  'description' => '',
  'properties' => 
  array (
  ),
), '', true, true);
$snippets[2]->setContent(file_get_contents($sources['source_core'] . '/elements/snippets/npelfindercontent.snippet.php'));

return $snippets;
