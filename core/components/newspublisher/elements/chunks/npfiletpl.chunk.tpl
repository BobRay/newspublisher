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
          // Disable kb shortcuts for these commands, otherwise they still work even if they are listed as disabled
          /*commandsOptions: {
            upload : {shortcuts : []},
            rm : {shortcuts : []},
            download : {shortcuts : []}
          },*/
          allowShortcuts : false,

          url : '[[++site_url]]npelfinderconnector.html',
          width: '80%',
          height: '600px',
          getFileCallback: function(file) {
             var filePath = file.url.replace('\\','/'); // (normalize file path)
             var base = file.baseUrl.replace('\\','/');
             var finalPath = filePath.replace(base, '');
             $('#np-[[+npx.fieldName]]').val(finalPath); // put the file path in the input field
             $('#editor').remove(); //close the window after image is selected
             // console.log(filePath);
             // console.log(file.url);
             // console.log(file.baseUrl);
          }
  });
});
</script>

