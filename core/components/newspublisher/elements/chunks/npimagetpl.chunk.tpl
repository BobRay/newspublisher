    <div id="np-[[+npx.fieldName]]-container" class="np-image">
        [[+np.error_[[+npx.fieldName]]]]
        <label class="fieldlabel" for="np-[[+npx.fieldName]]" title="[[+npx.help]]">[[+npx.caption]]: </label>
        <input name="[[+npx.fieldName]]" class="image" id="np-[[+npx.fieldName]]"  type="textarea" rows="1"  value="[[+np.[[+npx.fieldName]]]]" height="30px"    />
        <button id="np-[[+npx.fieldName]]_button" type="button">[[%np_launch_image_browser]]</button>
        <div id="np-[[+npx.fieldName]]_preview"></div>
        <script>
        $('#np-[[+npx.fieldName]]_button').on('click', function() {
          $('<div id="editor" />').dialogelfinder({
             modal: true, 
             width: "80%", 
             title: "Double-click to select your file", 
             zIndex: 99999,
             // don't know why this is necessary, but without it this only works once
             commandsOptions: {},
             url : 'http://localhost/addons/npelfinderconnector.html',
             width: '80%',
             height: '600px',
             getFileCallback: function(file) {
               var fileUrl = file.url.replace('\\','/'); // (file is an object)
               var mybase = file.baseUrl.replace('\\','/');
               var finalUrl = fileUrl.replace(mybase, '');
              
               // This is for the preview window 
               var imgTag = '<img src="'+ file.tmb + '">';

               $('#np-[[+npx.fieldName]]').val(finalUrl); // put the file path in the input field
               $('#editor').remove(); //close the window after image is selected
               $('#np-[[+npx.fieldName]]_preview').html(imgTag);
               // console.log(file.path);
               // console.log(file.url);
               // console.log('FINAL: '+finalUrl);
               // console.log(file);
             }
          });
}); 

</script>
</div>
       