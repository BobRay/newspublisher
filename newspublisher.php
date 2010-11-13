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


$modx->regClientCSS(MODX_ASSETS_URL . 'components/newspublisher/css/demo.css');
$modx->regClientCSS(MODX_ASSETS_URL . 'components/newspublisher/css/datepicker.css');
$modx->regClientStartupScript(MODX_ASSETS_URL . 'components/newspublisher/js/datepicker.js');

$modx->regClientScript(MODX_ASSETS_URL . 'components/newspublisher/js/mydp.js');

// get user groups that can post articles

$corePath=$modx->getOption('core_path').'components/tinymcefe/';
$modx->regClientStartupScript($modx->getOption('manager_url').'assets/ext3/adapter/ext/ext-base.js');
$modx->regClientStartupScript($modx->getOption('manager_url').'assets/ext3/ext-all.js');
$modx->regClientStartupScript($modx->getOption('manager_url').'assets/modext/build/core/modx-min.js');
$modx->regClientStartupScript($modx->getOption('manager_url').'assets/modext/util/datetime.js');

$useEditor = $modx->getOption('use_editor',null,false);
$whichEditor = $modx->getOption('which_editor',null,'');

$plugin=$modx->getObject('modPlugin',array('name'=>$whichEditor));
$tinyUrl = $modx->getOption('assets_url').'components/tinymcefe/';

