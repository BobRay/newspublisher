    <div id="np-[[+npx.fieldName]]-container" class="np-image">
        [[+np.error_[[+npx.fieldName]]]]
        <label class="fieldlabel" for="np-[[+npx.fieldName]]" title="[[+npx.help]]">[[+npx.caption]]: </label>
        <input name="[[+npx.fieldName]]" class="image" id="np-[[+npx.fieldName]]"  type="textarea" rows="1"  value="[[+np.[[+npx.fieldName]]]]" height="30px"    />
        <button id="np-[[+npx.fieldName]]_button" type="button">[[%np_launch_image_browser]]</button>
        <div id="np-[[+npx.fieldName]]_preview" style="margin-top:10px;"></div>
        <script>
        $('#np-[[+npx.fieldName]]_button').on('click', function() {
          $('<div id="editor" />').dialogelfinder({
             modal: true, 
             width: "80%",
             height: '600px',
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

             url: '[[++site_url]]npelfinderconnector.html[[+media_source]]',
             cssAutoLoad: [
                 '[[+np_assets_url]]elfinder/elfinderthemes/[[++np_elfinder_theme]]/css/theme.css'
             ],


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

/* Show image preview on page load (if TV value isn't blank) */

    $(document).ready(function () {
        /* ToDo: Trim this */
        var val = $('#np-[[+npx.fieldName]]').val();
        // console.log("Value: " + val);
        if (val.length > 0) {
            var phpThumbUrl = '[[+phpThumbUrl]]';
            var baseUrl = '[[+baseUrl]]';
            var imgTag = '<img src="' + phpThumbUrl + '&src=' + baseUrl + val + '&h=[[++np_elfinder_tmb_size]]&w=[[++np_elfinder_tmb_size]]">';
            // console.log("Base URL: " + baseUrl);
            // console.log("phpThumbUrl: " + phpThumbUrl);
            // console.log("Image Tag: " + imgTag);
            // console.log('Has Length');
            $('#np-[[+npx.fieldName]]_preview').html(imgTag);
        }



    });

</script>
</div>
       