baked.blocks.blockPhotoGallery = {
  instances: {},
  reload: function(blockId){
    baked.loadBlock(blockId, {
      ok: function(r){
        $block = baked.domBlockById(blockId);
        $block.find('.block-photo-gallery').replaceWith($(r.html).find('.block-photo-gallery'));
        $block.find('.block-photo-gallery-edit-list').replaceWith($(r.html).find('.block-photo-gallery-edit-list'));
      }
    });
  },
  saveSortTimer: null,
  saveSort: function(blockId){
    clearTimeout(baked.blocks.blockPhotoGallery.saveSortTimer);
    baked.blocks.blockPhotoGallery.saveSortTimer = setTimeout(function(){
      $block = baked.domBlockById(blockId);
      $ul = $block.find('.block-photo-gallery-edit-list');
      var fileIds = [];
      $ul.find('li').each(function(){
        fileIds.push($(this).attr('data-bk-file-id'));
      });

      baked.post('plugin/block_photo_gallery/block_photo_gallery_api/save_sort', {
        data: {
          'block_id': blockId,
          'file_ids': fileIds
        },
        ok: function(r){
          $block.find('.block-photo-gallery').replaceWith($(r.html).find('.block-photo-gallery'));
        }
      });
    }, 500);
  },
  alignEditor: function(blockId){
    var $block = baked.domBlockById(blockId);
    var $photoGallery = $block.find('.block-photo-gallery');
    var type = $photoGallery.attr('data-bk-type');
    var $boxes = $block.find('ul.bk-editor-boxes');
    if (type == 'lightbox') {
      $boxes.find('li.bk-type-lightbox').show();
      $boxes.find('li.bk-type-slider').hide();
    } else {
      $boxes.find('li.bk-type-lightbox').hide();
      $boxes.find('li.bk-type-slider').show();
    }
  }
};

$(function(){
  $(document).on('click', '[data-bk-block-photo-gallery-show-images]', function(){
    $a = $(this);
    var $block = $(this).parents('div.bk-block');
    if ($a.hasClass('active')) {
      $a.removeClass('active');
      $block.find('.block-photo-gallery-edit-list-outer').slideUp();
    } else {
      $a.addClass('active');
      $block.find('.block-photo-gallery-edit-list-outer').slideDown();
    }
  });

  $(document).on('click', '[data-bk-block-photo-gallery-set-type]', function(){
    var type = $(this).attr('data-bk-block-photo-gallery-set-type');
    var $block = $(this).parents('div.bk-block');
    var bkBlockId = $block.attr('data-bk-block-id');

    $(this).parent().find('a').removeClass('active');
    $(this).addClass('active');

    baked.post('plugin/block_photo_gallery/block_photo_gallery_api/update', {
      data: {
        'block_id': bkBlockId,
        'type': type
      },
      ok: function(r){
        $block.find('.block-photo-gallery').replaceWith($(r.html).find('.block-photo-gallery'));
        baked.blocks.blockPhotoGallery.alignEditor(bkBlockId);
      }
    });
  });

  $(document).on('click', '[data-bk-block-photo-gallery-increase]', function(){
    var $block = $(this).parents('div.bk-block');
    var bkBlockId = $block.attr('data-bk-block-id');

    baked.post('plugin/block_photo_gallery/block_photo_gallery_api/increase', {
      data: {
        'block_id': bkBlockId
      },
      ok: function(r){
        $block.find('.block-photo-gallery').replaceWith($(r.html).find('.block-photo-gallery'));
      }
    });
  });

  $(document).on('click', '[data-bk-block-photo-gallery-decrease]', function(){
    var $block = $(this).parents('div.bk-block');
    var bkBlockId = $block.attr('data-bk-block-id');

    baked.post('plugin/block_photo_gallery/block_photo_gallery_api/decrease', {
      data: {
        'block_id': bkBlockId
      },
      ok: function(r){
        $block.find('.block-photo-gallery').replaceWith($(r.html).find('.block-photo-gallery'));
      }
    });
  });

  $(document).on('submit', 'form.bk-photo-gallery-form', function(){
    var $block = $(this).parents('div.bk-block');
    var bkBlockId = $block.attr('data-bk-block-id');

    var params = {};
    $($(this).serializeArray()).each(function(i, v) {
      params[v.name] = v.value;
    });
    params['block_id'] = bkBlockId;
    baked.post('plugin/block_photo_gallery/block_photo_gallery_api/update', {
      data: params,
      ok: function(r){
        $block.find('.block-photo-gallery').replaceWith($(r.html).find('.block-photo-gallery'));
      }
    });
  });

  $(document).on('click', 'a.bk-photo-gallery-delete-photo', function(){
    var $block = $(this).parents('div.bk-block');
    var bkBlockId = $block.attr('data-bk-block-id');
    var $photo = $(this).parent();
    var fileId = $photo.attr('data-bk-file-id');

    baked.post('plugin/block_photo_gallery/block_photo_gallery_api/delete_photo', {
      data: {
        'block_id': bkBlockId,
        'file_id': fileId
      },
      ok: function(r){
        $photo.fadeOut('normal', function(){
          $photo.remove();
        });
        $block.find('.block-photo-gallery').replaceWith($(r.html).find('.block-photo-gallery'));
      }
    });
  });


});







