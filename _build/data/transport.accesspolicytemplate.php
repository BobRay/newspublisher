<?php
/**
 * NewsPublisher Access Policy Template
 *
 * @package newspublisher
 */

$template = $modx->newObject('modAccessPolicyTemplate');
$template->fromArray(array(
  'id' => 1,
  'name' => 'NewsPublisherAdminAcessPolicyTemplate',
  'description' => "Administrator Access Policy Template extended by the 'allow_modx_tags' permission used by NewsPublisher",
  'lexicon' => 'permissions',
));

return $template;
