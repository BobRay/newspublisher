 <div id="np-[[+npx.fieldName]]-container" class="np-file">
        [[+np.error_[[+npx.fieldName]]]]
        <label class="fieldlabel" for="np-[[+npx.fieldName]]" title="[[+npx.help]]">[[+npx.caption]]: </label>
        <input name="[[+npx.fieldName]]" class="file" id="np-[[+npx.fieldName]]" type="text"  value="[[+np.[[+npx.fieldName]]]]" />
   <!--     <button type="button" onclick="autoFileBrowser('#np-[[+npx.fieldName]]');">[[%np_launch_file_browser]]</button> -->
   <button id="elfinder_button" type="button">[[%np_launch_file_browser? &namespace=`newspublisher` &topic=`default`]]</button>
    </div>

<script>
$('#elfinder_button').on('click', function() {
   var ef_width = (("[[++np_elfinder_width]]" * 1)  || 80) / 100;
   var ef_height = (("[[++np_elfinder_height]]" * 1) || 80) /100;

  $('<div id="editor" />').dialogelfinder({
          modal: true,
          width: window.innerWidth * ef_width,
          height: window.innerHeight * ef_height,
          title: '<b>elFinder 2.0 (double-click to select your file)</b>',
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

          cssAutoLoad: [
              '[[+np_assets_url]]elfinder/elfinderthemes/[[++np_elfinder_theme]]/css/theme.css'
          ],

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

