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

/** Translation by Alberto Ramacciotti (obert2k11) <ramacciotti.alberto@gmail.com> */

/* NewsPublisher Property Description strings */
$_lang['np_aliastitle_desc'] = "(opzionale) Impostala a Si per utilizzare il minuscolo, unire con il trattino, titolo di pagina come alias. valore predefinito: Si - Se impostato su No, verrà utilizzato 'articolo-(data creata)'.  Verrà ignorato se alias è riempito nel modulo.";
$_lang['np_badwords_desc'] = '(opzionale) Lista di parole separata da una virgola non consentita nel documento.';
$_lang['np_cacheable_desc'] = "(opzionale) Imposta la flag a seconda del fatto che la risorsa sia memorizzata nella; valore predefinito: cache_default delle Impostazioni di Sistema per le nuove Risorse; impostalo a `Parent` per utilizzare le impostazioni dei genitori.";
$_lang['np_cancelid_desc'] = '(opzionale) ID del documento da caricare su Annulla; valore predefinito: http_referer.';
$_lang['np_captions_desc'] = '(opzionale) Didascalie personalizzate -- Lista separata da una virgola di FieldNames:FieldCaptions.
   Esempio: &captions=`introtext:Riassunto,content:Inserire il vostro articolo`';
$_lang['np_clearcache_desc'] = '(opzionale) Quando impostato su Si, NewsPublisher pulirà la cache del sito dopo aver salvato la risorsa; valore predefinito: Si.';
$_lang['np_cssfile_desc'] = '(opzionale) Nome del file CSS da utilizzare, o `` per nessun file CSS; valore predefinito: newspublisher.css. Il file deve essere nella cartella assets/newspublisher/css/';
$_lang['np_errortpl_desc'] = '(opzionale) Nome del chunk Tpl per la formattazione dei campi degli errori. Deve contenere il segnaposto [[+np.error]].';
$_lang['np_fielderrortpl_desc'] = '(opzionale) Nome del chunk Tpl per la formattazione dei campi degli errori. Deve contenere il segnaposto [[+np.error]].';
$_lang['np_footertpl_desc'] = '(opzionale) Chunk Tpl del Piè di pagina (nome del chunk) da essere inserito alla fine di un nuovo documento.';
$_lang['np_groups_desc'] = "(opzionale) Gruppi delle Risorse dove inserire il nuovo documento (non ha effetto sui documenti esistenti); impostalo a `parent` per utilizzare i gruppi dei genitori.";
$_lang['np_headertpl_desc'] = '(opzionale) Chunk Tpl della Testata (nome del chunk) da essere inserito all\'inizio di un nuovo documento.';
$_lang['np_hidemenu_desc'] = "(opzionale) Imposta il flag a seconda del fatto che la nuova pagina sia mostrata nel menu; valore predefinito: hidemenu_default delle Impostazioni di Sistema per le nuove Risorse; impostalo a `Parent per utilizzare l\'impostazione del genitore";
$_lang['np_initrte_desc'] = '(opzionale) Inizializza l\'editor rich text; impostalo se ci sono qualsiasi campo del rich text; valore predefinito: No';
$_lang['np_initdatepicker_desc'] = '(opzionale) Inizializza la Selezione Data; impostalo se ci sono qualsiasi campo della data; valore predefinito: Si';
$_lang['np_language_desc'] = '(opzionale) Lingua da utilizzare nei moduli e nei messaggi di errore.';
$_lang['np_listboxmax_desc'] = '(opzionale) Lunghezza massima per le listboxes. Il valore predefinito è di 8 voci.';
$_lang['np_multiplelistboxmax_desc'] = '(opzionale) Lunghezza massima per le listboxes a selezione multiple. Il valore predefinito è di 20 voci.';
$_lang['np_parentid_desc'] = '(opzionale) ID della cartella dove sono immagazzinati i nuovi documenti; valore predefinito: cartella di NewsPublisher.';
$_lang['np_postid_desc'] = '(opzionale) ID del documento da caricare in caso di successo; valore predefinito: la pagina creata o modificata.';
$_lang['np_prefix_desc'] = "(opzionale) Prefisso da utilizzare per i segnaposti; valore predefinito: 'np.'";
$_lang['np_published_desc'] = "(opzionale) Imposta le nuove risorse come pubblicate o no (sarà sovrascritto dalla data di Pubblicazione e Non pubblicazione). Impostalo a `parent` per combinare lo stato di pubblicazione del genitore; valore predefinito: publish_default delle Impostazioni di Sistema.";
$_lang['np_required_desc'] = '(opzionale) Lista separata da una virgola dei campi/TV da richiedere.';
$_lang['np_richtext_desc'] = "(opzionale) Imposta il flag a seconda del fatto che l\'Editor Rich Text sia utilizzato quando si sta modificando il contenuto della pagina nel Gestore; valore predefinito: richtext_default delle Impostazioni di Sistema per le nuove risorse; impostalo a `Parent` per utilizzare l'\impostazione del genitore.";
$_lang['np_rtcontent_desc'] = '(opzionale) Utilizzare il rich text per il campo Contenuto del modulo; valore predefinito: No.';
$_lang['np_rtsummary_desc'] = '(opzionale) Utilizzare il rich text per il campo Riassunto (introtext) del modulo; valore predefinito: No.';
$_lang['np_searchable_desc'] = "(opzionale) Imposta il flag a seconda del fatto che la nuova pagina sia inclusa nelle ricerche del sito; valore predefinito: search_default delle Impostazioni di Sistema per le nuove Risorse; impostalo a `Parent` per utilizzare le impostazioni del genitore.";
$_lang['np_show_desc'] = '(opzionale) Lista separata da una virgola dei campi/TV da mostrare.';
$_lang['np_readonly_desc'] = '(opzionale) Lista separata da una virgola dei campi che devono essere soltanto in modalità lettura; non funziona con opzioni o campi di textarea.';
$_lang['np_template_desc'] = "(opzionale) Nome del template da utilizzare per il nuovo documento; impostalo a `parent` per utilizzare il template genitore; per `parent`, &parentid deve essere impostato; valore predefinito: il default_template delle Impostazioni di Sistema.";
$_lang['np_tinyheight_desc'] = '(opzionale) Altezza delle aree del richtext; Il valore predefinito è di `400px`.';
$_lang['np_tinywidth_desc'] = '(opzionale) Larghezza delle aree del richtext; Il valore predefinito è di `95%`.';
$_lang['np_summaryrows_desc'] = '(opzionale) Numero di righe per il campo Riassunto.';
$_lang['np_summarycols_desc'] = '(opzionale) Numero di colonne per il campo Riassunto.';
$_lang['np_outertpl_desc'] = '(opzionale) Tpl utilizzato come una shell per le intere pagine.';
$_lang['np_texttpl_desc'] = '(opzionale) Tpl utilizzato per i campi di testo della risorsa.';
$_lang['np_inttpl_desc'] = '(opzionale) Tpl utilizzato per i campi degli interi della risorsa.';
$_lang['np_datetpl_desc'] = '(opzionale) Tpl utilizzato per i campi della data delle risorse e la data delle TV';
$_lang['np_booltpl_desc'] = '(opzionale) Tpl utilizzato per i campi Si/No della risorsa (es., pubblicato, ricercabile, ecc.).';
$_lang['np_optionoutertpl_desc'] = '(opzionale) Tpl utilizzato come una shell per le checkbox, liste, e le opzioni radio delle TV.';
$_lang['np_optiontpl_desc'] = '(opzionale) Tpl utilizzato per ogni opzione delle checkbox e le opzioni radio delle TV.';
$_lang['np_listoptiontpl_desc'] = '(opzionale) Tpl utilizzato per ogni opzione delle listbox delle TV.';
$_lang['np_aliasprefix_desc'] = '(opzionale) Prefisso da essere anteposto agli alias dei nuovi documenti con alias vuoti; l\'alias sarà aliasprefix - timestamp; valore predefinito (vuoto)';
$_lang['np_intmaxlength_desc'] = '(opzionale) Lunghezza massima per i campi interi degli input; valore predefinito: 10.';
$_lang['np_textmaxlength_desc'] = '(opzionale) Lunghezza massima per i campi testo degli input; valore predefinito: 60.';
$_lang['np_hoverhelp_desc'] = '(opzionale) Mostra l\'aiuto quando si punta il mouse sopra il campo della didascalia; valore predefinito: Si.';
$_lang['np_usetabs_desc'] = '(opzionale) Mostra la visualizzazione a schede; valore predefinito: No';
$_lang['np_tabs_desc'] = '(obbligatorio soltanto se usetabs è impostato) Specifiche per le schede (vedere la guida)';
$_lang['np_activetab_desc'] = '(opzionale) Scheda da mostrare quando il modulo è caricato';
$_lang['np_classkey_desc'] = '(opzionale) Chiave della Classe per le nuove risorse; utilizzalo soltanto se hai risorse in sotto-classi o se si stanno utilizzando per gli Articoli (impostalo a Articolo); valore predefinito: modDocument';
$_lang['np_contentrows_desc'] = '(opzionale)Righe da mostrare nel campo Contenuto; valore predefinito: 10';
$_lang['np_contentcols_desc'] = '(opzionale)Colonne da mostrare nel campo Contenuto; valore predefinito: 60';
$_lang['np_aliasdateformat_desc'] = '(opzionale)Stringa di formato per la data automatica degli alias (vedere la guida)';