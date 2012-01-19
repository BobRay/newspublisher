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
$_lang['np_not_in_group'] = 'Вы не в одной из авторизированых групп пользователей.';
$_lang['np_not_logged_in'] = 'Вы должны авторизоваться, чтобы публиковать сообщения.';
$_lang['np_no_permissions'] = 'У вас нет необходимых разрешений.';
$_lang['np_no_error_tpl'] = 'Нету &amp;errortpl: ';
$_lang['np_main_header'] = 'Создать/Редактировать документ';
$_lang['np_error_presubmit'] = 'Извините . . . В форме были допущены ошибки:';
$_lang['np_error_submit'] = 'Извините . . . Были допущены ошибки:';
$_lang['np_error_required'] = 'Поле [[+name]] обязательно.';
$_lang['np_missing_field'] = 'Отсутствует поле: [[+name]].';
$_lang['np_no_resource_group'] = 'Не удалось найти группу ресурсов: ';
$_lang['np_no_resource'] = 'Не удалось найти ресурс: ';
$_lang['np_no_template_name'] = 'Не удалось получить шаблон: [[+name]].';
$_lang['np_no_tvs'] = 'Вы хотите отобразить TVs, но в этом шаблоне их нет.';
$_lang['np_no_tv'] = "Вы хотите отобразить TV, но в этом шаблоне его нет: ";
$_lang['np_unauthorized'] = 'Вам не разрешено публиковать.';
$_lang['np_parent_not_sent'] = 'Вы утсановили &amp;template к родительскому, но не указали параметр parentid.';
$_lang['np_parent_not_found'] = 'Вы указали параметр `parent` но parent объект не найден: .';
$_lang['np_resource_save_failed'] = 'Возникла ошибка при сохранении документа.';
$_lang['np_to_template_id'] = 'Нету шаблона с таким номером: ';
$_lang['np_to_template_name'] = 'Нету шаблона с таким именем: ';
$_lang['np_date_hint'] = '(Г-М-Д)';
$_lang['np_time_hint'] = '(Время - любой формат)';
$_lang['np_date_format'] = 'Y-ds-m-ds-d';
$_lang['np_view_permission_denied'] = 'У Вас нету прав на просмотр этого документа.';
$_lang['np_create_permission_denied'] = 'У Вас нету прав на создание документов.';
$_lang['np_save_permission_denied'] = 'У Вас нету прав на сохранение документов';
$_lang['np_no_edit_self'] = 'Нельзя редактировать страницу NewsPublisher.';
$_lang['np_no_parent'] = 'Установлен параметр но у документа нету родителя: ';
$_lang['np_post_save_no_resource'] = 'Невозможно получить доступк ресурсу после сохранения.';
$_lang['np_illegal_value'] = 'Неправильное значение для &amp;';
$_lang['np_unknown_field'] = 'Неизвестное поле в _setDefault(): ';
$_lang['np_no_system_setting'] = 'Поле установлено как Системные установки по умолчанию, но Системные установки не установлены: ';
$_lang['np_no_tpl'] = 'Нельзя найти Tpl чанк: ';
$_lang['np_not_our_tv'] = 'Вы хотите отобразить поле TV который не прикреплен к этому шаблону.  ';
$_lang['np_no_permission'] = ' (возможно у Вас нету прав на доумент или группу)';
$_lang['np_no_evals'] = 'Нельзя редактировать TVs с @EVAL связанные с фронтэндом: ';
$_lang['np_no_evals_input'] = 'Нелльзя использовать @EVAL связанный с фронтэндом.';
$_lang['np_no_modx_tags'] = 'У Вас нету прав чтобы редактировать ресурс содержащий modx tags.';
$_lang['np_no_rte'] = 'Параметр &amp;initrte не установлен, а Вы запросили поле richtext: ';
$_lang['np_no_datepicker'] = 'Параметр &amp;initdatepicker не установлен, а Вы запросили поле с датой: ';

/* missing resource field lexicon strings */
$_lang['resource_pub_date'] =  'Publish Date';
$_lang['resource_pub_date_help'] =  ' (optional) set date to automatically publish resource. Click on the calendar icon to select a date.';
$_lang['resource_unpub_date'] =  'Unpublish Date';
$_lang['resource_unpub_date_help'] =  ' (optional) set date to automatically unpublish the resource. Click on the calendar icon to select a date.';
$_lang['resource_hidemenu'] =  'Hide from Menus';
$_lang['resource_hidemenu_help'] =  'When enabled the resource will *not* be available for use inside a web menu. Please note that some Menu Builders might choose to ignore this option.';
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
