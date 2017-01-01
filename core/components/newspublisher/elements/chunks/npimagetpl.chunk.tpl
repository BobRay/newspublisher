    <div id="np-[[+npx.fieldName]]-container" class="np-image">
        [[+np.error_[[+npx.fieldName]]]]
        <label class="fieldlabel" for="np-[[+npx.fieldName]]" title="[[+npx.help]]">[[+npx.caption]]: </label>
        <input name="[[+npx.fieldName]]" class="image" id="np-[[+npx.fieldName]]"  type="textarea" rows="1"  value="[[+np.[[+npx.fieldName]]]]" height="30px" />
        
        <!-- onchange="[[+npx.fieldName]]_preview(this.value)" -->
        
        <!-- <button type="button" onclick="var popup=window.open('[[+npx.browserUrl]]', 'Select image...', 'width=' + Math.min(screen.availWidth,1000) + ',height=' + Math.min(screen.availHeight*0.9,700) + 'status=no,location=no,toolbar=no,menubar=no');popup.focus();browserPathInput=getElementById('np-[[+npx.fieldName]]');">[[%np_launch_image_browser]]</button> -->
        <!-- <div id="[[+npx.fieldName]]_preview_container"></div>
        
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
              
        </script> -->
          <script>
    tinymce.init({  
    
    selector: "#np-[[+npx.fieldName]]",
    // language: [[+language]],
     file_browser_callback: autoFileBrowser,
    
    relative_urls: true,
    image_advtab: true,
    skin_url: '[[++assets_url]]components/tinymcewrapper/tinymceskins/modxPericles',
    // document_base_url: 'http://localhost/addons/',
    document_base_url: '[[++site_url]]',
    // height:20,
    // min_height: 2,
    // width:400,
    // width:400,
    resize:true,
    /*auto_resize:true,
    auto_resize_min_height: 2,
    auto_resize_max_width:600,*/
    // remove_script_host: false,
    // height: [[+height]],
    // width: [[+width]],
    extended_valid_elements : "fixedpre",
    custom_elements: "fixedpre",
   
    external_plugins: {
    // twAceEditor: "[[++assets_url]]components/tinymcewrapper/tinymceplugins/twAceEditor.js",
    // twCodeMirror: "[[++assets_url]]components/tinymcewrapper/tinymceplugins/twCodeMirror.js",
    // bubbleBar: "[[++assets_url]]components/tinymcewrapper/tinymceplugins/tinymceBubbleBar.js",
    // twExoticMarkdownEditor: "[[++assets_url]]components/tinymcewrapper/tinymceplugins/twExoticMarkdownEditor.js",
    // twPreCodeManager: "[[+npAssetsURL]]js/twPreCodeManager.js" // original
    // npFixedpreCodeManager: "[[+npAssetsURL]]js/npFixedPre.js"
  }, 
  

   // paste_word_valid_elements: "a,div,b,strong,i,em,h1,h2,h3,p,blockquote,ol,ul,pre",
    image_caption: true,
  //  browser_spellcheck: true,
  //  gecko_spellcheck: true,
    paste_data_images: false,
    statusbar: true,
    elementpath: false,
    resize: true,
    plugins: "imagetools,autoresize,preview,paste,contextmenu,image,fullscreen,code,charmap,searchreplace,textpattern,emoticons,insertdatetime,link",
    // plugins: "imagetools contextmenu autosave save paste image link searchreplace",
    menubar: false,
    toolbar: "fullscreen | code | undo redo | image",
      // contextmenu: "code | twPreCodeManager | fullscreen | removeformat | link | image"
      contextmenu: "fullscreen | image "

  }); 
</script>    
    </div>
