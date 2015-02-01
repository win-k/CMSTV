var AdminBlog = function(){
};

AdminBlog.prototype.setupEditor = function($dom){
  $dom.bkCkeditor({
    toolbar : [
      ['Bold','Italic']
      ,['NumberedList','BulletedList','-','Outdent','Indent','Blockquote']
      ,['JustifyLeft','JustifyCenter','JustifyRight']
      ,['Table']
      ,['Link','Unlink']
      ,['TextColor','BGColor']
      ,['Undo','Redo']
      ,['ShowBlocks']
      ,['Image','Youtube']
      ,['Source']
    ],
    height: 400,
    forcePasteAsPlainText: true,
    filebrowserBrowseUrl: baked.base+'js/kcfinder/browse.php?type=files',
    filebrowserImageBrowseUrl: baked.base+'js/kcfinder/browse.php?type=images',
    filebrowserFlashBrowseUrl: baked.base+'js/kcfinder/browse.php?type=flash',
    filebrowserUploadUrl: baked.base+'js/kcfinder/upload.php?type=files',
    filebrowserImageUploadUrl: baked.base+'js/kcfinder/upload.php?type=images',
    filebrowserFlashUploadUrl: baked.base+'js/kcfinder/upload.php?type=flash'
  });
};

AdminBlog.prototype.showEditorTab = function(selector){
  $('.editor').hide();
  $(selector).show();
  $('li[data-open-editor]').removeClass('current');
  $('li[data-open-editor="'+selector+'"]').addClass('current');
  adminBlog.setupEditor($(selector).find('textarea'));
};


