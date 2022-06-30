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


$modx =& $object->xpdo;
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

        $group = $modx->getObject($prefix . 'modAccessPolicyTemplateGroup', array('name' => 'Admin'));
        if (!$group) {
            $modx->log(xPDO::LOG_LEVEL_ERROR,'Cannot get the admin access policy template group'. $templateName);
            break;
        }
        $template->set('template_group', $group->get('id'));
        $modx->log(xPDO::LOG_LEVEL_INFO,'Setting template_group for '. $templateName);
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
                    $newPerm->save();
                }
            }
        }
        $success = $template->save();
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        $success = true;
        break;
}

return $success;
