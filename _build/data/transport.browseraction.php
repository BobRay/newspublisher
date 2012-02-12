<?php
/**
 * NewsPublisher File Browser modAction
 *
 * @package newspublisher
 */

$browserAction= $modx->newObject('modAction');
$browserAction->fromArray(array(
    'id' => 1,
    'namespace' => 'newspublisher',
    'controller' => 'filebrowser',
    'haslayout' => false,
    'parent' => 0,
    'lang_topics' => '',
    'assets' => '',            
), '', true, true);

return $browserAction;
