<script type="text/javascript">
/********** File/Image Browser **************/
if(typeof [[+file_browser_function]] == "undefined" || [[+file_browser_function]].name == "elFinderBrowser"){
    var ef_width = (("[[++np_elfinder_width]]" * 1) || 80) / 100;
    var ef_height = (("[[++np_elfinder_height]]" * 1) || 80) / 100;

    [[+file_browser_function]] = function(field_name, url, type, win, gallery) {
    tinymce.activeEditor.windowManager.open({
    // file is the URL of of the npElFinder resource
    file: '[[++site_url]]npelfinder[[+np_html_extension]]',
    title: 'elFinder 2.0 (double-click to select your file)',
    width : window.innerWidth * ef_width,
    height : window.innerHeight * ef_height,
    resizable: 'yes'
}, {
  setUrl: function (url) {
    win.document.getElementById(field_name).value = url;
  }
});
  return false;
  }}
  </script>
