<?php
/**
 * NewsPublisher
 *
 * 
 *
 * NewsPublisher is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * NewsPublisher is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * NewsPublisher; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package newspublisher
 */
/**
 * Default Lexicon Topic
 *
 * @package newspublisher
 * @subpackage lexicon
 */

/* newspublisher strings */
$_lang['np_not_in_group'] = 'You are not in any of the authorices user groups.';
$_lang['np_not_logged_in'] = 'You must be logged in to post.';
$_lang['np_no_permissions'] = 'You do not have the necessary permissions.';
$_lang['np_no_error_tpl'] = 'Could not find &amp;errortpl: [[+tpl]]';
$_lang['np_main_header'] = 'Create/Edit Resource';
$_lang['np_error_presubmit'] = 'Sorry . . . There were one or more problems in producing the form:';
$_lang['np_error_submit'] = 'Sorry . . . There were one or more problems with your submission:';
$_lang['np_error_required'] = 'The [[+name]] field is required.';
$_lang['np_missing_field'] = 'Missing field: [[+name]].';
$_lang['np_no_resource_group'] = 'Could not find [[+name]] resource group.';
$_lang['np_no_resource'] = 'Failed to get resource: [[+id]].';
$_lang['np_no_template_name'] = 'Failed to get template: [[+name]].';
$_lang['np_no_tvs'] = 'You wanted to order TVs, but this template has none.';
$_lang['np_unauthorized'] = 'You are not allowed to publish articles.';
$_lang['np_folder_not_sent'] = 'You set &amp;template to parent but did not include the folder parameter.';
$_lang['np_resource_save_failed'] = 'An error occured when saving the resource.';
$_lang['np_to_template_id'] = 'There is no template with this number: [[+id]].';
$_lang['np_to_template_name'] = 'There is no template with this name: [[+name]].';
$_lang['np_date_hint'] = '(Y-M-D)';
$_lang['np_date_format'] = 'format-y-m-d';
$_lang['np_view_permission_denied'] = 'You do not have permission to view this document';
$_lang['np_create_permission_denied'] = 'You do not have permission to create a document';
$_lang['np_save_permission_denied'] = 'You do not have permission to view this document';
$_lang['np_no_edit_self'] = 'You cannot edit the newspublisher page.';
$_lang['np_no_parent_groups'] = '&groups set to parent but doc has no parent';
$_lang['np_post_save_no_resource'] = 'Unable to get resource after save';

/* missing resource field lexicon strings */
$_lang['resource_pub_date'] =  'Publish Date';
$_lang['resource_pub_date_help'] =  ' (optional) set date to automatically publish resource. Click on the calendar icon to select a date.';
$_lang['resource_unpub_date'] =  'Unpublish Date';
$_lang['resource_unpub_date_help'] =  ' (optional) set date to automatically unpublish the resource. Click on the calendar icon to select a date.';
$_lang['resource_hidemenu'] =  'Hide from Menus';
$_lang['resource_hidemenu_help'] =  'When enabled the resource will'. '<b>' . 'not' . '</b>' . 'be available for use inside a web menu. Please note that some Menu Builders might choose to ignore this option.';
$_lang['resource_isfolder'] =  'Container';
$_lang['resource_isfolder_help'] =  'Check this to designate the Resource as a Container for other Resources. A `Container` is like a folder, but it can also have content of its own.';
$_lang['resource_content_dispo'] =  'Content Disposition';
$_lang['resource_content_dispo_help'] =  'Use the content disposition field to specify how this resource will be handled by the web browser. For file downloads select the Attachment option.';
$_lang['resource_class_key'] =  'Class Key';
$_lang['resource_context_key'] =  'Context Key';
$_lang['resource_context_key_help'] =  'The context the resource is attached to.';
$_lang['resource_publishedby_help'] =  'The ID of the user who published the resource.';
$_lang['resource_createdby_help'] =  'The ID of the user who originally created the resource.';
$_lang['resource_createdon_help'] =  'The date the resource was originally created.';
$_lang['resource_editedby_help'] =  'The ID of the user who most recently edited the resource.';
$_lang['resource_editedon_help'] =  'The date the resource was most recently edited.';
$_lang['resource_deleted'] =  'Deleted';
$_lang['resource_deleted_help'] =  'Marks the resource for deletion, but does not delete it.';
$_lang['resource_deletedon'] =  'Deleted On';
$_lang['resource_deletedon_help'] =  'The date the resource was most recently marked for deletion.';
$_lang['resource_deletedby'] =  'Deleted By';
$_lang['resource_deletedon_help'] =  'The ID of the user who most recently marked the resource for deletion.';
$_lang['resource_type'] =  'Resource Type';
$_lang['resource_type_help'] =  'The type of the resource (e.g., document, weblink, symlink, or static resource';
$_lang['resource_contentType'] =  'Content Type';
$_lang['resource_contentType_help'] =  "The resource's Content type (e.g., text/html).";
$_lang['resource_id'] =  'Resource ID';
$_lang['resource_id_help'] =  'The resource ID of the resource.';
$_lang['resource_content_help'] =  'The main content field of the resource.';
$_lang['resource_introtext'] =  'Summary (introtext)';
$_lang['resource_introtext_help'] =  "A brief summary of the resource's content.";
$_lang['resource_donthit'] =  "Don't Hit";
$_lang['resource_donthit_help'] =  'Deprecated.';
$_lang['resource_haskeywords'] =  'Has Key Words';
$_lang['resource_haskeywords_help'] =  'Deprecated.';
$_lang['resource_hasmetatags'] =  'Has Meta Tags';
$_lang['resource_hasmetatags_help'] =  'Deprecated.';
$_lang['resource_privateweb'] =  'Private Web';
$_lang['resource_privateweb_help'] =  'Deprecated.';
$_lang['resource_privatemgr'] =  'Private Manager';
$_lang['resource_privatemgr_help'] =  'Deprecated.';






















