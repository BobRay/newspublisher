<?php
/**
 * NewsPublisher
 * Copyright 2011-2023 Bob Ray
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
 * @author Bob Ray <https://bobsguides.com>
 
 *
 * Description: The NewsPublisher snippet presents a form in the front end for
 * creating resources. Rich text editing is available for text fields and TVs.
 *
 * Can be used to edit existing documents in conjunction with the
 * NpEditThisButton snippet.
 * /

/* Properties

           AREA: NewsPublisher Control Settings

 * @property &activetab textfield -- (optional) Tab to show when form
 *    is loaded; Default: (empty).
 * @property &allowedtags textfield -- (optional) Tags allowed in text
 *    fields; Default: see tutorial.
 * @property &badwords textfield -- (optional) Comma delimited list of
 *    words not allowed in document; Default: (empty).
 * @property &cancelid textfield -- (optional) Document ID to load on
 *    cancel; Default: http_referer.
 * @property &captions textfield -- (optional) Custom captions --
 *    Comma-separated list of FieldNames:FieldCaptions. Example:
 *    &captions=`introtext:Summary,content:Enter Your Post`; Default:
 *    (empty).
 * @property &clearcache combo-boolean -- (optional) When set to Yes,
 *    NewsPublisher will clear the site cache after saving the resource;
 *    Default: Yes.
 * @property &contentcols textfield -- (optional) Columns to show in
 *    Content field; Default: 60.
 * @property &contentrows textfield -- (optional) Rows to show in
 *    Content field; Default: 10.
 * @property &cssfile textfield -- (optional) Name of CSS file to use,
 *    or `` for no CSS file; File should be in assets/newspublisher/css/
 *    directory; Default: newspublisher.css.
 * @property &groups textfield -- (optional) Comma-separated list of
 *    resource groups to put new document in (no effect with existing docs);
 *    set to `parent` to use parent's groups; Default: (empty).
 * @property &hoverhelp combo-boolean -- (optional) Show help when
 *    hovering over field caption; Default: Yes.
 * @property &initdatepicker combo-boolean -- (optional) Initialize
 *    date picker; set this if there are any date fields; Default: Yes.
 * @property &initfilebrowser combo-boolean -- Initialize file browser
 *    for use in RTE and file/image TVs; Default: no.
 * @property &initrte combo-boolean -- (optional) Initialize rich text
 *    editor; set this if there are any rich text fields; Default: No.
 * @property &intmaxlength numberfield -- (optional) Max length for
 *    integer input fields; Default: 10.
 * @property &language textfield -- (optional) Language to use in
 *    forms and error messages; Default: (empty).
 * @property &listboxmax numberfield -- (optional) Maximum length for
 *    listboxes; Default: 8.
 * @property &multiplelistboxmax textfield -- (optional) Maximum
 *    length for multi-select listboxes; Default: 20.
 * @property &parents textfield -- Comma-separated list of parent IDs
 *    for user to select from (must be IDs or Context keys); If &parentid is
 *    sent, it will be selected in the list. Note: new_document_in_root
 *    permission may be necessary for new resources); Default: (empty).
 * @property &postid numberfield -- (optional) Document ID to load on
 *    success; Default: the page created or edited.
 * @property &prefix textfield -- (optional) Prefix to use for
 *    placeholders; Default: np.
 * @property &readonly textfield -- (optional) Comma-separated list of
 *    fields that should be read only; does not work with option or textarea
 *    fields; Default: (empty).
 * @property &required textfield -- (optional) Comma separated list of
 *    fields/tvs to require; Default: (empty).
 * @property &rtcontent combo-boolean -- (optional) Use rich text for
 *    the content form field; Default: No.
 * @property &rtsummary combo-boolean -- (optional) Use rich text for
 *    the summary (introtext) form field; Default: No.
 * @property &show textfield -- (optional) Comma separated list of
 *    fields/tvs to show; Default: (empty).
 * @property &stopOnBadTv combo-boolean -- (optional) If set to No,
 *    &show can contain TVs not attached to the current template without an
 *    error; Default: Yes.
 * @property &summarycols textfield -- (optional) Number of columns
 *    for the summary field; Default: 60.
 * @property &summaryrows textfield -- (optional) Number of rows for
 *    the summary field; Default: 10.
 * @property &tabs textfield -- (required only if usetabs is set)
 *    Specification for tabs (see tutorial); Default: (empty).
 * @property &templates textfield -- (optional) Comma-separated list
 *    of template IDs for user to select from (must be IDs); if &template is
 *    set, it will be selected in the list; Default: (empty).
 * @property &textmaxlength numberfield -- (optional) Max length for
 *    text input fields; Default: 60.
 * @property &tinyheight textfield -- (optional) Height of richtext
 *    areas; Default: 400px.
 * @property &tinysource textfield -- Source to load TinyMCE from;
 *    Default: //cdn.tinymce.com/4/tinymce.min.js.
 * @property &tinywidth textfield -- (optional) Width of richtext
 *    areas; Default: 95%.
 * @property &usetabs combo-boolean -- (optional) Show tabbed display;
 *    Default: No.
 * @property &which_editor textfield -- Rich-text editor to use; at
 *    present, TinyMCE is the only value that will work; Default: TinyMCE.

           AREA: Resource Field Settings

 * @property &aliasdateformat textfield -- (optional) Format string
 *    for auto date alias -- see tutorial; Default: PHP date + time format.
 * @property &aliasprefix textfield -- (optional) Prefix to be
 *    prepended to alias for new documents with an empty alias; alias will
 *    be aliasprefix - timestamp; Default: (empty).
 * @property &aliastitle combo-boolean -- (optional) Set to Yes to use
 *    lowercase, hyphenated, page title as alias. If set to No,
 *    'article-(date created)' is used. Ignored if alias is filled in form;
 *    Default: Yes.
 * @property &cacheable list -- (optional) Sets the flag that
 *    determines whether or not the resource is cached; for new resources,
 *    set to `Parent` to use parent's setting; Default: cache_default System
 *    Setting.
 * @property &classkey textfield -- (optional) Class key for new
 *    resources; use only if you have subclassed resource or are using this
 *    for Articles (set to Article); Default: modDocument.
 * @property &hidemenu list -- (optional) Sets the flag that
 *    determines whether or not the new page shows in the menu; for new
 *    resources, set to `Parent to use parent's setting; Default:
 *    hidemenu_default System Setting.
 * @property &parentid numberfield -- (optional) Folder ID where new
 *    documents are stored; Default: NewsPublisher folder; to force a
 *    parent, set this and do not show the parent field.
 * @property &presets textfield -- Preset values for new document
 *    fields in this form: `content:Some default content,introtext; Default:
 *    introtext`.
 * @property &published list -- (optional) Set new resource as
 *    published or not (will be overridden by publish and unpublish dates).
 *    Set to `parent` to match parent's pub status; Default: publish_default
 *    system setting.
 * @property &richtext list -- (optional) Sets the flag that
 *    determines whether or Rich Text Editor is used to when editing the
 *    page content in the Manager; for new resources, set to `Parent` to use
 *    parent's setting; Default: richtext_default System Setting.
 * @property &searchable list -- (optional) Sets the flag that
 *    determines whether or not the new page is included in site searches;
 *    for new resources, set to `Parent` to use parent's setting; Default:
 *    search_default System Setting.
 * @property &template textfield -- (optional) Name or ID of template
 *    to use for new document; for new resources, set to `Parent` to use
 *    parent's template; for `parent`, &parentid must be set; Default: the
 *    default_template System Setting.

           AREA: Tpls

 * @property &booltpl textfield -- (optional) Tpl used for Yes/No
 *    resource fields (e.g., published, searchable, etc.); Default:
 *    npBoolTpl.
 * @property &datetpl textfield -- (optional) Tpl used for date
 *    resource fields and date TVs; Default: npDateTpl.
 * @property &elfinderinittpl textfield -- (optional) Tpl used to
 *    initialize elFinder; Default: (empty).
 * @property &errortpl textfield -- (optional) Name of Tpl chunk for
 *    formatting field errors. Must contain [[+np.error]] placeholder;
 *    Default: npErrorTpl.
 * @property &fielderrortpl textfield -- (optional) Name of Tpl chunk
 *    for formatting field errors. Must contain [[+np.error]] placeholder;
 *    Default: npFieldErrorTpl.
 * @property &filetpl textfield -- (optional) Tpl used for file TVs;
 *    Default: (empty).
 * @property &imagetpl textfield -- (optional) Tpl used for image TVs;
 *    Default: (empty).
 * @property &inttpl textfield -- (optional) Tpl used for integer
 *    resource fields; Default: npIntTpl.
 * @property &listoptiontpl textfield -- (optional) Tpl used for each
 *    option of listbox TVs; Default: npListOptionTpl.
 * @property &optionoutertpl textfield -- (optional) Tpl used for as a
 *    shell for checkbox, list, and radio option TVs; Default:
 *    npOptionOuterTpl.
 * @property &optiontpl textfield -- (optional) Tpl used for each
 *    option of checkbox and radio option TVs; Default: npOptionTpl.
 * @property &outertpl textfield -- (optional) Tpl used as a shell for
 *    the whole page; Default: npOuterTpl.
 * @property &richtexttpl textfield -- (optional) Tpl used for
 *    richtext TVs; Default: (empty).
 * @property &texttpl textfield -- (optional) Tpl used for text
 *    resource fields; Default: npTextTpl.
 * @property &tinymceinittpl textfield -- (optional) Tpl used to
 *    initialize TinyMCE; Default: (empty).

 */


