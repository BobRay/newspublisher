<?php
/**
* Loads the newspublisher filebrowser manager page
* MODx Revolution 2.3 and above
*
* @package modx
* @subpackage newspublisher
*/

class FilebrowserManagerController extends modManagerController {
    public $loadBaseJavascript = true;
    public $loadHeader = false;
    public $loadFooter = false;

    public function initialize() {
        $this->is_Revo_2_2 = (boolean)version_compare($this->modx->version['full_version'], '2.3.0-rc1', '<');
    }

    /**
     * Check for any permissions or requirements to load page
     * @return bool
     */
    public function checkPermissions() {
        // only allow access if the browser was launched from within the newspublisher page
        return $this->modx->hasPermission('file_manager')
               && isset($_SESSION['newspublisher']['filebrowser'][$_GET['field']]);
    }

    /**
     * Register custom CSS/JS for the page
     * @return void
     */
    public function loadCustomCssJs() {
        $ver = $this->is_Revo_2_2 ? '-2.2' : '';
        $this->modx->regClientStartupScript(
            $this->modx->getOption('np.assets_url', null, MODX_ASSETS_URL.'components/newspublisher/').
            'js/widgets/modx.np.browser'.$ver.'.js'
        );
    }

    /**
     * Custom logic code here for setting placeholders, etc
     * @param array $scriptProperties
     * @return mixed
     */
    public function process(array $scriptProperties = array()) {
        return $_SESSION['newspublisher']['filebrowser'][$_GET['field']];
    }

    /**
     * Return the pagetitle
     *
     * @return string
     */
    public function getPageTitle() {
        return $this->modx->lexicon('modx_resource_browser');
    }

    /**
     * Return the location of the template file
     * @return string
     */
    public function getTemplateFile() {
        $ver = $this->is_Revo_2_2 ? '-2.2' : '';
        return $this->modx->getOption('core_path').
               'components/newspublisher/templates/filebrowser'.$ver.'.tpl';
    }

    /**
     * Specify the language topics to load
     * @return array
     */
    public function getLanguageTopics() {
        return array('file');
    }
}

