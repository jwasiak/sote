function setImageField(url)
{
  var win = tinyMCEPopup.getWindowArg("window");

  if (tinyMCEPopup.getWindowArg("type") == 'image' && win.ImageDialog.showPreviewImage)
  {
    win.ImageDialog.showPreviewImage(url);
  }

  win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = url;
  tinyMCEPopup.close();
}