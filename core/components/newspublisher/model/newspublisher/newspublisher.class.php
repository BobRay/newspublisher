<?php

/**
 * NewsPublisher
 *
 * Copyright 2011-2017 Bob Ray
 *
 * @author Bob Ray <http://bobsguides.com>
 * @author Raymond Irving
 * 7/10/11
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
 * NewsPublisher; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package newspublisher
 */
/**
 * MODx NewsPublisher Class
 *
  * @package  newspublisher
 *
 * The NewsPublisher snippet presents a form in the front end for
 * creating resources. Rich text editing is available for text fields
 * and rich text template variables.
 *
 * Refactored for OOP and Revolution by Bob Ray, January, 2011
 * The Newspublisher class contains all functions relating to NewsPublisher's
 * operation.
 */

/* For Lexicon Helper
   $modx->lexicon->load('newspublisher:default');
*/

class Newspublisher {

   /** @var $version string current version */
    protected $version = '2.1.0-pl';
   /**
    * @var modx object Reference pointer to modx object
    */
    protected $modx;
    /**
     * @var $context string name of current context
     */
    protected $context;
    /**
     * @var array scriptProperties array
     */
    protected $props;
    /**
     * @var $allTvs array Array of all TVs
     */
    protected $allTvs = array();
    /**
     * @var array Array of error messages
     */
    protected $errors;
    /**
     * @var $resource modResource The current resource
     */
    protected $resource;
    /** @var $classKey string class of the resource */
    protected $classKey;
    /**
     * @var int ID of the resource's parent
     */
    protected $parentId;
    /**
     * @var $parentObj modResource The parent object
     */
    protected $parentObj;
    /**
     * @var boolean Indicates that we're editing an existing resource (ID of resource) 
     */
    protected $existing;
    /**
     * @var boolean Indicates a repost to self
     */
    protected $isPostBack;
    /**
     * @var string Path to NewsPublisher Core
     */
    protected $corePath;
    /**
     * @var string Path to NewsPublisher assets directory
     */
    protected $assetsPath;
    /**
     * @var string URL to NewsPublisher Assets directory
     */
    protected $assetsUrl;
    /**
     * @var boolean Use alias as title
     */
    protected $aliasTitle;
    /**
     * @var boolean Clear the cache after saving doc
     */
    protected $clearcache;
    /**
     * @var string Content of optional header chunk
     */
    protected $header;
    /**
     * @var string Content of optional footer chunk
     */
    protected $footer;
    /**
     * @var int Max size of listbox TVs
     */
    protected $listboxMax;
    /**
     * @var int Max size of multi-select listbox TVs
     */
    protected $multipleListboxMax;
    /**
     * @var string prefix for placeholders
     */
    protected $prefix;
    /**
     * @var string Comma-separated list of words to remove
     */
    protected $badwords;
    /**
     * @var string Value for published resource field
     */
    protected $published;
    /**
     * @var string Value for hidemenu resource field
     */
    protected $hideMenu;
    /**
     * @var string Value for alias resource field
     */
    protected $alias;
    /**
     * @var string Value for cacheable resource field
     */
    protected $cacheable;
    /**
     * @var string Value for searchable resource field
     */
    protected $searchable;
    /**
     * @var string Value for template resource field
     */
    protected $template;
    /**
     * @var string Value for richtext resource field
     */
    protected $richtext;
    /**
     * @var array Array of Tpl chunk contents
     */
    protected $tpls;
    /**
     * @var string Comma-separated list or resource groups to
     * assign new docs to
     */
    protected $groups;
    /**
     * @var int Max length for integer input fields
     */
    protected $intMaxlength;
    /**
     * @var int Max length for text input fields
     */
    protected $textMaxlength;
    /**
     * @var $captions array (associative) array of fieldnames:fieldcaptions
     */
    protected $captions;
    /** @var $useTabs boolean - create separate tabs */
    protected $useTabs;
    /** @var $tabs string - tab specification JSON string */
    protected $tabs;
    /** @var $activeTab string - tab to start on */
    protected $activeTab;
    /** @var $stopOnBadTv boolean - abort if &show contains a TV not attached to template  */
    protected $stopOnBadTv;
    /** @var $templates array - comma-separated list of templates to display as options */
    protected $templates;
    /** @var $parents array - comma-separated list of parents to display as options */
    protected $parents;
    /** @var $allowedTags string - allowed HTML tags */
    protected $allowedTags;
    /** @var $launchNotify bool - If true, launch Notify after saving */
    protected $launchNotify;
    /** @var $showNotify bool - If true, show Launch Notify Checkbox */
    protected $showNotify;
    /** @var  $notifyChecked bool - If true, Notify checkbox is checked by default */
    protected $notifyChecked;
    /** @var   $duplicateButton bool - If true, show duplicate button */
    protected $duplicateButton = false;

    /** @var   $deleteButton bool - If true, show delete button */
    protected $deleteButton = false;

    /** $var $confirmDelete bool - if true, show 'are you sure' dialog */
    protected $confirmDelete = true;

    /** $var $presets string - Preset values for fields */
    protected $presets = array();


    /** NewsPublisher constructor
     *
     * @access public
     * @param (reference object) $modx - modx object
     * @param (reference array) $props - scriptProperties array.
     */

    public function __construct(&$modx, &$props) {
        $this->modx =& $modx;
        $this->props =& $props;
        /* NP paths; Set the np. System Settings only for development */
        $this->corePath = $this->modx->getOption('np.core_path',
            null, MODX_CORE_PATH . 'components/newspublisher/');
        $this->assetsPath = $this->modx->getOption('np.assets_path',
            null, MODX_ASSETS_PATH . 'components/newspublisher/');
        $this->assetsUrl = $this->modx->getOption('np.assets_url',
            null, MODX_ASSETS_URL . 'components/newspublisher/');
    }

    /** Sets Postback status
     *
     * @access public
     * @param $setting (bool) desired setting */
    public function setPostBack($setting) {
        $this->isPostBack = $setting;
    }

    /** gets Postback status. Used by snippet to determine
     * postback status.
     *
     * @access public
     * @return bool - true if set, false if not
     */

    public function getPostBack() {
        return $this->isPostBack;
    }

    /** Initialize variables and placeholders - load RTE and file browser if called for.
     *  Uses $_POST on postback.
     *  Checks for an existing resource to edit in $_POST.
     *  Sets errors on failure.
     *
     *  @access public
     *  @param string $context - current context key
     */

