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
$_lang['np_aliastitle_desc'] = "(optional) Set to Yes to use lowercase, hyphenated, page title as alias. If set to No, 'article-(date created)' is used. Ignored if alias is filled in form; default: Yes.";
$_lang['np_badwords_desc'] = '(optional) Comma delimited list of words not allowed in document; default: (empty).';
$_lang['np_cacheable_desc'] = "(optional) Sets the flag that determines whether or not the resource is cached; for new resources, set to `Parent` to use parent's setting; default: cache_default System Setting.";
$_lang['np_cancelid_desc'] = '(optional) Document ID to load on cancel; default: http_referer.';
$_lang['np_captions_desc'] = '(optional) Custom captions -- Comma-separated list of FieldNames:FieldCaptions. Example: &captions=`introtext:Summary,content:Enter Your Post`; default: (empty).';
$_lang['np_clearcache_desc'] = '(optional) When set to Yes, NewsPublisher will clear the site cache after saving the resource; default: Yes.';
$_lang['np_cssfile_desc'] = '(optional) Name of CSS file to use, or `` for no CSS file; File should be in assets/newspublisher/css/ directory; default: newspublisher.css. ';
$_lang['np_errortpl_desc'] = '(optional) Name of Tpl chunk for formatting field errors. Must contain [[+np.error]] placeholder; default: npErrorTpl.';
$_lang['np_fielderrortpl_desc'] = '(optional) Name of Tpl chunk for formatting field errors. Must contain [[+np.error]] placeholder; default: npFieldErrorTpl';
$_lang['np_groups_desc'] = "(optional) Comma-separated list of resource groups to put new document in (no effect with existing docs); set to `parent` to use parent's groups; default: (empty).";
$_lang['np_hidemenu_desc'] = "(optional) Sets the flag that determines whether or not the new page shows in the menu; for new resources, set to `Parent to use parent's setting; default: hidemenu_default System Setting";
$_lang['np_initrte_desc'] = '(optional) Initialize rich text editor; set this if there are any rich text fields; default: No';
$_lang['np_initdatepicker_desc'] = '(optional) Initialize date picker; set this if there are any date fields; default: Yes';
$_lang['np_language_desc'] = '(optional) Language to use in forms and error messages; default: (empty).';
$_lang['np_listboxmax_desc'] = '(optional) Maximum length for listboxes. Default: 8.';
$_lang['np_multiplelistboxmax_desc'] = '(optional) Maximum length for multi-select listboxes. Default: 20.';
$_lang['np_parentid_desc'] = '(optional) Folder ID where new documents are stored; default: NewsPublisher folder.';
$_lang['np_postid_desc'] = '(optional) Document ID to load on success; default: the page created or edited.';
$_lang['np_prefix_desc'] = "(optional) Prefix to use for placeholders; default: 'np.'";
$_lang['np_published_desc'] = "(optional) Set new resource as published or not (will be overridden by publish and unpublish dates). Set to `parent` to match parent's pub status; default: publish_default system setting.";
$_lang['np_required_desc'] = '(optional) Comma separated list of fields/tvs to require; default: (empty).';
$_lang['np_richtext_desc'] = "(optional) Sets the flag that determines whether or Rich Text Editor is used to when editing the page content in the Manager; for new resources, set to `Parent` to use parent's setting; default: richtext_default System Setting.";
$_lang['np_rtcontent_desc'] = '(optional) Use rich text for the content form field; default: No.';
$_lang['np_rtsummary_desc'] = '(optional) Use rich text for the summary (introtext) form field; default: No.';
$_lang['np_searchable_desc'] = "(optional) Sets the flag that determines whether or not the new page is included in site searches; for new resources, set to `Parent` to us parent's setting; default: search_default System Setting.";
$_lang['np_show_desc'] = '(optional) Comma separated list of fields/tvs to show: default: (empty).';
$_lang['np_readonly_desc'] = '(optional) Comma-separated list of fields that should be read only; does not work with option or textarea fields; default: (empty).';
$_lang['np_template_desc'] = "(optional) Name of template to use for new document; for new resources, set to `parent` to use parent's template; for `parent`, &parentid must be set; default: the default_template System Setting.";
$_lang['np_tinyheight_desc'] = '(optional) Height of richtext areas; default: 400px.';
$_lang['np_tinywidth_desc'] = '(optional) Width of richtext areas; default: 95%.';
$_lang['np_summaryrows_desc'] = '(optional) Number of rows for the summary field; default: 10.';
$_lang['np_summarycols_desc'] = '(optional) Number of columns for the summary field; default: 60.';
$_lang['np_outertpl_desc'] = '(optional) Tpl used as a shell for the whole page; default: npOuterTpl.';
$_lang['np_texttpl_desc'] = '(optional) Tpl used for text resource fields; default: npTextTpl.';
$_lang['np_inttpl_desc'] = '(optional) Tpl used for integer resource fields; default: npIntTpl.';
$_lang['np_datetpl_desc'] = '(optional) Tpl used for date resource fields and date TVs; default: npDateTpl';
$_lang['np_booltpl_desc'] = '(optional) Tpl used for Yes/No resource fields (e.g., published, searchable, etc.); default: npBoolTpl.';
 $_lang['np_optionoutertpl_desc'] = '(optional) Tpl used for as a shell for checkbox, list, and radio option TVs; default: npOptionOuterTpl.';
