<?php
/** Edit button for front-end editing with NewsPublisher
 * &noShow - comma-separated list of page IDs where the button will be hidden
 * (should always include the NewsPublisher page).
 * &bottom - distance from bottom; default: 30%
 * &right - distance from right; default: 30%
 * &debug - return debugging information in the button.
 *
 * Note: Button is enabled during debug -- don't click on it
 * if it contains an error message.
 *
 * @package newspublisher
 */


$language = $modx->getOption('language',$scriptProperties,null);
$language = $language ? $language . ':' : '';
$modx->lexicon->load($language.'newspublisher:default');

/* Caption for edit button  */

$buttonCaption = $modx->lexicon('np_edit');
$buttonCaption = empty($buttonCaption) ? 'np_edit' : $buttonCaption;

/* value will be unchanged if there are no errors  */
$value = $buttonCaption;

if (! $modx->hasPermission('edit_document')) {
    $value = $modx->lexicon('np_no_edit_document_permission');
}

if (! $modx->hasPermission('save_document')) {
    $value = $modx->lexicon('np_no_context_save_document_permission');
}

if (! $modx->resource->checkPolicy('save')) {
    $value = $modx->lexicon('np_no_resource_save_document_permission');
}
$id = $modx->resource->get('id');
if ( $id == $modx->getOption('site_start') ) {
    $value = $modx->lexicon('np_no_edit_home_page');
}

$hidden = explode(',',$noShow);
if (in_array($modx->resource->get('id'),$hidden)) {
   $value = 'In noShow list';
}
$bottom = empty($bottom)? '30%' : $bottom;
$right = empty($right)? '30%' : $right;
$output = '<form action="[[~8]]" method="post" style="position:fixed;bottom:'.$bottom .  ';right:' . $right . '">';
$output .= "\n" . '<input type = "hidden" name="np_existing" value="true">';
$output .= "\n" . '<input type = "hidden" name="np_doc_id" value="' . $modx->resource->get('id') . '">';
$output .= "\n" . '<input type="submit" class = "np_edit_this_button" name="submit" value="' . $value . '">';
$output .= "\n" . '</form>';

if ( ($value != $buttonCaption) && !$debug) {
    $output = '';
}

return $output;