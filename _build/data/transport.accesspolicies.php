<?php
/**
 * NewsPublisher Access Policies
 *
 * @package newspublisher
 */
$policies = array();

$policies[1] = $modx->newObject('modAccessPolicy');
$policies[1]->fromArray(array(
  'id' => 1,
  'name' => 'NewsPublisher Editor',
  'description' => 'Allows content editors to create/edit/delete resources in the frontend and use the MODx file browser (but no other parts of the manager interface)',
  'parent' => 0,
  'class' => '',
  'data' => '{"change_password":true,"class_map":true,"delete_document":true,"directory_create":true,"directory_list":true,"directory_remove":true,"directory_update":true,"edit_document":true,"file_list":true,"file_manager":true,"file_remove":true,"file_upload":true,"frames":true,"list":true,"load":true,"logout":true,"new_document":true,"publish_document":true,"save_document":true,"source_view":true,"unpublish_document":true,"view":true,"view_document":true,"view_unpublished":true}',
  'lexicon' => 'permissions',
  'template' => 1, // TODO: How identify the AdministratorTemplate (name could have been changed)?
), '', true, true);

return $policies;
