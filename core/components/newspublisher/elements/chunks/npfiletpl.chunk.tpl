    <div id="np-[[+npx.fieldName]]-container" class="np-file">
        [[+np.error_[[+npx.fieldName]]]]
        <label class="fieldlabel" for="np-[[+npx.fieldName]]" title="[[+npx.help]]">[[+npx.caption]]: </label>
        <input name="[[+npx.fieldName]]" class="file" id="np-[[+npx.fieldName]]" type="text"  value="[[+np.[[+npx.fieldName]]]]" />
        <button type="button" onclick="var popup=window.open('[[+npx.browserUrl]]', 'Select file...', 'width=' + Math.min(screen.availWidth,1000) + ',height=' + Math.min(screen.availHeight*0.9,700) + 'status=no,location=no,toolbar=no,menubar=no');popup.focus();browserPathInput=getElementById('np-[[+npx.fieldName]]');">[[%np_launch_file_browser]]</button>
    </div>
