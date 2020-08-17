var sfAssetsLibrary_Engine = function(){};

sfAssetsLibrary_Engine.prototype = {
  init : function(url, win)
  {
    this.url = url;
    this.window = win;
  },

  fileBrowserCallBack : function (field_name, url, type, win)
  {
    tinyMCE.activeEditor.windowManager.open({
      file :      type == 'image' ? this.url+'/images_only/1' : this.url,
      title:      'Assets',
      width :     800,
      height :    500,
      inline:     'yes',
      resizable : 'yes',
      scrollbars: 'yes'
    },
    {
      input:      field_name,
      type:       type,
      window:     win
    });
    //$childWindow = window.open(this.url, 'Wybierz obraz', 'location=0,resizeable=1,scrollbars=1');
    //$childWindow.opener = this.window;

    return false;
  }
}

var sfAssetsLibrary = new sfAssetsLibrary_Engine();