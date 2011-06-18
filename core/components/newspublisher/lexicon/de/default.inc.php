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
 * Default Lexicon Topic (German translation by mschlegal)
 *
 * @package newspublisher
 * @subpackage lexicon
 */

/* newspublisher strings */
$_lang['np_not_in_group'] = 'Sie gehÃ¶ren zu keiner der autorisierten Benutzergruppen.';
$_lang['np_not_logged_in'] = 'Sie mÃ¼ssen angemeldet sein, um einen Beitrag erstellen zu kÃ¶nnen.';
$_lang['np_no_permissions'] = 'Sie besitzen nicht die nÃ¶tigen Zugriffsrechte.';
$_lang['np_main_header'] = 'Ressource erstellen/bearbeiten';
$_lang['np_error_presubmit'] = 'Entschuldigung . . .  Es gab (mindestens) ein Problem beim Erstellen des Formulars:';
$_lang['np_error_submit'] = 'Entschuldigung . . .  Es gab (mindestens) ein Problem beim Erstellen der Ressource:';
$_lang['np_error_required'] = 'Das Feld [[+name]] muss ausgefÃ¼llt werden.';
$_lang['np_missing_field'] = 'Nicht ausgefÃ¼llt: [[+name]].';
$_lang['np_no_resource_group'] = 'Konnte Ressourcen-Gruppe nicht finden: ';
$_lang['np_no_resource'] = 'Ressource nicht gefunden: ';
$_lang['np_no_template_name'] = 'Template nicht gefunden: [[+name]].';
$_lang['np_unauthorized'] = 'Sie besitzen nicht die nÃ¶tigen Rechte, um BeitrÃ¤ge zu publizieren.';
$_lang['np_resource_save_failed'] = 'Beim speichern der Ressource ist ein Fehler aufgetreten.';
$_lang['np_date_hint'] = '(J-M-T)';
$_lang['np_time_hint'] = '(Zeit - irgendein Format)';
$_lang['np_date_format'] = 'd-dt-m-dt-Y';
$_lang['np_view_permission_denied'] = 'Sie besitzen nicht die nÃ¶tigen Zugriffsrechte, um dieses Dokument anzuzeigen';
$_lang['np_create_permission_denied'] = 'Sie besitzen nicht die nÃ¶tigen Zugriffsrechte, um ein Dokument zu erstellen';
$_lang['np_save_permission_denied'] = 'Sie besitzen nicht die nÃ¶tigen Zugriffsrechte, um dieses Dokument anzuzeigen';
$_lang['np_no_edit_self'] = 'Sie kÃ¶nnen die Newspublisher-Seite nicht bearbeiten.';
$_lang['np_post_save_no_resource'] = 'Konnte Ressource nach dem Speichern nicht aufrufen';
$_lang['np_illegal_value'] = 'UngÃ¼ltiger Wert fÃ¼r: &amp;';
$_lang['np_no_permission'] = ' (Sie haben mÃ¶glicherweise keine Zugriffsrechte fÃ¼r das angegebene Dokument oder die angegebene Gruppe)';
$_lang['np_no_modx_tags'] = 'Sie haben nicht die nÃ¶tigen Rechte, um Ressourcen mit MODx-Tags zu bearbeiten.';

/* missing resource field lexicon strings */
$_lang['resource_pub_date'] =  'VerÃ¶ffentlichen am';
$_lang['resource_pub_date_help'] =  ' (optional) Das Datum, an welchem die Ressource automatisch verÃ¶ffentlicht wird. Klicken Sie auf das Kalendersymbol, um das Datum auszuwÃ¤hlen.';
$_lang['resource_unpub_date'] =  'ZurÃ¼ckziehen am';
$_lang['resource_unpub_date_help'] =  ' (optional) Das Datum, an welchem die Ressource automatisch zurÃ¼ckgezogen wird. Klicken Sie auf das Kalendersymbol, um das Datum auszuwÃ¤hlen.';
$_lang['resource_hidemenu'] =  'Nicht in MenÃ¼s anzeigen';
$_lang['resource_hidemenu_help'] =  'Wenn diese Einstellung aktiviert ist, wird die Ressource *nicht* in MenÃ¼s Ihrer Webseite erscheinen. Bitte beachten Sie, dass einige MenÃ¼-Skripte diese Option ignorieren kÃ¶nnten.';
$_lang['resource_isfolder'] =  'Container';
$_lang['resource_isfolder_help'] =  'Wenn diese Einstellung aktiviert ist, fungiert die Ressource als Container fÃ¼r andere Ressourcen. Ein "Container" ist wie ein Ordner, nur dass er selbst auch einen Inhalt haben kann.';
$_lang['resource_content_dispo'] =  'Content-Disposition';
$_lang['resource_content_dispo_help'] =  'Verwenden Sie dieses Feld, um festzulegen, wie eine Ressource im Browser verarbeitet wird. FÃ¼r Datei-Downloads verwenden Sie die Option "Attachment".';
$_lang['resource_class_key'] =  'SchlÃ¼ssel der Klasse';
$_lang['resource_context_key'] =  'Kontext';
$_lang['resource_context_key_help'] =  'Der Kontext, zu dem die Ressource gehÃ¶rt.';
$_lang['resource_publishedby_help'] =  'ID des Benutzers, der die Ressource verÃ¶ffentlicht hat.';
$_lang['resource_createdby_help'] =  'ID des Benutzers, der die Ressource ursprÃ¼nglich erstellt hat.';
$_lang['resource_createdon_help'] =  'Das Datum, an welchem die Ressource ursprÃ¼nglich erstellt wurde.';
$_lang['resource_editedby_help'] =  'ID des Benutzers, der die Ressource als letzter bearbeitet hat.';
$_lang['resource_editedon_help'] =  'Das Datum, an welchem die Ressource zuletzt bearbeitet wurde.';
$_lang['resource_deleted'] =  'GelÃ¶scht';
$_lang['resource_deleted_help'] =  'Wenn diese Einstellung aktiviert ist, wird die Ressource als gelÃ¶scht markiert. Damit ist sie noch nicht unwiederbringlich gelÃ¶scht.';
$_lang['resource_deletedon'] =  'GelÃ¶scht am';
$_lang['resource_deletedon_help'] =  'Das Datum, an dem die Ressource zuletzt als gelÃ¶scht markiert wurde.';
$_lang['resource_deletedby'] =  'GelÃ¶scht durch';
$_lang['resource_deletedon_help'] =  'ID des Benutzers, der die Ressource als letzter als gelÃ¶scht markiert hat.';
$_lang['resource_type'] =  'Ressourcen-Typ';
$_lang['resource_type_help'] =  'Typ der Ressource (z.B. Dokument, Weblink, Symlink oder statische Ressource';
$_lang['resource_contentType'] =  'Inhaltstyp';
$_lang['resource_id'] =  'Ressourcen-ID';
$_lang['resource_id_help'] =  'ID der Ressource.';
$_lang['resource_content_help'] =  'Hauptinhalt der Ressource.';
$_lang['resource_introtext'] =  'Zusammenfassung (Intro-Text)';
$_lang['resource_introtext_help'] =  'Kurze Zusammenfassung der Ressource.';
