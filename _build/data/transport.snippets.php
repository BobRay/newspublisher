<?php
/**
 * NewsPublisher transport snippets
 * Copyright 2011 Bob Ray
 * @file transport.snippets.php
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
 * @description array of snippet objects for NewsPublisher package
 * @package newspublisher
 * @subpackage build
 */

function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = str_replace('<?php','',$o);
    $o = str_replace('?>','',$o);
    $o = trim($o);
    return $o;
}
$snippets = array();

$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'name' => 'NewsPublisher',
    'description' => 'Front-end resource creation/editing snippet.',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/newspublisher.snippet.php'),
),'',true,true);
$properties = include $sources['data'].'properties.newspublisher.php';
$snippets[0]->setProperties($properties);
unset($properties);


$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'name' => 'NpEditThisButton',
    'description' => 'Displays a button to edit the current resource with NewsPublisher.',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/npeditthisbutton.snippet.php'),
),'',true,true);
$properties = include $sources['data'].'properties.npeditthisbutton.php';
$snippets[1]->setProperties($properties);
unset($properties);

return $snippets;