    public function init($context) {
        $this->context = $context;
        $language = $this->modx->getOption('language', $this->props, '');
        $language = !empty($language)
            ? $language
            : $this->modx->getOption('cultureKey', NULL,
                $this->modx->getOption('manager_language', NULL, 'en'));
        switch ($context) {
            case 'mgr':
                break;
            case 'web':
            default:
                $this->modx->lexicon->load($language . ':newspublisher:default');
                break;
        }
        $this->duplicateButton =
            $this->modx->getOption('duplicatebutton', $this->props, false);
        $this->deleteButton =
            $this->modx->getOption('deletebutton', $this->props, false);

        $this->confirmDelete =
            $this->modx->getOption('confirmdelete', $this->props, true);

        /* set tab properties */
        $this->useTabs = isset($this->props['usetabs'])
            ? ! empty($this->props['usetabs'])
            : false;
        $this->tabs = isset($this->props['tabs'])
            ? $this->props['tabs']
            : null;
        $this->activeTab = isset($this->props['activetab']) &&
                !empty($this->props['activetab'])
            ? $this->props['activetab']
            : '';

        $this->classKey = (! isset($this->props['classkey'])) ||
                empty($this->props['classkey'])
            ? 'modDocument'
            : $this->props['classkey'];

        $this->allowedTags = $this->modx->getOption('allowedtags', $this->props, '<p><br><a><i><em><b><strong><pre><table><th><td><tr><img><span><div><h1><h2><h3><h4><h5><font><ul><ol><li><dl><dt><dd><object><blockquote><code>');

        /* inject NP CSS file */
        /* Empty but sent parameter means use no CSS file at all */

        if ($this->props['cssfile'] === '0') { /* 0 sent, -- no css file */
            $css = false;
        } elseif (empty($this->props['cssfile'])) { /* nothing sent - use default */
            $css = $this->assetsUrl . 'css/newspublisher.css';
        } else {  /* set but not empty -- use it */
            $css = $this->assetsUrl . 'css/' . $this->props['cssfile'];
        }

        if ($css !== false) {
            $this->modx->regClientCSS($css . '?v=' . $this->version);
        }

        $this->prefix =  empty($this->props['prefix'])
            ? 'np'
            : $this->props['prefix'];
        /* see if we're editing an existing doc */
        $this->existing = false;
        if (isset($_POST['np_existing']) &&
                $_POST['np_existing'] == 'true') {
            $this->existing = is_numeric($_POST['np_doc_id'])
                ? $_POST['np_doc_id']
                : false;
        }

        /* see if it's a repost */
        $this->setPostback(isset($_POST['hidSubmit']) &&
            $_POST['hidSubmit'] == 'true');

        $this->showNotify = (bool) $this->modx->getOption('shownotify', $this->props, false, true);
        if ($this->showNotify) {
            if ($this->isPostBack) {
                $this->notifyChecked = $this->modx->getOption('np_launch_notify',
                    $_POST, false);
            } else {
                $this->notifyChecked = $this->modx->getOption('notifychecked',
                    $this->props, false, true);
            }
            $this->launchNotify = $this->notifyChecked;
        }

        if ($this->isPostBack) {
            foreach($_POST as $k => $v) {
                /* Don't use arrays for HTML select/radio fields with a single element.
                 * The nested arrays cause problems when saving fields */
                if (is_array($v) && count($v)==1) {
                    $_POST[$k] = reset($v);
                }
            }

            /* No need to convert tags here. MODX will have removed them
               if allow_tags_in_post System Setting is off */

            $this->modx->toPlaceholders($_POST,$this->prefix);
        }

        if($this->existing) {


            $this->resource = $this->modx->getObject('modResource', $this->existing);
            if ($this->resource) {
                if (isset($_POST['Duplicate'])) {
                    if (! $this->resource->checkPolicy('copy')) {
                        $this->setError(
                            $this->modx->lexicon('np_copy_permission_denied'));
                        return;
                    }
                    $result = $this->duplicate($this->resource->get('id'), $this->resource->get('context_key'));
                    if ($result !== true) {
                        $this->setError($result);
                        return;
                    }
                }

                if (isset($_POST['Delete'])) {
                    if (!$this->resource->checkPolicy('delete')) {
                        $this->setError(
                            $this->modx->lexicon('np_no_delete_permission'));
                        return;
                    }
                    $result =
                        $this->deleteResource($this->resource->get('id'));
                    $this->setError($result);
                    return;
                }

                if (! ($this->modx->hasPermission('view_document') &&
                    $this->resource->checkPolicy('view')) ) {
                    if (!$this->modx->hasPermission('view_document')) {
                        $this->setError($this->modx->lexicon('np_view_permission_denied'));
                    }
                    if (!$this->resource->checkPolicy('view')) {
                        $this->setError($this->modx->lexicon('np_view_this_permission_denied'));
                    }
                    return;
                }
                if (! $this->isPostBack) {
                    $ph = $this->resource->toArray();
                    if ($ph['parent'] == 0) {
                        $ph['parent'] = $ph['context_key'];
                    } else {
                        $this->parentId = $this->resource->get('parent');
                    }
                    if ($this->hasToken($ph)) {
                        if ($this->modx->hasPermission('allow_modx_tags')) {
                            $ph = $this->convertTags($ph);
                        } else {
                        /* return error if there are any MODX tags */
                            $this->setError($this->modx->lexicon('np_no_modx_tags'));
                            return;
                        }
                    }
                    
                    $this->modx->toPlaceholders($ph,$this->prefix);
                    unset($ph);
                }
            } else {
               $this->setError($this->modx->lexicon('np_no_resource') . $this->existing);
               return;

            }
            /* need to forward this from $_POST so we know it's an existing doc */
            $stuff = '<input type="hidden" name="np_existing" value="true" />' . "\n" .
                '<input type="hidden" name="np_doc_id" value="' .
                $this->resource->get('id') . '" />';
            $this->modx->toPlaceholder('post_stuff', $stuff, $this->prefix);

        } else {
            /* new document */

            if (!$this->modx->hasPermission('new_document')) {
                $this->setError($this->modx->lexicon('np_create_permission_denied'));
                return;
            }

            /* Create new resource object */
            $this->resource = $this->modx->newObject($this->classKey);

            /* get folder id where we should store the new resource,
             else store under current document */
            if (isset($this->props['parent'])) {
                $this->props['parentid'] = $this->props['parent'];
                unset($this->props['parent']);
            }
            $temp = $this->modx->getOption('parentid', $this->props, '');
            if (empty($temp)) {
                $this->parentId = (int) $this->modx->resource->get('id');
            } else {
                $this->parentId = is_numeric($temp)
                    ? (int) $temp
                    : $temp;
            }
            unset($temp);

            /* Set some field defaults */

            $this->resource->set('parent', $this->parentId);

            $this->aliasTitle = $this->props['aliastitle']
                ? true
                : false;
            $this->clearcache = isset($_POST['clearcache'])
                ? $_POST['clearcache']
                : $this->props['clearcache'];

            $this->hideMenu = isset($_POST['hidemenu'])
                ? $_POST['hidemenu']
                : $this->_setDefault('hidemenu',$this->parentId);
            $this->resource->set('hidemenu', $this->hideMenu);

            $this->cacheable = isset($_POST['cacheable'])
                ? $_POST['cacheable']
                : $this->_setDefault('cacheable',$this->parentId);

            $this->resource->set('cacheable', $this->cacheable);

            $this->searchable = isset($_POST['searchable'])
                ? $_POST['searchable']
                : $this->_setDefault('searchable',$this->parentId);
            $this->resource->set('searchable', $this->searchable);

            $this->published = isset($_POST['published'])
                ? $_POST['published']
                : $this->_setDefault('published',$this->parentId);
            $this->resource->set('published', $this->published);

            /* This is the default for the richtext checkbox --
               nothing to do with whether NP uses an RTE */
            $this->richtext = isset($_POST['richtext'])
                ? $_POST['richtext']
                : $this->_setDefault('richtext',$this->parentId);
            $this->resource->set('richtext', $this->richtext);

            if (! empty($this->props['groups'])) {
                $this->groups = $this->_setDefault('groups',$this->parentId);
            }
            $this->header = !empty($this->props['headertpl'])
                ? $this->modx->getChunk($this->props['headertpl'])
                : '';
            $this->footer = !empty($this->props['footertpl'])
                ? $this->modx->getChunk($this->props['footertpl'])
                :'';

            /* Set $presets array from properties */
            if (isset($this->props['presets'])) {
                $this->presets = $this->parseDoubleDelimitedString($this->props['presets']);
            }

            /* Do presets for resource fields on new docs */
            $f = $this->resource->toArray();

            /* Set presets for regular resource fields */
            if ((!empty($this->presets)) && (!$this->isPostBack)) {
                $dirty = false;
                /* separate array to avoid overwriting other fields */
                $fArray = array();
                foreach($this->presets as $pKey => $pValue) {
                    if (key_exists($pKey, $f)) {
                       $dirty = true;
                       $fArray[$pKey] = $pValue;
                    }
                }
                if ($dirty) {
                    $this->modx->toPlaceholders($fArray, $this->prefix);
                }
            }
            unset($f, $fArray,$dirty);
        }

        /* Set some control properties */
        if( !empty($this->props['badwords'])) {
            $this->badwords = str_replace(' ','', $this->props['badwords']);
            $this->badwords = "/".str_replace(',','|', $this->badwords)."/i";
        }

        $this->stopOnBadTv = $this->modx->getOption('stopOnBadTv', $this->props, true);

        $this->modx->lexicon->load('core:resource');
        $this->template = (integer) $this->_getTemplate();
        $temp = $this->modx->getOption('templates', $this->props, '');
        $this->templates = empty($temp)
            ? array()
            : explode(',', $temp);
        $this->parents = $this->getParents();

        if($this->props['initdatepicker']) {
            $this->modx->regClientCSS($this->assetsUrl . 'datepicker/css/datepicker.css');
            $this->modx->regClientStartupHTMLBlock('<script type=text/javascript src="' .
                $this->assetsUrl . 'datepicker/js/datepicker.packed.js">{"lang":"' .
                $language . '"}</script>');
        }

        $this->listboxMax = $this->props['listboxmax']
            ? $this->props['listboxmax']
            : 8;
        $this->multipleListboxMax = $this->props['multiplelistboxmax']
            ? $this->props['multiplelistboxmax']
            : 8;

        $this->intMaxlength = !empty($this->props['intmaxlength'])
            ? $this->props['intmaxlength']
            : 10;
        $this->textMaxlength = !empty($this->props['textmaxlength'])
            ? $this->props['textmaxlength']
            : 60;

        /* Rich Text Editing and/or file or image TVs */
        if ($this->props['initrte']) {

            /* Get location to load TinyMCE fom */
            $tinySource = $this->modx->getOption('tinysource', $this->props, "//cdn.tinymce.com/4/tinymce.min.js", true);
            // $this->modx->log(modX::LOG_LEVEL_ERROR, 'tinysource ' . $tinySource);

            /* Get name of TinyMCE configuration chunk */
            $tinyChunk = $this->modx->getOption('tinymceinittpl', $this->props, 'npTinymceInitTpl', true);
            $language = $this->modx->getOption('language', $this->props, 'en', true);

            /* Tinyproperties is the array sent to getChunk to replace the placeholders in $tinyChunk */
            $tinyproperties['language'] = '"' . $language . '"';
            $tinyproperties['npAssetsURL'] = $this->assetsUrl;
            $tinyproperties['width'] = $this->modx->getOption('tinywidth', $this->props, '95%', true);
            $tinyproperties['height'] = $this->modx->getOption('tinyheight', $this->props, '400px', true);

            /* Load JQuery and elFinder JS */
            $this->modx->regClientStartupHTMLBlock('
                <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js" type="text/javascript"></script>
                <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
                <script src="' . $this->assetsUrl . 'elfinder/js/elfinder.min.js" type="text/javascript"></script >'
            );

            /* Fire OnRichTextEditorInit (probably unnecessary) */
            $fields = array(
                'editor' => 'TinyMCE',
                'elements' => '',
                'forfrontend' => 1,
            );

            $this->modx->invokeEvent('OnRichTextEditorInit', $fields);

            /* Inject Tiny Source */
            $this->modx->regClientStartupScript($tinySource);

            /* Inject Tiny configuration chunk */
            $this->modx->regClientStartupScript($this->modx->getChunk($tinyChunk, $tinyproperties));

        } /* end if ($richtext) */
} /* end init */

