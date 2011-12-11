    <div id="np-[[+npx.fieldName]]-container" class="np-date">
        [[+np.error_[[+npx.fieldName]]]]
        <label class="fieldlabel" for="[[+npx.fieldName]]" title="[[+npx.help]]">[[+npx.caption]]:</label>
        <div class = "np-date-hints"><span class = "np-date-hint"> [[%np_date_hint]]</span><span class ="np-time-hint">[[%np_time_hint]]</span></div>
        <input type="text" id="[[+npx.fieldName]]" name="[[+npx.fieldName]]" maxlength="10" value="[[+np.[[+npx.fieldName]]]]" onblur="check_[[+npx.fieldName]]()" />
        <input type="text" class="[[+npx.fieldName]]_time" name="[[+npx.fieldName]]_time" id="[[+npx.fieldName]]_time" maxlength="10" value="[[+np.[[+npx.fieldName]]_time]]" />
        <div class="invalid_date" id="[[+npx.fieldName]]_date_error" style="visibility:hidden">[[%np_invalid_date]]</div>
      
        <script type="text/javascript">
          function check_[[+npx.fieldName]]() {
            if (datePickerController.getSelectedDate('[[+npx.fieldName]]')) {
              document.getElementById('[[+npx.fieldName]]').style.color='inherit';
              document.getElementById('[[+npx.fieldName]]_date_error').style.visibility='hidden';
            } else {
              var input = document.getElementById('[[+npx.fieldName]]');
              if (input.value != '') {
                input.style.color='red';
                document.getElementById('[[+npx.fieldName]]_date_error').style.visibility='visible';
              }
            }
          }
          datePickerController.createDatePicker({
            formElements:{"[[+npx.fieldName]]":"[[%np_date_format]]"},
            callbackFunctions:{"dateset":[ check_[[+npx.fieldName]] ]},
            noFadeEffect:true,
          [[+npx.disabledDates]]
          });
        </script>
    </div>
