 <div id="np-[[+npx.fieldName]]-container" class="np-file">
        [[+np.error_[[+npx.fieldName]]]]
        <label class="fieldlabel" for="np-[[+npx.fieldName]]" title="[[+npx.help]]">[[+npx.caption]]: </label>
        <input name="[[+npx.fieldName]]" class="file" id="np-[[+npx.fieldName]]" type="text"  value="[[+np.[[+npx.fieldName]]]]" />
   <!--     <button type="button" onclick="autoFileBrowser('#np-[[+npx.fieldName]]');">[[%np_launch_file_browser]]</button> -->
   <button id="elfinder_button" type="button">[[%np_launch_file_browser]]</button>
    </div>

<script>
$('#elfinder_button').on('click', function() {
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
            // var filePath = file; // (file is an object)
            // console.log(file.path);
            $('#np-[[+npx.fieldName]]').val('[[++assets_path]]' + file.path); // put the file path in the input field
            $('#editor').remove(); //close the window after image is selected
          }
  });
});
</script>