    /** Sets default values for published, hidemenu, searchable,
     * cacheable, and groups (if sent).
     *
     * @access protected
     *
     * @param string - $field - name of resource field
     * @param int - $parentId - ID of parent resource
     *
     * @return mixed - returns boolean option, JSON string for
     * groups, and null on failure
     */

    protected function _setDefault($field,$parentId) {

        $retVal = null;
        $prop = $this->props[$field];
        if ($prop == 'Parent' || $prop == 'parent') {
            /* get parent if we don't already have it */
            if (! $this->parentObj) {
                if (is_numeric($this->parentId)) {
                    $this->parentObj = $this->modx->getObject('modResource',
                        $this->parentId);
                } else {
                    $this->parentObj = $this->modx->getObject('modResource',
                        array('pagetitle' => $this->parentId));
                }
            }
            if (! $this->parentObj) {
                $prop = 'System Default';
            }
        }
        $prop = (string) $prop; // convert booleans
        $prop = $prop == 'Yes'? '1': $prop;
        $prop = $prop == 'No'? '0' :$prop;

        if ($prop != 'System Default') {
            if ($prop === '1' || $prop === '0') {
                $retVal = $prop;

            } elseif ($prop == 'parent' || $prop == 'Parent') {
                if ($field == 'groups') {
                    $groupString = $this->_setGroups($prop, $this->parentObj);
                    $retVal = $groupString;
                    unset($groupString);
                } else {
                    $retVal = $this->parentObj->get($field);
                }
            } elseif ($field == 'groups') {
                $retVal = $this->_setGroups($prop);
            }
        } else { /* not 1, 0, or parent; use system default except for groups */
            switch($field) {

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

                case 'richtext':
                    $option = 'richtext_default';
                    break;

                default:
                    $this->setError($this->modx->lexicon('np_unknown_field') . $field);
                    return null;
            }
            if ($option != 'groups') {
                $retVal = $this->modx->getOption($option);
            }
            if ($retVal === null) {
                $this->setError($this->modx->lexicon('np_no_system_setting') . $option);
            }

        }
        if ($retVal === null) {
            $this->setError($this->modx->lexicon('np_illegal_value') .
                $field . ': ' . $prop .
                $this->modx->lexicon('np_no_permission') );
        }
        return $retVal;
    }


    /** return a specified Tpl chunk
     *
     * @access public
     * @param $tpl string - tpl name
     *
     * @return string - tpl content
     *
    */

    public function getTpl($tpl) {
        if (!isset($this->tpls[$tpl])) {
            $this->tpls[$tpl] = !empty ($this->props[strtolower($tpl)])
                ? $this->modx->getChunk($this->props[strtolower($tpl)])
                : $this->modx->getChunk('np' . $tpl);

            if (empty($this->tpls[$tpl])) {
                $this->setError($this->modx->lexicon('np_no_tpl') . $tpl);

                switch ($tpl) {
                    case 'OuterTpl':
                        $this->tpls[$tpl] = '<div class="newspublisher">
                            <h2>[[%np_main_header]]</h2>
                            [[!+np.error_header:ifnotempty=`<h3>[[!+np.error_header]]</h3>`]]
                            [[!+np.errors_presubmit:ifnotempty=`[[!+np.errors_presubmit]]`]]
                            [[!+np.errors_submit:ifnotempty=`[[!+np.errors_submit]]`]]
                            [[!+np.errors:ifnotempty=`[[!+np.errors]]`]]</div>';
                        break;

                    case 'ErrorTpl':
                        $this->tpls[$tpl] =
                            '<span class = "errormessage">[[+np.error]]</span>';
                        break;

                    case 'FieldErrorTpl':
                        $this->tpls[$tpl] =
                            '<span class = "fielderrormessage">[[+np.error]]</span>';
                        break;
                }
            }

            /* set different placeholder prefix if requested */

            if ($this->prefix != 'np') {
                $this->tpls[$tpl] = str_replace('np.',
                    $this->prefix . '.', $this->tpls[$tpl]);
            }

        }

        return $this->tpls[$tpl];
    }


