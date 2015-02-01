baked.blocks.blockTextPhoto = {
  instances: {},
  reload: function(blockId){
    baked.loadBlock(blockId, {
      ok: function(r){
        $block = baked.domBlockById(blockId);
        $block.find('.bk-block-text-photo-content').replaceWith($(r.html).find('.bk-block-text-photo-content'));
      }
    });
  },
  resize: function(blockId, size){
    var $block = baked.domBlockById(blockId);
    baked.post('plugin/block_text_photo/block_text_photo_api/update', {
      data: {
        'block_id': blockId,
        'size'    : size.width
      },
      ok: function(r){
        $block.find('.bk-block-text-photo-image-box').replaceWith(
          $(r.html).find('.bk-block-text-photo-image-box').css('height', size.height+'px')
        );
      }
    });
  }
};

$(function(){
  $(document).on('submit', '[data-block-editor-text-photo]', function(){
    var $block = $(this).parents('div.bk-block');
    var blockId = $block.attr('data-bk-block-id');
    var params = {};
    $($(this).serializeArray()).each(function(i, v) {
      params[v.name] = v.value;
    });
    params['block_id'] = blockId;

    baked.post('plugin/block_text_photo/block_text_photo_api/update', {
      data: params,
      ok: function(r){
        $block.find('div.bk-block-text-photo-content').replaceWith($(r.html).find('div.bk-block-text-photo-content'));
        baked.closeAllEditor();
      }
    });
  });

  $(document).on('click', '[data-bk-block-text-photo-align]', function(){
    var align = $(this).attr('data-bk-block-text-photo-align');
    var $block = $(this).parents('div.bk-block');
    var bkBlockId = $block.attr('data-bk-block-id');

    baked.post('plugin/block_text_photo/block_text_photo_api/update', {
      data: {
        'block_id': bkBlockId,
        'align'   : align
      },
      ok: function(r){
        $block.find('div.bk-block-text-photo-content').replaceWith($(r.html).find('div.bk-block-text-photo-content'));
      }
    });
  });
});
