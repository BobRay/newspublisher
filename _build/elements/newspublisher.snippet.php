<?php
/**
 * NewsPublisher
 *
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
 * @name newspublisher.class.php
 * @author Raymond Irving
 * @author Bob Ray
 
 *
 * The NewsPublisher snippet presents a form in the front end for
 * creating resources. Rich text editing is available for text fields.
 * /
/* To Do:
placeholder prefixes
phpdoc stuff
image TVs
date tvs
Check permissions?
Fix/add &allowAnyPost
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
    &postid      - document id to load on success. Defaults to the page created or edited
    &cancelid    - document id to load on cancel. Defaults to http_referer.
    &canpost     - comma delimited user groups that can use the form.
                   Leave blank for public posting
    &allGroups   - If set to 1, user must be a member of all groups
    &permissions - Comma-separated list of permissions. If set, user must have all permissions.
    &badwords    - comma delimited list of words not allowed in post
    &template    - name of template to use for news post; set to 'parent' to use parent's template;
                   for 'parent', &folder must be set; defaults to system default template

    &headertpl   - header Tpl chunk (chunk name) to be inserted at the begining of the news content
    &footertpl   - footer Tpl chunk (chunk name) to be inserted at the end of the news content
    &formtpl     - form Tpl chunk (chunk name)
    &richtext    - Initialize rich text editor; set this if there are any rich text fields
    &rtcontent   - use rich text for the content form field
    &rtsummary   - use rich text for the summary (introtext) form field
    &showinmenu  - sets the flag to (1|0) as to whether or not the new page
                   shows in the menu. defaults to 0
    &aliastitle  - set to 1 to use page title as alias suffix. Defaults to 0 - date created.
    &clearcache  - when set to 1 the system will automatically clear the site cache after publishing an article.
    &hour        - Hour, minute and second for published and unpublished dates; defaults to 12:01 am.
    &minute
    &second
    &listboxmax  - maximum length for listboxes. Default is 8 items.
    &cssfile     - name of CSS file to use, or '' for no CSS file; defaults to newspublisher.css.
    &errortpl    -  (optional) name of Tpl chunk for formatting field errors
    &groups      - resource groups to put new document in (no effect with existing docs).
                   set to 'parent' to use parent's groups.
    &language    - language to use
    &prefix      - prefix to use for placeholders

*/

require_once $modx->getOption('np.core_path',null,$modx->getOption('core_path').'components/newspublisher/').'classes/newspublisher.class.php';
$np = new Newspublisher($modx, $scriptProperties);


$np_prefix = $modx->getOption('prefix',$scriptProperties,'np');
$scriptProperties['prefix'] = $np_prefix;
/*
<script type="text/javascript">

function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}

document.onkeypress = stopRKey;

</script>
*/
if (false) {
        /* if $canpost is empty, allow anonymous posting */
        if (! empty($canpost)) {
            $allGroups =  (! empty($allGroups)) && ($allGroups == '1');
            $neededGroups = explode(',',$canpost);
            if (! $modx->user->isMember($neededGroups,$allGroups) ){
               $np->setError($modx->lexicon('np_not_in_group'));
            }
        } else {
            $scriptProperties['allowAnyPost'] = true;
        }

        /* check for required permissions */
        if (! empty($permissions)) {
            $neededPermissions = explode(',',$permissions);
            $authorized = false;
            foreach ($neededPermissions as $perm) {
                if (! $modx->hasPermission($perm) ){
                    $authorized = false;
                    break;
                }
            }
            if (! authorized) {
                $np->setError($modx->lexicon('np_no_permissions'));
            }
        }
}
$np->init($modx->context->get('key'));

/* get error Tpl chunk */
$errorTpl = isset($errortpl)? $modx->getChunk($errortpl): '<span class = "errormessage">[[+np.error]]</span>';

if(empty($errorTpl)) { /* user sent it but it's not there */
    $msg = str_replace('[[+tpl]]',$scriptProperties['errortpl'], $this->modx->lexicon('np_no_error_tpl'));
   return $msg;
}
$errors = $np->getErrors();
if (! empty($errors) ) { /* doesn't have permission */
    $errorMessage .= str_replace('[[+np.error]]',$error,$errors[0]);
    return($errorMessage);
 }

if (isset($cancelId)) {
    $cancelUrl = $modx->makeUrl($cancelId,'','','full');
} else {
    $cancelUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $modx->resource->get('id');
}
$modx->setPlaceholder('np.cancel_url',$cancelUrl);

$errorHeaderPresubmit = $modx->lexicon('np_error_presubmit');
$errorHeaderSubmit = $modx->lexicon('np_error_submit');

$fieldErrorTpl = isset($fielderrortpl)? $modx->getChunk($fielderrortpl): '<span class = "fielderrormessage">[[+np.error]]</span>';

if(empty($fieldErrorTpl)) {
    $msg = str_replace('[[+tpl]]',$scriptProperties['errortpl'], $this->modx->lexicon('np_no_error_tpl'));
   return $msg;
}



$formTpl .= $np->displayForm();

/* handle pre-submission errors */
$errors = $np->getErrors();

if (! empty($errors) ) {
   
    $modx->setPlaceholder('np.error_header',$errorHeaderPresubmit);
    foreach($errors as $error) {
        $errorMessage .= str_replace('[[+np.error]]',$error,$errorTpl);
    }
    $modx->setPlaceholder('np.errors_presubmit',$errorMessage);
    return($formTpl);
 }
 // get postback status
 $isPostBack = $np->getPostBack();
 
if (empty($scriptProperties['hidealltvs'])) {
    $formTpl = str_replace('[[+np.allTVs]]',$np->displayTVs(),$formTpl);
}


if ($isPostBack) {

    $errors = $np->getErrors();
    if (! empty($errors)) {
        $modx->setPlaceholder('np.error_header',$errorHeaderSubmit);
        foreach($errors as $error) {
            $errorMessage .= str_replace('[[+np.error]]',$error,$errorTpl);
        }
        $modx->setPlaceholder('np.errors_submit',$errorMessage);
        return($formTpl);

    }
   
    /* handle pre-save errors (field errors set in validate() ) */
    $np->validate($fieldErrorTpl);
    $errors = $np->getErrors();
    if (! empty($errors) ) {
        foreach($errors as $error) {
            $errorMessage .= str_replace('[[+np.error]]',$error,$errorTpl);
        }
        $modx->setPlaceholder('np.errors_submit',$errorMessage);
        $modx->setPlaceholder('np.error_header',$errorHeaderSubmit);
        return $formTpl;
    }

    $np->saveResource();

    /* handle save errors */
    $errors = $np->getErrors();

    if (! empty($errors) ) {
        $modx->setPlaceholder('np.error_header',$errorHeaderSubmit);
        foreach($errors as $error) {
            $errorMessage .= str_replace('[[+np.error]]',$error,$errorTpl);
        }

        $modx->setPlaceholder('np.errors_submit' , $errorMessage);
        
        return($formTpl);
    } else {
        $np->forward($scriptProperties['postId']);
    }


} else {
   return $formTpl;
}
?>
