<?php
#::::::::::::::::::::::::::::::::::::::::
#
#  Snippet Name: NewsPublisher
#  Short Desc: Create articles directly from front end (news, blogs, PR, etc.)
#  Created By: Raymond Irving (xwisdom@yahoo.com), August 2005
#
#  Version: 3.0.1
#  Modified: November 06, 2010
#
#  Changelog:
#     Mar 05, 06 -- modx_ prefix removed [Mark]
#     Dec 13, 05 -- Now inherrits web/manager docgroups thanks to Jared Carlow
#     Nov 06, 10 -- Revolution Conversion by Bob Ray
#
#::::::::::::::::::::::::::::::::::::::::
#  Description:
#    Checks to see if users belong to a certain group and
#    displays the specified chunk if they do. Performs several
#    sanity checks and allows to be used multiple times on a page.
#    Only meant to be used once per page.
#::::::::::::::::::::::::::::::::::::::::
#
# NOTE: Bruno17's tinymcefe component must be installed for rich text fields
#
#  Parameters:
#    &folder      - folder id where comments are stored
#    &makefolder  - set to 1 to automatically convert the parent document to a folder. Defaults to 0
#    &hideAllTVs  - set to 1 to hide all TVs
#    &hideTVs     - comma-separated list of TV IDs to hide
#    &postid      - document id to load after posting news item. Defaults to the page created
#    &canpost     - comma delimitted user groups that can post comments. leave blank for public posting
#    &badwords    - comma delimited list of words not allowed in post
#    &template    - name of template to use for news post
#    &headertpl   - header template (chunk name) to be inserted at the begining of the news content
#    &footertpl   - footer template (chunk name) to be inserted at the end of the news content
#    &formtpl     - form template (chunk name)
#    &richtext    - Initialize rich text editor
#    &rtcontent   - name of a richtext content form field
#    &rtsummary   - name of a richtext summary form field
#    &showinmenu  - sets the flag to true or false (1|0) as to whether or not it shows in the menu. defaults to false (0)
#    &aliastitle  - set to 1 to use page title as alias suffix. Defaults to 0 - date created.
#    &clearcache  - when set to 1 the system will automatically clear the site cache after publishing an article.
#    &hour        - Hour, minute and second for published and unpublished dates; defaults to 12:01 am.
#    &minute
#    &second
#
#::::::::::::::::::::::::::::::::::::::::

/* To Do:
richtext TVs
email TVs
image TVs
Hide TVs
Order TVs
Check permissions?
*/

$npPath = MODX_ASSETS_PATH . 'components/newspublisher/';

require_once($npPath . 'classes/newspublisher.class.php');

$np = new Newspublisher(&$modx, &$scriptProperties);

$np->init($scriptProperties['richtext']);

$postgrp = isset($canpost) ? explode(",",$canpost):array();
$allowAnyPost = count($postgrp)==0 ? true : false;
$scriptProperties['allowAnyPost'] = $allowAnyPost;

// get clear cache
$clearcache     = isset($clearcache) ? 1:0;

// get alias title
$aliastitle     = isset($aliastitle) ? 1:0;

// get rich text

$richtext = isset($richtext) ? $richtext : 1;

// get folder id where we should store articles
// else store under current document
$folder = isset($folder) ? intval($folder):$modx->resource->get('id');

// set rich text content field
$rtcontent = isset($rtcontent) ? $rtcontent:'content';

// set rich text summary field
$rtsummary = isset($rtsummary) ? $rtsummary:'introtext';

// get header
$header = isset($headertpl) ? "[[$".$headertpl."]]":'';

// get footer
$footer = isset($footertpl) ? "[[+".$footertpl."]]":'';



// get badwords
if(isset($badwords)) {
    $badwords = str_replace(' ','', $badwords);
    $badwords = "/".str_replace(',','|', $badwords)."/i";
}

// get menu status
$hidemenu = isset($showinmenu) && $showinmenu==1 ? 0 : 1;

if (false) {
// get template
if (isset($template)) {
    if(is_numeric($template) ) {
        // use it
    } else {
        $t = $modx->getObject('modTemplate',array('templatename'=>'$template'));
        $template = $t? $t->get('id') : $modx->getOption('default_template');
    }
} else {
$template = $modx->getOption('default_template');
}

}
// ************************
$message = '';

$formTpl .= $np->displayForm();

if (empty($scriptProperties['hideAllTVs'])) {
    $formTpl = str_replace('[[+np.allTVs]]',$np->displayTVs(),$formTpl);
}
// get postback status
$isPostBack = isset($_POST['hidSubmit']) ? true:false;
if ($isPostBack) {
    $success = $np->saveResource();
    if (! $success) {
        return $np->getMessage();
    } else {
        return 'Thank You';
    }

} else {
    if(!$allowAnyPost && !$modx->user->isMember($postgrp)) {
                $formTpl = '';
    } else {
        foreach($_POST as $n=>$v) {
            $formTpl = str_replace('[[+'.$n.']]',$v,$formTpl);
        }
    }
            // return form
    return $message.$formTpl;
}
?>
