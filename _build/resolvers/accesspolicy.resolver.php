<?php
/**
 * NewsPublisher access policy resolver script
 *
 * @package newspublisher
 */


$modx =& $object->xpdo;
$success = false;
$policyName = 'NewsPublisherEditor';
$templateName = 'NewsPublisherAdminAcessPolicyTemplate';


switch($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        $template = $modx->getObject('modAccessPolicyTemplate', array('name' => $templateName));
        if ($template) {
            $policy = $modx->getObject('modAccessPolicy', array('name' => $policyName));
            if (!$policy) {
                $modx->log(xPDO::LOG_LEVEL_ERROR,'Cannot get the '.$policyName);
                break;
            }
            $policy->set('template', $template->get('id'));
            $success = $policy->save();
        }
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        $success = true;
        break;
}

return $success;
