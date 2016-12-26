<?php
$assetsUrl = $modx->getOption('np.assets_url', null, $modx->getOption('assets_url', null) . 'components/newspublisher/');

$fields = array(
    'npAssetsURL' => $assetsUrl,
);


return $modx->getChunk('npElFinderContent', $fields);