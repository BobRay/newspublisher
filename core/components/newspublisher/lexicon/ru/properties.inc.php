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
 * Properties (property descriptions) Lexicon Topic
 *
 * @package newspublisher
 * @subpackage lexicon
 */

/* NewsPublisher Property Description strings */
$_lang['np_aliastitle_desc'] = "(опционное) Установите Yes для нижнего регистра, тире и заглавия страници в качестве альяса(alias). По умолчанию: Yes - если установлено No, тогда будет использовано 'article-(date created)'. Игнорируется если будет использовано поле 'alias'.";
$_lang['np_badwords_desc'] = '(опционное) Список зрещенных слов разделенный запятыми.';
$_lang['np_cacheable_desc'] = "(опционное) Установка флага кеширования ресурса; по умолчанию: cache_default Системные Установки для новых ресурсов; установите `Parent` для использования установок родителя.";
$_lang['np_cancelid_desc'] = '(опционное) ID документа для перехода на страницу при нажатии на cancel; по умолчанию: http_referer.';
$_lang['np_clearcache_desc'] = '(опционное) Когда установлено Yes, кеш будет очищен после сохранения ресурса; по умолчанию: Yes.';
$_lang['np_cssfile_desc'] = '(опционное) Имя CSS файла если есть, или `` если нету CSS файла; по умолчанию: newspublisher.css. Файл должен быть в папке assets/newspublisher/css/';
$_lang['np_errortpl_desc'] = '(опционное) Имя Tpl чанка для форматирования полей ошибок. Должен содержать [[+np.error]] плейсхолдер.';
$_lang['np_fielderrortpl_desc'] = '(опционное) Имя Tpl чанка для форматирования полей ошибок. Должен содержать [[+np.error]] плейсхолдер.';
$_lang['np_footertpl_desc'] = '(опционное) Чанк Footer Tpl (имя чанка) который будет добавлен в конец нового документа.';
$_lang['np_groups_desc'] = "(опционное) Группа ресурсов в которую будет помещен новый документ (не влияет на существующие документы); установите `parent` для использования группы родителя.";
$_lang['np_headertpl_desc'] = '(опционное) Чанк Header Tpl (имя чанка) который будет добавлен в начало нового документа.';
$_lang['np_hidemenu_desc'] = "(опционное) Установка флага для ресурса, доступности для меню; по умолчанию: hidemenu_default Системные Установки для новых ресурсов; установите `Parent` для использования установок родителя.";
$_lang['np_initrte_desc'] = '(опционное) Инициализировать редактор форматированого текста; установить если есть поле rich text; по умолчанию: No';
$_lang['np_initdatepicker_desc'] = "(опционное) Инициализация 'date picker'; установите если есть есть поля с датой; по умолчанию: Yes";
$_lang['np_language_desc'] = '(опционное) Язык для сообщений об ошибках в формах.';
$_lang['np_listboxmax_desc'] = '(опционное) Максимальная длинна для listboxes. По умолчанию 8 елементов.';
$_lang['np_multiplelistboxmax_desc'] = '(опционное) Максимальная длинна для multi-select listboxes. По умолчанию 20 елементов.';
$_lang['np_parentid_desc'] = '(опционное) ID папки где будут размещены новые документы; по умолчанию: папка NewsPublisher.';
$_lang['np_postid_desc'] = '(опционное) ID документа который будет загружен после создания/сохранения; по умолчанию: страница созданная/отредактированная.';
$_lang['np_prefix_desc'] = "(опционное) Префикс для плейсхолдеров; по умолчанию: 'np.'";
$_lang['np_published_desc'] = "(опционное) Установить новый ресурс как опубликованный или нет (будет переопределн - publish и unpublish датами). Установить наследование от `parent`, опубликован или нет; по умолчанию: publish_default Системные Установки.";
$_lang['np_required_desc'] = '(опционное) Список обязательных полей/TVs разделенный запятыми.';
$_lang['np_richtext_desc'] = "(опционное) Установка флага для Rich Text Editor если редактировать сраницу в Manager; по умолчанию: richtext_default системные установки для новых ресурсов; установите `Parent` для использования установок родителя.";
$_lang['np_rtcontent_desc'] = '(опционное) Использовать форматировный текст для рекдактирования поля content.';
$_lang['np_rtsummary_desc'] = '(опционное) Использовать форматированый текст для рекдактирования поля summary (introtext).';
$_lang['np_searchable_desc'] = "(опционное) Установка флага 'searchable' для новой документа; по умолчанию: search_default Систменые Установки для новых ресурсов; установите `Parent` для использования установок родителя.";
$_lang['np_show_desc'] = '(опционное) Список полей/TVs которые будут показаны, разделенный запятыми.';
$_lang['np_readonly_desc'] = '(опционное) Список полей/TVs только для чтения, разделенный запятыми; не применяется для полей option или textarea.';
$_lang['np_template_desc'] = "(опционное) Имя шаблона используемого для нового документа; установите `parent` чтобы использовать шаблон от parent; для `parent`, &parentid должен быть установлен; по умолчанию: default_template Системные Установки.";
$_lang['np_tinyheight_desc'] = '(опционное) Высота области richtext; по умолчанию `400px`.';
$_lang['np_tinywidth_desc'] = '(опционное) Ширина области richtext; по умолчанию `95%`.';
$_lang['np_summaryrows_desc'] = '(опционное) Число строк для поля summary.';
$_lang['np_summarycols_desc'] = '(опционное) Число столбцов для поля summary.';
$_lang['np_outertpl_desc'] = '(опционное) Tpl используемый для всей страницы создания/редактирования.';
$_lang['np_texttpl_desc'] = '(опционное) Tpl используемый для поля text.';
$_lang['np_inttpl_desc'] = '(опционное) Tpl используемый для числового поля.';
$_lang['np_datetpl_desc'] = '(опционное) Tpl используемый для поля date и date TVs';
$_lang['np_booltpl_desc'] = '(опционное) Tpl используемый для поля Yes/No (пр., published, searchable, и т.д.).';
$_lang['np_optionoutertpl_desc'] = '(опционное) Tpl используемый для поля checkbox, list и radio option TVs.';
$_lang['np_optiontpl_desc'] = '(опционное) Tpl используемый для каждой опции полей checkbox и radio option TVs.';
$_lang['np_listoptiontpl_desc'] = '(опционное) Tpl используемый для каждой опции полей listbox TVs.';
$_lang['np_aliasprefix_desc'] = '(опционное) Префикс который будет исполь зоваться в альясах для новый документов с пусттым альясом; альяс префикс будет - timestamp';
$_lang['np_intmaxlength_desc'] = '(опционное) Максимальная длинна числового поля; по умолчанию: 10.';
$_lang['np_textmaxlength_desc'] = '(опционное) Максимальная длинна текстового поля; по умлочанию: 60.';
$_lang['np_hoverhelp_desc'] = '(опционное) Показывать подсказки когда наводишь мышкой на поле; по умолчанию: Yes.';
$_lang['np_hasimagetv_desc'] = '(обязательно если есть поле image TVs) Инициализировать image browser; по умолчанию: No.';
$_lang['np_imagetvheight_desc'] = '(опционное) Высота области image TV; по умолчанию: 300px.';
$_lang['np_imagetvwidth_desc'] = '(опционное) Ширина области image TV; по умолчанию: 500px.';
