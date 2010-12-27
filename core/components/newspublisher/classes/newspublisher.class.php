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
    protected $errors;
    protected $resource;
    protected $parentId;
    protected $parentObj;
    protected $existing; // editing an existing resource (ID of resource)
    protected $isPostBack;
    protected $corePath; // path to NewsPublisher Core
    protected $assetsPath; // path to NewsPublisher assets dir
    protected $assetsUrl; // URL to NewsPublisher assets dir
    protected $aliasTitle; // use alias as title
    protected $clearcache;
    protected $header;
    protected $footer;
    protected $listboxmax;
    protected $prefix; // prefix for placeholders
    protected $badwords; // words to remove
    protected $published;
    protected $hideMenu;
    protected $alias;
    protected $cacheable;
    protected $searchable;
    protected $template;
    protected $tpls; // array of tpls





    public function __construct(&$modx, &$props) {
        $this->modx =& $modx;
        $this->props =& $props;
        /* NP paths; Set the np. System Settings only for development */
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
                $language = ! empty($this->props['language']) ? $this->props['language'] . ':' : '';
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

                if (!$this->modx->hasPermission('view_document') || !$this->resource->checkPolicy('view') ) {
                    $this->setError($this->modx->lexicon('np_view_permission_denied'));
                }
                if ($this->isPostBack) {
                    /* str_replace to prevent showing of placeholders */
                     $fs = array();
                     foreach($_POST as $k=>$v) {
                         $fs[$k] = str_replace(array('[',']'),array('&#91;','&#93;'),$v);
                     }
                    $this->modx->toPlaceholders($fs,$this->prefix);

                } else {
                    $ph = $this->resource->toArray();
                    foreach($ph as $k=>$v) {
                             $fs[$k] = str_replace(array('[',']'),array('&#91;','&#93;'),$v);
                     }
                     $ph = $fs;
                    $ph['pub_date'] = $ph['pub_date']? substr($ph['pub_date'],0,10) : '';
                    $ph['unpub_date'] = $ph['unpub_date']? substr($ph['unpub_date'],0,10) : '';

                    $this->modx->toPlaceholders($ph,$this->prefix);
                    unset($ph);
                }
            } else {
               $this->setError($this->modx->lexicon('np_no_resource') . $this->existing);
               return;

            }
            /* need to forward this from $_POST so we know it's an existing doc */
            $stuff = '<input type="hidden" name="np_existing" value="true" />' . "\n" .
            '<input type="hidden" name="np_doc_id" value="' . $this->resource->get('id') . '" />';
            $this->modx->toPlaceholder('post_stuff',$stuff,$this->prefix);

        } else {
            /* new document */
            if (!$this->modx->hasPermission('new_document')) {
                $this->setError($this->modx->lexicon('np_create_permission_denied'));
            }
            $this->resource = $this->modx->newObject('modResource');
            /* get folder id where we should store articles
             else store under current document */
             $this->parentId = !empty($this->props['parent']) ? intval($this->props['parent']):$this->modx->resource->get('id');

            /* str_replace to prevent showing of placeholders */
             $fs = array();
             foreach($_POST as $k=>$v) {
                 $fs[$k] = str_replace(array('[',']'),array('&#91;','&#93;'),$v);
             }
             $this->modx->toPlaceholders($fs,$this->prefix);


             $this->aliasTitle = $this->props['aliastitle']? true : false;
             $this->listboxmax = $this->props['listboxmax']? $this->props['listboxmax'] : 8;
             $this->clearcache = isset($_POST['clearcache'])? $_POST['clearcache'] : $this->props['clearcache'] ? true: false;
             /* ToDo: add synchcache in processor fields */
             $this->hideMenu = isset($_POST['hidemenu'])? $_POST['hidemenu'] : $this->setDefault('hidemenu',$this->parentId);
             $this->resource->set('hidemenu', $this->hideMenu);

             $this->cacheable = isset($_POST['cacheable'])? $_POST['cacheable'] : $this->setDefault('cacheable',$this->parentId);
             $this->resource->set('cacheable', $this->cacheable);

             $this->searchable = isset($_POST['searchable'])? $_POST['searchable'] : $this->setDefault('searchable',$this->parentId);
             $this->resource->set('searchable', $this->searchable);

             $this->published = isset($_POST['published'])? $_POST['published'] : $this->setDefault('published',$this->parentId);
             $this->resource->set('published', $this->published);

             /*ToDo: Check groups */
             if (! empty($this->props['groups'])) {
                $this->groups = $this->setDefault('groups',$this->parentId);
             }
             $this->header = !empty($this->props['headertpl']) ? $this->modx->getChunk($this->props['headertpl']) : '';
             $this->footer = !empty($this->props['footertpl']) ? $this->modx->getChunk($this->props['footertpl']):'';



        }
         if( !empty($this->props['badwords'])) {
             $this->badwords = str_replace(' ','', $this->props['badwords']);
             $this->badwords = "/".str_replace(',','|', $this->badwords)."/i";
         }

       $this->modx->lexicon->load('core:resource');
       $this->template = $this->getTemplate();
       if($this->props['initdatepicker']) {
            $this->modx->regClientCSS($this->assetsUrl . 'datepicker/css/datepicker.css');
            $this->modx->regClientStartupScript($this->assetsUrl . 'datepicker/js/datepicker.js');
       }

       /* inject NP CSS file */
       /* empty but sent parameter means use no CSS file at all */

       if (empty($this->props['cssfile'])) { /* nothing sent - use default */
           $css = $this->assetsUrl . 'css/newspublisher.css';
       } else if (empty($this->props['cssfile']) ) { /* empty param -- no css file */
           $css = false;
       } else {  /* set but not empty -- use it */
           $css = $this->assetsUrl . 'components/newspublisher/css/' . $this->props['cssfile'];
       }

       if ($css !== false) {
           $this->modx->regClientCSS($css);
       }

       $ph = ! empty($this->props['contentrows'])? $this->props['contentrows'] : '10';
       $this->modx->setPlaceholder('np.contentrows',$ph);

       $ph = ! empty($this->props['contentcols'])? $this->props['contentcols'] : '60';
       $this->modx->setPlaceholder('np.contentcols',$ph);

       $ph = ! empty($this->props['summaryrows'])? $this->props['summaryrows'] : '10';
       $this->modx->setPlaceholder('np.summaryrows',$ph);

       $ph = ! empty($this->props['summarycols'])? $this->props['summarycols'] : '60';
       $this->modx->setPlaceholder('np.summarycols',$ph);

       /* do rich text stuff */
        //$ph = ! empty($this->props['rtcontent']) ? 'MODX_RichTextWidget':'content';
        $ph = ! empty($this->props['rtcontent']) ? 'modx-richtext':'content';
        $this->modx->setPlaceholder('np.rt_content_1', $ph );
        $ph = ! empty($this->props['rtcontent']) ? 'modx-richtext':'content';
        $this->modx->setPlaceholder('np.rt_content_2', $ph );

        /* set rich text summary field */
        //$ph = ! empty($this->props['rtsummary']) ? 'MODX_RichTextWidget':'introtext';
        $ph = ! empty($this->props['rtsummary']) ? 'modx-richtext':'introtext';
        $this->modx->setPlaceholder('np.rt_summary_1', $ph );
        $ph = ! empty($this->props['rtsummary']) ? 'modx-richtext':'introtext';
        $this->modx->setPlaceholder('np.rt_summary_2', $ph );

        unset($ph);
       if ($this->props['initrte']) {

            /* set rich text content field */


           $tinyPath = $this->modx->getOption('core_path').'components/tinymce/';
           $this->modx->regClientStartupScript($this->modx->getOption('manager_url').'assets/ext3/adapter/ext/ext-base.js');
           $this->modx->regClientStartupScript($this->modx->getOption('manager_url').'assets/ext3/ext-all.js');
           $this->modx->regClientStartupScript($this->modx->getOption('manager_url').'assets/modext/core/modx.js');


           $whichEditor = $this->modx->getOption('which_editor',null,'');

           $plugin=$this->modx->getObject('modPlugin',array('name'=>$whichEditor));
           if ($whichEditor == 'TinyMCE' ) {
               //$tinyUrl = $this->modx->getOption('assets_url').'components/tinymcefe/';
                $tinyUrl = $this->modx->getOption('assets_url').'components/tinymce/';
               /* OnRichTextEditorInit */

               $tinyproperties=$plugin->getProperties();
               require_once $tinyPath.'tinymce.class.php';
               $tiny = new TinyMCE($this->modx,$tinyproperties,$tinyUrl);
               if (isset($this->props['forfrontend']) || $this->modx->isFrontend()) {
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

public function setDefault($field,$parentId) {

    $retVal = null;
    $prop = $this->props[$field];
    if ($prop == 'Parent' || $prop == 'parent') {
        /* get parent if we don't already have it */
        if (! $this->parentObj) {
            $this->parentObj = $this->modx->getObject('modResource',$this->parentId);
        }
        if (! $this->parentObj) {
            $this->setError('&amp;' .$this->modx->lexicon('np_no_parent'));
            return $retVal;
        }
    }
    $prop = (string) $prop; // convert booleans
    $prop == 'Yes'? '1': $prop;
    $prop = $prop == 'No'? '0' :$prop;

    if ($prop != 'System Default') {
        if ($prop === '1' || $prop === '0') {
            $retVal = $prop;

        } else if ($prop == 'parent' || $prop === 'Parent') {
            if ($field == 'groups') {
                $groupString = $this->setGroups($prop, $this->parentObj);
                $retVal = $groupString;
                unset($groupString);
            } else {
                    $retVal = $this->parentObj->get($field);
            }
        }
    } else { /* not 1, 0, or parent; use system default except for groups */
        switch($field) {

            case 'groups':
                /* ToDo: Sanity Check groups here */
                $retVal = $prop;
                break;

                break;
            case 'published':
                $option = 'publish_default';
                break;

            case 'hidemenu':
                $option = 'hidemenu_default';
                break;

            case 'cacheable':
                $option = 'cache_default';
                break;

            case 'searchable':
                $option = 'search_default';
                break;

            default:
                $this->setError($this->modx->lexicon('np_unknown_field'));
                return;
        }
        $retVal = $this->modx->getOption($option);
        if ($retVal === null) {
            $this->setError($this->modx->lexicon('np_no_system_setting') . $option);
        }

    }
    if ($retVal === null) {
        $this->setError($this->modx->lexicon('np_illegal_value') . $field);
    }
    return $retVal;
}
public function getTpls() {
        $this->tpls = array();
        $this->tpls['outerTpl'] = !empty ($this->props['outertpl'])? $this->modx->getChunk($this->props['outertpl']) : '<div class="newspublisher">
        <h2>[[%np_main_header]]</h2>
        [[!+np.error_header:ifnotempty=`<h3>[[!+np.error_header]]</h3>`]]
        [[!+np.errors_presubmit:ifnotempty=`[[!+np.errors_presubmit]]`]]
        [[!+np.errors_submit:ifnotempty=`[[!+np.errors_submit]]`]]
        [[!+np.errors:ifnotempty=`[[!+np.errors]]`]]
        <form action="[[~[[*id]]]]" method="post">
            <input name="hidSubmit" type="hidden" id="hidSubmit" value="true" />
        [[+np.insert]]
        <span class = "buttons">
            <input class="submit" type="submit" name="Submit" value="Submit" />
            <input type="button" class="cancel" name="Cancel" value="Cancel" onclick="window.location = \'[[+np.cancel_url]]\' " />
        </span>
        [[+np.post_stuff]]
    </form>
</div>';


    $this->tpls['textTpl'] = ! empty ($this->props['texttpl'])? $this->modx->getChunk($this->props['texttpl']) : '[[+np.error_[[+npx.fieldName]]]]
            <label for="[[+npx.fieldName]]" title="[[%resource_[[+npx.fieldName]]_help:notags]]">[[%resource_[[+npx.fieldName]]]]: </label>
            <input name="[[+npx.fieldName]]" class="text" id="[[+npx.fieldName]]" type="text"  value="[[+np.[[+npx.fieldName]]]]" maxlength="60" />';


    $this->tpls['intTpl'] = ! empty ($this->props['inttpl'])? $this->modx->getChunk($this->props['inttpl']) : '[[+np.error_[[+npx.fieldName]]]]
            <label class="intfield" for="[[+npx.fieldName]]" title="[[%resource_[[+npx.fieldName]]_help]]">[[%resource_[[+npx.fieldName]]]]: </label>
            <input name="[[+npx.fieldName]]" class="int" id="[[+npx.fieldName]]" type="text"  value="[[+np.[[+npx.fieldName]]]]" maxlength="3" />';

    $this->tpls['dateTpl'] = ! empty ($this->props['datetpl'])? $this->modx->getChunk($this->props['datetpl']) : '[[+np.error_[[+npx.fieldName]]]]
    <div class="datepicker">
      <span class="npdate">
        <label for="[[+npx.fieldName]]" title="[[%resource_[[+npx.fieldName]]_help]]">[[%resource_[[+npx.fieldName]]]] [[%np_date_hint]]: </label>
        <input type="text" class="w4em [[%np_date_format]] divider-dash no-transparency" id="[[+npx.fieldName]]" name="[[+npx.fieldName]]" maxlength="10" readonly="readonly" value="[[+np.[[+npx.fieldName]]]]" />
      </span>
    </div>';

    $this->tpls['boolTpl'] = ! empty ($this->props['booltpl'])? $this->modx->getChunk($this->props['booltpl']) : '<fieldset class="np-tv-checkbox" title="[[%resource_[[+npx.fieldName]]_help]]"><legend>[[%resource_[[+npx.fieldName]]]]</legend>
    <input type="hidden" name = "[[+npx.fieldName]]" value = "" />
    <span class="option"><input class="checkbox" type="checkbox" name="[[+npx.fieldName]]" id="[[+npx.fieldName]]" value="1" [[+checked]]/></span>
 </fieldset>';

    $success = true;
    foreach($this->tpls as $tpl=>$val) {
        if (empty($val)) {
            $this->setError($this->modx->lexicon('np_no_tpl') . $tpl);
            $success = false;
        }
    }
    return $success;
}

public function displayForm($show) {

    $fields = explode(',',$show);
    foreach ($fields as $field) {
        $field = trim($field);
    }

    if (! $this->resource) {
        $this->setError($this->modx->lexicon('np_no_resource'));
        return $this->tpls['outerTpl'];
    }

    /* get the resource field names */
    $resourceFields = array_keys($this->resource->toArray());

    /*ToDo: Handle pub_date and un_pub date minutes:hours:seconds */
    foreach($fields as $field) {
        if (in_array($field,$resourceFields)) { /* regular resource field */
            $val = $this->resource->_fieldMeta[$field][phptype];
            if ($field == 'hidemenu') {  /* correct schema error */
                $val = 'boolean';
            }
            /* do introtext and content fields */
            if ($field == 'content') {
                $inner .= "\n" . '[[+np.error_content]]
                <label for="content">[[%resource_content]]: </label>
                <div class="[[+np.rt_content_1]]">
                    <textarea rows="[[+np.contentrows]]" cols="[[+np.contentcols]]" class="[[+np.rt_content_2]]" name="content" id="content">[[+np.content]]</textarea>
                </div>';

            } else if ($field == 'introtext') {
                $inner .= "\n" . '[[+np.error_introtext]]
                <label for="introtext" title="[[%resource_summary_help]]">[[%resource_summary]]: </label>
                <div class="[[+np.rt_summary_1]]">
                    <textarea  rows="[[+np.summaryrows]]" cols="[[+np.summarycols]]" class="[[+np.rt_summary_2]]" name="introtext" id="introtext">[[+np.introtext]]</textarea>
                </div>';

            } else {
                switch($val) {
                    case 'string':
                        $inner .= "\n" . str_replace('[[+npx.fieldName]]',$field,$this->tpls['textTpl']);
                        break;

                    case 'boolean':
                        $t = $this->tpls['boolTpl'];
                        if ($this->resource->get($field)) {
                            $t = str_replace('[[+checked]]','checked="checked"',$t);
                        } else {
                            $t = str_replace('[[+checked]]','',$t);
                        }
                        $inner .= "\n" . str_replace('[[+npx.fieldName]]',$field,$t);;
                        break;
                    case 'integer':
                        $inner .= "\n" . str_replace('[[+npx.fieldName]]',$field,$this->tpls['intTpl']);
                        break;
                    case 'fulltext':
                        $inner .= '<br />' . $field . ' -- FULLTEXT' . $val . '<br />';
                        break;
                    case 'timestamp':
                        $inner .= "\n" . str_replace('[[+npx.fieldName]]',$field,$this->tpls['dateTpl']);
                        break;
                    default:
                        $inner .= '<br />' . $field . ' -- OTHER' . $val . '<br />';
                }
            }
        } else {
            /* see if it's a TV */
            $retVal = $this->displayTv($field);
            if ($retVal) {
                $inner .= "\n" . $retVal;
            }
        }
    }
    $formTpl = str_replace('[[+np.insert]]',$inner,$this->tpls['outerTpl']);

    return $formTpl;
    $formTpl = '';
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

            <div class="datepicker">
                [[+np.error_pub_date]]
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
        <span class = "buttons">
            <input class="submit" type="submit" name="Submit" value="Submit" />
            <input type="button" class="cancel" name="Cancel" value="Cancel" onclick="window.location = \'[[+np.cancel_url]]\' " />
        </span>
    </form>
</div>';



    return $formTpl;

} /* end displayForm */
public function displayTv($tvNameOrId) {

    /* ToDo: move next line to init */

        if (is_numeric($tvNameOrId)) {
           $tvObj = $this->modx->getObject('modTemplateVar',$tvNameOrId);
        } else {
           $tvObj = $this->modx->getObject('modTemplateVar',array('name' => $tvNameOrId));
        }
        if (empty($tvObj)) {
            $this->setError($this->modx->lexicon('np_no_tv') . $tvNameOrId);
            return null;
        } else {
            /* make sure requested TV is attached to this template */
            $tvId = $tvObj->get('id');
            $found = $this->modx->getCount('modTemplateVarTemplate', array('templateid' => $this->template, 'tmplvarid' => $tvId));
            if (! $found) {
                $this->setError($this->modx->lexicon('np_not_our_tv') . ' Template: ' . $this->template . '  ----    TV: ' . $tvNameOrId);
                return null;
            } else {
                $this->allTvs[] = $tvObj;
            }
        }


/* we have a TV to show */
/* Build TV template dynamically based on type */

    $formTpl = '';
    $hidden = explode(',',$this->props['hidetvs']);

    $tv = $tvObj;

      $fields = $tv->toArray();

      /* skip hidden TVs */
      if (in_array($fields['id'],$hidden)) {
         return null;
      }
      /* use TV's name as caption if caption is empty */
      $caption = empty($fields['caption'])? $fields['name'] : $fields['caption'];

      /* create error placeholder for field */
      $formTpl .=  "\n" . '[[+np.error_'. $fields['name'] . ']]' . "\n";

      /* Build TV input code dynamically based on type */
      $tvType = $tv->get('type');
      $tvType = $tvType == 'option'? 'radio' : $tvType;


      switch ($tvType) {
            case 'date':
                $tpl = $this->tpls['dateTpl'];
                $tpl = str_replace('[[%resource_[[+npx.fieldName]]_help]]',$fields['description'],$tpl);
                $tpl = str_replace('[[%resource_[[+npx.fieldName]]]]',$caption,$tpl);
                $formTpl .= "\n" . str_replace('[[+npx.fieldName]]',$fields['name'],$tpl);
                unset($tpl);
                break;
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
      if ($this->existing  && ! $this->isPostBack) {
                    //die('<br />FIELD: ' . $fields['name'] . '<br />VALUE: ' . $tv->renderOutput($this->existing) . '<br />Existing: ' . $this->existing  . '<br />');
                    $this->modx->setPlaceholder($this->prefix . '.' . $fields['name'],$tv->renderOutput($this->existing) );
                }
                $rows = $tvType=='textarea'? 5 : 10;
                $cols = 60;
                $formTpl .= "\n" . '<label title="' . $fields['description'] . '">'. $caption  . '</label><textarea rows="'. $rows . '" cols="' . $cols . '"' . 'name="' . $fields['name'] . '"'. $fields['description'] . ' id="' . $fields['name'] . '">' . '[[+'. $this->prefix . '.' . $fields['name'] . ']]</textarea>';
                break;
            case 'richtext':
                if ($this->existing && !$this->isPostBack) {
                    //die('<br />FIELD: ' . $fields['name'] . '<br />VALUE: ' . $tv->renderOutput($this->existing) . '<br />Existing: ' . $this->existing  . '<br />');
                    $this->modx->setPlaceholder($this->prefix . '.' . $fields['name'],$tv->renderOutput($this->existing) );
                }
                $formTpl .= "\n" . '<label title="'. $fields['description'] . '">'. $caption  . '</label>
                <div class="modx-richtext">
                    <textarea rows="8" cols="60" class="modx-richtext" name="' . $fields['name'] . '" id="' . $fields['name'] . '">' . '[[+' . $this->prefix . '.' . $fields['name'] . ']]</textarea>
                </div>';
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
                    $multiple = ($tvType == 'listbox-multiple')? ' multiple="multiple" ': '';
                    $count = count($options);
                    $max = $this->listboxmax;
                    $size = ($count <= $max)? $count : $max;
                    $formTpl .= "\n" . '<select ' . 'name="'. $fields['name'] . $arrayPostfix . '" ' .  $multiple . 'size="' . $size . '">' . "\n";
                }
                $i=0;
                if ($tvType == 'checkbox') {
                            $formTpl .= "\n    " . '<input type="hidden" name="' . $fields['name'] . '[]" value = "" />';
                        }
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
                    if(empty($val) && !isset($_POST[$fields['name']])) {
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
                    if (empty($val)  && !isset($_POST[$fields['name']])) {
                        if ($fields['default_text'] == $rvalue || in_array($rvalue,$defaults) ){
                            if ($tvType == 'radio' || $tvType == 'checkbox') {
                                $formTpl .= ' checked ="checked" ';
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
                    if ($iType == 'input') {
                    $formTpl .= ' />' . $option;
                    } else {
                        $formTpl .= '>' . $option . '</' . $iType . '>';
                    }
                    if ($tvType != 'listbox' && $tvType != 'listbox-multiple') {
                        $formTpl .= '</span>';
                    }

                }
                if($tvType == 'listbox' || $tvType == 'listbox-multiple') {
                    $formTpl .= "\n" . '</select>';
                }
                $formTpl .= "\n" . '</fieldset>';
                break;
            /* ToDo: Add Date and other TV types */
            default:
                break;

        }  /* end switch */




return $formTpl;
}

public function saveResource() {

    //if (! $this->existing) {
    //    $this->resource = $this->modx->newObject('modResource');
    //}
    /* ToDo: Add permission test to init to disallow editing of docs that already have tags (remove this?) */
    if (! $this->modx->hasPermission('allow_modx_tags')) {
        $allowedTags = '<p><br><a><i><em><b><strong><pre><table><th><td><tr><img><span><div><h1><h2><h3><h4><h5><font><ul><ol><li><dl><dt><dd>';
        foreach($_POST as $k=>$v)
            if (! is_array($v)) { /* leave checkboxes, etc. alone */
                $_POST[$k] = $this->modx->stripTags($v,$allowedTags);
            }
    }
    $oldFields = $this->resource->toArray();
    $newFields = $_POST;
    $fields = array_replace($oldFields, $newFields);


    if (! $this->existing) {

        /* ToDo: Move this to init()? */
        /* set alias name of document used to store articles */
        if (empty($fields['alias'])) { /* leave it alone if filled */
            if(!$this->aliasTitle) {
                $alias = 'article-' . time();
            } else { /* use pagetitle */
                $alias = $this->modx->stripTags($_POST['pagetitle']);
                $alias=strtolower($alias);
                $alias = preg_replace('/&.+?;/', '', $alias); // kill entities
                $alias = preg_replace('/[^\.%a-z0-9 _-]/', '', $alias);
                $alias = preg_replace('/\s+/', '-', $alias);
                $alias = preg_replace('|-+|', '-', $alias);
                $alias = trim($alias, '-');
                //$alias = mysql_real_escape_string($alias);
            }
            $fields['alias'] = $alias;
        }
        /* set fields for new object */
        /* set editedon and editedby for existing docs */
        $fields['editedon'] = '0';
        $fields['editedby'] = '0';
        /* these *might* be in the $_POST array. Set them if not */
        $fields['hidemenu'] = isset($newFields['hidemenu'])? $newFields['hidemenu']: $this->hidemenu;
        $fields['template'] = isset ($newFields['template']) ? $newFields['template'] : $this->template;
        $fields['parent'] = isset ($newFields['parent']) ? $$newFields['parent'] :$this->parentId;
        $fields['searchable'] = isset ($newFields['searchable']) ? $newFields['searchable'] :$this->searchable;
        $fields['cacheable'] = isset ($newFields['cacheable']) ? $newFields['cacheable'] :$this->cacheable;
        $fields['createdby'] = $this->modx->user->get('id');
        $fields['content']  = $this->header . $fields['content'] . $this->footer;

    }



    /* ToDo: fix this */
    /*
    foreach($fields as $n=>$v) {
        if(!empty($this->badwords)) $v = preg_replace($this->badwords,'[Filtered]',$v); // remove badwords
        if (! is_array($v) ){
            $v = $this->modx->stripTags(htmlspecialchars($v));
        }
        $content = str_replace('[[+'.$n.']]',$v,$content);
    }
    */
/* ToDo: remove this -- handled in processor, processor wants a string and sets published appropriately */
if (false) {
        $H=isset($this->props['hours'])? $this->props['hours'] : 0;
        $M=isset($this->props['$minutes'])? $this->props['minutes']: 1;
        $S=isset($this->props['seconds'])? $this->props['seconds']: 0;

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
    $parentObj = $this->modx->getObject('modResource',$fields['parent'] ); // parent of new page

    /* ToDo: Remove this */
    if (false) {
    /* while we have the parent object -
       set published status if not set by pub dates above */
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
        /* Add TVs to $fields for processor */
    /* e.g. $fields[tv13] = $_POST['MyTv5'] */
    /* processor handles all types */

    if (! empty($this->allTvs)) {
        $fields['tvs'] = true;
        foreach($this->allTvs as $tv) {
            $fields['tv' . $tv->get('id')] = $_POST[$tv->get('name')];
        }
    }
    /* set groups for new doc if param is set */
    if ( (!empty($this->groups) && (! $this->existing)) ) {
            $fields['resource_groups']= $this->groups;
        }

    /* one last error check before calling processor */
    if ( ! empty( $this->errors)) {
        /* return without altering the DB */
        return '';
    }
    /* call the appropriate processor to save resource and TVs */
    if ($this->existing) {
       $response = $this->modx->runProcessor('resource/update',$fields);
    } else {
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
       // $this->resource = $this->modx->getObject('modResource',$object['id']);
       $postId = $object['id'];

       /* clean post array */
       $_POST = array();
    }

    if ( ! $postId) {
        $this->setError('np_post_save_no_resource');
    }
    return $postId;

} /* end saveResource() */

public function forward($postId) {
        if (empty($postId)) {
            $postId = $this->existing? $this->existing : $this->resource->get('id');
        }
    /* clear cache on parameter or new resource */
       if ($this->clearcache || (! $this->existing) ) {
           $cacheManager = $this->modx->getCacheManager();
           $cacheManager->clearCache(array (
                "{$this->resource->context_key}/",
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

/** creates a JSON string to send in the resource_groups field
 * for resource/update or resource/create processors.
 *
 * @param string $resourceGroups - a comma-separated list of
 * resource groups names or IDs (or both mixed) to assign a
 * document to.
 *
 * @return string (JSON encoded array)
 */

protected function setGroups($resourceGroups, $parentObj = null) {

    $values = array();
    if ($resourceGroups == 'parent') {

        $resourceGroups = $parentObj->getMany('ResourceGroupResources');

        if (! empty($resourceGroups)) { /* skip if parent doesn't belong to any resource groups */
            /* build $resourceGroups string from parent's groups */
            $groupNumbers = array();
            foreach ($resourceGroups as $resourceGroup) {
                $groupNumbers[] = $resourceGroup->get('document_group');
            }
            $resourceGroups = implode(',',$groupNumbers);
        } else {/* parent not in any groups */
            $this->setError($this->modx->lexicon('np_no_parent_groups'));
            return null;
        }


    }  /* end if 'parent' */

    $groups = explode(',',$resourceGroups);

    foreach($groups as  $group) {
        $group = trim($group);
        if (is_numeric($group)) {
            $groupObj = $this->modx->getObject('modResourceGroup',$group);
        } else {
            $groupObj = $this->modx->getObject('modResourceGroup',array('name'=>$group));
        }
        $values[] = array(
            'id' => $groupObj->get('id'),
            'name' => $groupObj->get('name'),
            'access' => '1',
            'menu' => '',
        );
    }
    //die('<pre>' . print_r($values,true));
    return $this->modx->toJSON($values);

}

/** allows strip slashes on an array
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

/* add error to error array */
public function setError($msg) {
    $this->errors[] = $msg;
}

/* returns the template ID */
protected function getTemplate() {
    if ($this->existing) {
        return $this->resource->get('template');
    }
    $template = $this->modx->getOption('default_template');

    if ($this->props['template'] == 'parent') {
        if (empty($this->parentId)) {
            $this->setError($this->modx->lexicon('np_parent_not_sent'));
        }
        if (empty($this->parentObj)) {
            $parentObj = $this->modx->getObject('modResource',$this->parentId);
        }
        if ($parentObj) {
            $template = $parentObj->get('template');
        } else {
            $this->setError($this->modx->lexicon('np_parent_not_found') . $this->parentId);
        }

    } else if (! empty($this->props->template)) {


        if(is_numeric($this->props['template']) ) { /* user sent a number */
            /* make sure it exists */
            if ( ! $this->modx->getObject('modTemplate',$this->props['template']) ) {
                $this->SetError($this->modx->lexicon('np_no_template_id') . $this->props['template']);
            }
        } else { /* user sent a template name */
            $t = $this->modx->getObject('modTemplate',array('templatename'=>$this->props['template']));
            if (! $t) {
                $this->setError($this->modx->lexicon('np_no_template_name') . $this->props['template']);
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
/* todo: remove this  */
protected function setxxxxxGroups($parentObj, $resourceId) {
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
