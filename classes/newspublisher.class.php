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
    protected $rtContent;
    protected $rtSummary;
    protected $folder;
    protected $template;
    protected $errors;


    public function __construct(&$modx, &$props) {
        $this->modx = $modx;
        $this->props = $props;
    }

    public function init($richText) {
        $this->modx->lexicon->load('core:resource');
        $this->rtcontent = isset($props['rtcontent']) ? $props['rtcontent']:'content';
        $this->rtsummary = isset($props['rtsummary']) ? $props['rtsummary']:'introtext';
        $this->folder = isset($this->props['folder']) ? intval($this->props['folder']):$this->modx->resource->get('id');
        $this->template = $this->getTemplate();
        //$this->modx->regClientCSS(MODX_ASSETS_URL . 'components/newspublisher/css/demo.css');
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
            $corePath=$this->modx->getOption('core_path').'components/tinymcefe/';
            $this->modx->regClientStartupScript($this->modx->getOption('manager_url').'assets/ext3/adapter/ext/ext-base.js');
            $this->modx->regClientStartupScript($this->modx->getOption('manager_url').'assets/ext3/ext-all.js');
            $this->modx->regClientStartupScript($this->modx->getOption('manager_url').'assets/modext/build/core/modx-min.js');


            $whichEditor = $this->modx->getOption('which_editor',null,'');

            $plugin=$this->modx->getObject('modPlugin',array('name'=>$whichEditor));
            if ($whichEditor == 'TinyMCE' ) {
                $tinyUrl = $this->modx->getOption('assets_url').'components/tinymcefe/';

                /* OnRichTextEditorInit */

                $tinyproperties=$plugin->getProperties();
                require_once $corePath.'tinymce.class.php';
                $tiny = new TinyMCE($this->modx,$tinyproperties,$tinyUrl);
                if (isset($forfrontend) || $this->modx->isFrontend()) {
                    $def = $this->modx->getOption('cultureKey',null,$this->modx->getOption('manager_language',null,'en'));
                    $tiny->properties['language'] = $this->modx->getOption('fe_editor_lang',array(),$def);
                    $tiny->properties['frontend'] = true;
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
    <h2>Create Resource</h2>
    [[!+np.error_header:ifnotempty=`<h3>[[!+np.error_header]]</h3>`]]
    [[!+np.errors_presubmit:ifnotempty=`[[!+np.errors_presubmit]]`]]
    <form action="[[~[[*id]]]]" method="post">

        <input name="hidSubmit" type="hidden" id="hidSubmit" value="true" />
        [[+np.error_pagetitle]]
        <p><label for="pagetitle">[[%resource_pagetitle]]: </label><input name="pagetitle" title="[[%resource_pagetitle_help]]" id="pagetitle" type="text"  value="[[+pagetitle]]" maxlength="60" /></p>
        [[+np.error_longtitle]]
        <p><label for="longtitle">[[%resource_longtitle]]: </label><input name="longtitle" title="[[%resource_longtitle_help]]" id="longtitle" type="text"  value="[[+longtitle]]" maxlength="100" /></p>
        [[+np.error_description]]
        <p><label for="description">[[%resource_description]]: </label><input name="description" title="[[%resource_description_help]]" id="description" type="text"  value="[[+description]]" maxlength="100" /></p>
        [[+np.error_menutitle]]
        <p><label for="menutitle">[[%resource_menutitle]]: </label><input name="menutitle" title="[[%resource_menutitle_help]]" id="menutitle" type="text"  value="[[+menutitle]]" maxlength="60" /></p>
        [[+np.error_pub_date]]
        <div class="datepicker">
        <p><label for="pub_date">[[%resource_publishdate]]: </label><input type="text" class="w4em format-d-m-y divider-dash no-transparency" id="pub_date" name="pub_date" title="[[%resource_publishdate_help]]" maxlength="10" readonly="readonly" value="[[+pub_date]]" /></p>
        [[+np.error__unpub_date]]
        <p><label for="unpub_date">[[%resource_unpublishdate]]: </label><input type="text" class="w4em format-d-m-y divider-dash no-transparency" id="unpub_date" name="unpub_date" title="[[%resource_unpublishdate_help]]" maxlength="10" readonly="readonly" value="[[+unpub_date]]" /></p>
        </div>
        [[+np.error_introtext]]
        <label for="introtext">[[%resource_summary]]: </label><div class="MODX_RichTextWidget"><textarea class="modx-richtext" name="introtext" id="introtext">[[+introtext]]</textarea></div>
        [[+np.error_content]]
        <label for="content">[[%resource_content]]: </label><div class="MODX_RichTextWidget"><textarea class="modx-richtext" name="content" id="content">[[+content]]</textarea></div>';

    $formTpl .= '[[+np.allTVs]]';

    $formTpl .= "\n" . '<p><input class="submit" type="submit" name="Submit" value="Submit" /></p>
    </form></div>';

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
            $this->errors[] = 'You wanted to order TVs, but this template has none';
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
        $this->errors[] = 'No TvTemplates retrieved';

    }

    foreach($tvTemplates as $tvTemplate) {
        $tvObj = $tvTemplate->getOne('TemplateVar');
        if ($tvObj) {
           $this->allTvs[] = $tvObj;
        }
    }

if (! empty($this->allTvs)) {
    //$formTpl .= '<br />';
    $hidden = explode(',',$this->props['hidetvs']);

    foreach ($this->allTvs as $tv) {
      //$formTpl .= '<br />TV Found: ' . $tv->get('name');

      $fields = $tv->toArray();

      /* skip hidden TVs */
      if (in_array($fields['id'],$hidden)) {
          continue;
      }
      $formTpl .=  "\n" . '[[+np.error_'. $fields['name'] . ']]' . "\n";
        $tvType = $tv->get('type');
        $tvType = $tvType == 'option'? 'radio' : $tvType;
//$formTpl .= '<br />TYPE: ' . $tvType . '<br />';
        switch($tvType) {
            case 'text':
            case 'textbox':
            case 'email';
                $formTpl .= "\n" . '<p><label for="' . $fields['name']. '">'. $fields['caption']  . ' </label><input name="' . $fields['name'] . '" id="' . $fields['name'] . '" type="text" size="40" value="[[+' . $fields['name'] . ']]" /></p>';
                break;

            case 'textarea':
                $formTpl .= "\n" . '<p><label>'. $fields['caption']  . '</label><br /><textarea name="' . $fields['name'] . '" id="' . $fields['name'] . '" cols="50" rows="5">' . '[[+' . $fields['name'] . ']]</textarea>';
                break;
// *********

            case 'radio':
            case 'checkbox':
            case 'listbox':
            case 'listbox-multiple':
                $iType = 'input';
                $iType = ($tvType == 'listbox' || $tvType == 'listbox-multiple')? 'option' : $iType;
                $arrayPostfix = ($tvType == 'checkbox' || $tvType=='listbox-multiple')? '[]' : '';
                $options = explode('||',$fields['elements']);

                $formTpl .= "\n" . '<fieldset class="np-tv-' . $tvType . '"><legend>'. $fields['caption']  . '</legend>';

                if($tvType == 'listbox' || $tvType == 'listbox-multiple') {
                    $multiple = ($tvType == 'listbox-multiple')? 'multiple="multiple" ': '';
                    $count = count($options);
                    $max = $this->props['listboxmax'];
                    $size = ($count <= $max)? $count : $max;
                    $formTpl .= "\n" . '<select ' . 'name="'. $fields['name'] . $arrayPostfix . '" ' .  $multiple . 'size="' . $size . '">' . "\n";
                }
                $i=0;
                foreach ($options as $option) {
                    $val = $_POST[$fields['name']];
                    if(empty($val)) {
                        $defaults = explode('||',$fields['default_text']);
                        $option = strtok($option,'=');
                        $rvalue = strtok('=');
                        $rvalue = $rvalue? $rvalue : $option;
                    } else {
                        $rvalue = $option;
                    }
                    if ($tvType == 'listbox' || $tvType =='listbox-multiple') {
                        $formTpl .= '<p>'. "\n    " . '<' . $iType . ' value="' . $rvalue . '"';
                    } else {
                        $formTpl .= '<p>'. "\n    " . '<' . $iType . ' class="' . $tvType . '"' . ' type="' . $tvType . '" name="' . $fields['name'] . $arrayPostfix . '" value="' . $rvalue . '"';
                    }
                    if (empty($val)) {
                        if ($fields['default_text'] == $rvalue || in_array($rvalue,$defaults) ){
                            if ($tvType == 'radio' || $tvType == 'checkbox') {
                                $formTpl .= ' checked="checked" ';
                            } else {
                                $formTpl .= ' selected="selected" ';
                            }
                        }
                    } else {  /* post is not empty */
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
                    $formTpl .= ' />' . $option . '</p>';

                }
                if($tvType == 'listbox' || $tvType == 'listbox-multiple') {
                    $formTpl .= "\n" . '</select>';
                }
                $formTpl .= '</fieldset>';
                break;

            default:
                break;

        }  /* end switch */
        //$formTpl .= '<br />';
    } /* end foreach */
    // $formTpl = "\n" . '<div class = "tvs">' . $formTpl . '</div>' . "\n";
} /* end if (!empty $allTvs) */
return $formTpl;
}

public function saveResource() {
    // $this->message=print_r($_POST,true);

    if(get_magic_quotes_gpc()){

        // $_POST = array_map($this->strip_slashes_deep, $_POST);

    }

    if(trim($_POST['pagetitle'])=='') {
        //$this->errors[] = 'Missing page title';
    } elseif($_POST[$this->rtcontent]=='') {
        //$this->errors[] = 'Missing content';
        // return false;
    } else {
    // get created date

        $createdon = time();

    // set alias name of document used to store articles
        if(!$aliastitle) {
            $alias = 'article-'.$createdon;
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

        $user = $this->modx->user;
        $userid = $this->modx->user->get('id');
        if(!$userid && $allowAnyPost) $user = '(anonymous)';

        // check if user has rights

        if(!$this->props['allowAnyPost'] && !$this->modx->user->isMember($this->props['postgrp'])) {
            $this->errors[] = 'You are not allowed to publish articles';

        }

        $allowedTags = '<p><br><a><i><em><b><strong><pre><table><th><td><tr><img><span><div><h1><h2><h3><h4><h5><font><ul><ol><li><dl><dt><dd>';

        // format content
        $content = $this->modx->stripTags($_POST[$this->rtcontent],$allowedTags);
        $content = str_replace('[[+user]]',$user,$content);
        $content = str_replace('[[+createdon]]',strftime('%d-%b-%Y %H:%M',$createdon),$content);
        foreach($_POST as $n=>$v) {
            if(!empty($badwords)) $v = preg_replace($badwords,'[Filtered]',$v); // remove badwords
            $v = $this->modx->stripTags(htmlspecialchars($v));
            // $v = str_replace("\n",'<br />',$v);
            $content = str_replace('[+'.$n.'+]',$v,$content);
        }
        $folder = $this->folder;

        $title = mysql_escape_string($this->modx->stripTags($_POST['pagetitle']));
        $longtitle = mysql_escape_string($this->modx->stripTags($_POST['longtitle']));
        $menutitle = mysql_escape_string($this->modx->stripTags($_POST['menutitle']));
        $description = mysql_escape_string($this->modx->stripTags($_POST['description']));
        $introtext = mysql_escape_string($this->modx->stripTags($_POST[$this->rtsummary],$allowedTags));
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
            } elseif($pub_date > $createdon) {
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
        $createdBy = $this->modx->user->get('id');

        $flds = array(
            'pagetitle'     => $title,
            'longtitle'     => $longtitle,
            'menutitle'     => $menutitle,
            'description'   => $description,
            'introtext'     => $introtext,
            'alias'         => $alias,
            'parent'        => $folder,
            'createdon'     => $createdon,
            'createdby'     => $createdBy,
            'editedon'      => '0',
            'editedby'      => '0',
            'published'     => $published,
            'pub_date'      => $pub_date,
            'unpub_date'    => $unpub_date,
            'deleted'       => '0',
            'hidemenu'      => $hidemenu,
            'menuindex'     => $mnuidx,
            'template'      => $this->template,
            'content'       => $this->header . $content . $this->footer
        );

        $resource = $this->modx->newObject('modResource',$flds);

        $parentObj = $this->modx->getObject('modResource',$flds['parent']);

         // If there's a parent object, put the new doc in the same resource groups as the parent

        if ($parentObj) {  // skip if no parent


            $resourceGroups = $parentObj->getMany('ResourceGroupResources');

            if (! empty($resourceGroups)) { // skip if parent doesn't belong to any resource groups
                foreach ($resourceGroups as $resourceGroup) {
                    $docGroupNum = $resourceGroup->get('document_group');
                    $docNum = $resourceGroup->get('document');

                    $resourceGroupObj = $this->modx->getObject('modResourceGroup', $docGroupNum);
                    $intersect = $this->modx->newObject('modResourceGroupResource');
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
            $cacheManager = $this->modx->getCacheManager();
            $cacheManager->clearCache();
        }

        /* Save TVs */
        if (! empty ($this->allTvs)) {
            //$this->message .=  '<br />' . 'Saving ' . count($this->allTvs);
            $resourceId = $resource->get('id');
            //$this->message .=  '<br />' . 'Resource ID: '.$resourceId;
            foreach($this->allTvs as $tv) {
                $fields = $tv->toArray();
                //$this->message .= '<br />TV: ' . $tv->get('name') . '<br />' . print_r($_POST[$fields['name']],true);
                switch ($fields['type']) {
                    case 'text':
                    case 'textbox':
                    case 'textarea':
                    case 'option':
                    case 'listbox':
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
                        // return print_r($boxes,true);
                        // echo '<br />TvName: ' . $fields['name'];
                        //echo '<br />ARRAY: ' . $_POST[$fields['name']];

                        // echo '<br />COUNT: ' . count($boxes);
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

        // get redirect/post id
        //$redirectid = $modx->db->getValue('SELECT id as \'redirectid\' FROM '.$modx->getFullTableName('site_content').' WHERE createdon=\''.$createdon.'\'');
        return true;

        // redirect to post id
        $goToUrl = $this->modx->makeUrl($postid);
        if (empty($goToUrl)) {
            // die ('Postid: ' . $postid . '<br />goToUrl: ' . $goToUrl);
        }
        $this->modx->sendRedirect($goToUrl);
    }  /* end else (empty pagetitle or content */

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
protected function getTemplate() {
    // get template
if (isset($this->props['template'])) {
    if(is_numeric($this->props['template']) ) {
        // use it
    } else {
        $t = $this->modx->getObject('modTemplate',array('templatename'=>$this->props['template']));
        if (! $t) {
            $this->errors[] = 'Failed to get template';
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

} /* end class */
?>
