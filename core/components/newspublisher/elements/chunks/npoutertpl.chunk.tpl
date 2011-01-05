<div class="newspublisher">
        <h2>[[%np_main_header]]</h2>
        [[!+[[+prefix]].error_header:ifnotempty=`<h3>[[!+[[+prefix]].error_header]]</h3>`]]
        [[!+[[+prefix]].errors_presubmit:ifnotempty=`[[!+[[+prefix]].errors_presubmit]]`]]
        [[!+[[+prefix]].errors_submit:ifnotempty=`[[!+[[+prefix]].errors_submit]]`]]
        [[!+[[+prefix]].errors:ifnotempty=`[[!+[[+prefix]].errors]]`]]
  <form action="[[~[[*id]]]]" method="post">
            <input name="hidSubmit" type="hidden" id="hidSubmit" value="true" />
        [[+npx.insert]]
        <span class = "buttons">
            <input class="submit" type="submit" name="Submit" value="Submit" />
            <input type="button" class="cancel" name="Cancel" value="Cancel" onclick="window.location = '[[+[[+prefix]].cancel_url]]' " />
        </span>
        [[+[[+prefix]].post_stuff]]
  </form>
</div>