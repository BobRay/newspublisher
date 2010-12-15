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
 * creating resources. Rich text editing is available for text fields
 * and rich text template variables.
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
    protected $corePath; // path to NewsPublisher Core
    protected $assetsPath; // path to NewsPublisher assets dir
    protected $assetsUrl; // URL to NewsPublisher assets dir
    protected $hidemenu; // hide docs from menu
    protected $aliastitle; // use alias as title
    protected $clearcache;
    protected $header;
    protected $footer;
    protected $listboxmax;
    protected $prefix; // prefix for placeholders




    public function __construct(&$modx, &$props) {
        $this->modx =& $modx;
        $this->props =& $props;
        /* NP paths; Set the properties in NP only for development */
        $this->corePath = $this->modx->getOption('np.core_path',null,MODX_CORE_PATH.'components/newspublisher/');
        $this->assetsPath = $this->modx->getOption('np.assets_path',null,MODX_ASSETS_PATH.'components/newspublisher/');
        $this->assetsUrl = $this->modx->getOption('np.assets_url',null,MODX_ASSETS_URL.'components/newspublisher/');
    }

    public function setPostBack($setting) {
        $this->isPostBack = $setting;
    }
    public function getPostBack() {
        return $this->isPostBack;
    }
/* Check for a resource to edit in $_POST  */

    public function init($context) {

        switch ($context) {
            case 'mgr': break;
            case 'web':
            default:
                $language = isset($this->props['language']) ? $this->props['language'] . ':' : '';
                $this->modx->lexicon->load($language.'newspublisher:default');
                break;
        }
        $this->prefix = $this->props['prefix'];
        /* see if we're editing an existing doc */
        $this->existing = false;
        if (isset($_POST['np_existing']) && $_POST['np_existing'] == 'true' ) {
            $this->existing = is_numeric($_POST['np_doc_id'])? $_POST['np_doc_id'] : false;
        }


        /* see if it's a repost */
        $this->setPostback( isset($_POST['hidSubmit']) && $_POST['hidSubmit'] == 'true');

        if($this->existing) {
            
            $this->resource = $this->modx->getObject('modResource', $this->existing);
            if ($this->resource) {
                if ($this->isPostBack) {
                    /* str_replace to prevent showing of placeholders */
                         $fs = array();
                         foreach($_POST as $k=>$v) {
  	                         $fs[$k] = str_replace(array('[',']'),array('&#91;','&#93'),$v);
                         }
                    $this->modx->toPlaceholders($fs,$this->prefix);

                } else {
                    $ph = $this->resource->toArray();
                    foreach($ph as $k=>$v) {
  	                         $fs[$k] = str_replace(array('[',']'),array('&#91;','&#93'),$v);
                     }
                     $ph = $fs;
                    $ph['pub_date'] = $ph['pub_date']? substr($ph['pub_date'],0,10) : '';
                    $ph['unpub_date'] = $ph['unpub_date']? substr($ph['unpub_date'],0,10) : '';

                    $this->modx->toPlaceholders($ph,$this->prefix);
                    unset($ph);
                }
            } else {
               $msg = str_replace('[[+id]]',$existing, $this->modx->lexicon('np_no_resource'));
               $this->setError($msg);
               return;

            }
            /* need to forward this from $_POST so we know it's an existing doc */
            $stuff = '<input type="hidden" name="np_existing" value="true">' . "\n" .
            '<input type="hidden" name="np_doc_id" value="' . $this->resource->get('id') . '">';
            $this->modx->toPlaceholder('post_stuff',$stuff,$this->prefix);
            
        } else {
            if ($this->isPostBack) {
                /* str_replace to prevent showing of placeholders */
                 $fs = array();
                 foreach($_POST as $k=>$v) {
                     $fs[$k] = str_replace(array('[',']'),array('&#91;','&#93;'),$v);
                 }
                $this->modx->toPlaceholders($fs,$this->prefix);
            }
        }
        if ($this->existing){
            if (!$this->modx->hasPermission('view_document') || !$this->resource->checkPolicy('view') ) {
                $this->setError($this->modx->lexicon('np_view_permission_denied'));
            }
        } else {
            if (!$this->modx->hasPermission('new_document')) {
                $this->setError($this->modx->lexicon('np_create_permission_denied'));
            }
        }
        $this->aliastitle = isset($this->props['aliastitle'])? true : false;
        $this->clearcache = isset($this->props['clearcache']) ? true: false;

        /* get folder id where we should store articles
           else store under current document */
        $this->folder = isset($this->props['folder']) ? intval($this->props['folder']):$modx->resource->get('id');
        if(isset($this->props['badwords'])) {
            $this->badwords = str_replace(' ','', $this->props['badwords']);
            $this->badwords = "/".str_replace(',','|', $this->badwords)."/i";
        }
        // get menu status
        $this->hidemenu = isset($this->props['showinmenu']) && $this->props['showinmenu']=='1' ? '0' : '1';

      
       $this->modx->lexicon->load('core:resource');
       $this->template = $this->getTemplate();
       $this->modx->regClientCSS($this->assetsUrl . 'datepicker/css/datepicker.css');
       $this->modx->regClientStartupScript($this->assetsUrl . 'datepicker/js/datepicker.js');
       $this->header = isset($this->props['headertpl']) ? $this->modx->getChunk($this->props['headertpl']) : '';
       $this->footer = isset($this->props['footertpl']) ? $this->modx->getChunk($this->props['footertpl']):'';

       /* inject NP CSS file */
       /* empty but sent parameter means use no CSS file at all */

       if ( ! isset($this->props['cssfile'])) { /* nothing sent - use default */
           $css = $this->assetsUrl . 'css/newspublisher.css';
       } else if (empty($this->props['cssfile']) ) { /* empty param -- no css file */
           $css = false;
       } else {  /* set but not empty -- use it */
           $css = $this->assetsUrl . 'components/newspublisher/css/' . $this->props['cssfile'];
       }

       if ($css !== false) {
           $this->modx->regClientCSS($css);
       }
       //set listbox max size
       $this->listboxmax = isset($this->props['listboxmax'])? $this->props['listboxmax'] : 8;

       /* do rich text stuff */
       if ($this->props['richtext']) {
           
            /* set rich text content field */
            $ph = isset($this->props['rtcontent']) ? 'MODX_RichTextWidget':'content';
            $this->modx->setPlaceholder('np.rt_content_1', $ph );
            $ph = isset($this->props['rtcontent']) ? 'modx-richtext':'content';
            $this->modx->setPlaceholder('np.rt_content_2', $ph );

            /* set rich text summary field */
            $ph = isset($this->props['rtsummary']) ? 'MODX_RichTextWidget':'introtext';
            $this->modx->setPlaceholder('np.rt_summary_1', $ph );
            $ph = isset($this->props['rtsummary']) ? 'modx-richtext':'introtext';
            $this->modx->setPlaceholder('np.rt_summary_2', $ph );

            unset($ph);
           
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
        <h2>[[%np_main_header]]</h2>
        [[!+np.error_header:ifnotempty=`<h3>[[!+np.error_header]]</h3>`]]
        [[!+np.errors_presubmit:ifnotempty=`[[!+np.errors_presubmit]]`]]
        [[!+np.errors_submit:ifnotempty=`[[!+np.errors_submit]]`]]
        [[!+np.errors:ifnotempty=`[[!+np.errors]]`]]
        <form action="[[~[[*id]]]]" method="post">

            <input name="hidSubmit" type="hidden" id="hidSubmit" value="true" />
            [[+np.error_pagetitle]]
            <label for="pagetitle" title="[[%resource_pagetitle_help]]">[[%resource_pagetitle]]: </label><input name="pagetitle"  id="pagetitle" type="text"  value="[[+np.pagetitle]]" maxlength="60" />
            [[+np.error_longtitle]]
            <label for="longtitle" title="[[%resource_longtitle_help]]">[[%resource_longtitle]]: </label><input name="longtitle" id="longtitle" type="text"  value="[[+np.longtitle]]" maxlength="100" />
            [[+np.error_description]]
            <label for="description" title="[[%resource_description_help]]">[[%resource_description]]: </label><input name="description" id="description" type="text"  value="[[+np.description]]" maxlength="100" />
            [[+np.error_menutitle]]
            <label for="menutitle" title="[[%resource_menutitle_help]]">[[%resource_menutitle]]: </label><input name="menutitle" id="menutitle" type="text"  value="[[+np.menutitle]]" maxlength="60" />
            [[+np.error_pub_date]]
            <div class="datepicker">
                <span class="npdate"><label for="pub_date" title="[[%resource_publishdate_help]]">[[%resource_publishdate]] [[%np_date_hint]]: </label><input type="text" class="w4em [[%np_date_format]] divider-dash no-transparency" id="pub_date" name="pub_date" maxlength="10" readonly="readonly" value="[[+np.pub_date]]" /></span>
                [[+np.error_unpub_date]]
                <span class="npdate"><label for="unpub_date" title="[[%resource_unpublishdate_help]]">[[%resource_unpublishdate]] [[%np_date_hint]]: </label><input type="text" class="w4em [[%np_date_format]] divider-dash no-transparency" id="unpub_date" name="unpub_date" maxlength="10" readonly="readonly" value="[[+np.unpub_date]]" /><span class="npdate">
            </div>
            [[+np.error_introtext]]
            <label for="introtext" title="[[%resource_summary_help]]">[[%resource_summary]]: </label><div class="[[+np.rt_summary_1]]"><textarea class="[[+np.rt_summary_2]]" name="introtext" id="introtext">[[+np.introtext]]</textarea></div>
            [[+np.error_content]]
            <label for="content">[[%resource_content]]: </label><div class="[[+np.rt_content_1]]"><textarea class="[[+np.rt_content_2]]" name="content" id="content">[[+np.content]]</textarea></div>
            [[+np.allTVs]]
            [[+np.post_stuff]]
        <span class = "buttons"><input class="submit" type="submit" name="Submit" value="Submit" /><input type="button" class="cancel" name="Cancel" value="Cancel" onclick="window.location = \'[[+np.cancel_url]]\' " /></span>
    </form>
</div>';



    return $formTpl;

} /* end displayForm */

public function displayTVs() {
    /* Display TVs */

    $this->allTvs = array();

    /* get the array of TVs for this template in order of ID */
    $c = $this->modx->newQuery('modTemplateVarTemplate');
    $where = array('templateid'=>$this->template);
    $c->where($where);
    $c->sortby('tmplvarid','ASC');
    $tvTemplates = $this->modx->getCollection('modTemplateVarTemplate',$c);


    /* re-sort TVs by &orderTVs if sent */
    if (! empty ($this->props['orderTVs'])) {
        $ids = explode(',', $this->props['orderTVs']);
        if (count($ids) == 0) {
            $this->setError($this->modx->lexicon('np_no_tvs'));
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
    if (! empty($tvTemplates)) {
        foreach($tvTemplates as $tvTemplate) {
            $tvObj = $tvTemplate->getOne('TemplateVar');
            if ($tvObj) {
               $this->allTvs[] = $tvObj;
            }
        }
    }

/* we have some TVs to show */
/* Build TVs dynamically based on type */
if (! empty($this->allTvs)) {

    $hidden = explode(',',$this->props['hidetvs']);

    foreach ($this->allTvs as $tv) {

      $fields = $tv->toArray();

      /* skip hidden TVs */
      if (in_array($fields['id'],$hidden)) {
          continue;
      }
      /* use TV's name as caption if caption is empty */
      $caption = empty($fields['caption'])? $fields['name'] : $fields['caption'];

      /* create error placeholder for field */
      $formTpl .=  "\n" . '[[+np.error_'. $fields['name'] . ']]' . "\n";

      /* Build TV input code dynamically based on type */
      $tvType = $tv->get('type');
      $tvType = $tvType == 'option'? 'radio' : $tvType;


      switch($tvType) {
            case 'text':
            case 'textbox':
            case 'email';
            case 'image';
                $formTpl .= "\n" . '<label for="' . $fields['name']. '" title="'. $fields['description'] . '">'. $caption  . ' </label><input name="' . $fields['name'] . '" id="' .                    $fields['name'] . '" type="text" size="40" value="[[+' .$this->prefix .'.' . $fields['name'] . ']]" />';
                if ($this->existing && !$this->isPostBack) {
                    $this->modx->setPlaceholder($this->prefix . '.' . $fields['name'],$tv->renderOutput($this->existing) );
                }

                break;

            case 'textarea':
            case 'textareamini':
                if ($this->existing  && ! $this->isPostBack) {
                    //die('<br />FIELD: ' . $fields['name'] . '<br />VALUE: ' . $tv->renderOutput($this->existing) . '<br />Existing: ' . $this->existing  . '<br />');
                    $this->modx->setPlaceholder($this->prefix . '.' . $fields['name'],$tv->renderOutput($this->existing) );
                }
                $formTpl .= "\n" . '<label title="' . $fields['description'] . '">'. $caption  . '</label><textarea name="' . $fields['name'] . '"'. $fields['description'] . ' id="' . $fields['name'] . '">' . '[[+'. $this->prefix . '.' . $fields['name'] . ']]</textarea>';
                break;
            case 'richtext':
                if ($this->existing && !$this->isPostBack) {
                    //die('<br />FIELD: ' . $fields['name'] . '<br />VALUE: ' . $tv->renderOutput($this->existing) . '<br />Existing: ' . $this->existing  . '<br />');
                    $this->modx->setPlaceholder($this->prefix . '.' . $fields['name'],$tv->renderOutput($this->existing) );
                }
                $formTpl .= "\n" . '<label title="'. $fields['description'] . '">'. $caption  . '</label><div class="MODX_RichTextWidget"><textarea class="modx-richtext" name="' . $fields['name'] . '" id="' . $fields['name'] . '">' . '[[+' . $this->prefix . '.' . $fields['name'] . ']]</textarea></div>';
                break;


            /********* Options *********/

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
                    $max = $this->listboxmax;
                    $size = ($count <= $max)? $count : $max;
                    $formTpl .= "\n" . '<select ' . 'name="'. $fields['name'] . $arrayPostfix . '" ' .  $multiple . 'size="' . $size . '">' . "\n";
                }
                $i=0;
                foreach ($options as $option) {
                    if ($this->existing  && ! $this->isPostBack)  {

                        if (is_array($options)) {
                            $val = explode('||',$tv->getValue($this->existing));
                        } else {
                            $val = $tv->renderOutput($this->existing);
                        }

                    } else {
                        $val = $_POST[$fields['name']];
                    }
                    /* if field is empty, get the default value */
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

    if (! $this->existing) {
        $this->resource = $this->modx->newObject('modResource');
    }
    $oldFields = $this->resource->toArray();
    $newFields = $_POST;
    $fields = array_replace($oldFields, $newFields);

    $user = $this->modx->user;
    $userid = $this->modx->user->get('id');
    
    if (! $this->existing) {

        $fields['createdon'] = time();

        /* set alias name of document used to store articles */

        if (empty($fields['alias'])) { /* leave it alone if filled */
            if(!$this->aliastitle) { /* default */
                $alias = 'article-' . time();
            } else { /* use pagetitle */
                $alias = $this->modx->stripTags($_POST['pagetitle']);
                $alias = strtolower($alias);
                $alias = preg_replace('/&.+?;/', '', $alias); // kill entities
                $alias = preg_replace('/[^\.%a-z0-9 _-]/', '', $alias);
                $alias = preg_replace('/\s+/', '-', $alias);
                $alias = preg_replace('|-+|', '-', $alias);
                $alias = trim($alias, '-');
                $alias = mysql_escape_string($alias);
            }
            if($this->props['aliaslower']) {
                    $alias=strtolower($alias);
            }
            $fields['alias'] = $alias;
        }
    /* set editedon and editedby for existing docs */
    } else {
        $fields['editedon'] = time();
        $fields['editedby'] = $userid;
    }

    $allowedTags = '<p><br><a><i><em><b><strong><pre><table><th><td><tr><img><span><div><h1><h2><h3><h4><h5><font><ul><ol><li><dl><dt><dd>';


    $content = $this->modx->stripTags($fields['content'],$allowedTags);

    foreach($fields as $n=>$v) {
        if(!empty($this->badwords)) $v = preg_replace($this->badwords,'[Filtered]',$v); // remove badwords
        if (! is_array($v) ){
            $v = $this->modx->stripTags(htmlspecialchars($v));
        }
        $content = str_replace('[[+'.$n.']]',$v,$content);
    }


    $fields['title'] = $fields['pagetitle'];
    
    $published = 'notSet';

    /* set published status for raw save() */
    if (false) {

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

    }
        
    if (! $this->existing) {

        $fields['editedon'] = '0';
        $fields['editedby'] = '0';
        $fields['deleted'] = '0';
        $fields['hidemenu'] = $this->hidemenu;
        $fields['template'] = $this->template;
        $fields['content']  = $this->header . $fields['content'] . $this->footer;
        $fields['parent'] = $this->folder;
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
        /* can probably remove this */
        $this->resource->fromArray($fields);
        if ( ! empty( $this->errors)) {
            /* return without altering the DB */
            return '';
        }

        /* Add TVs to $fields for procesor */
        /* e.g. $fields[tv13] = $_POST['MyTv5'] */
        /* processor handles all types */
        foreach($this->allTvs as $tv) {
            $fields['tv' . $tv->get('id')] = $_POST[$tv->get('name')];
        }
        

        
        /* update $_POST from $fields array */
        /* can be removed if $_POST is removed from runProcessor code */
        $_POST = array_merge($_POST,$fields);

        /* call the appropriate processor to save resource and TVs */
        if ($this->existing) {
           $response = $this->modx->runProcessor('resource/update',$fields);
        } else {
            //die('Content: ' . $fields['content']);
            $response = $this->modx->runProcessor('resource/create',$fields);
        }
        if ($response->isError()) {
           if ($response->hasFieldErrors()) {
               $fieldErrors = $response->getAllErrors();
               $errorMessage = implode("\n",$fieldErrors);
           } else {
               $errorMessage = 'An error occurred: '.$response->getMessage();
           }
           $this->setError($errorMessage);
           return '';

        } else {
           $object = $response->getObject();
           $this->resource = $this->modx->getObject('modResource',$object['id']);
           //$id = $object['id'];
        }
        
        if ($this->resource) {
            $resourceId = $this->resource->get('id');
        } else {
            return 'Cant get Resource';
        }
        /* if these are set, we need the parent object if it's a new resource */
        if (! $this->existing) {
            if (($this->props['groups'])) {
                $parentObj = $this->modx->getObject('modResource',$fields['parent'] ); // parent of new page
            }
            if ($parentObj && $this->props['groups'] ) {
                $this->setGroups($parentObj, $resourceId);
            }
        }
} /* end saveResource() */

public function forward($postId) {
        if (empty($postId)) {
            $postId = $this->existing? $this->existing : $this->resource->get('id');
        }
    /* clear cache on parameter or new resource */
       if ($this->clearcache || (! $this->existing) ) {
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

        /* The next two lines can probably be removed once makeUrl()
         *  and sendRedirect() are updated */
        $controller = $this->modx->getOption('request_controller',null,'index.php');
        $goToUrl = $controller . '?id=' . $postId;

        $this->modx->sendRedirect($goToUrl);
}

/* allows strip slashes on an array
 * not used, but may have to be called if magic_quotes_gpc causes trouble
 * */
protected function stripslashes_deep($value) {
    $value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);
    return $value;
}
/* return any errors set in the class */
public function getErrors() {
    return $this->errors;
}

public function setError($msg) {
    $this->errors[] = $msg;
}
/** Set class property */
public function setProperty($prop,$value) {
    $this->props[$prop] = $value;
}
/* returns the template ID */
protected function getTemplate() {
    if ($this->existing) {
        return $this->resource->get('template');
    }
    $template = $this->modx->getOption('default_template');

    if ($this->props['template'] == 'parent') {
        if (empty($this->props['folder'])) {
            $this->setError($this->modx->lexicon('np_folder_not_sent'));
        }
        $parentObj = $this->modx->getObject('modResource',$this->props['folder']);
        if ($parentObj) {
            $template = $parentObj->get('template');
            unset($parentObj);
        }

    } else if (! empty($this->props->template)) {


        if(is_numeric($this->props['template']) ) { /* user sent a number */
            /* make sure it exists */
            if ( ! $this->modx->getObject('modTemplate',$this->props['template']) ) {
                $msg = str_replace('[[+id]]', $this->props['template'], $this->modx->lexicon('np_no_template_id') );
                $this->SetError($msg);
            }
        } else { /* user sent a template name */
            $t = $this->modx->getObject('modTemplate',array('templatename'=>$this->props['template']));
            if (! $t) {
                $msg = str_replace('[[+name]]', $this->props['template'], $this->modx->lexicon('np_no_template_name') );
                $this->setError($msg);
            }
            $template = $t? $t->get('id') : $this->modx->getOption('default_template');
            unset($t);

        }
    }

    return $template;
}
/* set error if required field is empty */
public function validate($errorTpl) {
    $success = true;
    $fields = explode(',',$this->props['required']);
    if (! empty($fields)) {

        foreach($fields as $field) {
            if (empty($_POST[$field]) ) {
                $success = false;
                /* set ph for field error msg */
                $msg = $this->modx->lexicon('np_error_required');
                $msg = str_replace('[[+name]]',$field,$msg);
                $msg = str_replace('[[+np.error]]',$msg,$errorTpl);
                $ph =  'np.error_' . $field;
                $this->modx->setPlaceholder($ph,$msg);

                /* set error for header */
                $msg = $this->modx->lexicon('np_missing_field');
                $msg = str_replace('[[+name]]',$field,$msg);
                $this->setError($msg);

            }
        }
    }
    
    return $success;
}

/* set a new object's resource groups -- only called for new resources */
protected function setGroups($parentObj, $resourceId) {
    /* use the parent's groups if &groups is set to `parent` */
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
                    $msg = str_replace('[[+name]]',$rGroup,$this->modx->lexicon('np_no_resource_group') );
                    $this->setError($msg);
                }
            } /* end foreach($rGroups) */
        } /* end if (count($rGroups)) */

    } /* end use group list in parameter */

} /* end setGroups function */

} /* end class */

/* array_replace function for pre PHP 5.3 */
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
