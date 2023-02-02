<?php
/**
 * NewsPublisher access policy template resolver script
 *
 * @package newspublisher
 */


/* @var $modx modX */
/* @var $modx modX */
/* @var $policy modAccessPolicy */
/* @var $options array */
/* @var $object array */
/* @var $template modAccessPolicyTemplate */
/* @var $group modAccessPolicyTemplateGroup */
/* @var $adminTemplate modAccessPolicyTemplate */
/* @var $permission modAccessPermission */
/* @var $newPerm modAccessPermission */
/* @var $existingPermissions array */

/** @var $transport modTransportPackage */

if ($transport) {
    $modx =& $transport->xpdo;
} else {
    $modx =& $object->xpdo;
}

$success = false;
$templateName = 'NewsPublisherPolicyTemplate';
$prefix = $modx->getVersionData()['version'] >= 3
    ? 'MODX\Revolution\\'
    : '';


switch($options[xPDOTransport::PACKAGE_ACTION]) {

    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        $template = $modx->getObject($prefix . 'modAccessPolicyTemplate', array('name' => $templateName));
        if (!$template) {
            $modx->log(xPDO::LOG_LEVEL_ERROR,'Cannot get the '.$templateName);
            break;
        }

        /* Copy all permissions from the AdministratorTemplate (not necessary if upgrading, they will already exist)  */
        $existingPermissions = $template->getMany('Permissions');
        if (empty($existingPermissions)) {
            $adminTemplate = $modx->getObject($prefix . 'modAccessPolicyTemplate', array('id' => 1));
            if (!$adminTemplate) {
                $modx->log(xPDO::LOG_LEVEL_ERROR,'Cannot get the AdministratorTemplate modAccessPolicyTemplate');
                break;
            }
            $modx->log(xPDO::LOG_LEVEL_INFO,'Setting permissions for '. $templateName);
            $permissions = $adminTemplate->getMany('Permissions');
            $modx->lexicon->load('newspublisher:permissions');
            $permissions[] = $modx->newObject($prefix . 'modAccessPermission',array(
                'name' => 'allow_modx_tags',
                'description' => $modx->lexicon('np_allow_modx_tags_desc'),
                'value' => true,
            ));
            if (!empty($permissions)) {
                foreach ($permissions as $permission) {
                    $newPerm = $modx->newObject($prefix . 'modAccessPermission');
                    $newPerm->fromArray($permission->toArray());
                    $newPerm->set('template',$template->get('id'));
                    if (! $newPerm->save()) {
                       $modx->log(modX::LOG_LEVEL_ERROR, 'Could not save permission ');
                    }
                }
            }
        }
        $success = $template->save();
        if (! $success) {
            $modx->log(modX::LOG_LEVEL_ERROR, 'Could not save Policy Template');
        }
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        $success = true;
        break;
}

return $success;
