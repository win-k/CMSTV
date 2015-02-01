var adminThemes = new AdminTheme;

$(function(){
  $(document).on('click', '.act-install-theme', function(){
    var zip = $(this).attr('data-theme-zip');
    var plugin = $(this).attr('data-theme-plugin');
    adminThemes.prepareInstallTheme(zip, plugin);
  });
});
