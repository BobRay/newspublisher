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
          height: '600px',
          title: "Double-click to select your file", 
          zIndex: 99999,

              /* Disable command Keyboard shortcuts, otherwise they still work
                     even if the commands are listed as disabled */

              /* Disable all command shortcuts */
              allowShortcuts: false,

              /* Disable specific command shortcuts */

              // commandsOptions: {
              //     upload : {shortcuts : []},
              //     rm : {shortcuts : []},
              //     download : {shortcuts : []}
              // },

          url : '[[++site_url]]npelfinderconnector.html[[+media_source]]',


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

