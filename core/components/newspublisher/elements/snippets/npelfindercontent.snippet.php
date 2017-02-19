<?php
/** @var $modx modX */

if ((!$modx->user->hasSessionContext($modx->context->get('key'))) && (!$modx->user->get('sudo'))) {
    die('Unauthorized');
}

$assetsUrl = $modx->getOption('np.assets_url', null, MODX_ASSETS_URL . 'components/newspublisher/');
$fields = array(
    'npAssetsURL' => $assetsUrl,
);

if (isset($_GET['media_source'])) {
    $ms = $_GET['media_source'];
    if (!empty($ms)) {
        $fields['media_source'] = '?&media_source=' . $ms;
    }
}

return $modx->getChunk('npElFinderContent', $fields);