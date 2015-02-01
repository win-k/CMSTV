var adminBlog = new AdminBlog();

$(function(){
  $(document).on('click', '#editor-controller a', function(){
    var selector = $(this).parent().attr('data-open-editor');
    adminBlog.showEditorTab(selector);
  });

  $(document).on('click', '.preview-entry', function(){
    var $form = $(this).parents('form');
    var data = {
      'body1': $form.find('#EntryBody1').val(),
      'body2': $form.find('#EntryBody2').val(),
      'page_id': $form.find('#EntryPageId').val(),
      'published': $form.find('#EntryPublished').val(),
      'title': $form.find('#EntryTitle').val()
    };

    baked.saveSession('preview_entry', data, function(r){
      baked.getPageInfo({
        'page_id': data['page_id']
      }, function(r){
        var url = r.page.Page.path+'?mode=preview';
        window.open(url, 'entry_preview');
      });
    });

  });
});



