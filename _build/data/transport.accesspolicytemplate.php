<?php
/**
 * NewsPublisher Access Policy Template
 *
 * @package newspublisher
 */
/* @var $modx modX */
/* @var $template modAccessPolicyTemplate */
$template = $modx->newObject('modAccessPolicyTemplate');
$template->fromArray(array(
  'id' => 1,
  'name' => 'NewsPublisherPolicyTemplate',
  'group' => 'Administrator',
  'description' => "Administrator Access Policy Template extended by the 'allow_modx_tags' permission used by NewsPublisher",
  'lexicon' => 'permissions',
));

return $template;
