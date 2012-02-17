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
 * Default Lexicon Topic (German translation by mschlegel)
 *
 * @package newspublisher
 * @subpackage lexicon
 */

/* newspublisher strings */
$_lang['np_not_in_group'] = 'Sie gehören zu keiner der autorisierten Benutzergruppen.';
$_lang['np_not_logged_in'] = 'Sie müssen angemeldet sein, um einen Beitrag erstellen zu können.';
$_lang['np_no_permissions'] = 'Sie besitzen nicht die nötigen Zugriffsrechte.';
$_lang['np_no_error_tpl'] = 'Konnte &amp;errortpl nicht finden: ';
$_lang['np_main_header'] = 'Ressource erstellen/bearbeiten';
$_lang['np_error_presubmit'] = 'Entschuldigung . . .  Es gab (mindestens) ein Problem beim Erstellen des Formulars:';
$_lang['np_error_submit'] = 'Entschuldigung . . .  Es gab (mindestens) ein Problem beim Erstellen der Ressource:';
$_lang['np_error_required'] = 'Das Feld [[+name]] muss ausgefüllt werden.';
$_lang['np_missing_field'] = 'Nicht ausgefüllt: [[+name]].';
$_lang['np_no_resource_group'] = 'Konnte Ressourcen-Gruppe nicht finden: ';
$_lang['np_no_resource'] = 'Ressource nicht gefunden: ';
$_lang['np_no_template_name'] = 'Template nicht gefunden: [[+name]].';
$_lang['np_no_tvs'] = 'Sie wollten TVs anzeigen, aber dieses Template hat keine.';
$_lang['np_no_tv'] = 'Sie wollten eine Template-Variable anzeigen, die nicht zu diesem Template gehört oder nicht existiert: ';
$_lang['np_unauthorized'] = 'Sie besitzen nicht die nötigen Rechte, um Beiträge zu publizieren.';
$_lang['np_parent_not_sent'] = 'Sie haben das als Template &amp; `parent` angegeben, aber den `parentid-Parameter nicht angegeben.';
$_lang['np_parent_not_found'] = 'Sie habe für eine Eigenschaft `parent` angegeben, aber die Elternressource wurde nicht gefunden: .';
$_lang['np_resource_save_failed'] = 'Beim Speichern der Ressource ist ein Fehler aufgetreten.';
$_lang['np_to_template_id'] = 'Es gibt kein Template mit dieser ID: ';
$_lang['np_to_template_name'] = 'Es gibt kein Template mit diesem Namen: ';
$_lang['np_date_hint'] = '(T.M.J)';
$_lang['np_time_hint'] = '(Zeit - irgendein Format)';
$_lang['np_date_format'] = 'd-dt-m-dt-Y';
$_lang['np_invalid_date'] = 'Datum ungültig!';
$_lang['np_view_permission_denied'] = 'Sie besitzen nicht die nötigen Zugriffsrechte, um Dokumente anzuzeigen';
$_lang['np_view_this_permission_denied'] = 'Sie besitzen nicht die nötigen Zugriffsrechte, um dieses Dokument anzuzeigen';
$_lang['np_create_permission_denied'] = 'Sie besitzen nicht die nötigen Zugriffsrechte, um ein Dokument zu erstellen';
$_lang['np_save_permission_denied'] = 'Sie besitzen nicht die nötigen Zugriffsrechte, um Dokumente zu speichern';
$_lang['np_save_this_permission_denied'] = 'Sie besitzen nicht die nötigen Zugriffsrechte, um dieses Dokument zu speichern';
$_lang['np_no_edit_self'] = 'Sie können die Newspublisher-Seite nicht bearbeiten.';
$_lang['np_no_parent'] = 'Für die Eigenschaft wurde `parent` angegeben, aber die Ressource hat keine definier Elternressource: ';
$_lang['np_post_save_no_resource'] = 'Konnte Ressource nach dem Speichern nicht aufrufen';
$_lang['np_illegal_value'] = 'Ungültiger Wert für: &amp;';
$_lang['np_unknown_field'] = 'Unbekanntes Feld in _setDefault(): ';
$_lang['np_no_system_setting'] = 'Für das Feld wurde `System Default` angegeben, aber die Systemeinstellung ist nicht gesetzt: ';
$_lang['np_no_tpl'] = 'Konnte Template-Chunk nicht finden: ';
$_lang['np_not_our_tv'] = 'Sie wollten eine Template Variable anzeigen, die nicht mit diesem Template assoziiert ist.   ';
$_lang['np_no_permission'] = ' (Sie haben möglicherweise keine Zugriffsrechte für das angegebene Dokument oder die angegebene Gruppe)';
$_lang['np_no_evals'] = 'Kann im Frontend keine TVs mit @EVAL-Bindings bearbeiten: ';
$_lang['np_no_evals_input'] = 'Kann im Frontend keine @EVAL-Bindings benutzen.';
$_lang['np_no_modx_tags'] = 'Sie haben nicht die nötigen Rechte, um Ressourcen mit MODx-Tags zu bearbeiten.';
$_lang['np_no_rte'] = 'Der Parameter &amp;initrte wurde nicht gesetzt, obwohl Sie dieses Richtext-Feld anzeigen möchten: ';
$_lang['np_no_datepicker'] = 'Der Parameter &amp;initdatepicker wurde nicht gesetzt, obwohl Sie dieses Datums-Feld anzeigen möchten: ';
$_lang['np_launch_image_browser'] = 'Bild auswählen';
$_lang['np_launch_file_browser'] = 'Datei auswählen';
$_lang['np_no_action_found'] = "Konnte die Aktion 'filebrowser' nicht finden. Möglicherweise wurde sie gelöscht. Bitte installieren Sie NewsPublisher neu.";
$_lang['np_media_source_access_denied'] = 'Sie besitzen nicht die nötigen Zugriffsrechte, um die mit folgender Template-Variable verknüpfte Medienquelle anzuzeigen:';
$_lang['np_source_error'] = 'Mit dieser Template-Variable ist keine Medienquelle verknüpft: ';
$_lang['np_source_wctx_error'] = 'Konnte den Kontext der Medienquelle für diese Template-Variable nicht ermitteln: ';

