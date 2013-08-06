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

/** Translation by Alberto Ramacciotti (obert2k11) <ramacciotti.alberto@gmail.com> */

/* newspublisher strings */
$_lang['np_not_in_group'] = 'Non sei in nessuno dei gruppi utenti autorizzati.';
$_lang['np_not_logged_in'] = 'Devi essere autenticato per pubblicare.';
$_lang['np_no_permissions'] = 'Non hai i permessi necessari.';
$_lang['np_no_error_tpl'] = 'Impossibile trovare &amp;errortpl: ';
$_lang['np_main_header'] = 'Crea/Modifica Risorsa';
$_lang['np_error_presubmit'] = 'Spiacenti . . . Si è verificato uno o più problemi nella generazione del modulo:';
$_lang['np_error_submit'] = 'Spiacenti . . . Si è verificato uno o più problemi con il vostro invio:';
$_lang['np_error_required'] = 'Il campo [[+name]] è obbligatorio.';
$_lang['np_missing_field'] = 'Campo mancante: [[+name]].';
$_lang['np_no_resource_group'] = 'Impossibile trovare resource group: ';
$_lang['np_no_resource'] = 'Impossibile ottenere la risorsa: ';
$_lang['np_no_template_name'] = 'Impossibile ottenere il template: [[+name]].';
$_lang['np_no_tvs'] = 'Volevi visualizzare le TV, ma questo template non ne ha.';
$_lang['np_no_tv'] = "Volevi visualizzare una TV, ma questo template non ne ha: ";
$_lang['np_unauthorized'] = 'Non ti è permesso di pubblicare articoli.';
$_lang['np_parent_not_sent'] = 'Hai impostato il &amp;template a `parent` ma non includeva il parametro parentid.';
$_lang['np_parent_not_found'] = 'Hai impostato una proprietà a `parent` ma l\'oggetto genitore non è stato trovato: .';
$_lang['np_resource_save_failed'] = 'Si è verificato un errore durante il salvataggio della risorsa.';
$_lang['np_to_template_id'] = 'Non c\'è il template con questo numero: ';
$_lang['np_to_template_name'] = 'Non c\'è il modello con questo nome: ';
$_lang['np_date_hint'] = '(D-M-Y)';
$_lang['np_time_hint'] = '(Tempo - qualsiasi formato)';
$_lang['np_date_format'] = 'd-ds-m-ds-Y';
$_lang['np_invalid_date'] = 'Data non valida!';
$_lang['np_view_permission_denied'] = 'Non hai il permesso di visualizzare alcun documento';
$_lang['np_view_this_permission_denied'] = 'Non hai il permesso di visualizzare questo documento';
$_lang['np_create_permission_denied'] = 'Non hai il permesso di creare un documento';
$_lang['np_save_permission_denied'] = 'Non hai il permesso di salvare alcun documento';
$_lang['np_save_this_permission_denied'] = 'Non hai il permesso di salvare questo documento';
$_lang['np_no_edit_self'] = 'Non puoi modificare la pagina newspublisher.';
$_lang['np_no_parent'] = 'La proprietà è impostata su parent ma il documento non ha genitore: ';
$_lang['np_post_save_no_resource'] = 'Impossibile ottenere la risorsa dopo averla salvata';
$_lang['np_illegal_value'] = 'Valore non valido per &amp;';
$_lang['np_unknown_field'] = 'Campo sconosciuto nel _setDefault(): ';
$_lang['np_no_system_setting'] = 'Il campo è impostato su System Default ma System Setting non è impostato: ';
$_lang['np_no_tpl'] = 'Impossibile trovare Tpl chunk: ';
$_lang['np_not_our_tv'] = 'Vuoi visualizzare una TV che non è allegata a questo template.   ';
$_lang['np_no_permission'] = ' (non si può avere l\'autorizzazione per il documento o il gruppo a cui si riferisce)';
$_lang['np_no_evals'] = 'Non è possibile modificare le TV con i binding @EVAL nel front end: ';
$_lang['np_no_evals_input'] = 'Non è possibile utilizzare i binding @EVAL nel front end.';
$_lang['np_no_modx_tags'] = 'Non hai il permesso di modificare le risorse che contengono tag di modx.';
$_lang['np_no_rte'] = 'Il parametro &amp;initrte non è impostato, ma tu hai richiesto questo campo richtext: ';
$_lang['np_no_datepicker'] = 'Il parametro &amp;initdatepicker non è impostato, ma tu hai richiesto questo campo data: ';
$_lang['np_launch_image_browser'] = 'Selezionare un\'immagine';
$_lang['np_launch_file_browser'] = 'Selezionare un file';
$_lang['np_no_action_found'] = "Impossibile trovare l\'azione 'filebrowser'. Potreste averla cancellato accidentalmente. Si prega di reinstallare NewsPublisher.";
$_lang['np_media_source_access_denied'] = "Non hai il permesso di accesso alle media source associate con la TV: ";
$_lang['np_source_error'] = 'Nessuna media source è associata con questa TV: ';
$_lang['np_source_wctx_error'] = 'Il contesto di lavoro della media source non può essere recuperata per la TV: ';


