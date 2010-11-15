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
    protected $props;

    public function __construct(&$modx, &$props) {
        $this->modx = $modx;
        $this->props = $props;
    }

    public function init($richText) {
        $this->modx->regClientCSS(MODX_ASSETS_URL . 'components/newspublisher/css/demo.css');
        $this->modx->regClientCSS(MODX_ASSETS_URL . 'components/newspublisher/css/datepicker.css');
        $this->modx->regClientStartupScript(MODX_ASSETS_URL . 'components/newspublisher/js/datepicker.js');
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


}
?>
