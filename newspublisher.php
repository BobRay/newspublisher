<?php
/**
 * @name newspublisher.class.php
 * @author Raymond Irving
 * @author Bob Ray
 * @package newspublisher
 *
 * The NewsPublisher snippet presents a form in the front end for
 * creating resources. Rich text editing is available for text fields.
 * /
/* To Do:
implement update strategy/edit button
allow 'parent' for &template
add &groups parameter
modx.js
remove table css
image TVs
Check permissions?
*/

/*
  Version: 3.0.3
  Modified: November 06, 2010

  Changelog:
     Mar 05, 06 -- modx_ prefix removed [Mark]
     Dec 13, 05 -- Now inherrits web/manager docgroups thanks to Jared Carlow
     Nov 06, 10 -- Revolution Conversion by Bob Ray
     Nov 15, 10 -- Added TVs to form

     NOTE: Bruno17's tinymcefe component must be installed for rich text fields

  Parameters:
    &folder      - folder id where comments are stored
    &published   - set new resource as published or not
                   (will be overridden by publish and unpublish dates)
                   set to `parent` to match parent's pub status
                   defaults to publish_default system setting
    &makefolder  - set to 1 to automatically convert the parent document to a folder.
                   Defaults to 0
    &hidealltvs  - set to 1 to hide all TVs
    &hidetvs     - comma-separated list of TV IDs to hide
    &postid      - document id to load on success. Defaults to the page created
    &cancelid    - document id to load on cancel. Defaults to http_referer.
    &canpost     - comma delimitted user groups that can use the form.
                   Leave blank for public posting
    &badwords    - comma delimited list of words not allowed in post
    &template    - name of template to use for news post
    &headertpl   - header template (chunk name) to be inserted at the begining of the news content
    &footertpl   - footer template (chunk name) to be inserted at the end of the news content
    &formtpl     - form template (chunk name)
    &richtext    - Initialize rich text editor; set this if there are any rich text fields
    &rtcontent   - use rich text for the content form field
    &rtsummary   - use rich text for the summary (introtext) form field
    &showinmenu  - sets the flag to true or false (1|0) as to whether or not the new page
                   shows in the menu. defaults to false (0)
    &aliastitle  - set to 1 to use page title as alias suffix. Defaults to 0 - date created.
    &clearcache  - when set to 1 the system will automatically clear the site cache after publishing an article.
    &hour        - Hour, minute and second for published and unpublished dates; defaults to 12:01 am.
    &minute
    &second
    &listboxmax  - maximum length for listboxes. Default is 8 items.
    &cssfile     - name of CSS file to use, or '' for no CSS file; defaults to newspublisher.css.
    &errortpl    -  (optional) name of Tpl chunk for formatting field errors

*/

/* This has to change !!! */
define('NEWSPUBLISHER_URL', 'core/components/newspublisher/');

$language = isset($language) ? $language . ':' : '';
$modx->lexicon->load($language.'newspublisher:default');

if (isset($cancelId)) {
    $cancelUrl = $modx->makeUrl($cancelId,'','','full');
} else {
    $cancelUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $modx->resource->get('id');
}

$modx->setPlaceholder('np.cancel_url',$cancelUrl);

$postgrp = isset($canpost) ? explode(",",$canpost):array();
$allowAnyPost = count($postgrp)==0 ? true : false;
$scriptProperties['allowAnyPost'] = $allowAnyPost;

$errorHeaderPresubmit = $modx->lexicon('np.error_presubmit');
$errorHeader = isset($errorHeader) ? $errorHeader : $modx->lexicon('np.error_submit');

// get clear cache
$clearcache     = isset($clearcache) ? 1:0;

// get alias title
$aliastitle     = isset($aliastitle) ? 1:0;

// get rich text

$richtext = isset($richtext) ? $richtext : 1;

// get folder id where we should store articles
// else store under current document
$folder = isset($folder) ? intval($folder):$modx->resource->get('id');

