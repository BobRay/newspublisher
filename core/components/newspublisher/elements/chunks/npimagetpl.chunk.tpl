    <div id="np-[[+npx.fieldName]]-container" class="np-image">
        [[+np.error_[[+npx.fieldName]]]]
        <label class="fieldlabel" for="np-[[+npx.fieldName]]" title="[[+npx.help]]">[[+npx.caption]]: </label>
        <input name="[[+npx.fieldName]]" class="image" id="np-[[+npx.fieldName]]" onchange="[[+npx.fieldName]]_preview(this.value)" type="text"  value="[[+np.[[+npx.fieldName]]]]" />
        <button type="button" onclick="var popup=window.open('[[+npx.browserUrl]]', 'Select image...', 'width=' + Math.min(screen.availWidth,1000) + ',height=' + Math.min(screen.availHeight*0.9,700) + 'status=no,location=no,toolbar=no,menubar=no');popup.focus();browserPathInput=getElementById('np-[[+npx.fieldName]]');">[[%np_launch_image_browser]]</button>
        <div id="[[+npx.fieldName]]_preview_container"></div>
        
        <script type="text/javascript">
            function [[+npx.fieldName]]_preview(rel_image_url) {
                var img = document.getElementById('[[+npx.fieldName]]_thumb');
                if (rel_image_url != '') {
                    if (!img) {
                      img = document.createElement('img');
                      img.id='[[+npx.fieldName]]_thumb';
                      document.getElementById('[[+npx.fieldName]]_preview_container').appendChild(img);
                    }
                    // generate the thumbail
                    img.src='[[+npx.phpthumbBaseUrl]]&src=' + rel_image_url + '&w=120&h=120';
                } else if (img) {
                    document.getElementById('[[+npx.fieldName]]_preview_container').removeChild(img);
                }
            }
            
            // ensure image is shown on page loading
            [[+npx.fieldName]]_preview(document.getElementById('np-[[+npx.fieldName]]').value);
              
          </script>
    </div>
