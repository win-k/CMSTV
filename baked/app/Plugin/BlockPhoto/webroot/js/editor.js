baked.blocks.blockPhoto = {
  instances: {},
  reload: function(blockId){
    baked.loadBlock(blockId, {
      ok: function(r){
        $block = baked.domBlockById(blockId);
        $block.find('.bk-block-photo-box').replaceWith($(r.html).find('.bk-block-photo-box'));
      }
    });
  },
  resize: function(blockId, size){
    var $block = baked.domBlockById(blockId);
    baked.post('plugin/block_photo/block_photo_api/update', {
      data: {
        'block_id': blockId,
        'size'    : size.width
      },
      ok: function(r){
        $block.find('.bk-block-photo-box').replaceWith(
          $(r.html).find('.bk-block-photo-box').css('height', size.height+'px')
        );
      }
    });
  }
};

$(function(){
  $(document).on('click', '[data-bk-block-photo-align]', function(){
    var align = $(this).attr('data-bk-block-photo-align');
    var $block = $(this).parents('div.bk-block');
    var bkBlockId = $block.attr('data-bk-block-id');

    baked.post('plugin/block_photo/block_photo_api/update', {
      data: {
        'block_id': bkBlockId,
        'align'   : align
      },
      ok: function(r){
        $block.find('.bk-block-photo-box').replaceWith($(r.html).find('.bk-block-photo-box'));
      }
    });
  });
});







