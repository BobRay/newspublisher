<?php
/**
 * NewsPublisher transport chunks
 * Copyright 2011 Bob Ray
 * @file transport.chunks.php
 * @author Bob Ray <http://bobsguides.com>
 * @date 1/15/11
 *
 * NewsPublisher is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * NewsPublisher is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * NewsPublisher; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package newspublisher
 */
/**
 * @description array of chunk objects for NewsPublisher package
 * @package newspublisher
 * @subpackage build
 */

$chunks = array();

$chunks[1]= $modx->newObject('modChunk');
$chunks[1]->fromArray(array(
    'id' => 1,
    'name' => 'npOuterTpl',
    'description' => 'Outer Tpl chunk for entire NewsPublisher form',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/npoutertpl.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[2]= $modx->newObject('modChunk');
$chunks[2]->fromArray(array(
    'id' => 2,
    'name' => 'npTextAreaTpl',
    'description' => 'Tpl chunk for NewsPublisher textarea and richtext fields and TVs',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/nptextareatpl.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[3]= $modx->newObject('modChunk');
$chunks[3]->fromArray(array(
    'id' => 3,
    'name' => 'npTextTpl',
    'description' => 'Tpl chunk for NewsPublisher one-line text fields and TVs; also used as a default tpl for unhandled TV types',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/nptexttpl.chunk.tpl'),
    'properties' => '',
),'',true,true);


$chunks[4]= $modx->newObject('modChunk');
$chunks[4]->fromArray(array(
    'id' => 4,
    'name' => 'npBoolTpl',
    'description' => 'Tpl chunk for NewsPublisher boolean fields',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/npbooltpl.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[5]= $modx->newObject('modChunk');
$chunks[5]->fromArray(array(
    'id' => 5,
    'name' => 'npDateTpl',
    'description' => 'Tpl chunk for NewsPublisher date fields and date TVs',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/npdatetpl.chunk.tpl'),
    'properties' => '',
),'',true,true);



$chunks[6]= $modx->newObject('modChunk');
$chunks[6]->fromArray(array(
    'id' => 6,
    'name' => 'npImageTpl',
    'description' => 'Tpl chunk for NewsPublisher image TVs',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/npimagetpl.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[7]= $modx->newObject('modChunk');
$chunks[7]->fromArray(array(
    'id' => 7,
    'name' => 'npIntTpl',
    'description' => 'Tpl chunk for NewsPublisher integer fields',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/npinttpl.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[8]= $modx->newObject('modChunk');
$chunks[8]->fromArray(array(
    'id' => 8,
    'name' => 'npListOuterTpl',
    'description' => 'Outer Tpl chunk for NewsPublisher listbox TVs',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/nplistoutertpl.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[9]= $modx->newObject('modChunk');
$chunks[9]->fromArray(array(
    'id' => 9,
    'name' => 'npListOptionTpl',
    'description' => 'Inner Tpl chunk for NewsPublisher listbox TVs (used for each option)',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/nplistoptiontpl.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[10]= $modx->newObject('modChunk');
$chunks[10]->fromArray(array(
    'id' => 10,
    'name' => 'npOptionOuterTpl',
    'description' => 'Outer Tpl chunk for NewsPublisher checkbox and radio TVs',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/npoptionoutertpl.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[11]= $modx->newObject('modChunk');
$chunks[11]->fromArray(array(
    'id' => 11,
    'name' => 'npOptionTpl',
    'description' => 'Inner Tpl chunk for NewsPublisher checkbox and radio TVs (used for each option)',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/npoptiontpl.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[12]= $modx->newObject('modChunk');
$chunks[12]->fromArray(array(
    'id' => 12,
    'name' => 'npErrorTpl',
    'description' => 'Tpl chunk for use in the NewsPublisher error header',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/nperrortpl.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[13]= $modx->newObject('modChunk');
$chunks[13]->fromArray(array(
    'id' => 13,
    'name' => 'npFieldErrorTpl',
    'description' => 'Tpl chunk display above each NewsPublisher field',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/npfielderrortpl.chunk.tpl'),
    'properties' => '',
),'',true,true);


return $chunks;