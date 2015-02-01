baked.blocks.blockSpace = {
  resize: function(blockId, size){
    var $block = baked.domBlockById(blockId);
    baked.post('plugin/block_space/block_space_api/update', {
      data: {
        'block_id': blockId,
        'size'    : size.height
      }
    });
  }
};
