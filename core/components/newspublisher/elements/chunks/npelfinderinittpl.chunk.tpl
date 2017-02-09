<script type="text/javascript">
/********** File/Image Browser **************/
  if(typeof autoFileBrowser == "undefined" || autoFileBrowser.name == "elFinderBrowser"){
    autoFileBrowser = function(field_name, url, type, win, gallery) {
    tinymce.activeEditor.windowManager.open({
    // file is the URL of of the npElFinder resource
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