/* missing resource field lexicon strings */
$_lang['resource_pub_date'] =  'Data della pubblicazione';
$_lang['resource_pub_date_help'] =  '(opzionale) set date to automatically publish resource. Click on the calendar icon to select a date.';
$_lang['resource_unpub_date'] =  'Data di annullazione della pubblicazione';
$_lang['resource_unpub_date_help'] =  '(opzionale) set date to automatically unpublish the resource. Click on the calendar icon to select a date.';
$_lang['resource_hidemenu'] =  'Nascondi dai Menu';
$_lang['resource_hidemenu_help'] =  'When enabled the resource will *not* be available for use inside a web menu. Please note that some Menu Builders might choose to ignore this option.';
$_lang['resource_isfolder'] =  'Contenitore';
$_lang['resource_isfolder_help'] =  'Spuntare questo per assegnare la Risorsa come Contenitore di altre Risorse. Un `Contenitore` è come una cartella, ma può anche avere del contenuto proprio.';
$_lang['resource_content_dispo'] =  'Disposizione contenuti';
$_lang['resource_content_dispo_help'] =  'Utilizzare il campo disposizione contenuti per specificare come questa risorsa viene gestita dal browser web. Per il download di file selezionare l\'opzione Allegato.';
$_lang['resource_class_key'] =  'Chiave della Classe';
$_lang['resource_context_key'] =  'Chiave del Contesto';
$_lang['resource_context_key_help'] =  'Il contesto della risorsa a cui è allegato.';
$_lang['resource_publishedby_help'] =  'L\'ID dell\'utente che ha pubblicato la risorsa.';
$_lang['resource_createdby_help'] =  'L\'ID dell\'utente che ha originariamente creato la risorsa.';
$_lang['resource_createdon_help'] =  'La data della risorsa creata originariamente.';
$_lang['resource_editedby_help'] =  'L\'ID dell\'utente che ha modificato la risorsa più recentemente.';
$_lang['resource_editedon_help'] =  'La data della risorsa modificata più recentemente.';
$_lang['resource_deleted'] =  'Cancellato';
$_lang['resource_deleted_help'] =  'Marca la risorsa per l\'eliminazione, ma non è stata cancellata.';
$_lang['resource_deletedon'] =  'Cancellato il';
$_lang['resource_deletedon_help'] =  'La data della risorsa è stata più recentemente contrassegnata per l\'eliminazione.';
$_lang['resource_deletedby'] =  'Cancellato Da';
$_lang['resource_deletedon_help'] =  'L\' ID dell\'utente che ha marcato più recentemente la risorsa per l\'eliminazione.';
$_lang['resource_type'] =  'Tipo della Risorsa';
$_lang['resource_type_help'] =  'Il tipo della risorsa (es., documento, weblink, symlink, o risorsa statica';
$_lang['resource_contentType'] =  'Tipo di Contenuto';
$_lang['resource_contentType_help'] =  "Il tipo di Contenuto della risorsa (es., text/html).";
$_lang['resource_id'] =  'ID della Risorsa';
$_lang['resource_id_help'] =  'L\'ID della risorsa della risorsa.';
$_lang['resource_content_help'] =  'Il campo del contenuto principale della risorsa.';
$_lang['resource_introtext'] =  'Riassunto (testo introduttivo)';
$_lang['resource_introtext_help'] =  "Un breve riassunto del contenuto della risorsa.";
$_lang['resource_donthit'] =  "Non premere";
$_lang['resource_donthit_help'] =  'Deprecato.';
$_lang['resource_haskeywords'] =  'Ha Parole Chiavi';
$_lang['resource_haskeywords_help'] =  'Deprecato.';
$_lang['resource_hasmetatags'] =  'Ha Meta Tag';
$_lang['resource_hasmetatags_help'] =  'Deprecato.';
$_lang['resource_privateweb'] =  'Rete privata';
$_lang['resource_privateweb_help'] =  'Deprecato.';
$_lang['resource_privatemgr'] =  'Gestore privato';
$_lang['resource_privatemgr_help'] =  'Deprecato.';

/* messages for NP tabs */
$_lang['np_could_not_find_tab_field'] = 'Impossibile trovare il campo tab: ';
$_lang['np_invalid_tabs'] = 'La proprietà npTabs non è valida o è vuota';
$_lang['np_tabs_other'] = 'Altro';
$_lang['np_tabs_show_all'] = "Mostra tutto";