/** @define "$modx->getOption('np.core_path',null,$modx->getOption('core_path').'components/newspublisher/')" "VALUE" */

    /** @var $modx modX */
    /** @var $scriptProperties array */

$errorMessage = '';
$formTpl = '';

$language = $modx->getOption('language', $scriptProperties, '');
$language = !empty($language)
    ? $language
    : $modx->getOption('cultureKey', NULL,
        $modx->getOption('manager_language', NULL, 'en'));
$modx->lexicon->load($language . ':newspublisher:default');

/* Redirect to login page if np_login_redirect is set and user is not logged in */
$loggedIn = $modx->user->hasSessionContext($modx->context->get('key'));

if ((!$loggedIn) && (!$modx->user->get('sudo'))) {
    $redirect = $modx->getOption('np_login_redirect', null, false, true);
    if ($redirect) {
        $loginId = $modx->getOption('np_login_id', $scriptProperties, '', true);
        if (!empty($loginId)) {
            $url = $modx->makeUrl($loginId, "", "", "full");
            $modx->sendRedirect($url);
        } else {
            $modx->log(modX::LOG_LEVEL_ERROR, $modx->lexicon('np_no_login_id'));
            die($modx->lexicon('np_not_logged_in'));
        }
    } else {
        die($modx->lexicon('np_not_logged_in'));
    }
}

