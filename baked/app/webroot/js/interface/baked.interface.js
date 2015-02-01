var baked = new Baked;

$(function(){
  var keyups = [];
  $(document).on('keyup', function(e){
    keyups.unshift(e.keyCode);
    if (keyups.length > 3) keyups.splice(3);
    if (keyups.join('') == '272727') {
      baked.goEditModeOrShowSigninBox();
      keyups = [];
    }
  });

  $(document).on('submit', '#bk-sign-in-form', function(e){
    var params = baked.params($(this));
    baked.post('system/api_system/sign_in', {
      data: params,
      ok: function(r){
        baked.goEditmode(function(){
          baked.reload();
        });
      }
    });
  });

  $('textarea.code-mirror').each(function(){
    if (!CodeMirror) return;
    var cm = CodeMirror.fromTextArea(this, {
      mode: 'application/x-httpd-php',
      lineNumbers: true,
      indentUnit: 2
    });
    cm.setSize(null, 500);
  });

  $(document).on('click', '[data-toggle]', function(e){
    var selector = $(this).attr('data-toggle');
    $(selector).toggle('fast');
  });

  $(document).on('click', '.click-to-disappear', function(){
    $(this).fadeOut();
  });

  $(document).on('click', '[data-bk-show-comment-editor]', function(){
    var entryId = $(this).attr('data-bk-show-comment-editor');
    baked.showCommentEditorBox(entryId);
  });

  $(document).on('submit', '#comment-editor-form', function(){
    var name = $(this).find('#CommentName').val();
    var body = $(this).find('#CommentBody').val();
    var entryId = $(this).find('#CommentEntryId').val();
    var params = {
      name: name,
      body: body,
      'entry_id': entryId
    };
    baked.submitComment(params);
  });

  $(document).on('click', '.bk-close-box', function(){
    $.fancybox.close();
  });

});

function c(val) {
  console.log(val);
}
