baked.blocks.blockCode = {
  editors: {}
};
baked.events.opened.BlockCode = function(blockId){
  if (baked.blocks.blockCode.editors[blockId])
    baked.blocks.blockCode.editors[blockId].refresh();
};

$(function(){
  $(document).on('submit', '[data-block-code-form]', function(){
    var $block = $(this).parents('div.bk-block');
    var blockId = $block.attr('data-bk-block-id');
    var params = {};
    $($(this).serializeArray()).each(function(i, v) {
      params[v.name] = v.value;
    });
    params['block_id'] = blockId;

    baked.post('plugin/block_code/block_code_api/update', {
      data: params,
      ok: function(r){
        $block.find('div.bk-block-code-content').replaceWith($(r.html).find('div.bk-block-code-content'));
        baked.closeAllEditor();
      }
    });
  });
});
