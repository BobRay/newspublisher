<?php
/**
 * Loads the newspublisher filebrowser manager page
 * Versions below 2.20
 *
 * @package modx
 * @subpackage newspublisher
 */

if (!$modx->hasPermission('file_manager')) return $modx->error->failure($modx->lexicon('permission_denied'));

foreach ($_GET as $opt => $val) {
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