    /** Creates the HTML for the displayed form by concatenating
     * the necessary Tpls and calling _displayTv() for any TVs.
     *
     * @access public
     * @param $show string - comma-separated list of fields and TVs
     * (name or ID) to include in the form
     *
     * @return string -  returns the finished form
     */
    public function displayForm($show) {

        $fields = explode(',',$show);
        $inner = '';

        if (! $this->resource) {
            $this->setError($this->modx->lexicon('np_no_resource'));
            return $this->getTpl('OuterTpl');
        }
        if ($this->useTabs) {
            if (! $this->modx->fromJSON($this->tabs)) {
                $this->setError($this->modx->lexicon('np_invalid_tabs'));
                return $this->getTpl('OuterTpl');

            } else {
                $tabsJs = $this->modx->getChunk('npTabsJsTpl', array(
                    'activeButton' => $this->activeTab,
                    'buttonsJson' => $this->tabs,
                ));
                $this->modx->regClientStartupScript('//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript');
                $this->modx->regClientStartupScript($tabsJs);
                unset($tabsJs);
                //$this->setError('json_passed');
            }
        }

        /* get the resource field names */
        $resourceFieldNames = array_keys($this->modx->getFields($this->classKey));

        /* set captions from properties (if any) */
        if (isset($this->props['captions'])) {
            $this->captions = $this->parseDoubleDelimitedString($this->props['captions']);
        }

        foreach($fields as $field) {
            $field = trim($field);

            if (in_array($field,$resourceFieldNames)) {
                /* regular resource field */
                $inner .= $this->_displayField($field);
            } else {
                /* see if it's a TV */
                /* (presets done inside  _displayTv() ) */

                $retVal = $this->_displayTv($field);
                if ($retVal) {
                    $inner .= "\n" . $retVal;
                }
            }
        }

        if ($this->showNotify) {
            $nf_text = $this->getNotifyText();
            $inner .= $nf_text;
        }

        $formTpl = str_replace('[[+npx.insert]]',$inner,$this->getTpl('OuterTpl'));
        if ($this->duplicateButton && $this->existing) {
            $caption = $this->modx->lexicon('np_duplicate');
            $formTpl = str_replace('[[+np_duplicate_button]]',
                '<input class="submit" id="np_duplicate_button" type="submit" name="Duplicate" value="' . $caption . '" />', $formTpl);
        }

        if ($this->deleteButton && $this->existing) {
            $confirm = $this->confirmDelete
                ? 'onClick="return confirm(\'' . $this->modx->lexicon('np_confirm_delete') . '\')"'
            : '';
            $caption = $this->modx->lexicon('np_delete');
            $formTpl = str_replace('[[+np_delete_button]]',
                '<input class="submit" id="np_delete_button" type="submit" name="Delete" value="' . $caption . '"' . $confirm .   '/>
                ', $formTpl);
/*        $this->modx->regClientStartupScript('<script type = "text/javascript">
                function np_delete() {
                    var r = confirm(_("np_confirm_delete"));
                    if (r == true) {
                        return true;
                    } else {
                        return false;
                    }
                }

            </script>');*/
        }



        //die ('<pre>' . print_r($formTpl,true));
        /*echo '$_POST<br /><pre>'  . print_r($this->resource->toArray(), true) . '</pre>';*/
        return $formTpl;
    } /* end displayForm */

    function getNotifyText() {
        $find = array(
            '[[+npx.caption]]',
            '[[+npx.fieldName]]',
            '[[+npx.help]]',
            '[[+npx.checked]]',
            'class="np-checkbox"',
        );
        $replace = array(
            $this->modx->lexicon('np_launch_notify'),
            'np_launch_notify',
            '',
            $this->notifyChecked
                ? ' checked="checked" '
                : '',
            '',
            'class="np-notify',
        );
        $temp = "\n" . '<div id="launch_notify_div" style="width:40%">' . "\n";

        $temp .= $this->getTpl('boolTpl');

        $temp = str_replace($find, $replace, $temp);

        $c = $this->modx->newQuery('modTemplateVar', array(
            'name' => 'NotifySubscribers',
        ));
        $c->select('elements');
        $elements = $this->modx->getValue($c->prepare());
        $inner = "\n<hr>\n";
        $elements = explode('||', $elements);
        $current = isset($_POST['pageType']) ? $_POST['pageType'] : '';
        foreach ($elements as $s) {
            list($caption, $name) = explode('==', $s);
            $checked = '';
            if ($name == $current) {
                $checked = 'checked="checked"';
            } else {
                if ($name == 'new' && (!$this->existing)) {
                    $checked = 'checked="checked"';
                } elseif ($name == 'existing' && ($this->existing)) {
                    $checked = 'checked="checked"';
                }
            }
            $inner .= "\n" . '<input style="width:30px;margin-left:25px" type="radio" name="pageType" id="' . $name . '"
 value="' . $name . '" ' .   $checked .  ' >' .  '<span
>' . $caption . '</span><br>';
        }
        $temp = str_replace('</fieldset', $inner . "\n" . '</fieldset', $temp);
        return $temp . "\n" . '</div>';
    }

    /** displays an individual field
     * @access protected
     * @param $field string - name of the field
     * @return string - returns the HTML code for the field.
     */

    protected function _displayField($field) {
        /* @var $template modTemplateVar */
        $replace = array();
        $inner = '';
        /* set hover help unless user has turned it off */
        $replace['[[+npx.help]]'] = $this->props['hoverhelp']
            ? '[[%resource_' . $field . '_help:notags]]'
            : '';

        /* if set use 1) caption from properties, 2) MODX field captions */
        $caption =  !empty($this->captions[$field])
            ? $this->captions[$field]
            : '[[%resource_' . $field . ']]';
        $replace['[[+npx.caption]]'] = $caption;
        $fieldType = $this->resource->_fieldMeta[$field]['phptype'];

        if ($field == 'id') {
            $replace['[[+npx.readonly]]'] = 'readonly="readonly"';
        } elseif ($this->props['readonly']) {
            $readOnlyArray = explode(',', $this->props['readonly']);
            if (in_array($field, $readOnlyArray)) {
                $replace['[[+npx.readonly]]'] = 'readonly="readonly"';
            }
            unset($readOnlyArray);
        }

        $replace['[[+npx.fieldName]]'] = $field ;


        /* do content and introtext fields */
        switch ($field) {
            case 'content':
                /* adjust content field type according to class_key */
                if ($this->existing)  {
                    $class_key = $this->resource->get('class_key');
                } else {$class_key = isset($_POST['class_key'])
                    ? $_POST['class_key']
                    : 'modDocument';
                }

                switch ($class_key) {
                    default:
                    case 'modDocument':
                        $rows =  ! empty($this->props['contentrows'])
                            ? $this->props['contentrows']
                            : '10';
                        $cols =  ! empty($this->props['contentcols'])
                            ? $this->props['contentcols']
                            : '60';
                        $inner .= $this->_displayTextarea($field,
                            $this->props['rtcontent'], 'np-content', $rows, $cols);
                        break;
                    
                    case 'modWebLink':
                    case 'modSymLink':
                        $class_key = strtolower(substr($class_key, 3));
                        $replace['[[+npx.caption]]'] = $this->modx->lexicon($class_key);
                        $replace['[[+npx.help]]'] = $this->modx->lexicon($class_key.'_help');
                        $inner .= $this->_displaySimple($field,
                            'TextTpl', $this->textMaxlength);
                        break;

                    case 'modStaticResource':
                        $replace['[[+npx.caption]]'] = $this->modx->lexicon('static_resource');
                        $inner .= $this->_displayFileInput($field, 'fileTpl');
                }
                break;

            case 'description':
                $rows = !empty($this->props['descriptionrows'])
                    ? $this->props['descriptionrows']
                    : '5';
                $cols = !empty($this->props['descriptioncols'])
                    ? $this->props['descriptioncols']
                    : '51';
                $inner .= $this->_displayTextarea($field,
                    $this->props['rtdescription'],
                    'np-description', $rows, $cols);
                break;

            case 'introtext':
                $rows =  ! empty($this->props['summaryrows'])
                    ? $this->props['summaryrows']
                    : '10';
                $cols =  ! empty($this->props['summarycols'])
                    ? $this->props['summarycols']
                    : '60';
                $inner .= $this->_displayTextarea($field,
                    $this->props['rtsummary'],
                    'np-introtext', $rows, $cols);
                break;

            case 'template':
                $options = array();
                $c = $this->modx->newQuery('modTemplate');
                $c->sortby('templatename', 'ASC');
                if (! empty($this->templates)) {
                    $c->where(array(
                        'id:IN' => $this->templates,
                    ));
                } else {
                    $c->where(array('id' => $this->template));

                }

                $templates = $this->modx->getCollection('modTemplate', $c);
                foreach ($templates as $template) {
                    if ($template->checkPolicy('list')) {
                        $options[$template->get('id')] =
                            $template->get('templatename');
                    }
                }

                $inner .= $this->_displayList($field, 'listbox', $options,
                    $this->template);
                break;

            case 'parent':
                $options = $this->parents;
                $inner .= $this->_displayList($field, 'listbox', $options,
                    $this->parentId);
                break;


            case 'class_key':
                $options = array();
                $classes = ($this->classKey != 'modDocument')
                    ? array($this->classKey => $this->classKey)
                    : array();
                $classes = array_merge($classes, array(
                    'modDocument' => 'document',
                    'modSymLink' => 'symlink',
                    'modWebLink' => 'weblink',
                    'modStaticResource' => 'static_resource',
                ));

                foreach ($classes as $k => $v) {
                    $options[$k] = $this->modx->lexicon($v);
                }

                $inner .= $this->_displayList($field, 'listbox',
                    $options, $this->resource->get('class_key'));
                break;
                
            case 'content_dispo':
                $options = array();
                $dispo = array('inline', 'attachment');
                foreach ($dispo as $k => $v) {
                    $options[$k] = $this->modx->lexicon($v);
                }
                $inner .= $this->_displayList($field, 'listbox',
                    $options, $this->resource->get('content_dispo'));
                break;

            case 'uri_override': /* correct schema errors */
            case 'hidemenu':
                $fieldType = 'boolean';
            /* intentional fall through */
            default:
                switch($fieldType) {
                    case 'string':
                    default:
                        $inner .= $this->_displaySimple($field, 'TextTpl',
                            $this->textMaxlength);
                        break;

                    case 'boolean':
                        $inner .= $this->_displayBoolean($field,
                            $this->resource->get($field));
                        break;

                    case 'integer':
                        $inner .= $this->_displaySimple($field,
                            'IntTpl', $this->intMaxlength);
                        break;

                    case 'timestamp':
                        $inner .= $this->_displayDateInput($field,
                            $this->resource->get($field));
                        break;
                }
        }

        $inner = $this->strReplaceAssoc($replace, $inner);

        return $inner;
    }
    

    /** displays an individual TV
     *
     * @access protected
     * @param $tvNameOrId string - name or ID of TV to process.
     *
     * @return string - returns the HTML code for the TV.
     */

    protected function _displayTv($tvNameOrId) {
        /* @var $tvObj modTemplateVar */
        /* @var $tv modTemplateVar */
        /* @var $parent modResource */
        /* @var $resource modResource */

        if (is_numeric($tvNameOrId)) {
           $tvObj = $this->modx->getObject('modTemplateVar',
               (integer) $tvNameOrId);
        } else {
           $tvObj = $this->modx->getObject('modTemplateVar',
               array('name' => $tvNameOrId));
        }
        if (empty($tvObj)) {
            $this->setError($this->modx->lexicon('np_no_tv') . $tvNameOrId);
            return null;
        } else {
            /* make sure requested TV is attached to this template*/
            $tvId = $tvObj->get('id');
            $found = $this->modx->getCount('modTemplateVarTemplate', array(
                'templateid' => $this->template,
                'tmplvarid' => $tvId,
            ));
            if (! $found) {
                /* No error if stopOnBadTv is false  */
                if ($this->stopOnBadTv) {
                    $this->setError($this->modx->lexicon('np_not_our_tv') .
                        ' Template: ' . $this->template . '  ----    TV: ' .
                        $tvNameOrId);
                    return null;
                } else {
                    return '';
                }

            } else {
                $this->allTvs[] = $tvObj;
            }
        }


    /* we have a TV to show */
    /* Build TV template dynamically based on type */

        $formTpl = '';
        $tv = $tvObj;

        $fields = $tv->toArray();

        $name = $fields['name'];

        $params = $tv->get('input_properties');
        /* if set, use 1) caption from properties, 2) field caption, 3) field name */
        $caption = !empty ($this->captions[$name])
            ? $this->captions[$name]
            : (empty($fields['caption'])
                ? $name
                : $fields['caption']);

        if ($this->hasToken($caption)) {
            if ($this->modx->hasPermission('allow_modx_tags')) {
                $caption = $this->convertTags($caption);
            } else {
                $this->setError($this->modx->lexicon('np_no_modx_tags')
                    . ': ' . $caption);
                return '';
            }
        }

        /* Build TV input code dynamically based on type */
        $tvType = $tv->get('type');
        $tvType = $tvType == 'option'? 'radio' : $tvType;

        /* set TV to current value or default if not postBack */
        if (! $this->isPostBack ) {
            $ph = '';
            if ($this->existing) {
                $ph = $tv->getValue($this->existing);
            }
            /* empty value gets default_text for both new and existing docs */
            if (empty($ph)) {
                $ph = $fields['default_text'];
            }

            if ($this->hasToken($ph)) {
                if ($this->modx->hasPermission('allow_modx_tags')) {
                    $ph = $this->convertTags($ph);
                } else  {
                    $this->setError($this->modx->lexicon('np_no_modx_tags')
                        . ': ' . $tv->get('name'));
                    return NULL;
                }
            }

        
            if (stristr($ph,'@EVAL')) {
                $this->setError($this->modx->lexicon('np_no_evals') .
                    $tv->get('name'));
                return null;
                
            } else {
                /* Do presets for TVs */
                if (isset($this->presets[$name])) {
                    if ((!$this->existing)) {
                        $ph = $this->presets[$name];
                    }
                }
                $this->modx->toPlaceholder($name, $ph, $this->prefix );
            }
        }

        $replace = array();
        $replace['[[+npx.help]]'] = $this->props['hoverhelp']
            ? $fields['description']
            :'';
        $replace['[[+npx.caption]]'] = $caption;
        $replace['[[+npx.fieldName]]'] = $name;

        switch ($tvType) {
            case 'date':
                $formTpl .= $this->_displayDateInput($name,
                    $tv->getValue($this->existing), $params);
                break;

            case 'text':
            case 'textbox':
            case 'email';
                $formTpl .= $this->_displaySimple($name,
                    'TextTpl', $this->textMaxlength);
                break;

            case 'number':
                $formTpl .= $this->_displaySimple($name,
                    'IntTpl', $this->intMaxlength);
                break;

            case 'textarea':
            case 'textareamini':
                $formTpl .= $this->_displayTextarea($name, false, $tvType);
                break;

            case 'richtext':
                $formTpl .= $this->_displayTextarea($name, true, 'textarea');

                break;


            case 'radio':
            case 'checkbox':
            case 'listbox':
            case 'listbox-multiple':
            case 'dropdown':
            
                /* handle @ binding TVs */
                if (preg_match('/^@/',$fields['elements'])) {
                    $fields['elements'] = $tv->processBindings($fields['elements']);
                }
                $elements = explode('||',$fields['elements']);

                /* parse options */
                $options = array();
                foreach ($elements as $option) {
                    $text = strtok($option,'=');
                    $option = strtok('=');
                    $option = $option? $option : $text;
                    $options[$option] = $text;
                }

                /* selected entries */
                $selected = explode('||',$tv->getValue($this->existing));

                /* render HTML */
                $formTpl .= $this->_displayList($name, $tvType, $options, $selected,
                    $params['allowBlank']=='true' &&
                    ($tvType=='listbox' || $tvType=='dropdown'));
                break;

            case 'resourcelist':

                /* code adapted from core/model/modx/processors/element/tv/renders/mgr/input/resourcelist.php */

                $bindingsResult = $tv->processBindings($tv->get('elements'),
                    $this->modx->resource->get('id'));
                $parents = $tv->parseInputOptions($bindingsResult);
                $parents = !empty($params['parents']) || $params['parents'] === '0'
                    ? explode(',',$params['parents'])
                    : $parents;
                $params['depth'] = !empty($params['depth'])
                    ? $params['depth']
                    : 10;
                if (empty($parents) || (empty($parents[0]) && $parents[0] !== '0')) {
                    $parents = array($this->modx->getOption('site_start',null,1));
                }

                $parentList = array();
                foreach ($parents as $parent) {
                    $parent = $this->modx->getObject('modResource',$parent);
                    if ($parent) $parentList[] = $parent;
                }

                /* get all children */
                $ids = array();
                foreach ($parentList as $parent) {
                    if ($params['includeParent'] != 'false') $ids[] = $parent->get('id');
                    $children = $this->modx->getChildIds($parent->get('id'),
                        $params['depth'], array(
                        'context' => $parent->get('context_key'),
                    ));
                    $ids = array_merge($ids,$children);
                }
                $ids = array_unique($ids);

                if (empty($ids)) {
                    $resources = array();
                } else {
                    /* get resources */
                    $c = $this->modx->newQuery('modResource');
                    $c->leftJoin('modResource','Parent');
                    if (!empty($ids)) {
                        $c->where(array('modResource.id:IN' => $ids));
                    }
                    if (!empty($params['where'])) {
                        $params['where'] = $this->modx->fromJSON($params['where']);
                        $c->where($params['where']);
                    }
                    $c->sortby('Parent.menuindex,modResource.menuindex','ASC');
                    if (!empty($params['limit'])) {
                        $c->limit($params['limit']);
                    }
                    $resources = $this->modx->getCollection('modResource',$c);
                }

                /* iterate */
                $options = array();
                $selected = array();
                foreach ($resources as $resource) {
                    $id = $resource->get('id');
                    $options[$id] = $resource->get('pagetitle');
                    if ($id == $tv->getValue($this->existing)) {
                        $selected[] = $id;
                    }
                }

                /* If the list is empty do not require selecting something */
                if (empty($options)) {
                    $params['allowBlank'] = 'true';
                }
                $formTpl .= $this->_displayList($name, 'listbox',
                    $options, $selected, $params['allowBlank']!='false');
                break;

                
            case 'image':
            case 'file':
                            
                /* code adapted from core/model/modx/processors/element/tv/renders/mgr/input/file.php
                 * and (...)/image.php */

                /* remove this? */
                $this->modx->getService('fileHandler',
                    'modFileHandler', '', array('context' => $this->context));
                $params['wctx'] = $this->context;
                $value = $tv->getValue($this->existing);
                $openTo = '';

                $source = $tv->getSource($this->context);
                if (!$source) {
                    $this->setError($this->modx->lexicon('np_no_media_source') .
                        $name);
                    return null;
                }
                if (!$source->getWorkingContext()) {
                    $this->setError($this->modx->lexicon('np_source_wctx_error') .
                        $name);
                }
                $source->initialize();
                $params['source'] = $source->get('id');
                
                if (!$source->checkPolicy('view')) {
                    $this->setError($this->modx->lexicon('np_media_source_access_denied')
                        . $name);
                    return null;
                }

                if (!empty($value)) {
                    $openTo = $source->getOpenTo($value,$params);
                }

                $formTpl .= $this->_displayFileInput($name, $tvType.'Tpl',
                    $params, $openTo);
                break;
            default:
                /* use custom TV file if it exists */
                $tvFile = dirname(dirname(dirname(__FILE__))) . '/tvs/' . $tvType . '.php';
                 if (file_exists($tvFile)) {
                    include($tvFile);
                } else {
                     /* Use text type by default */
                     $formTpl .= $this->_displaySimple($name,
                         'TextTpl', $this->textMaxlength);
                }
                break;

        }  /* end switch */
        
        $formTpl = $this->strReplaceAssoc($replace, $formTpl);

        /* Add TV to required fields if blank values are not allowed */
        if (isset($params['allowBlank']) && ($params['allowBlank'] == 'false')) {
            $this->props['required'] .= ',' . $name;
        }
        
        return $formTpl;
    }

    /** Uses an associative array for string replacement
     *
     * @param $replace array - associative array of keys and values
     * @param &$subject string - string to do replacements in
     * @return string - modified subject */

    public function strReplaceAssoc(array $replace, $subject) {
       return str_replace(array_keys($replace), array_values($replace), $subject);
    }
    

    /** Produces the HTML code for date fields/TVs
     * Splits time string into date and time and sets
     * placeholders for each of them
     *
     * @access protected
     * @param $name string - name of the field/TV
     * @param $timeString string - date-time string in the format "2011-04-01 13:20:01"
     * @param $options array - Associative array of options. Accepts 'disabledDates',
     *     'disabledDays', 'minDateValue' and 'maxDateValue' (in the format used
     *     for the corresponding TV input options)
     * @return string - date field/TV HTML code */
    
    protected function _displayDateInput($name, $timeString, $options = array()) {

        if (! $this->props['initdatepicker']) {
            $msg = $this->modx->lexicon('np_no_datepicker');
            $this->setError($msg . $name);
            $this->setFieldError($name, $msg);
        }
        
        if (! $this->isPostBack) {
            $s = $timeString? $s = substr($timeString, 11, 5):'';
            $this->modx->toPlaceholder($name . '_time' , $s, $this->prefix);

            /* format date string according to np_date_format lexicon entry
             * (see http://www.frequency-decoder.com/2009/09/09/unobtrusive-date-picker-widget-v5
             * for details)
             */
            if ($timeString) {
              $format = $this->modx->lexicon('np_date_format');
              $format = str_replace( array('-','sp','dt','sl','ds','cc'),
                 array( '', ' ', '.', '/', '-', ','), $format);
              $timestamp = mktime(0, 0, 0, (int) substr($timeString,5,2),
                  (int) substr($timeString,8,2), (int) substr($timeString,0,4));
              $s = date($format, $timestamp);
            } else {
              $s = '';
            }
            $this->modx->toPlaceholder($name, $s, $this->prefix);
        }
          
        /* Set disabled dates */

        $disabled = '';
        if (isset($options['disabledDates']) && $options['disabledDates']) {
          $disabled .= 'disabledDates:{';
          foreach (explode(',', $options['disabledDates']) as $d) {
              $disabled .= '"';
              $d = str_replace('-', '', $d);
              $d = str_replace('.', '*', $d);
              if (! (strpos($d, '^') === false)) {
                  $d = str_replace('^',  str_repeat('*', 9 - strlen($d)), $d);
              }
              $disabled .= $d . '":1,';
          }
          $disabled .= '},';
        }
        if (isset($options['disabledDays']) && $options['disabledDays']) {
            $disabled .= 'disabledDays:[';
            $days = explode(',', $options['disabledDays']);
            for ($day = 1; $day <= 7; $day++) {
                $disabled .= (in_array($day, $days) ? 1 : 0) . ',';
            }
            $disabled .= '],';
        }
        if (isset($options['minDateValue']) && $options['minDateValue']) {
            $disabled .= 'rangeLow:"' .
            str_replace('-', '', $options['minDateValue']) . '",';
        }
        if (isset($options['maxDateValue']) && $options['maxDateValue']) {
            $disabled .= 'rangeHigh:"' . str_replace('-', '',
            $options['maxDateValue']) . '",';
        }

        $PHs = array('[[+npx.disabledDates]]' => $disabled);

        return $this->strReplaceAssoc($PHs, $this->getTpl('DateTpl'));
    }
    
    /** Produces the HTML code for simple text fields/TVs
     * 
     * @access protected
     * @param $name string - name of the field/TV
     * @param $tplName string - name of the template chunk that should be used
     * @param $maxLength int - Max length for the input field (in characters)
     * @return string - field/TV HTML code */

    protected function _displaySimple($name, $tplName, $maxLength = 10) {
        $PHs = array('[[+npx.maxlength]]' => $maxLength);
        return $this->strReplaceAssoc($PHs, $this->getTpl($tplName));
    }


    /** Produces the HTML code for file/image TVs
     * 
     * @access protected
     * @param $name string - name of the TV
     * @param $tplName string - name of the template chunk that should be used
     * @param $sourceOptions array - Associative array of options. Accepts all file/image TV input options.
     *       Possible options: all (processed) TV input options (Revo versions below 2.20), respectively the media source.
     *       'wctx' doesn't seem to have an effect (?)
     * @param $openTo string - Path for the directory to open to
     * @return string - HTML code */

    protected function _displayFileInput($name, $tplName, $sourceOptions = array(), $openTo = '') {
        /* @var $browserAction modAction */

       /* $browserAction = $this->modx->getObject('modAction',
            array('namespace' => 'newspublisher', 'controller' => 'filebrowser'));
        $browserUrl = $browserAction ? $this->modx->getOption('manager_url',null,
                MODX_MANAGER_URL).'index.php?a='.$browserAction->get('id') : null;*/
        $browserUrl = true;
        if ($browserUrl) {
          /*  $phpthumbUrl = $this->modx->getOption('connectors_url',null,
                    MODX_CONNECTORS_URL) . 'system/phpthumb.php?';
            foreach ($sourceOptions as $key => $value) {
                $phpthumbUrl .= "&{$key}={$value}";
            }

            $browserUrl .= '&field=' . $name;
            $sourceOptions['openTo'] = $openTo;
            $_SESSION['newspublisher']['filebrowser'][$name] = $sourceOptions;*/

            $PHs = array();

            // $PHs = array(
            //    '[[+npx.phpthumbBaseUrl]]' => $phpthumbUrl,
            //    '[[+npx.browserUrl]]'   => $browserUrl
            //);

            return $this->strReplaceAssoc($PHs, $this->getTpl($tplName));

        } else {
            
            $this->setError($this->modx->lexicon('np_no_action_found'));
            return null;
        }
    
    }
    
    /** Produces the HTML code for boolean (checkbox) fields/TVs
     * 
     * @access protected
     * @param $name string - name of the field/TV
     * @param $checked bool - Is the Checkbox activated?  (ignored on postback)
     * @return string - field/TV HTML code */

    protected function _displayBoolean($name, $checked) {
        if ($this->isPostBack) {
            $checked = $_POST[$name];
        }
        $PHs = array('[[+npx.checked]]' => $checked? 'checked="checked"' : '');

        return $this->strReplaceAssoc($PHs, $this->getTpl('BoolTpl'));
    }

    
    /** Produces the HTML code for list fields/TVs
     * 
     * @access protected
     * @param $name string  - name of the field/TV
     * @param $type string  - type of list (checkbox, listbox, listbox-multiple)
     * @param $options array -  associative array of list entries in the form array
     *     ('value' => 'text to display').
     * @param $selected mixed - List entry or array of (mutiple) list entries
     *     ($options values) that are currently selected
     *     (this option is ignored on postback)
     * @param $showNone bool - If true, the first option will be 'empty'
     *     (represented by a '-')
     * @return string - field/TV HTML code */

    protected function _displayList($name, $type, $options, $selected = null, $showNone = false) {

        if ($showNone) $options = array('' => '-') + $options;

        $postfix = ($type == 'checkbox' || $type=='listbox-multiple' ||
            $type=='listbox')? '[]' : '';
        
        $PHs = array('[[+npx.name]]' => $name . $postfix);

        if($type == 'listbox' || $type == 'listbox-multiple' || $type == 'dropdown') {
            $formTpl = $this->getTpl('ListOuterTpl');
            $PHs['[[+npx.multiple]]'] = ($type == 'listbox-multiple')
                ? ' multiple="multiple" '
                : '';
            $count = count($options);
            if ($type == 'dropdown') {
                $max = 1;
            } else {
                $max = ($type == 'listbox')
                    ? $this->listboxMax
                    : $this->multipleListboxMax;
            }
            $PHs['[[+npx.size]]'] = ($count <= $max)
                ? $count
                : $max;
        } else {
            $formTpl = $this->getTpl('OptionOuterTpl');
        }

        $PHs['[[+npx.hidden]]'] = ($type == 'checkbox')
            ? '<input type="hidden" name="' . $name . '[]" value="" />'
            : '';
        $PHs['[[+npx.class]]'] = $type;

        /* Do outer TPl replacements */
        $formTpl = $this->strReplaceAssoc($PHs,$formTpl);

        /* new replace array for options */
        $inner = '';
        $PHs = array('[[+npx.name]]' => $name . $postfix);

        // if postback -> use selection from $_POST
        if ($this->isPostBack && isset($_POST[$name])) {
            $selected = $_POST[$name];
        }
        if (!is_array($selected)) $selected = array($selected);

        /* Set HTML code to use for selected options */
        $selectedCode = ($type == 'radio' || $type == 'checkbox')
            ? 'checked="checked"'
            : 'selected="selected"';

        if ($type == 'listbox' || $type =='listbox-multiple' || $type == 'dropdown') {
            $optionTpl = $this->getTpl('ListOptionTpl');
        } else {
            $optionTpl = $this->getTpl('OptionTpl');
            $PHs['[[+npx.class]]'] = $PHs['[[+npx.type]]'] = $type;
        }

        /* loop through options and set selections */
        $idx = 1;
        foreach ($options as $value => $text) {
            $PHs['[[+npx.name]]'] = $name . $postfix;
            $PHs['[[+npx.value]]'] = $value;
            $PHs['[[+npx.idx]]'] = $idx;
            $PHs['[[+npx.selected]]'] = in_array($value, $selected)
                ? $selectedCode
                : '';
            $PHs['[[+npx.text]]'] = $text;
            $inner .= $this->strReplaceAssoc($PHs,"\n" .$optionTpl);
            $idx++;
        }

        return str_replace('[[+npx.options]]',$inner, $formTpl);
    }


    /** Produces the HTML code for textarea fields/TVs
     * 
     * @access protected
     * @param $name string - name of the field/TV
     * @param $RichText bool - Is this a Richtext field?
     * @param $noRTE_class string - class name for non-Richtext textareas
     * @param $rows int - number of rows in the textarea
     * @param $columns int - width (number of columns) of the textarea
     * @return string - field/TV HTML code
     */

    protected function _displayTextarea($name, $RichText, $noRTE_class, $rows = 20, $columns = 60) {
        $PHs = array(
            '[[+npx.rows]]' => $rows,
            '[[+npx.cols]]' => $columns
            );

        if ($RichText) {
            if($this->props['initrte']) {
                $PHs['[[+npx.class]]'] = 'modx-richtext';
            } else {
                $msg = $this->modx->lexicon('np_no_rte');
                $this->setError($msg . $name);
                $this->setFieldError($name, $msg);
                $PHs['[[+npx.class]]'] = $noRTE_class;
            }
        } else {
            $PHs['[[+npx.class]]'] = $noRTE_class;
        }
        return $this->strReplaceAssoc($PHs,
            $this->getTpl('TextAreaTpl'));
    }


    /** Saves the resource to the database.
     *
     * @access public
     * @return int - returns the ID of the created or edited resource,
     * or empty string on error.
     * Used by snippet to forward the user.
     *
     */

    public function saveResource() {

        /* user needs both permissions to save a document */
        if (! ($this->modx->hasPermission('save_document') &&
                $this->resource->checkPolicy('save'))) {
            if (! $this->modx->hasPermission('save_document') ) {
                $this->setError($this->modx->lexicon('np_save_permission_denied'));
            }
            if (!$this->resource->checkPolicy('save') ) {
                $this->setError($this->modx->lexicon('np_save_this_permission_denied'));
            }
            return '';
        }
        
        /* strip any unwanted tags */
        foreach ($_POST as $k => $v) {
            if (!is_array($v)) {
                $_POST[$k] = $this->modx->stripTags($v, $this->allowedTags);
            }
        }

        if ($this->modx->hasPermission('allow_modx_tags')) {
            $_POST = $this->convertTags($_POST, 'toSquare', '{{');
        }

        $oldFields = $this->resource->toArray();

        if (!empty($this->badwords)) {
            /* replace bad words */
            foreach ($_POST as $field => $val) {
                if (!is_array($val)) {
                    $_POST[$field] = preg_replace($this->badwords, '[Filtered]', $val);
                }
            }
        }

        /* correct timestamp resource fields */
        foreach ($_POST as $field => $val) {
            if (isset($this->resource->_fieldMeta[$field]) &&
                $this->resource->_fieldMeta[$field]['phptype'] == 'timestamp') {
                    $postTime = isset($_POST[$field . '_time'])? $_POST[$field . '_time'] : '';
                $_POST[$field] = $val . ' ' . $postTime;
                if (empty($_POST[$field]) || $_POST[$field] == ' ') {
                    $_POST[$field] = 0;
                }
            }
        }
        $fields = array_merge($oldFields, $_POST);
        if (!$this->existing) { /* new document */

            /* set alias name of document used to store articles */
            if (empty($fields['alias'])) { /* leave it alone if filled */
                if (!$this->aliasTitle) {
                    $suffix = !empty($this->props['aliasdateformat'])
                        ? date($this->props['aliasdateformat'])
                        : '-' . time();
                    if (!empty($this->props['aliasprefix'])) {
                        $alias = $this->props['aliasprefix'] . $suffix;
                    } else {
                        $alias = $suffix;
                    }
                } else { /* use pagetitle */
                    $alias = $this->modx->stripTags($_POST['pagetitle']);
                    $alias = strtolower($alias);
                    $alias = preg_replace('/&.+?;/', '', $alias); // kill entities
                    $alias = preg_replace('/[^\.%a-z0-9 _-]/', '', $alias);
                    $alias = preg_replace('/\s+/', '-', $alias);
                    $alias = preg_replace('|-+|', '-', $alias);
                    $alias = trim($alias, '-');

                }
                $fields['alias'] = $alias;
            }

            if (empty($fields['uri'])) {
                $fields['uri'] = $this->resource->getAliasPath($alias);
            }

            /* set fields for new object */

            /* set editedon and editedby for existing docs */
            $fields['editedon'] = '0';
            $fields['editedby'] = '0';

            /* these *might* be in the $_POST array. Set them if not */

            if (isset($_POST['published'])) {
                $fields['published'] = $_POST['published'];
            } else {
                $fields['published'] = $this->published;
            }

            $fields['hidemenu'] = isset($_POST['hidemenu'])
                ? $_POST['hidemenu']
                : $this->hideMenu;
            $fields['template'] = isset ($_POST['template'])
                ? $_POST['template']
                : $this->template;

            $fields['parent'] = isset($_POST['parent'])
                ? $_POST['parent']
                : $this->parentId;

            if (! is_numeric($fields['parent'])) {
                $this->resource->set('context_key', $fields['parent']);
            }

            $fields['searchable'] = isset ($_POST['searchable'])
                ? $_POST['searchable']
                : $this->searchable;
            $fields['cacheable'] = isset ($_POST['cacheable'])
                ? $_POST['cacheable']
                : $this->cacheable;
            $fields['richtext'] = isset ($_POST['richtext'])
                ? $_POST['richtext']
                : $this->richtext;
            $fields['createdby'] = $this->modx->user->get('id');
            $fields['content']  = $this->header . $fields['content'] . $this->footer;
            $fields['context_key'] = isset ($fields['context_key'])
                ? $fields['context_key']
                : $this->modx->context->get('key');


        }

        /* Add TVs to $fields for processor */
        /* e.g. $fields[tv13] = $_POST['MyTv5'] */
        /* processor handles all types */

        if (!empty($this->allTvs)) {
            /* *********************************************
             * Deal with bug in resource update processor. *
             * Set $fields to current TV value for all TVs *
             * This section can be removed when it's fixed *
             ********************************************* */
            if ($this->existing) {
                /* @var $t_tv modTemplateVar */
                $t_resourceTVs = $this->resource->getMany('TemplateVars');
                $t_resourceId = $this->resource->get('id');
                foreach ($t_resourceTVs as $t_tv) {
                    $t_tvId = $t_tv->get('id');
                    $t_value = $t_tv->getValue($t_resourceId);
                    $fields['tv' . $t_tvId] = $t_value;
                }
                unset($t_resourceTVs,$t_resourceId,$t_tvId,$t_value);
            }

            /* ****************************************** */
            $fields['tvs'] = true;
            foreach ($this->allTvs as $tv) {
                /* @var $tv modtemplateVar */
                $name = $tv->get('name');

                if ($tv->get('type') == 'date') {
                    $tvCode = 'tv' . $tv->get('id');
                    if (empty($_POST[$name])) {
                        $fields[$tvCode] = '';
                    } else {
                        $fields[$tvCode] = $_POST[$name] . ' ' .
                            $_POST[$name . '_time'];
                    }
                    if ($fields[$tvCode] == ' ' || empty($fields[$tvCode])) {
                        $fields[$tvCode] = 0;
                    }
                } else {
                    if (is_array($_POST[$name])) {
                        /* get rid of phantom checkbox */
                        if ($tv->get('type') == 'checkbox') {
                            unset($_POST[$name][0]);
                        }
                    }
                    $fields['tv' . $tv->get('id')] = $_POST[$name];
                }
            }
        }
        /* set groups for new doc if param is set */
        if ((!empty($this->groups) && (!$this->existing))) {
            $fields['resource_groups'] = $this->groups;
        }

        /* one last error check before calling processor */
        if (!empty($this->errors)) {
            /* return without altering the DB */
            return '';
        }
        if ($this->props['clearcache']) {
            $fields['syncsite'] = true;
        }
        unset($fields['pub_date_time'], $fields['Submit'],
            $fields['unpub_date_time'], $fields['hidSubmit']);

        /* call the appropriate processor to save resource and TVs */

        if ($this->existing) {
            /* Clear cache file for existing resource */
            @unlink(MODX_CORE_PATH  . 'cache/resource/web/resources/' .
                $fields['id'] . '.cache.php');
            $response = $this->modx->runProcessor('resource/update', $fields);
        } else {
                $response = $this->modx->runProcessor('resource/create', $fields);
        }

        /* @var $response modProcessorResponse */
        if ($response->isError()) {
            if ($response->hasFieldErrors()) {
                $fieldErrors = $response->getAllErrors();
                $errorMessage = implode("\n", $fieldErrors);
            } else {
                $errorMessage = 'An error occurred: ' . $response->getMessage();
            }
            $this->setError($errorMessage);
            return '';

        } else {
            $object = $response->getObject();

            $postId = $object['id'];

            if ($this->launchNotify) {
                $notifyObj = $this->modx->getObject('modResource', array('alias' => 'notify'));
                if ($notifyObj) {
                    if (isset($_POST['pageType']) && (!empty($_POST['pageType']))) {
                        $pageType = $_POST['pageType'];
                    } else {
                        $pageType = $this->existing ? 'existing' : 'new';
                    }

                $_SESSION['nf.pageId'] = $postId;
                $_SESSION['nf.pageType'] = $pageType;
                $notifyUrl = $this->modx->makeUrl($notifyObj->get('id'), "", "", "full");
                    $this->modx->reloadContext($this->modx->context->get('key'));
                    $this->modx->sendRedirect($notifyUrl);
                } else {
                    $this->setError('Could not find Notify page');
                }

            }
            /* clean post array */
            $_POST = array();
        }

        if (!$postId) {
            $this->setError('np_post_save_no_resource');
        }
        return $postId;

    } /* end saveResource() */

        /** Forward user to another page (default is edited page)
         *
         *  @access public
         *  @param $postId int - ID of page to forward to
         *  */

        public function forward($postId) {
            if (empty($postId)) {
                $postId = $this->existing
                    ? $this->existing
                    : $this->resource->get('id');
            }
            /* Assume that the processor cleared the cache */

            $_SESSION['np_resource_id'] = $this->resource->get('id');
            $ctx = $this->resource->get('context_key');
            $ctx = empty($ctx) ? '' : $ctx;
            if (! $this->existing) {
                $this->modx->reloadContext($ctx);
            }
            if (!empty($ctx) && ($ctx != $this->modx->context->get('key'))) {
                $this->modx->switchContext($ctx, true);
            }

            $goToUrl = $this->modx->makeUrl($postId, $ctx, "", "full");

            /* redirect to post id */

            /* The following code is necessary in older versions of MODX */
            /*$controller = $this->modx->getOption('request_controller',
                null,'index.php');
            $goToUrl = $controller . '?id=' . $postId;*/

            $this->modx->sendRedirect($goToUrl);
        }

    /** creates a JSON string to send in the resource_groups field
     * for resource/update or resource/create processors.
     *
     * @access protected
     * @param $resourceGroups string - a comma-separated list of
     * resource groups names or IDs (or both mixed) to assign a
     * document to.
     * @param $parentObj modResource - parent object
     *
     * @return string -  JSON encoded array
     */

    protected function _setGroups($resourceGroups, $parentObj = null) {
        $values = array();
        if ($resourceGroups == 'parent') {

            $resourceGroups = (array) $parentObj->getMany('ResourceGroupResources');

            if (!empty($resourceGroups)) {
                /* parent belongs to at least one resource group */
                /* build $resourceGroups string from parent's groups */
                $groupNumbers = array();
                foreach ($resourceGroups as $resourceGroup) {
                    /* @var $resourceGroup modResourceGroup */
                    $groupNumbers[] = $resourceGroup->get('document_group');
                }
                $resourceGroups = implode(',', $groupNumbers);
            } else { /* parent not in any groups */
                //$this->setError($this->modx->leXicon('np_no_parent_groups'));
                return '';
            }


        } /* end if 'parent' */

        $groups = explode(',', $resourceGroups);

        foreach ($groups as $group) {
            /* @var $groupObj modResourceGroup */
            $group = trim($group);
            if (is_numeric($group)) {
                $groupObj = $this->modx->getObject('modResourceGroup', (integer) $group);
            } else {
                $groupObj = $this->modx->getObject('modResourceGroup',
                    array('name' => $group));
            }
            if (! $groupObj) {
                $this->setError($this->modx->lexicon('np_no_resource_group') .
                    $group);
                return null;
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
    /*protected function _stripslashes_deep($value) {
        $value = is_array($value) ?
                array_map('_stripslashes_deep', $value) :
                stripslashes($value);
        return $value;
    }*/

    /** return any errors set in the class
     * @return array - array of error strings
     */
    public function getErrors() {
        return $this->errors;
    }

    /** add error to error array
     * @param $msg string - error message
     */
    public function setError($msg) {
        $this->errors[] = $msg;
    }

    /** Gets template ID of resource
     * @return int - returns the template ID
     */
    protected function _getTemplate() {
        if ($this->existing) {
            return $this->resource->get('template');
        }
        /* Allow templateid as alias for template */
        if (isset($this->props['templateid'])) {
            $this->props['template'] = $this->props['templateid'];
            unset($this->props['templateid']);
        }
        $template = $this->modx->getOption('default_template');

        if ($this->props['template'] == 'parent') {
            if (empty($this->parentId)) {
                $this->setError($this->modx->lexicon('np_parent_not_sent'));
            }
            if (empty($this->parentObj)) {
                $this->parentObj = $this->modx->getObject('modResource',
                    $this->parentId);
            }
            if ($this->parentObj) {
                $template = $this->parentObj->get('template');
            } else {
                $this->setError($this->modx->lexicon('np_parent_not_found') .
                    $this->parentId);
            }

        } elseif (!empty($this->props['template'])) {


            if (is_numeric($this->props['template'])) { /* user sent a number */
                $t = $this->modx->getObject('modTemplate',
                    (integer) $this->props['template']);
                /* make sure it exists */
                if (! $t) {
                    $this->SetError($this->modx->lexicon('np_no_template_name') .
                        $this->props['template']);
                }
            } else { /* user sent a template name */
                $t = $this->modx->getObject('modTemplate',
                    array(
                        'templatename' => $this->props['template']
                    ));
                if (!$t) {
                    $this->setError($this->modx->lexicon('np_no_template_name') .
                        $this->props['template']);
                }
            }
            /* @var $t modTemplate */
            $template = $t
                ? $t->get('id')
                : $this->modx->getOption('default_template');
                unset($t);
        }

        return $template;
    }

    /** Checks form fields before saving.
     *  Sets an error for the header and another for each
     *  missing required field.
     * */

    public function validate() {
        $errorTpl = $this->getTpl('FieldErrorTpl');
        $success = true;
        $fields = explode(',', $this->props['required']);
        if (!empty($fields)) {

            foreach ($fields as $field) {
                if (empty($_POST[$field])) {
                    $success = false;
                    /* set ph for field error msg */
                    $msg = $this->modx->lexicon('np_error_required');
                    $this->setFieldError($field, $msg);

                    /* set error for header */
                    $msg = $this->modx->lexicon('np_missing_field');
                    $msg = str_replace('[[+name]]', $field, $msg);
                    $this->setError($msg);

                }
            }
        }

        /* Ensure TV bindings do not contain an @EVAL binding */
        foreach ($this->allTvs as $tv) {
            /* @var $tv modTemplateVar */
            $name = $tv->get('name');
            $value = isset($_POST[$name])? $_POST[$name] : '';
            if (is_array($value)) $value = implode('', $value);
            if (isset($_POST[$name . '_time'])) {
                $value .= $_POST[$name . '_time'];
            }

            if (stristr($value, '@EVAL')) {
                $this->setError($this->modx->lexicon('np_no_evals_input'));
                $_POST[$name] = '';
                /* set fields to empty string */
                $this->modx->toPlaceholder($name, '', $this->prefix);
                $success = false;
            }

        }
        return $success;
    }

/** Sets placeholder for field error messages
 * @param $fieldName string - name of field
 * @param $msg string - lexicon error message string
 *
*/

    public function setFieldError($fieldName, $msg) {
        $msg = str_replace('[[+name]]', $fieldName, $msg);
        $msg = str_replace("[[+{$this->prefix}.error]]", $msg,
            $this->getTpl('FieldErrorTpl'));
        $ph = 'error_' . $fieldName;
        $this->modx->toPlaceholder($ph, $msg, $this->prefix);
    }

    /**
     * @param $ar mixed - string or array to convert
     * @param string $direction - 'toSquare' or 'toCurly'
     * @param string $token - string to search for ('[[' or '}}'
     *     non-strings and strings without the token are left alone
     *
     * @return mixed - returns converted string or array
     */
    public function convertTags($ar, $direction = 'toCurly', $token = '[[') {
        $find = $direction == 'toSquare'? array('{{', '}}') : array('[[', ']]');
        $replace = $direction == 'toSquare'? array('[[', ']]') : array('{{', '}}');

        if (! is_array($ar)) {
            if (is_string ($ar) && (strpos($ar, $token) !== false)) {
                $ar = str_replace($find, $replace, $ar);
            }
        } else {

            foreach ($ar as $key => $value) {
                $ar[$key] = $this->convertTags($value, $direction, $token);
            }
        }
        return $ar;
    }

    public function hasToken($subject, $token = '[[') {
        $tokenFound = false;
        if (!is_array($subject)) {
            return strpos($subject, $token) !== false;
        } else {
            foreach ($subject as $key => $value) {
                if ($this->hasToken($value, $token)) {
                    return true;
                }
            }
        }
        return $tokenFound;
    }

public function my_debug($message, $clear = false) {
    /* @var $chunk modChunk */
    global $modx;

    $chunk = $modx->getObject('modChunk', array('name'=>'debug'));
    if (! $chunk) {
        $chunk = $modx->newObject('modChunk', array('name'=>'debug'));
        $chunk->save();
        $chunk = $modx->getObject('modChunk', array('name'=>'debug'));
    }
    if ($clear) {
        $content = '';
    } else {
        $content = $chunk->getContent();
    }
    $content .= $message;
    $chunk->setContent($content);
    $chunk->save();
}

public function getParents() {
    $parentArray = array();
    $temp = $this->modx->getOption('parents', $this->props, '');
    if (empty($temp)) {
        $temp = $this->parentId;
    }
    if (!empty($temp)) {
        $parents = explode(',', $temp);
        foreach($parents as $parent) {
            if (is_numeric($parent)) {
                if ($parent == $this->resource->get('id')) {
                    /* Doc can't be its own parent */
                    continue;
                }
                $obj = $this->modx->getObject('modResource', (int) $parent);
                if ($obj) {
                    $parentArray[$obj->get('id')] = $obj->get('pagetitle');
                } else {
                    $this->setError(
                        $this->modx->lexicon('np_parent_resource_nf')
                    . ': '  . $parent);
                }
            } else {
                if ($this->modx->getCount('modContext', $parent)) {
                    $parentArray[$parent] = $parent;
                } else {
                    $this->setError(
                        $this->modx->lexicon('np_parent_context_nf')
                        . ': ' . $parent);
                }
            }
        }
    }
    return $parentArray;
}

public function deleteResource($id) {
    $okToDelete = true;
    $msg = $this->modx->lexicon('np_delete_failed');
    if (!$this->modx->hasPermission('delete_document')) {
        $okToDelete = false;
        $msg = $this->modx->lexicon('np_no_delete_document_permission');
    } elseif (! $this->resource->checkPolicy('delete')) {
        $okToDelete = false;
        $msg = $this->modx->lexicon('np_no_delete_permission');
    }

    if ($okToDelete) {
        $fields = array(
            'id' => $id,
        );

        $response = $this->modx->runProcessor('resource/delete', $fields);
        if ($response->isError()) {
            if ($response->hasFieldErrors()) {
                $fieldErrors = $response->getAllErrors();
                $msg = implode("\n", $fieldErrors);
            } else {
                $msg = 'An error occurred: ' . $response->getMessage();
            }
        } else {
            $msg = $this->modx->lexicon('np_resource_deleted');
        }
    }

    return $msg;

}

public function duplicate($id, $context) {

    /* Save changes before duplicating */
    $saved = $this->saveResource();
    if (empty($saved)) {
        return '';
    }
    $fields = array(
        'id' => $id,
        'name' => $this->modx->lexicon('np_duplicate_of') .
            $this->resource->get('pagetitle'),
    );
    $response = $this->modx->runProcessor('resource/duplicate', $fields);
    /* @var $response modProcessorResponse */
    if ($response->isError()) {
        if ($response->hasFieldErrors()) {
            $fieldErrors = $response->getAllErrors();
            $errorMessage = implode("\n", $fieldErrors);
        } else {
            $errorMessage = 'An error occurred: ' . $response->getMessage();
        }
        $this->setError($errorMessage);

        return '';

    } else {
        $object = $response->getObject();
        $postId = $object['id'];
        $this->modx->reloadContext($context);
        $_SESSION['np_doc_id'] = $postId;
        $_SESSION['np_doc_to_edit'] = $postId;
        /* Get NewsPublisher ID to forward to */
        $npId = $this->modx->resource->get('id');
        $url = $this->modx->makeUrl($npId, "", "", "full");
        $this->modx->sendRedirect($url);
    }
    return true;

}

    /**
     * Parse double-delimited string to a PHP array
     * @param $s string in the form 'key1:value1,key2,$value2
     * @return array parsed array or empty array
     */
    public function parseDoubleDelimitedString($s) {
        $retVal = array();
        if (!empty($s)) {
            $c = explode(',', $s);
            if (!empty($c)) {
                foreach ($c as $p) {
                    $pair = explode(':', $p, 2);
                    $retVal[trim($pair[0])] = trim($pair[1]);
                }
            }
        }

        return $retVal;
    }



} /* end class */
