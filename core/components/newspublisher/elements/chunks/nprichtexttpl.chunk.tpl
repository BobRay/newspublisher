<div id="np-[[+npx.fieldName]]-container" class="np-textarea">
    [[+np.error_[[+npx.fieldName]]]]
    <label class="fieldlabel" for="np-[[+npx.fieldName]]" title="[[+npx.help]]">[[+npx.caption]]:</label>
    <textarea rows="[[+npx.rows]]" cols="[[+npx.cols]]" class="[[+npx.class]]" name="[[+npx.fieldName]]"
              [[+npx.readonly]] id="np-[[+npx.fieldName]]">[[+np.[[+npx.fieldName]]]]</textarea>
</div>

<script type="text/javascript">
    [[+file_browser_function]] = function (field_name, url, type, win, gallery) {
        tinymce.activeEditor.windowManager.open({
            // file is the URL of of the npElFinder resource
            file: '[[++site_url]]npelfinder.html[[+media_source]]',
            title: 'elFinder 2.0',
            width: window.innerWidth / 1.2,
            height: window.innerHeight / 1.2,
            resizable: 'yes'
        }, {
            setUrl: function (url) {
                win.document.getElementById(field_name).value = url;
            }
        });
        return false;
    };

    /********** TinyMCE init code **************/
    tinymce.init({

        selector: '.modx-richtext-tv',
        file_browser_callback: [[+file_browser_function]],
        relative_urls: true,
        image_advtab: true,
        skin_url: '[[+npAssetsURL]]tinymceskins/[[++np_tinymce_skin]]',
        document_base_url: '[[++site_url]]',
        remove_script_host: false,
        height: '[[+height]]',
        width: '[[+width]]',
        extended_valid_elements: "fixedpre",
        custom_elements: "fixedpre",

        external_plugins: {
            // twAceEditor: "[[++assets_url]]components/tinymcewrapper/tinymceplugins/twAceEditor.js",
            // twCodeMirror: "[[++assets_url]]components/tinymcewrapper/tinymceplugins/twCodeMirror.js",
            // bubbleBar: "[[++assets_url]]components/tinymcewrapper/tinymceplugins/tinymceBubbleBar.js",
            // twExoticMarkdownEditor: "[[++assets_url]]components/tinymcewrapper/tinymceplugins/twExoticMarkdownEditor.js",
            // twPreCodeManager: "[[+npAssetsURL]]js/twPreCodeManager.js" // original
            // npFixedpreCodeManager: "[[+npAssetsURL]]js/npFixedPre.js"
        },


        paste_word_valid_elements: "a,div,b,strong,i,em,h1,h2,h3,p,blockquote,ol,ul,pre",
        image_caption: true,
        browser_spellcheck: true,
        gecko_spellcheck: true,
        paste_data_images: false,
        statusbar: true,
        resize: true,
        plugins: "imagetools,autoresize,preview,paste,contextmenu,image,wordcount,fullscreen,code,charmap,searchreplace,textpattern,emoticons,insertdatetime,link,codesample",
        // plugins: "imagetools contextmenu autosave save paste image link searchreplace",
        menubar: false,
        toolbar: "fullscreen | code | undo redo | blockquote | bold italic alignleft aligncenter alignright | bullist numlist | link unlink | image | styleselect charmap emoticons insertdatetime searchreplace",
        contextmenu: "code | fullscreen | removeformat | link | image |"

    });

</script>