/* Make these match if coming from Duplicate */
if (isset($_SESSION['np_doc_id'])) {
    $_POST['np_doc_id'] = $_SESSION['np_doc_id'];
    $_POST['np_existing'] = true;
    unset($_SESSION['np_doc_id']);
}
/* Protect against forged np_doc_id from npEditThisButton */
if (isset($_POST['np_doc_id'])) {
    if (! isset($_SESSION['np_doc_to_edit']) ||
        !in_array($_POST['np_doc_id'], explode(',', $_SESSION['np_doc_to_edit']))) {
            return ($modx->lexicon('np_unauthorized_document'));
    }
}

$classPath = $modx->getOption('np.core_path', null, $modx->getOption('core_path') . 'components/newspublisher/') . 'model/newspublisher/';

if (! $modx->loadClass('Newspublisher',$classPath, true, true)) {
    return '<h3>Could not load Newspublisher Class</h3><p>Path: ' . $classPath . '</p>';
}


/* Let &require override &required (it's a common mistake to use &require)
   this will only happen if the user explicitly sets &require in the tag */
if (isset($scriptProperties['require'])) {
    $scriptProperties['required'] = $scriptProperties['require'];
}
/* make sure some prefix is set in $scriptProperties */

$prefix = $modx->getOption('prefix', $scriptProperties, 'np', true);
$scriptProperties['prefix'] = $prefix;
$np_prefix = $prefix;

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

    /* Leave out header if resource has been deleted */
    if (strstr($errorMessage, $modx->lexicon('np_resource_deleted'))) {
        $errorHeaderPresubmit = '';
    }
    return '<div class="newspublisher">' . $errorHeaderPresubmit . $errorMessage . '</div>';
}

/* add Cancel button only if requested */
$cancelId = $modx->getOption('cancelid', $scriptProperties, null, true);

if (is_numeric($cancelId)) {
    $cancelUrl = $modx->makeUrl($cancelId, '', '', 'full');
} else {
    $cancelUrl = isset($_SERVER['HTTP_REFERER'])
        ? $_SERVER['HTTP_REFERER']
        : $modx->makeUrl($modx->resource->get('id'), "", "", "full");
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