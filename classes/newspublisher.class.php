<?php
  /**
 * @name newspublisher.class.php
 * @author Bob Ray
 * @package newspublisher
 *
 * Refactored for OOP and Revolution by Bob Ray, 11/2010
 * The Newspublisher class contains all functions relating to NewsPublsher's
 * functionality and any supporting functions they need.
 */

class Newspublisher {
    protected $modx;
    protected $props;  //scriptProperties array
    protected $allTvs;  // array of TVs.
    protected $message;
    protected $folder;
    protected $template;
    protected $errors;
    protected $resource;
    protected $existing; // editing an existing resource
    protected $isPostBack;




    public function __construct(&$modx, &$props) {
        $this->modx =& $modx;
        $this->props =& $props;
    }

    public function setPostBack($setting) {
        $this->isPostBack = $setting;
    }
/* Check for a resource to edit in $_POST  */

     public function init($richText, $existing=false) {
       if ($existing) {
           // die('Existing: ' . $existing);
           $this->existing=$existing;
           $this->resource = $this->modx->getObject('modResource',$existing);
           if ($this->resource) {
               $ph = $this->resource->toArray();
               $ph['pub_date'] = $ph['pub_date']? substr($ph['pub_date'],0,10) : '';
               $ph['unpub_date'] = $ph['unpub_date']? substr($ph['unpub_date'],0,10) : '';

               $this->modx->toPlaceholders($ph);
           } else {
               $msg = str_replace('[[+id]]',$existing, $this->modx->lexicon('np.no_resource'));
               $this->errors[] = $msg;

           }
       }
       $this->modx->lexicon->load('core:resource');
       $this->template = $this->getTemplate();
       $this->modx->regClientCSS(NEWSPUBLISHER_URL . 'css/datepicker.css');
       $this->modx->regClientStartupScript(NEWSPUBLISHER_URL . 'js/datepicker.js');
       $this->header = $this->modx->getChunk($this->props['headerTpl']);
       $this->footer = $this->modx->getChunk($this->props['footerTpl']);

       /* inject NP CSS file */
       /* empty but sent parameter means use no CSS file at all */

       if ( ! isset($this->props['cssfile'])) { /* nothing sent - use default */
           $css = NEWSPUBLISHER_URL . 'css/newspublisher.css';
       } else if (empty($this->props['cssfile']) ) { /* empty param -- no css file */
           $css = false;
       } else {  /* set but not empty -- use it */
           $css = MODX_CORE_URL . 'components/newspublisher/css/' . $this->props['cssfile'];
       }

       if ($css !== false) {
           $this->modx->regClientCSS($css);
       }

       if ($richText) {
           //$corePath=$this->modx->getOption('core_path').'components/tinymcefe/';
           $tinyPath = $this->modx->getOption('core_path').'components/tinymce/';
           $this->modx->regClientStartupScript($this->modx->getOption('manager_url').'assets/ext3/adapter/ext/ext-base.js');
           $this->modx->regClientStartupScript($this->modx->getOption('manager_url').'assets/ext3/ext-all.js');
           $this->modx->regClientStartupScript($this->modx->getOption('manager_url').'assets/modext/core/modx.js');


           $whichEditor = $this->modx->getOption('which_editor',null,'');

           $plugin=$this->modx->getObject('modPlugin',array('name'=>$whichEditor));
           if ($whichEditor == 'TinyMCE' ) {
               //$tinyUrl = $this->modx->getOption('assets_url').'components/tinymcefe/';

               /* OnRichTextEditorInit */

               $tinyproperties=$plugin->getProperties();
                               require_once $tinyPath.'tinymce.class.php';
               $tiny = new TinyMCE($this->modx,$tinyproperties,$tinyUrl);
               if (isset($forfrontend) || $this->modx->isFrontend()) {
                   $def = $this->modx->getOption('cultureKey',null,$this->modx->getOption('manager_language',null,'en'));
                   $tinyproperties['language'] = $this->modx->getOption('fe_editor_lang',array(),$def);
                   $tinyproperties['frontend'] = true;
                                       //$tinyproperties['selector'] = 'modx-richtext';//alternativ to 'frontend = true' you can use a selector for texareas
                   unset($def);
               }
               $tiny->setProperties($tinyproperties);
               $html = $tiny->initialize();

               $this->modx->regClientStartupScript($tiny->config['assetsUrl'].'jscripts/tiny_mce/langs/'.$tiny->properties['language'].'.js');
               $this->modx->regClientStartupScript($tiny->config['assetsUrl'].'tiny.browser.js');
               $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">
                   Ext.onReady(function() {
                   MODx.loadRTE();
                   });
               </script>');
           } /* end if ($whichEditor == 'TinyMCE') */

       } /* end if ($richtext) */

   } /* end init */

public function displayForm() {


// get form template
    if(isset($formtpl)) $formTpl = $this->modx->getChunk($formtpl);

    if(empty($formTpl)) $formTpl = '
        <div class="newspublisher">
        <h2>[[%np.main_header]]</h2>
        [[!+np.error_header:ifnotempty=`<h3>[[!+np.error_header]]</h3>`]]
        [[!+np.errors_presubmit:ifnotempty=`[[!+np.errors_presubmit]]`]]
        [[!+np.errors:ifnotempty=`[[!+np.errors]]`]]
        <form action="[[~[[*id]]]]" method="post">

            <input name="hidSubmit" type="hidden" id="hidSubmit" value="true" />
            [[+np.error_pagetitle]]
            <label for="pagetitle" title="[[%resource_pagetitle_help]]">[[%resource_pagetitle]]: </label><input name="pagetitle"  id="pagetitle" type="text"  value="[[+pagetitle]]" maxlength="60" />
            [[+np.error_longtitle]]
            <label for="longtitle" title="[[%resource_longtitle_help]]">[[%resource_longtitle]]: </label><input name="longtitle" id="longtitle" type="text"  value="[[+longtitle]]" maxlength="100" />
            [[+np.error_description]]
            <label for="description" title="[[%resource_description_help]]">[[%resource_description]]: </label><input name="description" id="description" type="text"  value="[[+description]]" maxlength="100" />
            [[+np.error_menutitle]]
            <label for="menutitle" title="[[%resource_menutitle_help]]">[[%resource_menutitle]]: </label><input name="menutitle" id="menutitle" type="text"  value="[[+menutitle]]" maxlength="60" />
            [[+np.error_pub_date]]
            <div class="datepicker">
                <span class="npdate"><label for="pub_date" title="[[%resource_publishdate_help]]">[[%resource_publishdate]]: </label><input type="text" class="w4em format-y-m-d divider-dash no-transparency" id="pub_date" name="pub_date" maxlength="10" readonly="readonly" value="[[+pub_date]]" /></span>
                [[+np.error_unpub_date]]
                <span class="npdate"><label for="unpub_date" title="[[%resource_unpublishdate_help]]">[[%resource_unpublishdate]]: </label><input type="text" class="w4em format-y-m-d divider-dash no-transparency" id="unpub_date" name="unpub_date" maxlength="10" readonly="readonly" value="[[+unpub_date]]" /><span class="npdate">
            </div>
            [[+np.error_introtext]]
            <label for="introtext" title="[[%resource_summary_help]]">[[%resource_summary]]: </label><div class="[[+np.rt_summary_1]]"><textarea class="[[+np.rt_summary_2]]" name="introtext" id="introtext">[[+introtext]]</textarea></div>
            [[+np.error_content]]
            <label for="content">[[%resource_content]]: </label><div class="[[+np.rt_content_1]]"><textarea class="[[+np.rt_content_2]]" name="content" id="content">[[+content]]</textarea></div>[[+np.allTVs]]
            [[+np_post_stuff]]
        <span class = "buttons"><input class="submit" type="submit" name="Submit" value="Submit" /><input type="button" class="cancel" name="Cancel" value="Cancel" onclick="window.location = \'[[+np.cancel_url]]\' " /></span>
    </form>
</div>';

    if($this->existing) {
        $stuff = '<input type="hidden" name="np_existing" value="true">' . "\n" .
        '<input type="hidden" name="np_doc_id" value="' . $this->resource->get('id') . '">';
        $this->modx->setPlaceholder('np_post_stuff',$stuff);
    }


    return $formTpl;
    /* done displaying TVs */
} /* end displayForm */

public function displayTVs() {
    /* Display TVs */

    $this->allTvs = array();

    $c = $this->modx->newQuery('modTemplateVarTemplate');
    $where = array('templateid'=>$this->template);
    $c->where($where);
    $c->sortby('tmplvarid','ASC');
    $tvTemplates = $this->modx->getCollection('modTemplateVarTemplate',$c);
    // $tvTemplates = $this->modx->getCollection('modTemplateVarTemplate',array('templateid'=>$this->template));
    if (! empty ($this->props['orderTVs'])) {
        $ids = explode(',', $this->props['orderTVs']);
        if (count($ids) == 0) {
            $this->errors[] = $this->modx->lexicon('np.no_tvs');
        }
     foreach($ids as $id) {
         foreach ($tvTemplates as $tvTemplate) {
             if ($tvTemplate->get('tmplvarid') == $id) {

                 $tvts[] = $tvTemplate;
             }

         }
     }
     $tvTemplates = $tvts;
     }

    if (count($tvTemplates) == 0) {
        $this->errors[] = $this->modx->lexicon('np.no_tv_templates');
    }

    foreach($tvTemplates as $tvTemplate) {
        $tvObj = $tvTemplate->getOne('TemplateVar');
        if ($tvObj) {
           $this->allTvs[] = $tvObj;
        }
    }

if (! empty($this->allTvs)) {

    $hidden = explode(',',$this->props['hidetvs']);

    foreach ($this->allTvs as $tv) {

      $fields = $tv->toArray();

      /* skip hidden TVs */
      if (in_array($fields['id'],$hidden)) {
          continue;
      }
      $caption = empty($fields['caption'])? $fields['name'] : $fields['caption'];
      $formTpl .=  "\n" . '[[+np.error_'. $fields['name'] . ']]' . "\n";
        $tvType = $tv->get('type');
        $tvType = $tvType == 'option'? 'radio' : $tvType;

        switch($tvType) {
            case 'text':
            case 'textbox':
            case 'email';
                $formTpl .= "\n" . '<label for="' . $fields['name']. '" title="'. $fields['description'] . '">'. $caption  . ' </label><input name="' . $fields['name'] . '" id="' . $fields['name'] . '" type="text" size="40" value="[[+' . $fields['name'] . ']]" />';
                if ($this->existing && !$this->isPostBack) {
                    //die('<br />FIELD: ' . $fields['name'] . '<br />VALUE: ' . $tv->renderOutput($this->existing) . '<br />Existing: ' . $this->existing  . '<br />');
                    $this->modx->setPlaceholder($fields['name'],$tv->renderOutput($this->existing) );
                }

                break;

            case 'textarea':
            case 'textareamini':
                if ($this->existing  && ! $this->isPostBack) {
                    //die('<br />FIELD: ' . $fields['name'] . '<br />VALUE: ' . $tv->renderOutput($this->existing) . '<br />Existing: ' . $this->existing  . '<br />');
                    $this->modx->setPlaceholder($fields['name'],$tv->renderOutput($this->existing) );
                }
                $formTpl .= "\n" . '<label title="' . $fields['description'] . '">'. $caption  . '</label><textarea name="' . $fields['name'] . '"'. $fields['description'] . ' id="' . $fields['name'] . '">' . '[[+' . $fields['name'] . ']]</textarea>';
                break;
            case 'richtext':
                if ($this->existing && !$this->isPostBack) {
                    //die('<br />FIELD: ' . $fields['name'] . '<br />VALUE: ' . $tv->renderOutput($this->existing) . '<br />Existing: ' . $this->existing  . '<br />');
                    $this->modx->setPlaceholder($fields['name'],$tv->renderOutput($this->existing) );
                }
                $formTpl .= "\n" . '<label title="'. $fields['description'] . '">'. $caption  . '</label><div class="MODX_RichTextWidget"><textarea class="modx-richtext" name="' . $fields['name'] . '" id="' . $fields['name'] . '">' . '[[+' . $fields['name'] . ']]</textarea></div>';
                break;
               //<label for="content">[[%resource_content]]: </label><div class="[[+np.rt_content_1]]"><textarea class="[[+np.rt_content_2]]" name="content" id="content">[[+content]]</textarea></div>';

// *********

            case 'radio':
            case 'checkbox':
            case 'listbox':
            case 'listbox-multiple':
                $iType = 'input';
                $iType = ($tvType == 'listbox' || $tvType == 'listbox-multiple')? 'option' : $iType;
                $arrayPostfix = ($tvType == 'checkbox' || $tvType=='listbox-multiple')? '[]' : '';
                $options = explode('||',$fields['elements']);

                $formTpl .= "\n" . '<fieldset class="np-tv-' . $tvType . '"' . ' title="' . $fields['description'] . '"><legend>'. $caption  . '</legend>';

                if($tvType == 'listbox' || $tvType == 'listbox-multiple') {
                    $multiple = ($tvType == 'listbox-multiple')? 'multiple="multiple" ': '';
                    $count = count($options);
                    $max = $this->props['listboxmax'];
                    $size = ($count <= $max)? $count : $max;
                    $formTpl .= "\n" . '<select ' . 'name="'. $fields['name'] . $arrayPostfix . '" ' .  $multiple . 'size="' . $size . '">' . "\n";
                }
                $i=0;
                foreach ($options as $option) {
                    if ($this->existing  && ! $this->isPostBack)  {
                        //die('<br />FIELD: ' . $fields['name'] . '<br />VALUE: ' . $tv->renderOutput($this->existing) . '<br />Existing: ' . $this->existing  . '<br />');
                        if (is_array($options)) {
                            $val = explode('||',$tv->getValue($this->existing));
                            // die('VAL: ' . print_r($val,true) . '<br />OPTIONS: ' . print_r($options,true));

                        } else {
                            $val = $tv->renderOutput($this->existing);
                        }

                    } else {
                        $val = $_POST[$fields['name']];
                    }
                    if(empty($val)) {
                        $defaults = explode('||',$fields['default_text']);
                        $option = strtok($option,'=');
                        $rvalue = strtok('=');
                        $rvalue = $rvalue? $rvalue : $option;
                    } else {
                        $rvalue = $option;
                    }
                    if ($tvType == 'listbox' || $tvType =='listbox-multiple') {
                        $formTpl .= "\n    " . '<' . $iType . ' value="' . $rvalue . '"';
                    } else {
                        $formTpl .= "\n    " . '<span class="option"><' . $iType . ' class="' . $tvType . '"' . ' type="' . $tvType . '" name="' . $fields['name'] . $arrayPostfix . '" value="' . $rvalue . '"';
                    }
                    if (empty($val)) {
                        if ($fields['default_text'] == $rvalue || in_array($rvalue,$defaults) ){
                            if ($tvType == 'radio' || $tvType == 'checkbox') {
                                $formTpl .= ' checked="checked" ';
                            } else {
                                $formTpl .= ' selected="selected" ';
                            }
                        }
                    } else {  /* field value is not empty */
                        if (is_array($val) ) {
                            if(in_array($option,$val)) {
                                if ($tvType == 'radio' || $tvType == 'checkbox') {
                                    $formTpl .= ' checked="checked" ';
                                } else {
                                    $formTpl .= ' selected="selected" ';
                                }
                            }
                        } else {
                            if ($option == $val) {
                                if ($tvType == 'radio' || $tvType == 'checkbox') {
                                    $formTpl .= ' checked="checked" ';
                                } else {
                                    $formTpl .= ' selected="selected" ';
                                }
                            }
                        }
                    }
                    $formTpl .= ' />' . $option;
                    if ($tvType != 'listbox' && $tvType != 'listbox-multiple') {
                        $formTpl .= '</span>';
                    }

                }
                if($tvType == 'listbox' || $tvType == 'listbox-multiple') {
                    $formTpl .= "\n" . '</select>';
                }
                $formTpl .= "\n" . '</fieldset>';
                break;

            default:
                break;

        }  /* end switch */

    } /* end foreach */

} /* end if (!empty $allTvs) */
return $formTpl;
}

public function saveResource() {
    //die('<pre>' . print_r($_POST,true));
    if (! $this->existing) {
        $this->resource = $this->modx->newObject('modResource');
    }
    $oldFields = $this->resource->toArray();
    $newFields = $_POST;
    $fields = array_replace($oldFields, $newFields);

    if(get_magic_quotes_gpc()){

        // $_POST = array_map($this->strip_slashes_deep, $_POST);

    }
    $user = $this->modx->user;
    $userid = $this->modx->user->get('id');
    if( (!$userid) && $allowAnyPost) $user = '(anonymous)';

    // check if user has rights -- Fix: Move this to snippet.

    if(!$this->props['allowAnyPost'] && !$this->modx->user->isMember($this->props['postgrp'])) {
        $this->errors[] = $this->modx->lexicon('unauthorized'); // 'You are not allowed to publish articles';
        return;

    }
    if (! $this->existing) {

        $fields['createdon'] = time();

   // set alias name of document used to store articles
        if(!$aliastitle) {
            $alias = 'article-' . time();
        } else {
            $alias = $this->modx->stripTags($_POST['pagetitle']);
            $alias = strtolower($alias);
            $alias = preg_replace('/&.+?;/', '', $alias); // kill entities
            $alias = preg_replace('/[^\.%a-z0-9 _-]/', '', $alias);
            $alias = preg_replace('/\s+/', '-', $alias);
            $alias = preg_replace('|-+|', '-', $alias);
            $alias = trim($alias, '-');
            $alias = 'article-'. mysql_escape_string($alias);
        }

    } else {
        $fields['editedon'] = time();
        $fields['editedby'] = $userid;
    }

        $allowedTags = '<p><br><a><i><em><b><strong><pre><table><th><td><tr><img><span><div><h1><h2><h3><h4><h5><font><ul><ol><li><dl><dt><dd>';

        // format content
        $content = $this->modx->stripTags($_POST['content'],$allowedTags);
        // $content = str_replace('[[+user]]',$user,$content);
        // $content = str_replace('[[+createdon]]',strftime('%d-%b-%Y %H:%M',$createdon),$content);
        foreach($fields as $n=>$v) {
            if(!empty($badwords)) $v = preg_replace($badwords,'[Filtered]',$v); // remove badwords
            if (! is_array($v) ){
                $v = $this->modx->stripTags(htmlspecialchars($v));
            }
            // $v = str_replace("\n",'<br />',$v);
            $content = str_replace('[+'.$n.'+]',$v,$content);
        }


        $fields['title'] = mysql_escape_string($this->modx->stripTags($fields['pagetitle']));
        $fields['longtitle'] = mysql_escape_string($this->modx->stripTags($fields['longtitle']));
        $fields['menutitle'] = mysql_escape_string($this->modx->stripTags($fields['menutitle']));
        $fields['description'] = mysql_escape_string($this->modx->stripTags($fields['description']));
        $fields['introtext'] = mysql_escape_string($this->modx->stripTags($fields['introtext'],$allowedTags));


        $H=isset($hours)? $hours : 0;
        $M=isset($minutes)? $minutes: 1;
        $S=isset($seconds)? $seconds: 0;

        $published = 'notSet';
        // check published date
        if($fields['pub_date']=="") {
            $fields['pub_date']="0";
        } else {
            list($Y, $m, $d) = sscanf($fields['pub_date'], "%4d-%2d-%2d");
            $fields['pub_date'] = strtotime("$m/$d/$Y $H:$M:$S");

            if($fields['pub_date'] <= time()) {
                $fields['published'] = '1';
            } else {
                $fields['published'] = '0';
            }

        }

        // check unpublished date
        if($fields['unpub_date']=="") {
            $fields['unpub_date']="0";
        } else {
            list($Y, $m, $d) = sscanf($fields['unpub_date'], "%4d-%2d-%2d");
            $fields['unpub_date'] = strtotime("$m/$d/$Y $H:$M:$S");
            if($fields['unpub_date'] < time()) {
                $fields['published'] = '0';
            }

        }


        /* post news content, resource groups, and published status */
        if (! $this->existing) {
            $fields['alias'] = $alias;
            $fields['editedon'] = '0';
            $fields['editedby'] = '0';
            $fields['deleted'] = '0';
            $fields['hidemenu'] = $this->props['hidemenu'];
            $fields['template'] = $this->template;
            $fields['content']  = $this->header . $content . $this->footer;
            $fields['parent'] = isset($this->props['folder']) ? intval($this->props['folder']):$this->modx->resource->get('id');;
        }

        $parentObj = $this->modx->getObject('modResource',$fields['parent'] ); // parent of new page


        /* while we have the parent object -
           set published status if not set by pub dates above */
        if ($published == 'notSet') {

            $prop = $this->props['published'];

            if ( ($prop == 'parent') && $parentObj) { /* set from parent */

                $fields['published'] = $parentObj->get('published');
            } else if ($prop === '1') {
                $fields['published'] = '1';
            } else if ($prop === '0') {
                $fields['published'] = '0';
            } else { /* use system default */
                $fields['published'] = $this->modx->getOption('publish_default');
            }

        }

        $this->resource->fromArray($fields);
        if ( ! empty( $this->errors)) {
            /* return without altering the DB */
            return;
        }
        if ( ! $this->resource->save() ){
            $this->errors[] = $this->modx->lexicon('np.resource_save_failed');
            return;
        };
        $resourceId = $this->resource->get('id');
        /* if these are set, we need the parent object if it's a new resource */
        if (! $this->existing) {
            if (($this->props['groups'] || $this->props['makefolder'])) {
                $parentObj = $this->modx->getObject('modResource',$fields['parent'] ); // parent of new page
            }
            if ($parentObj && $this->props['groups'] ) {
                $this->setGroups($parentObj, $resourceId);
            }
            if ($parentObj && $this->props['makefolder']) {
                $this->makeFolder($parentObj);
            }
        }
                // Make sure we have the ID.
        // $resource = $modx->getObject('modResource',array('pagetitle'=>$flds['pagetitle']));
        $postid = isset($postid) ? $postid: $this->resource->get('id');


        /* Save TVs */
        if (! empty ($this->allTvs)) {
            //$this->message .=  '<br />' . 'Saving ' . count($this->allTvs);
            $resourceId = $this->resource->get('id');
            //$this->message .=  '<br />' . 'Resource ID: '.$resourceId;
            foreach($this->allTvs as $tv) {
                $fields = $tv->toArray();
                //$this->message .= '<br />TV: ' . $tv->get('name') . '<br />' . print_r($_POST[$fields['name']],true);
                switch ($fields['type']) {
                    case 'text':
                    case 'textbox':
                    case 'textarea':
                    case 'textareamini';
                    case 'option':
                    case 'listbox':
                    case 'richtext':
                        //echo '<br />Value: ' . $value;
                        $value = $_POST[$fields['name']];
                        $lvalue = strtok($value,'=');
                        $rvalue = strtok('=');
                        $value = $rvalue? $rvalue: $lvalue;
                        $value = mysql_escape_string($this->modx->stripTags($value,$allowedTags));

                        if (!empty($value)) {
                            $tv->setValue($resourceId,$value);
                            $tv->save();
                        }
                        break;
                    case 'checkbox':
                    case 'listbox-multiple':
                        $boxes = $_POST[$fields['name']];
                        $value = implode('||',$boxes);
                        $value = mysql_escape_string($this->modx->stripTags($value,$allowedTags));

                        if (!empty($value)) {
                            $tv->setValue($resourceId,$value);
                            $tv->save();
                        }
                        // echo '<br />Checkboxes: ' . $value;

                        break;

                    default:
                        break;
                } /* end switch(fieldType) */
            } /* end foreach($allTvs) */
        } /* end if (!empty($allTVs)) -- Done saving TVs */



}

public function forward($postId) {
        if (empty($postId)) {
            $postId = $this->existing? $this->existing : $this->resource->get('id');
        }
    /* clear caches on parameter or new resource */
       if ($this->props['clearcache'] || (! $this->existing) ) {
           $cacheManager = $this->modx->getCacheManager();
           $cacheManager->clearCache(array (
                "{$resource->context_key}/",
            ),
            array(
                'objects' => array('modResource', 'modContext', 'modTemplateVarResource'),
                'publishing' => true
                )
            );
       }

        $_SESSION['np_resource_id'] = $this->resource->get('id');
        $goToUrl = $this->modx->makeUrl($postId);

        /* redirect to post id */

        // $goToUrl = $this->modx->makeUrl('270');

         if (empty($goToUrl)) {
            die('Unable to Forward<br />POST ID: ' . $postid . '<br />URL: ' . $goToUrl);
         }

        $this->modx->sendRedirect($goToUrl);
}
protected function stripslashes_deep($value) {
    $value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);
    return $value;
}

