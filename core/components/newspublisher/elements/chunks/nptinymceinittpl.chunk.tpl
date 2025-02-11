
<script type="text/javascript">
/********** TinyMCE init code **************/
  tinymce.init({  
    selector: "#np-content, .modx-richtext",
    language: [[+language]],
    file_browser_callback: [[+file_browser_function]],
    relative_urls: true,
    image_advtab: true,
    skin_url: '[[+npAssetsURL]]tinymceskins/[[++np_tinymce_skin]]',
    document_base_url: '[[++site_url]]',
    height: '[[+height]]',
    width: '[[+width]]',
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
      // contextmenu: "code | twPreCodeManager | fullscreen | removeformat | link | image"
      contextmenu: "code | fullscreen | removeformat | link | image |"

  });
</script>