/* missing resource field lexicon strings */
$_lang['resource_pub_date'] =  'Veröffentlichen am';
$_lang['resource_pub_date_help'] =  ' (optional) Das Datum, an welchem die Ressource automatisch veröffentlicht wird. Klicken Sie auf das Kalendersymbol, um das Datum auszuwählen.';
$_lang['resource_unpub_date'] =  'Zurückziehen am';
$_lang['resource_unpub_date_help'] =  ' (optional) Das Datum, an welchem die Ressource automatisch zurückgezogen wird. Klicken Sie auf das Kalendersymbol, um das Datum auszuwählen.';
$_lang['resource_hidemenu'] =  'Nicht in Menüs anzeigen';
$_lang['resource_hidemenu_help'] =  'Wenn diese Einstellung aktiviert ist, wird die Ressource *nicht* in Menüs Ihrer Webseite erscheinen. Bitte beachten Sie, dass einige Menü-Skripte diese Option ignorieren könnten.';
$_lang['resource_isfolder'] =  'Container';
$_lang['resource_isfolder_help'] =  'Wenn diese Einstellung aktiviert ist, fungiert die Ressource als Container für andere Ressourcen. Ein "Container" ist wie ein Ordner, nur dass er selbst auch einen Inhalt haben kann.';
$_lang['resource_content_dispo'] =  'Content-Disposition';
$_lang['resource_content_dispo_help'] =  'Verwenden Sie dieses Feld, um festzulegen, wie eine Ressource im Browser verarbeitet wird. Für Datei-Downloads verwenden Sie die Option "Attachment".';
$_lang['resource_class_key'] =  'Schlüssel der Klasse';
$_lang['resource_context_key'] =  'Kontext';
$_lang['resource_context_key_help'] =  'Der Kontext, zu dem die Ressource gehört.';
$_lang['resource_publishedby_help'] =  'ID des Benutzers, der die Ressource veröffentlicht hat.';
$_lang['resource_createdby_help'] =  'ID des Benutzers, der die Ressource ursprünglich erstellt hat.';
$_lang['resource_createdon_help'] =  'Das Datum, an welchem die Ressource ursprünglich erstellt wurde.';
$_lang['resource_editedby_help'] =  'ID des Benutzers, der die Ressource als letzter bearbeitet hat.';
$_lang['resource_editedon_help'] =  'Das Datum, an welchem die Ressource zuletzt bearbeitet wurde.';
$_lang['resource_deleted'] =  'Gelöscht';
$_lang['resource_deleted_help'] =  'Wenn diese Einstellung aktiviert ist, wird die Ressource als gelöscht markiert. Damit ist sie noch nicht unwiederbringlich gelöscht.';
$_lang['resource_deletedon'] =  'Gelöscht am';
$_lang['resource_deletedon_help'] =  'Das Datum, an dem die Ressource zuletzt als gelöscht markiert wurde.';
$_lang['resource_deletedby'] =  'Gelöscht durch';
$_lang['resource_deletedon_help'] =  'ID des Benutzers, der die Ressource als letzter als gelöscht markiert hat.';
$_lang['resource_type'] =  'Ressourcen-Typ';
$_lang['resource_type_help'] =  'Typ der Ressource (z.B. Dokument, Weblink, Symlink oder statische Ressource';
$_lang['resource_contentType'] =  'Inhaltstyp';
$_lang['resource_contentType_help'] =  'Der Inhaltstyp dieser Ressource (z.B., text/html).';
$_lang['resource_id'] =  'Ressourcen-ID';
$_lang['resource_id_help'] =  'ID der Ressource.';
$_lang['resource_content_help'] =  'Hauptinhalt der Ressource.';
$_lang['resource_introtext'] =  'Zusammenfassung (Intro-Text)';
$_lang['resource_introtext_help'] =  'Kurze Zusammenfassung der Ressource.';
$_lang['resource_donthit'] =  "Don't Hit";
$_lang['resource_donthit_help'] =  'Veraltet.';
$_lang['resource_haskeywords'] =  'Hat Schlüsselwörter';
$_lang['resource_haskeywords_help'] =  'Veraltet.';
$_lang['resource_hasmetatags'] =  'Hat Meta-Tags';
$_lang['resource_hasmetatags_help'] =  'Veraltet.';
$_lang['resource_privateweb'] =  'Private Web';
$_lang['resource_privateweb_help'] =  'Veraltet.';
$_lang['resource_privatemgr'] =  'Private Manager';
$_lang['resource_privatemgr_help'] =  'Veraltet.';