/* set rich text content field */
$ph = isset($rtcontent) ? 'MODX_RichTextWidget':'content';
$modx->setPlaceholder('np.rt_content_1', $ph );
$ph = isset($rtcontent) ? 'modx-richtext':'content';
$modx->setPlaceholder('np.rt_content_2', $ph );

/* set rich text summary field */
$ph = isset($rtsummary) ? 'MODX_RichTextWidget':'introtext';
$modx->setPlaceholder('np.rt_summary_1', $ph );
$ph = isset($rtsummary) ? 'modx-richtext':'introtext';
$modx->setPlaceholder('np.rt_summary_2', $ph );

unset($ph);
/* set TV rich text fields */
//$modx->setPlaceholder('np.tv_rt1','MODX_RichTextWidget');
//$modx->setPlaceholder('np.tv_rt2','modx-richtext');





//set listbox max size
$scriptProperties['listboxmax'] = isset($listboxmax)? $listboxmax : 8;

// get header
$scriptProperties['header'] = isset($headertpl) ? "[[$".$headertpl."]]":'';

// get footer
$scriptProperties['footer'] = isset($footertpl) ? "[[$".$footertpl."]]":'';

// get badwords
if(isset($badwords)) {
    $badwords = str_replace(' ','', $badwords);
    $badwords = "/".str_replace(',','|', $badwords)."/i";
}

// get menu status
$scriptProperties['hidemenu'] = isset($showinmenu) && $showinmenu==1 ? 0 : 1;


// get errorTpl

$errorTpl = isset($errortpl)? $modx->getChunk($errortpl): '<span class = "errormessage">[[+np.error]]</span>';

if(empty($errorTpl)) {
    return 'Failed to get &amp;errortpl chunk: ' . $errortpl;
}


// ************************
$message = '';
$npPath = MODX_CORE_PATH . 'components/newspublisher/';

require_once($npPath . 'classes/newspublisher.class.php');

$np = new Newspublisher(&$modx, &$scriptProperties);

// $np->init($scriptProperties['richtext'],'147');
$np->init($scriptProperties['richtext']);

$formTpl .= $np->displayForm();

/* handle pre-submission errors */
$errors = $np->getErrors();

if (! empty($errors) ) {
    $modx->setPlaceholder('np.error_header',$errorHeaderPresubmit);
    foreach($errors as $error) {
        // $errorMessage .= '<p class = "error">' . $error . '</p>';
        $errorMessage .= str_replace('[[+np.error]]',$error,$errorTpl);
    }
    $modx->setPlaceholder('np.errors_presubmit',$errorMessage);
    return($formTpl);
 }

$isPostBack = isset($_POST['hidSubmit']) ? true:false;
$np->setPostBack($isPostBack);

if (empty($scriptProperties['hidealltvs'])) {
    $formTpl = str_replace('[[+np.allTVs]]',$np->displayTVs(),$formTpl);
}
// get postback status

if ($isPostBack) {

     // die('<pre>' . print_r($_POST,true));
    $errors = $_POST['np.errors'];
    /* handle pre-save errors */
    $success = $np->validate($errorTpl);

    if (! $success) {
       foreach($_POST as $n=>$v) {
            $formTpl = str_replace('[[+'.$n.']]',$v,$formTpl);
        }
        return $formTpl;
    }



    $np->saveResource();

    /* handle save errors */
    $errors = $np->getErrors();

    if (! empty($errors) ) {
        foreach($errors as $error) {
            $modx->setPlaceholder('np.error_header',$errorHeader);
            $errorMessage .= str_replace('[[+np.error]]',$error,$errorTpl);
            $formTpl = $errorMessage . $formTpl;
        }
        foreach($_POST as $n=>$v) {
            $formTpl = str_replace('[[+'.$n.']]',$v,$formTpl);
        }
        return($formTpl);
    } else {
            // redirect goes here
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
    return $formTpl;
}
?>
