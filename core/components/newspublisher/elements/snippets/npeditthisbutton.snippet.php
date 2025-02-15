<?php
/**
 * NpEditThisButton
 * Copyright 2011-2025 Bob Ray
 *
 * @version Version 3.0.1-pl
 *
 * NpEditThisButton is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * NpEditThisButton is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * NewsPublisher; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package newspublisher
 * @subpackage npeditthisbutton
 * @author Bob Ray <https://bobsguides.com>

 *
 * The NpEditThisButton snippet presents a button in the front end for
 * editing resources. Clicking on the button launches NewsPublisher
 * for the current page.
 *
 * @property np_id (int) - ID of newspublisher page (set automatically on first run).
 * @property np_edit_id (int) - ID of resource to be edited
 * @property noShow (string) - Comma-separated list of IDs of documents
 *      on which the button should not be displayed. Defaults to
 *      home page, and NewsPublisher page.
 * @property bottom (optional) - distance from bottom of window to place
 *      button. Can be in any legal CSS format. Defaults to `20%`.
 * @property right (optional) - distance from right of window to place
 *      button. Can be in any legal CSS format. Defaults to `20%`.
 * @property buttonCaption (optional) - Caption for edit button.
 *      Defaults to np_edit language string.
 * @property language (optional) - Language to use for error messages.
 *      Use to override current language setting
 *      Defaults to current language setting.
 * @property debug (optional) - Displays the button on *all* pages with
 *      either the $buttonCaption, or a message explaining why it
 *      would not be shown.
 *
 */

/* @var $modx modX */

$classPrefix = $modx->getVersionData()['version'] >= 3
    ? 'MODX\Revolution\\'
    : '';


$props =& $scriptProperties;
$thisId = $modx->resource->get('id');
/* let user &language property override default language */
$language = $modx->getOption('language', $props, null);
$language = $language ? $language . ':' : '';
$modx->lexicon->load($language . 'newspublisher:button');
/* For lexicon helper
$modx->lexicon->load('newspublisher:button'); */

$ownPagesOnly = $modx->getOption('ownpagesonly', $props, '');
/* Caption for edit button  */
$debug = $modx->getOption('debug', $props, false);
$buttonCaption = $modx->getOption('buttonCaption', $props, $modx->lexicon('np_edit'), true);
$bottom = $modx->getOption('bottom', $props, '20%', true);
$right = $modx->getOption('right', $props, '20%', true);


$assetsUrl = $modx->getOption('np.assets_url', null, MODX_ASSETS_URL . 'components/newspublisher/');
$modx->regClientCSS($assetsUrl . 'css/button.css');

/* value will be unchanged if there are no errors  */
$defaultButtonCaption = $buttonCaption;

/* Deny use if ownPagesOnly is true */
/* get 'createdby' if sent */
$createdby = $modx->getOption('createdby', $props, '-1', true);
if (!empty($ownPagesOnly)) {
    if ($createdby !== '-1') {
        /* compare it to the ID of the current user */
        if ($createdby != $modx->user->get('id')) {
            $defaultButtonCaption = $modx->lexicon('np_not_your_page');
        }
    } else {
        if ($modx->resource->get('createdby') !== $modx->user->get('id')) {
            $defaultButtonCaption = $modx->lexicon('np_not_your_page');
        }
    }
}

/* $np_id is the property value */
$np_id = $modx->getOption('np_id', $props, '');
$npEditId = $modx->getOption('np_edit_id', $props, '');

/* set the np_id property to the ID of the NewsPublisher page
 * on first run if possible, error message if not */

$success = true;

if (empty($np_id)) {
    $npPage = $modx->getObject($classPrefix . 'modResource', array('alias' => 'newspublisher'));
    if (!$npPage) { /* Try pagetitle */
        $npPage = $modx->getObject($classPrefix . 'modResource', array('pagetitle' => 'NewsPublisher'));
    }

    if (!$npPage) {
        $success = false;
    }

    if ($npPage) {
        /* @var $snippetObj modSnippet */
        /* $npId is the true value of NewsPublisher page */
        $npId = $npPage->get('id');
        /* Set property to $npId */
        $snippetObj = $modx->getObject($classPrefix . 'modSnippet', array('name' => 'NpEditThisButton'));
        if ($snippetObj) {
            $snippetProps = $snippetObj->getProperties();
            $snippetProps['np_id'] = $npId;
            $snippetObj->setProperties($snippetProps);
            if ( !$snippetObj->save()) {;
                $success = false;
            }
            unset($snippetObj, $npPage);
        } else {
            $success = false;
        }
    }
    /* Failed - turn on debug so error message will display in button */
    if (!$success) {
        $defaultButtonCaption = $modx->lexicon('np_no_np_id');
        $debug = true;
    }
} else {
    $npId = $np_id;
}

/* Don't execute on NewsPublisher Page */
if ($thisId == $npId) {
    return '';
}
$modx->setPlaceholder('np_id', $npId);

/* check permissions on current page */
if (!$modx->hasPermission('edit_document')) {
    $defaultButtonCaption = $modx->lexicon('np_no_edit_document_permission');
}

if (!$modx->hasPermission('save_document')) {
    $defaultButtonCaption = $modx->lexicon('np_no_context_save_document_permission');
}

if (!$modx->resource->checkPolicy('save')) {
    $defaultButtonCaption = $modx->lexicon('np_no_resource_save_document_permission');
}

$npEditId = $modx->getOption('np_edit_id',$props,'');
$resourceToEdit = empty($npEditId)? $thisId : $npEditId;
$editHome = $modx->getOption('editHome', $props, false);

/* Don't show on the home page unless &editHome is set to 1 */
if (! $editHome) {
    if ($thisId == $modx->getOption('site_start')) {
        if ($resourceToEdit == $modx->getOption('site_start')) {
            $defaultButtonCaption = $modx->lexicon('np_no_edit_home_page');
        }
    }
}
/* Don't show if current page is in the noShow list */
$noShow = $modx->getOption('noShow', $props, '');
if (!empty($noShow)) {
    $hidden = explode(',', $noShow);
    if (in_array($resourceToEdit, $hidden)) {
        $defaultButtonCaption = 'In noShow list';
    }
}

/* protect against forged edit ID */
if (!isset($_SESSION['np_doc_to_edit'])) {
    $_SESSION['np_doc_to_edit'] = $resourceToEdit;
} else {
    $temp = explode(',', $_SESSION['np_doc_to_edit']);
    if (! in_array($resourceToEdit, $temp)) {
        $temp[] = $resourceToEdit;
        $_SESSION['np_doc_to_edit'] = implode(',', $temp);
    }
    unset($temp);
}

/* create and return the form */
if ($npEditId) {
    $output = '<form action="[[~[[+np_id]]]]" method="post"
    class="np_button_form">';
} else {
    $output = '<form action="[[~[[+np_id]]]]" method="post"
        class="np_button_form" style="position:fixed;bottom:' .
        $bottom . ';right:' . $right . '">';
}
$output .= "\n" . '<input type = "hidden" name="np_existing" value="true" />';
$output .= "\n" . '<input type = "hidden" name="np_doc_id" value="' . $resourceToEdit . '"/>';
$output .= "\n" . '<input type="submit" class = "np_edit_this_button" name="submit" value="' . $defaultButtonCaption . '"/>';
$output .= "\n" . '</form>';

/* Not OK -- don't show button unless debug is on */
if (($defaultButtonCaption != $buttonCaption) && !$debug) {
    $output = '';
}

return $output;
