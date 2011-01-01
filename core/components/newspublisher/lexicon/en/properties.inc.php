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
$_lang['np_aliastitle_desc'] = "(optional) Set to Yes to use lowercase, hyphenated, page title as alias. Defaults to Yes - If set to No, 'article-(date created)' is used.  Ignored if alias is filled in form.";
$_lang['np_badwords_desc'] = '(optional) Comma delimited list of words not allowed in document.';
$_lang['np_cacheable_desc'] = "(optional) Sets the flag to as to whether or not the resource is cached; defaults to cache_default System Setting for new resources; set to `Parent` to use parent's setting.";
$_lang['np_cancelid_desc'] = '(optional) Document id to load on cancel; defaults to http_referer.';
$_lang['np_cancelbutton_desc'] = '(optional) Set to Yes to include a cancel button for the form that will return the user to the previous page; defaults to No.';
$_lang['np_clearcache_desc'] = '(optional) When set to Yes, the cache will be cleared after saving the resource; default: Yes.';
$_lang['np_cssfile_desc'] = '(optional) Name of CSS file to use, or `` for no CSS file; defaults to newspublisher.css. File should be in assets/newspublisher/css/ directory';
$_lang['np_errortpl_desc'] = '(optional) Name of Tpl chunk for formatting field errors. Must contain [[+np.error]] placeholder.';
$_lang['np_fielderrortpl_desc'] = '(optional) Name of Tpl chunk for formatting field errors. Must contain [[+np.error]] placeholder.';
$_lang['np_footertpl_desc'] = '(optional) Footer Tpl chunk (chunk name) to be inserted at the end of a new document.';
$_lang['np_groups_desc'] = "(optional) Resource groups to put new document in (no effect with existing docs); set to `parent` to use parent's groups.";
$_lang['np_headertpl_desc'] = '(optional) Header Tpl chunk (chunk name) to be inserted at the beginning of a new document.';
$_lang['np_hidemenu_desc'] = "(optional) Sets the flag to as to whether or not the new page shows in the menu; defaults to hidemenu_default System Setting for new resources; set to `Parent to use parent's setting";
$_lang['np_initrte_desc'] = '(optional) Initialize rich text editor; set this if there are any rich text fields; defaults to No';
$_lang['np_language_desc'] = '(optional) Language to use in forms and error messages.';
$_lang['np_listboxmax_desc'] = '(optional) Maximum length for listboxes. Default is 8 items.';
$_lang['np_multiplelistboxmax_desc'] = '(optional) Maximum length for multi-select listboxes. Default is 20 items.';
$_lang['np_parentid_desc'] = '(optional) Folder id where new documents are stored; defaults to NewsPublisher folder.';
$_lang['np_postid_desc'] = '(optional) Document id to load on success; defaults to the page created or edited.';
$_lang['np_prefix_desc'] = "(optional) Prefix to use for placeholders; defaults to 'np.'";
$_lang['np_published_desc'] = "(optional) Set new resource as published or not (will be overridden by publish and unpublish dates). Set to `parent` to match parent's pub status; defaults to publish_default system setting.";
$_lang['np_required_desc'] = '(optional) Comma separated list of fields/tvs to require.';
$_lang['np_richtext_desc'] = "(optional) Sets the flag to as to whether or Rich Text Editor is used to when editing the page content in the Manager; defaults to richtext_default System Setting for new resources; set to `Parent` to use parent's setting.";
$_lang['np_rtcontent_desc'] = '(optional) Use rich text for the content form field.';
$_lang['np_rtsummary_desc'] = '(optional) Use rich text for the summary (introtext) form field.';
$_lang['np_searchable_desc'] = "(optional) Sets the flag to as to whether or not the new page is included in site searches; defaults to search_default System Setting for new resources; set to `Parent` to us parent's setting.";
$_lang['np_show_desc'] = '(optional) Comma separated list of fields/tvs to show.';
$_lang['np_template_desc'] = "(optional) Name of template to use for new document; set to `parent` to use parent's template; for `parent`, &folder must be set; defaults to the default_template System Setting.";
$_lang['np_contentrows_desc'] = '(optional) Number of rows for the content field.';
$_lang['np_contentcols_desc'] = '(optional) Number of columns for the content field.';
$_lang['np_summaryrows_desc'] = '(optional) Number of rows for the summary field.';
$_lang['np_summarycols_desc'] = '(optional) Number of columns for the summary field.';
$_lang['np_outertpl_desc'] = '(optional) Tpl used as a shell for the whole page.';
$_lang['np_texttpl_desc'] = '(optional) Tpl used for text resource fields.';
$_lang['np_inttpl_desc'] = '(optional) Tpl used for integer resource fields.';
$_lang['np_datetpl_desc'] = '(optional) Tpl used for date resource fields and date TVs';
$_lang['np_booltpl_desc'] = '(optional) Tpl used for Yes/No resource fields (e.g., published, searchable, etc.).';
 $_lang['np_optionoutertpl_desc'] = '(optional) Tpl used for as a shell for checkbox, list, and radio option TVs.';
$_lang['np_optiontpl_desc'] = '(optional) Tpl used for each option of checkbox and radio option TVs.';
$_lang['np_listoptiontpl_desc'] = '(optional) Tpl used for each option of listbox TVs.';








