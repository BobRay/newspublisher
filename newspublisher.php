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


// $modx->regClientCSS(MODX_ASSETS_URL . 'components/newspublisher/css/demo.css');
//$modx->regClientCSS(MODX_ASSETS_URL . 'components/newspublisher/css/datepicker.css');
// $modx->regClientStartupScript(MODX_ASSETS_URL . 'components/newspublisher/js/datepicker.js');

//$modx->regClientScript(MODX_ASSETS_URL . 'components/newspublisher/js/mydp.js');

// get user groups that can post articles

$modx->runSnippet('loadrichtext');
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
        <p><label for="content">Content: </label><br /><textarea name="content" cols="70" rows="20">[[+content]]</textarea></p>
        <p><input name="send" type="submit" value="Submit" /></p>

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
            //$redirectid = $modx->db->insert($flds,$modx->getFullTableName('site_content'));
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

                        echo '<br />Document Group: ' . $docGroupNum . ' . . . ' . 'Document: ' . $docNum;
                    }

                }


            }



            // Handle privateweb
           // $modx->db->query("UPDATE ".$modx->getFullTableName("site_content")." SET privateweb = 0 WHERE id='$lastInsertId';");
            //$privatewebSql =    "
            //    SELECT DISTINCT ".$modx->getFullTableName('document_groups').".document_group
            //    FROM ".$modx->getFullTableName('document_groups').", ".$modx->getFullTableName('webgroup_access')."
            //    WHERE
            //    ".$modx->getFullTableName('document_groups').".document_group = ".$modx->getFullTableName('webgroup_access').".documentgroup
            //    AND
             //   ".$modx->getFullTableName('document_groups').".document = $lastInsertId;";
             //   $privatewebIds = $modx->db->getColumn("document_group",$privatewebSql);
             //   if(count($privatewebIds)>0) {
              //      $modx->db->query("UPDATE ".$modx->getFullTableName("site_content")." SET privateweb = 1 WHERE id = $lastInsertId;");
              //  }

                // And privatemgr
              //  $modx->db->query("UPDATE ".$modx->getFullTableName("site_content")." SET privatemgr = 0 WHERE id='$lastInsertId';");
              //  $privatemgrSql =    "
               //     SELECT DISTINCT ".$modx->getFullTableName('document_groups').".document_group
               //     FROM ".$modx->getFullTableName('document_groups').", ".$modx->getFullTableName('membergroup_access')."
               //     WHERE
               //     ".$modx->getFullTableName('document_groups').".document_group = ".$modx->getFullTableName('membergroup_access')." .documentgroup
               //     AND
               //     ".$modx->getFullTableName('document_groups').".document = $lastInsertId;";
               //     $privatemgrIds = $modx->db->getColumn("document_group",$privatemgrSql);
               //     if(count($privatemgrIds)>0) {
               //         $modx->db->query("UPDATE ".$modx->getFullTableName("site_content")." SET privatemgr = 1 WHERE id = $lastInsertId;");
               //     }
            // end of document_groups stuff!

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
             //   include_once $modx->config['base_path']."manager/processors/cache_sync.class.processor.php";
             //   $sync = new synccache();
             //   $sync->setCachepath("assets/cache/");
             //   $sync->setReport(false);
             //   $sync->emptyCache(); // first empty the cache
            //}

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
