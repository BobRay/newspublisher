<?php
/**
 * NewsPublisher access policy template resolver script
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
        if (!$template) {
            $modx->log(xPDO::LOG_LEVEL_ERROR,'Cannot get the '.$templateName);
            break;
        }
        $group = $modx->getObject('modAccessPolicyTemplateGroup', array('name' => 'Admin'));
        if (!$group) {
            $modx->log(xPDO::LOG_LEVEL_ERROR,'Cannot get the admin access policy template group'.$templateName);
            break;
        }
        $template->set('template_group', $group->get('id'));

        // TODO: how best identify the Admin Template?
        $adminTemplate = $modx->getObject('modAccessPolicyTemplate', array('id' => 1)); 
        if (!$adminTemplate) {
            $modx->log(xPDO::LOG_LEVEL_ERROR,'Cannot get the AdministratorTemplate modAccessPolicyTemplate');
            break;
        }
        
        $permissions = $adminTemplate->getMany('Permissions');
        $modx->lexicon->load('newspublisher:permissions');
        $permissions[] = $modx->newObject('modAccessPermission',array(
            'name' => 'allow_modx_tags',
            'description' => $modx->lexicon('np_allow_modx_tags_desc'),
            'value' => true,
        ));
        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                $newPerm = $modx->newObject('modAccessPermission');
                $newPerm->fromArray($permission->toArray());
                $newPerm->set('template',$template->get('id'));
                $newPerm->save();
            }
        }
        $success = $template->save();
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        $success = true;
        break;
}

return $success;