$_lang['np_optiontpl_desc'] = '(optional) Tpl used for each option of checkbox and radio option TVs; default: npOptionTpl.';
$_lang['np_listoptiontpl_desc'] = '(optional) Tpl used for each option of listbox TVs; default: npListOptionTpl.';
$_lang['np_aliasprefix_desc'] = '(optional) Prefix to be prepended to alias for new documents with an empty alias; alias will be aliasprefix - timestamp; default: (empty)';
$_lang['np_intmaxlength_desc'] = '(optional) Max length for integer input fields; default: 10.';
$_lang['np_textmaxlength_desc'] = '(optional) Max length for text input fields; default: 60.';
$_lang['np_hoverhelp_desc'] = '(optional) Show help when hovering over field caption; default: Yes.';
$_lang['np_usetabs_desc'] = '(optional) Show tabbed display; default: No';
$_lang['np_tabs_desc'] = '(required only if usetabs is set) Specification for tabs (see tutorial); default: (empty)';
$_lang['np_activetab_desc'] = '(optional) Tab to show when form is loaded; default: (empty)';
$_lang['np_classkey_desc'] = '(optional) Class key for new resources; use only if you have subclassed resource or are using this for Articles (set to Article); default: modDocument';
$_lang['np_contentrows_desc'] = '(optional) Rows to show in Content field; default: 10';
$_lang['np_contentcols_desc'] = '(optional) Columns to show in Content field; default: 60';
$_lang['np_aliasdateformat_desc'] = '(optional) Format string for auto date alias -- see tutorial; default: PHP date + time format';
$_lang['np_allowedtags_desc'] = '(optional) Tags allowed in text fields; default: see tutorial';
$_lang['np_stopOnBadTv_desc'] = '(optional) If set to No, &show can contain TVs not attached to the current template without an error; default: Yes';
$_lang['np_templates_desc'] = '(optional) Comma-separated list of template IDs for user to select from (must be IDs); if empty, all templates are shown; to force a template, set &template and do not show the template field; default: (empty)';
$_lang['np_parents_desc'] = 'Comma-separated list of parent IDs for user to select from (must be IDs); if empty, all parents are shown; to force a parent, set &parent and do not show the parent field; default: (empty)';
$_lang['np_which_editor_desc'] = 'Rich-text editor to use; at present, TinyMCE is the only value that will work; default: TinyMCE';
