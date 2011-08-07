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
 * Properties (German property descriptions) Lexicon Topic
 * (German translation by mschlegal)
 *
 * @package newspublisher
 * @subpackage lexicon
 */

/* NewsPublisher Property Description strings */
$_lang['np_aliastitle_desc'] = "(optional) Auf Ja setzen, um den Seitentitel in Kleinbuchstaben mit Bindestrichen als Alias zu benutzen. Standardeinstellung: Ja - Wenn Nein angegeben, wird 'article-Erstellungsdatum' benutzt.  Ignoriert, wenn im Formular ein Alias angegeben wurde.";
$_lang['np_badwords_desc'] = '(optional) Komma-separierte Liste von Wörtern, die im Dokument nicht erlaubt sind.';
$_lang['np_cacheable_desc'] = "(optional) Soll die Ressource in den Cache übernommen werden oder nicht? Standardeinstellung: Wert der Systemeinstellung 'cache_default' (für neue Ressourcen); Geben Sie `Parent` an, um die Einstellung der Elternressource zu verwenden.";
$_lang['np_cancelid_desc'] = '(optional) Dokument-ID, die geladen werden soll, wenn abgebrochen wurde. Standardeinstellung: http_referer.';
$_lang['np_clearcache_desc'] = '(optional) Wenn auf Ja gesetzt, wird der Cache nach dem Speichern der Ressource gelöscht. Standardeinstellung: Ja.';
$_lang['np_cssfile_desc'] = '(optional) Name der zu benutzenden CSS-Datei oder ``, um gar keine CSS-Datei zu benutzen; Standardeinstellung: newspublisher.css. Die Datei sollte im Ordner assets/newspublisher/css/ sein';
$_lang['np_errortpl_desc'] = '(optional) Name des Template-Chunks zur Anzeige von Fehlermeldungen für die einzelnen Felder. Muss den Platzhalter [[+np.error]] enthalten.';
$_lang['np_fielderrortpl_desc'] = '(optional) Name des Template-Chunks zur Darstellung von Fehlermeldungen für die einzelnen Felder. Muss den Platzhalter [[+np.error]] enthalten.';
$_lang['np_footertpl_desc'] = '(optional) Template-Chunk (Name) zur Darstellung eines Fußbereiches am Ende jedes neuen Dokumentes.';
$_lang['np_groups_desc'] = "(optional) Ressourcen-Gruppe, zu welcher das neue Dokument gehören soll (hat keinen Effekt auf die existierenden Dokumente); Auf `parent` setzen, um die Gruppe der Elternressource zu verwenden.";
$_lang['np_headertpl_desc'] = '(optional)  Template-Chunk (Name) zur Darstellung eines Kopfbereiches am Anfang jedes neuen Dokumentes.';
$_lang['np_hidemenu_desc'] = "(optional) Wenn auf 'Ja' gesetzt, wird die neue Seite nicht in Seiten-Menüs angezeigt; Standardeinstellung: hidemenu_default System-Einstellung für neue Ressourcen; Geben Sie `Parent` an, um die Einstellung der Elternressource zu verwenden.";
$_lang['np_initrte_desc'] = '(optional) Rich-Text-Editor initialisieren. Setzen, wenn Rich-Text-Eingabefelder vorhanden sind. Standardeinstellung: Nein';
$_lang['np_initdatepicker_desc'] = '(optional) Kalender initialisieren. Setzen, wenn Eingabefelder für ein Datum vorhanden sind. Standardeinstellung: Ja';
$_lang['np_language_desc'] = '(optional) Sprache für Formulare und Fehlermeldungen.';
$_lang['np_listboxmax_desc'] = '(optional) Maximale Länge von Auswahllisten. Standard: 8 Einträge.';
$_lang['np_multiplelistboxmax_desc'] = '(optional) Maximale Länge von Auswahllisten mit Mehrfachauswahl. Standard: 20 Einträge.';
$_lang['np_parentid_desc'] = '(optional) ID der Container-Ressource, in der neue Dokumente gespeichert werden sollen. Standardeinstellung: Newspublisher-Ressource.';
$_lang['np_postid_desc'] = '(optional) Ressourcen-ID, die nach erfolgreichem Speichern geladen werden soll. Standardeinstellung: die gerade erstellte/bearbeitete Seite.';
$_lang['np_prefix_desc'] = "(optional) Präfix für Platzhalter; Standardeinstellung: 'np.'";
$_lang['np_published_desc'] = "(optional) Einstellung, die darüber entscheidet, ob die Ressource publiziert ist oder nicht (wird durch Setzen von Publikations-/Rückzugsdatum ausser Kraft gesetzt). Auf `parent` setzen, um den Publikations-Status der Elternressource zu übernehmen. Standardeinstellung: publish_default Systemeinstellung.";
$_lang['np_required_desc'] = '(optional) Komma-separierte Liste von Feldern/TVs, welche zwingend eine Eingabe benötigen.';
$_lang['np_richtext_desc'] = "(optional) Wenn aktiviert wird beim Bearbeiten des Seiteninhalts im MODx-Manager ein Rich-Text-Editor benutzt. Standardeinstellung: richtext_default Systemeinstellung für neue Ressourcen. Geben Sie `Parent` an, um die Einstellung der Elternressource zu verwenden.";
$_lang['np_rtcontent_desc'] = '(optional) Hauptinhalt als Rich-Text eingeben.';
$_lang['np_rtsummary_desc'] = '(optional) Zusammenfassung (introtext) als Rich-Text eingeben.';
$_lang['np_searchable_desc'] = "(optional) Wenn aktiviert, werden neu erstellte Dokumente in die Seitensuche eingeschlossen. Standardeinstellung: search_default Systemeinstellung für neue Ressourcen. Geben Sie `Parent` an, um die Einstellung der Elternressource zu verwenden.";
$_lang['np_show_desc'] = '(optional) Komma-separierte Liste von Feldern/TVs, die angezeigt werden sollen.';
$_lang['np_readonly_desc'] = '(optional) Komma-separierte Liste von Feldern, die nur gelesen werden können (nicht bearbeitet); funktioniert nicht mit <textarea>-Feldern.';
$_lang['np_template_desc'] = "(optional) Name des Templates, das für neue Dokumente verwendet wird. Geben Sie `Parent` an, um das Template der Elternressource zu verwenden. Für `Parent` muss &parentid gesetzt werden. Standardeinstellung: default_template Systemeinstellung.";
$_lang['np_tinyheight_desc'] = '(optional) Höhe der Rich-Text-Eingabefelder; Standard ist `400px`.';
$_lang['np_tinywidth_desc'] = '(optional) Breite der Rich-Text-Eingabefelder; Standard ist `95%`.';
$_lang['np_summaryrows_desc'] = '(optional) Anzahl Zeilen des Eingabefeldes für die Zusammenfassung (introtext).';
$_lang['np_summarycols_desc'] = '(optional) Anzahl Spalten des Eingabefeldes für die Zusammenfassung (introtext).';
$_lang['np_outertpl_desc'] = '(optional) Template-Chunk für das Grundgerüst der Seite.';
$_lang['np_texttpl_desc'] = '(optional) Template-Chunk für Text-Ressourcenfelder.';
$_lang['np_inttpl_desc'] = '(optional) Template-Chunk für Eingabefelder für ganze Zahlen.';
$_lang['np_datetpl_desc'] = '(optional) Template-Chunk für Datums-Eingabefelder';
$_lang['np_booltpl_desc'] = '(optional) Template-Chunk für Ja/Nein-Eingabefelder (z.B. veröffentlicht, durchsuchbar, usw.).';
 $_lang['np_optionoutertpl_desc'] = '(optional) Template-Chunk für das Grundgerüst von Checkbox-, Listen- und Optionsschaltflächen-TVs.';
$_lang['np_optiontpl_desc'] = '(optional) Template-Chunk für jede einzelne Checkbox-, Listen- und Optionsschaltflächen-TV.';
$_lang['np_listoptiontpl_desc'] = '(optional) Template-Chunk für jede einzelne Options-/Auswahlfeld-(Listbox-)TV.';
$_lang['np_aliasprefix_desc'] = "(optional) Präfix, das vor dem Alias von neuen Dokumenten eingefügt wird. Für Dokumente mit einem leeren Alias wird der Alias die Form 'Alias-Präfix - Zeitstempel' haben";
$_lang['np_intmaxlength_desc'] = '(optional) Maximale Länge für Ganzzahl-Eingabefelder; Standardeinstellung: 10.';
$_lang['np_textmaxlength_desc'] = '(optional) Maximale Länge für Text-Eingabefelder; Standardeinstellung: 60.';
$_lang['np_hoverhelp_desc'] = '(optional) Hilfe anzeigen, wenn die Maus über die Feld-Überschrift fährt. Standardeinstellung: Ja.';
