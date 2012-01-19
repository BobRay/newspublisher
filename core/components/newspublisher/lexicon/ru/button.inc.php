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
 * Button Lexicon Topic
 *
 * @package newspublisher
 * @subpackage lexicon
 */


/* NewsPublisher EditThisButton strings */
$_lang['np_edit'] = 'Редактировать';
$_lang['np_no_edit_document_permission'] = 'Нету разрешений на edit_document';
$_lang['np_no_context_save_document_permission'] = 'Нету контекстных разрешений save_document';
$_lang['np_no_resource_save_document_permission'] = 'Нету разрешений на save_document';
$_lang['np_no_edit_home_page'] = 'Нельзя редактировать домашнюю страницу';
$_lang['np_no_np_id'] = 'Невозможно установить по умолчанию np_id параметр. Укажите вручную ID страницы Newspublisher.';
$_lang['np_id_desc'] = 'ID страницы редактирования ресурсов (устанавливается автоматически при первом запуске).';
$_lang['np_edit_id_desc'] = 'ID страницы для создания/редактирования ресурсов (снизу и справа свойства игнорируются - кнопка отображается как встроенная). Можете использовать этот тег кнопки редактирования в Вашем getResources Tpl чанке, чтобы получить множество кнопок на странице: [[!NpEditThisButton? &edit_id=`[[+id]]`]].';
$_lang['np_noShow_desc'] = 'Список ID документов, разделенный запятыми, на которых кнопка не должна появляться. По умолчанию это домашняя страница и страница NewsPublisher.';
$_lang['np_bottom_desc'] = '(опционное) - расстояние снизу от окна к самой кнопке. Может быть любым корректным CSS свойством. По умолчанию `20%`.';
$_lang['np_right_desc'] = '(опционное) - расстояние справа от окна к месту кнопки. Может быть любым корректным CSS свойством. По умолчанию `20%`.';
$_lang['np_language_desc'] = '(опционное) - Язык отображений ошибок.';
$_lang['np_debug_desc'] = '(опционное) - Отображает кнопку на всех страницах либо с $buttonCaption, либо с сообщением объясняющим почему она не будет показана.';
