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

/** Translation by Alberto Ramacciotti (obert2k11) <ramacciotti.alberto@gmail.com> */

/* NewsPublisher EditThisButton strings */
$_lang['np_edit'] = 'Modifica';
$_lang['np_no_edit_document_permission'] = 'Nessun permesso di edit_document';
$_lang['np_no_context_save_document_permission'] = 'Nessun permesso di contesto save_document';
$_lang['np_no_resource_save_document_permission'] = 'Nessun permesso di salvare la Risorsa in questo documento';
$_lang['np_no_edit_home_page'] = 'Non è possibile modificare la home page';
$_lang['np_no_np_id'] = 'impossibile impostare la proprietà predefinita np_id. Impostare manualmente l\'ID della pagina Newspublisher.';
$_lang['np_id_desc'] = 'ID della pagina di Newspublisher (impostata automaticamente alla prima esecuzione).';
$_lang['np_edit_id_desc'] = 'ID della pagina da modificare (le proprietà in basso e a destra vengono ignorate -- il pulsante è mostrato in linea). È possibile utilizzare questo in un pulsante di modifica del tag nel vostro chunk del Tpl getResources per avere bottoni multipli in una pagina: [[!NpEditThisButton? &edit_id=`[[+id]]`]].';
$_lang['np_noShow_desc'] = 'Virgola - lista di ID separati di documenti in cui non deve essere visualizzato il pulsante. Valori predefiniti impostati alla home page, e alla pagina NewsPublisher.';
$_lang['np_bottom_desc'] = '(opzionale) - distanza dal basso della finestra per posizionare il pulsante. Può essere in qualsiasi formato CSS legale. Valore predefinito impostato a `20%`.';
$_lang['np_right_desc'] = '(opzionale) - distanza dalla destra della finestra per per posizionare il pulsante. Può essere in qualsiasi formato CSS legale. Valore predefinito impostato a `20%`.';
$_lang['np_language_desc'] = '(opzionale) - Lingua da utilizzare per i messaggi di errore.';
$_lang['np_debug_desc'] = '(opzionale) - Mostra il pulsante su tutte le pagine sia con il $buttonCaption, o con un messaggio che spieghi il motivo per cui non è stata mostrato.';