/* OnRichTextEditorInit */
        if ($useEditor && $whichEditor == 'TinyMCE') {
            $tinyproperties=$plugin->getProperties();
            require_once $corePath.'tinymce.class.php';
            $tiny = new TinyMCE($modx,$tinyproperties,$tinyUrl);
            if (isset($forfrontend) || $modx->isFrontend()) {
                $def = $modx->getOption('cultureKey',null,$modx->getOption('manager_language',null,'en'));
                $tiny->properties['language'] = $modx->getOption('fe_editor_lang',array(),$def);
                $tiny->properties['frontend'] = true;
                unset($def);
            }
            $tiny->setProperties($tinyproperties);
            $html = $tiny->initialize();

            $modx->regClientStartupScript($tiny->config['assetsUrl'].'jscripts/tiny_mce/langs/'.$tiny->properties['language'].'.js');
            $modx->regClientStartupScript($tiny->config['assetsUrl'].'tiny.browser.js');
            $modx->regClientStartupHTMLBlock('<script type="text/javascript">
                Ext.onReady(function() {
                MODx.loadRTE();
                });
            </script>');

        }


$postgrp = isset($canpost) ? explode(",",$canpost):array();
$allowAnyPost = count($postgrp)==0 ? true : false;

// get clear cache
$clearcache     = isset($clearcache) ? 1:0;

// get alias title
$aliastitle     = isset($aliastitle) ? 1:0;

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

// get postback status
$isPostBack = isset($_POST['NewsPublisherForm']) ? true:false;

// get badwords
if(isset($badwords)) {
    $badwords = str_replace(' ','', $badwords);
    $badwords = "/".str_replace(',','|', $badwords)."/i";
}

// get menu status
$hidemenu = isset($showinmenu) && $showinmenu==1 ? 0 : 1;

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

$message = '';

if (false) {
// **************
$id = 'xcontent';
$w= $params['w'] ? $params['w'] : '100%';
$h= $params['h'] ? $params['h'] : '400px';
//$richtexteditor= $params['edt'] ? $params['edt'] : "";
//$richtexteditor = $modx->getOption('which_editor');

//$richtexteditor = 'TinyMCE';
$value = 'SomeValue';

$o= '<div class="MODX_RichTextWidget"><textarea class="modx-richtext"  id="' . $id . '" name="' . $id . '" style="width:' . $w . '; height:' . $h . ';">';
$o .= htmlspecialchars($value);
$o .= '</textarea></div>';

// setup editors

return $o;
// **************

}
// get form template
if(isset($formtpl)) $formTpl = $modx->getChunk($formtpl);
if(empty($formTpl)) $formTpl = '
    <div class="dp">
    <form name="NewsPublisher" method="post">

        <input name="NewsPublisherForm" type="hidden" value="on" />

        <p><label for="pagetitle">Page title: </label><input name="pagetitle" type="text" size="40" value="[[+pagetitle]]" /></p>
        <p><label for="longtitle">Long title: </label><input name="longtitle" type="text" size="40" value="[[+longtitle]]" /></p>
        <p><label for="description">Description: </label><input name="description" type="text" size="40" value="[[+description]]" /></p>
        <p><label for="pub_date">Published Date: </label><input type="text" class="w4em format-d-m-y divider-dash no-transparency" id="pub_date" name="pub_date" maxlength="10" size="9" readonly="readonly" value="[[+pub_date]]"/></p>
        <p><label for="unpub_date">Unpublished Date: </label><input type="text" class="w4em format-d-m-y divider-dash no-transparency" id="unpub_date" name="unpub_date" maxlength="10" size="9" readonly="readonly" value="[[+unpub_date]]" /></p>
        <p><label for="introtext">Summary: </label><br /><textarea name="introtext" cols="50" rows="5">[[+introtext]]</textarea></p>
        <p><label for="content">Content: </label><br /></p><div class="MODX_RichTextWidget"><textarea class="modx-richtext" name="content" id="content" cols="70" rows="20">[[+content]]</textarea></div>';

/* Display TVs */

$allTvs = array();
$template = 1;
$templateObj = $modx->getObject('modTemplate',$template);

$tvTemplates = $modx->getCollection('modTemplateVarTemplate',array('templateid'=>$template));

if (! $templateObj) {
    die('Failed to get Template: ' . $template);
}
$formTpl .= '<br />Template: ' . $template;
$formTpl .= '<br />TV Count: ' . count($tvTemplates);
foreach($tvTemplates as $tvTemplate) {
    $tvObj = $tvTemplate->getOne('TemplateVar');
    if ($tvObj) {
       $allTvs[] = $tvObj;
    }
}

if (! empty($allTvs)) {
  foreach ($allTvs as $tv) {
      // $formTpl .= '<br />TV Found: ' . $tv->get('name');
      $fields = $tv->toArray();
     // if (! empty($fields['default_text'])) {
     //     $modx->setPlaceholder($fields['name'],$fields['default_text']);
     // }
      switch($tv->get('type') ) {
      case 'text':
      case 'textbox':
          $formTpl .= "\n" . '<p><label for="' . $fields['name'] . '">'. $fields['caption']  . '</label><input name="' . $fields['name'] . '" id="' . $fields['name'] . '" type="text" size="40" value="[[+' . $fields['name'] . ']]" /></p>';
          break;

      case 'textarea':
          $formTpl .= "\n" . '<p><label for="' . $fields['name'] . '">'. $fields['caption']  . '</label><textarea name="' . $fields['name'] . '" id="' . $fields['name'] . '" type="text" cols="50" rows="5" value="[[+' . $fields['name'] . ']]"></textarea></p>';
          break;
      case option:
          $options = explode('||',$fields['elements']);
          if (empty($fields['default_text'])) {
              $fields['default_text'] = $options[0];
          }

          $formTpl .= '<p><label for="' . $fields['name'] . '">'. $fields['caption']  . '</label></p><br />';

          foreach ($options as $option) {
              $option = strtok($option,'=');
              $rvalue = strtok('=');
              $rvalue = $rvalue? $rvalue : $option;
              $formTpl .= "\n&nbsp;&nbsp;&nbsp;" . '<input type="radio" value="' . $rvalue .  '" name="' . $fields['name'] . '"' . ' id="' . $fields['name'] . '"';
              $formTpl .= $fields['default_text'] == $rvalue? ' checked ': ' ';
              $formTpl .= ' />' . $option . '<br />';

          }
      default:
          break;

      }
  }

}

$formTpl .= '<p><input name="send" type="submit" value="Submit" /></p>

    </form></div>';

// switch block
switch ($isPostBack) {
    case true:
        // process post back
        // remove magic quotes from POST
        if(get_magic_quotes_gpc()){
            $_POST = array_map("stripslashes", $_POST);
        }
        if(trim($_POST['pagetitle'])=='') $modx->webAlert('Missing page title.');
        elseif($_POST[$rtcontent]=='') $modx->webAlert('Missing news content.');
        else {
            // get created date
            $createdon = time();

            // set alias name of document used to store articles
            if(!$aliastitle) {
                $alias = 'article-'.$createdon;
            } else {
                $alias = $modx->stripTags($_POST['pagetitle']);
                $alias = strtolower($alias);
                $alias = preg_replace('/&.+?;/', '', $alias); // kill entities
                $alias = preg_replace('/[^\.%a-z0-9 _-]/', '', $alias);
                $alias = preg_replace('/\s+/', '-', $alias);
                $alias = preg_replace('|-+|', '-', $alias);
                $alias = trim($alias, '-');
                $alias = 'article-'. mysql_escape_string($alias);
            }

            $user = $modx->user;
            $userid = $modx->user->get('id');
            if(!$user && $allowAnyPost) $user = '(anonymous)';

            // check if user has rights
            if(!$allowAnyPost && !$modx->isMember($postgrp)) {
                return 'You are not allowed to publish articles';
            }

            $allowedTags = '<p><br><a><i><em><b><strong><pre><table><th><td><tr><img><span><div><h1><h2><h3><h4><h5><font><ul><ol><li><dl><dt><dd>';

            // format content
            $content = $modx->stripTags($_POST[$rtcontent],$allowedTags);
            $content = str_replace('[[+user]]',$user,$content);
            $content = str_replace('[[+createdon]]',strftime('%d-%b-%Y %H:%M',$createdon),$content);
            foreach($_POST as $n=>$v) {
                if(!empty($badwords)) $v = preg_replace($badwords,'[Filtered]',$v); // remove badwords
                $v = $modx->stripTags(htmlspecialchars($v));
                $v = str_replace("\n",'<br />',$v);
                $content = str_replace('[+'.$n.'+]',$v,$content);
            }

            $title = mysql_escape_string($modx->stripTags($_POST['pagetitle']));
            $longtitle = mysql_escape_string($modx->stripTags($_POST['longtitle']));
            $description = mysql_escape_string($modx->stripTags($_POST['description']));
            $introtext = mysql_escape_string($modx->stripTags($_POST[$rtsummary],$allowedTags));
            $pub_date = $_POST['pub_date'];
            $unpub_date = $_POST['unpub_date'];
            $published = 1;

            $H=isset($hours)? $hours : 0;
            $M=isset($minutes)? $minutes: 1;
            $S=isset($seconds)? $seconds: 0;

            // check published date
            if($pub_date=="") {
                $pub_date="0";
            } else {
                list($d, $m, $Y) = sscanf($pub_date, "%2d-%2d-%4d");

                $pub_date = strtotime("$m/$d/$Y $H:$M:$S");

                if($pub_date < $createdon) {
                    $published = 1;
                }    elseif($pub_date > $createdon) {
                    $published = 0;
                }
            }

            // check unpublished date
            if($unpub_date=="") {
                $unpub_date="0";
            } else {
                list($d, $m, $Y) = sscanf($unpub_date, "%2d-%2d-%4d");

                $unpub_date = strtotime("$m/$d/$Y $H:$M:$S");
                if($unpub_date < $createdon) {
                    $published = 0;
                }
            }

            // set menu index
            //$mnuidx = $modx->db->getValue('SELECT MAX(menuindex)+1 as \'mnuidx\' FROM '.$modx->getFullTableName('site_content').' WHERE parent=\''.$folder.'\'');
            //if($mnuidx<1) $mnuidx = 0;

            // post news content
            $createdBy = $modx->user->get('id');

            $flds = array(
                'pagetitle'     => $title,
                'longtitle'     => $longtitle,
                'description' => $description,
                'introtext'     => $introtext,
                'alias'             => $alias,
                'parent'            => $folder,
                'createdon'     => $createdon,
                'createdby'     => $createdBy,
                'editedon'        => '0',
                'editedby'        => '0',
                'published'     => $published,
                'pub_date'        => $pub_date,
                'unpub_date'    => $unpub_date,
                'deleted'         => '0',
                'hidemenu'        => $hidemenu,
                'menuindex'     => $mnuidx,
                'template'        => $template,
                'content'         => $header.$content.$footer
            );

            $resource = $modx->newObject('modResource',$flds);

            $parentObj = $modx->getObject('modResource',$flds['parent']);

             // If there's a parent object, put the new doc in the same resource groups as the parent

            if ($parentObj) {  // skip if no parent


                $resourceGroups = $parentObj->getMany('ResourceGroupResources');

                if (! empty($resourceGroups)) { // skip if parent doesn't belong to any resource groups
                    foreach ($resourceGroups as $resourceGroup) {
                        $docGroupNum = $resourceGroup->get('document_group');
                        $docNum = $resourceGroup->get('document');

                        $resourceGroupObj = $modx->getObject('modResourceGroup', $docGroupNum);
                        $intersect = $modx->newObject('modResourceGroupResource');
                        $intersect->addOne($resource);
                        $intersect->addOne($resourceGroupObj);
                        $intersect->save();

                        // echo '<br />Document Group: ' . $docGroupNum . ' . . . ' . 'Document: ' . $docNum;
                    }

                }


            }


           if(!empty($makefolder)) {
                // convert parent into folder
           //   $modx->db->update(array('isfolder'=>'1'),$modx->getFullTableName('site_content'),'id=\''.$folder.'\'');
                if (! $parentObj->get('isfolder')) {
                    $parentObj->set('isfolder','1');
                    $parentObj->save();
                }

           }

           $resource->save();
           // Make sure we have the ID.
           // $resource = $modx->getObject('modResource',array('pagetitle'=>$flds['pagetitle']));
           $postid = isset($postid) ? $postid: $resource->get('id');


            // empty cache
            if($clearcache==1){
                $cacheManager = $modx->getCacheManager();
                $cacheManager->clearCache();
            }

/* handle TVs */
if (! empty ($allTvs)) {
    $resourceId = $resource->get('id');
    foreach($allTvs as $tv) {
        $fields = $tv->toArray();
        switch ($fields['type']) {
            case 'text':
            case 'textbox':
            case 'textarea':
            case 'option':
                echo '<br />Value: ' . $value;
                $value = $_POST[$fields['name']];
                $lvalue = strtok($value,'=');
                $rvalue = strtok('=');
                $value = $rvalue? $rvalue: $lvalue;
                $value = mysql_escape_string($modx->stripTags($value,$allowedTags));

                if (!empty($value)) {
                    $tv->setValue($resourceId,$value);
                    $tv->save();
                }
                break;

            default:
                break;
        }
    }
}

            // get redirect/post id
            //$redirectid = $modx->db->getValue('SELECT id as \'redirectid\' FROM '.$modx->getFullTableName('site_content').' WHERE createdon=\''.$createdon.'\'');


            // redirect to post id
            $goToUrl = $modx->makeUrl($postid);
            if (empty($goToUrl)) {
                die ('Postid: ' . $postid . '<br />goToUrl: ' . $goToUrl);
            }
            $modx->sendRedirect($goToUrl);
        }


    default:
        // display news form
        // check if user has rights to post comments
        // if(!$allowAnyPost && !$modx->isMemberOfWebGroup($postgrp)) {
         if(!$allowAnyPost && !$modx->user->isMember($postgrp)) {
            $formTpl = '';
        } else {
            foreach($_POST as $n=>$v) {
                $formTpl = str_replace('[[+'.$n.']]',$v,$formTpl);
            }
        }
        // return form
        return $message.$formTpl;
        break;
}
?>
