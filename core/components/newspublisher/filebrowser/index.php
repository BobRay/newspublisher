<?php
/**
 * Loads the newspublisher filebrowser manager page
 * Versions below 2.20
 *
 * @package modx
 * @subpackage newspublisher
 */


// Only allow access if the browser was launched from within the newspublisher page
if (!$modx->hasPermission('file_manager') || !isset($_SESSION['newspublisher']['filebrowser'][$_GET['field']]))
    return $modx->error->failure($modx->lexicon('permission_denied'));


$modx->regClientStartupScript($modx->getOption('manager_url').'assets/modext/core/modx.view.js');
$modx->regClientStartupScript($modx->getOption('np.assets_url', null, MODX_ASSETS_URL . 'components/newspublisher/').'js/widgets/modx.np.browser.js');

foreach ($_SESSION['newspublisher']['filebrowser'][$_GET['field']] as $opt => $val) {
    $modx->smarty->assign($opt, $val);
}

$id = $_SERVER['HTTP_MODAUTH'] = $_SESSION["modx.{$modx->context->get('key')}.user.token"];
if (!isset($id)) $id = $modx->site_id; // versions before 2.1.1

$modx->smarty->assign('site_id', $id);

$modx->regClientStartupHTMLBlock('<script type="text/javascript">
MODx.siteId = "'.$id.'";
MODx.ctx = "'.$ctx.'";
</script>');

$modx->response->registerCssJs(false);
return $modx->smarty->fetch('filebrowser/index.tpl');
