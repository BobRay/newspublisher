<div class="newspublisher">
        <h2 id="newspublisherHeader">[[%np_main_header]]</h2>
        [[!+np.error_header:ifnotempty=`<h3>[[!+np.error_header]]</h3>`]]
        [[!+np.errors_presubmit:ifnotempty=`[[!+np.errors_presubmit]]`]]
        [[!+np.errors_submit:ifnotempty=`[[!+np.errors_submit]]`]]
        [[!+np.errors:ifnotempty=`[[!+np.errors]]`]]
  <form id="newspublisherForm" action="[[~[[*id]]]]" method="post">
            <input name="hidSubmit" type="hidden" id="hidSubmit" value="true" />
        [[+npx.insert]]
         <span class = "buttons">
             <input class="submit" id="np_submit_button" type="submit" name="Submit" value="Submit" />
             [[+np_duplicate_button]]
             [[+np_delete_button]]
             <input type="button" id="np_cancel_button" class="cancel" name="Cancel" value="Cancel" onclick="window.location = '[[+np.cancel_url]]' " />
         </span>
        [[+np.post_stuff]]
  </form>
</div>