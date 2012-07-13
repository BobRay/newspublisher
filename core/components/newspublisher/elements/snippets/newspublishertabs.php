<?php
/**
 * NewsPublisher
 * Copyright 2011 Bob Ray
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
 * NewsPublisher; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package newspublisher
 * @author Raymond Irving
 * @author Bob Ray <http://bobsguides.com>
 
 *
 * Description: The NewsPublisher snippet presents a form in the front end for
 * creating resources. Rich text editing is available for text fields and TVs.
 *
 * Can be used to edit existing documents in conjunction with the
 * NpEditThisButton snippet.
 * /

/*
  @version Version 1.3.0-rc1
  Modified: July 10, 2011

   NOTE: You may need the latest version of TinyMCE for rich text editing.

  Properties:
    @property parentid      - (optional) Folder id where new documents are stored; defaults to NewsPublisher folder.
    @property show        - (optional) Comma separated list of fields/tvs to show (shown in order).
                     defaults to 'pagetitle,longtitle,description,menutitle,pub_date,unpub_date,introtext,content'.

*/

/** @define "$modx->getOption('np.core_path',null,$modx->getOption('core_path').'components/newspublisher/')" "VALUE" */

    /* @var $modx modX */

$modx->regClientStartupScript('//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript');
/*$modx->regClientStartupScript(MODX_ASSETS_URL . 'mycomponents/newspublisher/assets/components/newspublisher/js/widgets/newspublishertabs.js');*/
return '';
require_once $modx->getOption('np.core_path', null, $modx->getOption('core_path') . 'components/newspublisher/') . 'classes/newspublisher.class.php';

/* Let &require override &required (it's a common mistake to use &require)
   this will only happen if the user explicitly sets &require in the tag */

$errorMessage = '';
$formTpl = '';

if (isset($scriptProperties['require'])) {
    $scriptProperties['required'] = $scriptProperties['require'];
}
/* make sure some prefix is set in $scriptProperties */

$scriptProperties['prefix'] = empty($scriptProperties['prefix'])
        ? 'np' : $scriptProperties['prefix'];
$np_prefix = $scriptProperties['prefix'];

/* create and initialize newspublisher object */
$np = new Newspublisher($modx, $scriptProperties);
$np->init($modx->context->get('key'));

$errorTpl =  $np->getTpl('ErrorTpl');
$fieldErrorTpl = $np->getTpl('FieldErrorTpl');
$errorHeaderPresubmit = $modx->lexicon('np_error_presubmit');
$errorHeaderSubmit = $modx->lexicon('np_error_submit');

/* Handle errors in init() */
$errors = $np->getErrors();
if (!empty($errors)) {

    $modx->toPlaceholder('error_header', $errorHeaderPresubmit, $np_prefix);
    foreach ($errors as $error) {
        $errorMessage .= str_replace('[[+' . $np_prefix . '.error]]', $error, $errorTpl);
    }
    $modx->toPlaceholder('errors_presubmit', $errorMessage, $np_prefix);
    return '<div class="newspublisher">' . $errorHeaderPresubmit . $errorMessage . '</div>';
}

/* add Cancel button only if requested */
if (!empty ($scriptProperties['cancelid'])) {
    $cancelUrl = $modx->makeUrl($scriptProperties['cancelid'], '', '', 'full');
} else {
    $cancelUrl = isset($_SERVER['HTTP_REFERER'])
            ? $_SERVER['HTTP_REFERER'] : $modx->resource->get('id');
}
$modx->toPlaceholder('cancel_url', $cancelUrl, $np_prefix);

$formTpl .= $np->displayForm($scriptProperties['show']);

/* handle pre-submission errors (no form shown) */

$errors = $np->getErrors();

if (!empty($errors)) {

    $modx->toPlaceholder('error_header', $errorHeaderPresubmit, $np_prefix);
    foreach ($errors as $error) {
        $errorMessage .= str_replace('[[+' . $np_prefix . '.error]]', $error, $errorTpl);
    }
    $modx->toPlaceholder('errors_presubmit', $errorMessage, $np_prefix);
    return '<div class="newspublisher">' . $errorHeaderPresubmit . $errorMessage . '</div>';
}



// get postback status
$isPostBack = $np->getPostBack();

if ($isPostBack) {
    /* check for errors, validate, and save if no errors */
    $errors = $np->getErrors();
    if (!empty($errors)) {
        $modx->toPlaceholder('error_header', $errorHeaderSubmit, $np_prefix);
        foreach ($errors as $error) {
            $errorMessage .= str_replace("[[+{$np_prefix} . '.error]]", $error, $errorTpl);
        }
        $modx->toPlaceholder('errors_submit', $errorMessage, $np_prefix);
        return ($formTpl);

    }

    /* handle pre-save errors (field errors set in validate() ) */
    $np->validate();
    $errors = $np->getErrors();
    if (!empty($errors)) {
        foreach ($errors as $error) {
            $errorMessage .= str_replace("[[+{$np_prefix}.error]]", $error, $errorTpl);
        }
        $modx->toPlaceholder('errors_submit', $errorMessage, $np_prefix);
        $modx->toPlaceholder('error_header', $errorHeaderSubmit, $np_prefix);
        return $formTpl;
    }

    $docId = $np->saveResource(); /* returns ID of edited doc */

    /* if user has set postid, use it, otherwise use ID of the doc */
    $postId = empty($scriptProperties['postid']) ? $docId : $scriptProperties['postid']  ;
    

    /* handle save errors */
    $errors = $np->getErrors();

    if (!empty($errors)) {
        $modx->toPlaceholder('error_header', $errorHeaderSubmit, $np_prefix);
        foreach ($errors as $error) {
            $errorMessage .= str_replace("[[+{$np_prefix}.error]]", $error, $errorTpl);
        }

        $modx->toPlaceholder('errors_submit', $errorMessage, $np_prefix);

        return ($formTpl);
    } else { /* successful save -- forward user */
        $np->forward($postId);
    }
} else { /* just return the form */
    return $formTpl;
}