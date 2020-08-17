  var portal;
    function init() {
    portal = new Portal(options);
    portal.applySettings(settings);
  }
  Event.observe(window, 'load', init, false);
  