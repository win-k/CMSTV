$(function(){
  $(document).on('submit', '[data-block-editor-text]', function(){
    var $block = $(this).parents('div.bk-block');
    var blockId = $block.attr('data-bk-block-id');
    var params = {};
    $($(this).serializeArray()).each(function(i, v) {
      params[v.name] = v.value;
    });
    params['block_id'] = blockId;

    baked.post('plugin/block_text/block_text_api/update', {
      data: params,
      ok: function(r){
        $block.find('div.bk-block-text-content').replaceWith($(r.html).find('div.bk-block-text-content'));
        baked.closeAllEditor();
      }
    });
  });
});