public function getErrors() {
    return $this->errors;
}
/* returns the template ID */
protected function getTemplate() {
    // get template
if (isset($this->props['template'])) {
    if(is_numeric($this->props['template']) ) {
        /* make sure it exists */
        if ( ! $this->modx->getObject('modTemplate',$this->props['template']) ) {
            $msg = str_replace('[[+id]]', $this->props['template'], $this->modx->lexicon('np_no_template_id') );
            $this->errors[] = $msg;
        }
    } else {
        $t = $this->modx->getObject('modTemplate',array('templatename'=>$this->props['template']));
        if (! $t) {
            $msg = str_replace('[[+name]]', $this->props['template'], $this->modx->lexicon('np_no_template_name') );
            $this->errors[] = $msg;
        }
        $template = $t? $t->get('id') : $this->modx->getOption('default_template');

    }
} else {
    $template = $this->modx->getOption('default_template');
}

return $template;

}
public function validate($errorTpl) {
    $success = true;
    $fields = explode(',',$this->props['required']);
    if (! empty($fields)) {

        foreach($fields as $field) {
            if (empty($_POST[$field]) ) {
                $success = false;
                $msg = $this->modx->lexicon('np.error_required');
                $msg = str_replace('[[+name]]',$field,$msg);
                // if (empty($errorTpl)) die('No error Tpl');
                $msg = str_replace('[[+np.error]]',$msg,$errorTpl);
                $ph =  'np.error_' . $field;
                $this->modx->setPlaceholder($ph,$msg);
            }
        }
    }
   return $success;
}
/* make the parent into a folder if it's not already */
protected function makeFolder(&$parentObj) {
    if ($parentObj->get('isFolder') == '0') {
        $parentObj->set('isfolder','1');
        $parentObj->save();
    }
}
/* set a new object's resource groups */
protected function setGroups($parentObj, $resourceId) {

    if ($this->props['groups'] == 'parent') {

        /* put the new doc in the same resource groups as the parent */
        $resourceGroups = $parentObj->getMany('ResourceGroupResources');

        if (! empty($resourceGroups)) { /* skip if parent doesn't belong to any resource groups */
            foreach ($resourceGroups as $resourceGroup) {
                $docGroupNum = $resourceGroup->get('document_group');
                $docNum = $resourceGroup->get('document');

                $resourceGroupObj = $this->modx->getObject('modResourceGroup', $docGroupNum);
                $intersect = $this->modx->newObject('modResourceGroupResource');
                $intersect->addOne($this->resource);
                $intersect->addOne($resourceGroupObj);
                $intersect->save();

                // echo '<br />Document Group: ' . $docGroupNum . ' . . . ' . 'Document: ' . $docNum;
            }
        } /* end if (! empty($resourceGroups)) */


    } else {  /* use group list in parameter */
        /* get group names */
        $rGroups = explode(',', $this->props['groups']);
        if (count($rGroups)) {
            foreach($rGroups as $rGroup) {
                $resourceGroupObj = $this->modx->getObject('modResourceGroup',array('name'=>$rGroup));
                if ($resourceGroupObj) {
                    $intersect = $this->modx->newObject('modResourceGroupResource');
                    $intersect->addOne($this->resource);
                    $intersect->addOne($resourceGroupObj);
                    $intersect->save();

                } else {
                    $msg = str_replace('[[+name]]',$rGroup,$this->modx->lexicon('np.no_resource_group') );
                    $this->errors[] = $msg;
                }
            } /* end foreach($rGroups) */
        } /* end if (count($rGroups)) */

    } /* end use group list in parameter */

} /* end setGroups function */



} /* end class */

if (!function_exists('array_replace'))
{
  function array_replace( array &$array, array &$array1 )
  {
    $args = func_get_args();
    $count = func_num_args();

    for ($i = 0; $i < $count; ++$i) {
      if (is_array($args[$i])) {
        foreach ($args[$i] as $key => $val) {
          $array[$key] = $val;
        }
      }
      else {
        trigger_error(
          __FUNCTION__ . '(): Argument #' . ($i+1) . ' is not an array',
          E_USER_WARNING
        );
        return NULL;
      }
    }

    return $array;
  }
}

?>
