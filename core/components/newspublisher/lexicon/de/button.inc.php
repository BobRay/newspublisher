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
 * Button German Lexicon Topic (German translation by mschlegal)
 *
 * @package newspublisher
 * @subpackage lexicon
 */


/* NewsPublisher EditThisButton strings */
$_lang['np_edit'] = 'Bearbeiten';
$_lang['np_no_edit_document_permission'] = 'Keine Rechte, Dokumente zu bearbeiten';
$_lang['np_no_edit_this_document_permission'] = 'Keine Rechte, dieses Dokument zu bearbeiten';
$_lang['np_no_context_save_document_permission'] = 'Keine Rechte, Dokumente in diesem Kontext zu speichern';
$_lang['np_no_resource_save_document_permission'] = 'Keine Rechte, dieses Dokument zu speichern';
$_lang['np_no_edit_home_page'] = 'Kann Startseite nicht bearbeiten';
$_lang['np_no_np_id'] = 'Konnte np_id nicht setzen. Setzen Sie die ID der Newspublisher-Seite manuell.';
$_lang['np_id_desc'] = 'ID der Newspublisher-Seite (automatisch im ersten Durchgang gesetzt).';
$_lang['np_edit_id_desc'] = 'ID der zu bearbeitenden Seite (`bottom` und `right` werden ignoriert -- der Knopf wird immer an der Position angezeigt, an welcher er platziert wurde). Dies ermöglicht es, mehrere bearbeiten-Knöpfe pro Seite anzuzeigen, z.B. indem Sie einen Knopf im Template-Chunk von getResources platzieren: [[!NpEditThisButton? &edit_id=`[[+id]]`]].';
$_lang['np_noShow_desc'] = 'Komma-separierte liste von IDs von Dokumenten, bei welchen der Knopf nicht angezeigt werden soll. Standard-IDs: Startseite und Newspublisher-Seite.';
$_lang['np_bottom_desc'] = '(optional) - Abstand des Knopfes vom unteren Rand des Fensters. Jedes in CSS zulässige Maß kann angegeben werden. Standardwert: `20%`.';
$_lang['np_right_desc'] = '(optional) - Abstand des Knopfes vom rechten Rand des Fensters. Jedes in CSS zulässige Maß kann angegeben werden. Standardwert: `20%`.';
$_lang['np_language_desc'] = '(optional) - Für Fehlermeldungen zu verwendende Sprache.';
$_lang['np_debug_desc'] = '(optional) - Wenn auf `1` gesetzt, wird immer ein bearbeiten-Knopf angezeigt, entweder mit der normalen Beschriftung oder mit einer Meldung, die erklärt, warum der Knopf normalerweise nicht angezeigt wird.';
