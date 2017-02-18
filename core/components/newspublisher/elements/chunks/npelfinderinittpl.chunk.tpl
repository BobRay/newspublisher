<script type="text/javascript">
/********** File/Image Browser **************/
if(typeof [[+file_browser_function]] == "undefined" || [[+file_browser_function]].name == "elFinderBrowser"){
  [[+file_browser_function]] = function(field_name, url, type, win, gallery) {
  tinymce.activeEditor.windowManager.open({
  // file is the URL of of the npElFinder resource
  file: '[[++site_url]]npelfinder.html',
  title: 'elFinder 2.0 (double-click to select your file)',
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