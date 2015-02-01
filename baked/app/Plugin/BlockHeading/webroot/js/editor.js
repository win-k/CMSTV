$(function(){
  $(document).on('submit', '[data-block-editor-heading]', function(){
    var $form = $(this);
    var $block = $form.parents('div.bk-block');
    var h = $form.find('select.bk-block-input-h > option:selected').val();
    var text = $form.find('input.bk-block-input-text').val();
    baked.post('plugin/block_heading/block_heading_api/update', {
      data: {
        'block_id': $block.attr('data-bk-block-id'),
        h: h,
        text: text
      },
      ok: function(r){
        $block.replaceWith(r.html);
        baked.closeAllEditor();
      }
    });
  });
});
