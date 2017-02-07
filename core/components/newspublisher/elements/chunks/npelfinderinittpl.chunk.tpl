<script type="text/javascript">
/********** File/Image Browser **************/
  if(typeof autoFileBrowser == "undefined" || autoFileBrowser.name == "elFinderBrowser"){
    var browserUrl = "assets/components/tinymcewrapper/frontend/imogen_theme/index.html";
    autoFileBrowser = function(field_name, url, type, win, gallery) {
    tinymce.activeEditor.windowManager.open({
    // file: 'assets/mycomponents/newspublisher/assets/components/newspublisher/elfinder/elfinder.html',// use an absolute path!
    // file is the URL of a resource
    file: '[[++site_url]]npelfinder.html',
    title: 'elFinder 2.0',
    width : window.innerWidth/1.2,
    height : window.innerHeight/1.2,
    resizable: 'yes'
  }, {
    setUrl: function (url) {
      win.document.getElementById(field_name).value = url;
    }
  });
  return false;
  }}
  </script>