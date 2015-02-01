var AdminTheme = function(){
};

AdminTheme.prototype.prepareInstallTheme = function(zip, plugin){
  var self = this;
  baked.showLoading();
  baked.post('admin/themes/api/check_plugin_exists', {
    data: {
      plugin: plugin
    },
    ok: function(r){
      if (r.exists) {
        if (baked.confirm(r.message)) {
          self._extractTheme(zip, plugin);
        } else {
          baked.hideLoading();
        }
      } else {
        self._extractTheme(zip, plugin);
      }
    }
  });
};

AdminTheme.prototype._extractTheme = function(zip, plugin){
  var self = this;
  baked.post('admin/themes/api/extract_zip', {
    data: {
      zip: zip,
      plugin: plugin
    },
    ok: function(r){
      self._installTheme(r.pluguinPath);
    },
    ng: function(r){
      baked.hideLoading();
    }
  });
};

AdminTheme.prototype._installTheme = function(pluguinPath){
  var self = this;
  baked.post('admin/themes/api/install', {
    data: {
      'plugin_path': pluguinPath
    },
    ok: function(r){
      baked.alert(r.message);
    },
    complete: function(){
      baked.hideLoading();
    }
  });
};
