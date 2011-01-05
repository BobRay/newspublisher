<?php
/**
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