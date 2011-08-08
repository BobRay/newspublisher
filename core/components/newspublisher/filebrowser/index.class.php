<?php
/**
* Loads the newspublisher filebrowser manager page
* Revo 2.20 and above
*
* @package modx
* @subpackage newspublisher
*/

class FilebrowserManagerController extends modManagerController {
    public $ctx;
    public $loadBaseJavascript = true;
    public $loadHeader = false;
    public $loadFooter = false;
    
    /**
     * Check for any permissions or requirements to load page
     * @return bool
     */
    public function checkPermissions() {
        return $this->modx->hasPermission('file_manager');
    }

    /**
     * Register custom CSS/JS for the page
     * @return void
     */
    public function loadCustomCssJs() {
        $this->modx->regClientStartupScript($this->modx->getOption('np.assets_url', null, MODX_ASSETS_URL . 'components/newspublisher/').'js/widgets/modx.np.browser.js');
    }

    /**
     * Custom logic code here for setting placeholders, etc
     * @param array $scriptProperties
     * @return mixed
     */
    public function process(array $scriptProperties = array()) {
        $scriptProperties['np_assets_url'] = $this->modx->getOption('np.assets_url', null, MODX_ASSETS_URL . 'components/newspublisher/');
        // required??
        //$_SERVER['HTTP_MODAUTH'] = $_SESSION["modx.{$this->modx->context->get('key')}.user.token"];
        //$scriptProperties['site_id'] = $_SERVER['HTTP_MODAUTH'];

        return $scriptProperties;
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
        return $this->modx->getOption('core_path').'components/newspublisher/filebrowser/index_2_20.tpl';
    }

    /**
     * Specify the language topics to load
     * @return array
     */
    public function getLanguageTopics() {
        return array('file');
    }
}

