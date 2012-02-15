<?php
/**
 * NewsPublisher access policy resolver script
 *
 * @package newspublisher
 */

/* @var $modx modX */
/* @var $policy modAccessPolicy */
/* @var $options array */
/* @var $object array */
/* @var $template modAccessPolicyTemplate */

$modx =& $object->xpdo;
$success = false;
$policyName = 'NewsPublisherEditor';
$templateName = 'NewsPublisherPolicyTemplate';


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
