<?php
/**
 * NewsPublisher access policy resolver script
 * Copyright 2013-2023 Bob Ray <https://bobsguides.com>
 * @package newspublisher
 */

/** @var $modx modX */
/** @var $policy modAccessPolicy */
/** @var $options array */
/** @var $object array */
/** @var $template modAccessPolicyTemplate */

/** @var $transport modTransportPackage */

if ($transport) {
    $modx =& $transport->xpdo;
} else {
    $modx =& $object->xpdo;
}
$modx->log(modX::LOG_LEVEL_INFO, 'Running access policy resolver');
$success = false;
$policyName = 'NewsPublisherEditor';
$templateName = 'NewsPublisherPolicyTemplate';
$prefix = $modx->getVersionData()['version'] >= 3
    ? 'MODX\Revolution\\'
    : '';

switch($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        $template = $modx->getObject($prefix . 'modAccessPolicyTemplate', array('name' => $templateName));
        if ($template) {
            $policy = $modx->getObject($prefix . 'modAccessPolicy', array('name' => $policyName));
            if (!$policy) {
                $modx->log(xPDO::LOG_LEVEL_ERROR,'Cannot get the '.$policyName);
                break;
            }
            $modx->log(xPDO::LOG_LEVEL_INFO,'Setting template field for '. $policyName . ' policy');
            $policy->set('template', $template->get('id'));
            $success = $policy->save();
        }
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        $success = true;
        break;
}

return $success;
