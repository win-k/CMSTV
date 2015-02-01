$(function(){

  baked.setupCkeditor();
  baked.sortableBlocks();

  $(document).on('click', '[data-bk-show-page-manager]', function(){
    baked.showPageManager();
  });

  $(document).on('submit', 'form#bk-page-manager-form', function(e){
    e.preventDefault();
    baked.savePageManager();
  });

  $(document).on('click', 'ul#bk-page-manager a.bk-up', function(){
    $li = $(this).parents('li');
    $target = $li.prev();
    if ($target.length == 0) return;
    $li.after($target);
    baked.alignPageManager();
  });

  $(document).on('click', 'ul#bk-page-manager a.bk-down', function(){
    $li = $(this).parents('li');
    $target = $li.next();
    if ($target.length == 0) return;
    $li.before($target);
    baked.alignPageManager();
  });

  $(document).on('click', 'ul#bk-page-manager a.bk-left', function(){
    $li = $(this).parents('li');
    var depth = parseInt($li.attr('data-bk-depth'));
    if (depth == 0) return;
    $li.attr('data-bk-depth', depth-1);
    baked.alignPageManager();
  });

  $(document).on('click', 'ul#bk-page-manager a.bk-right', function(){
    $li = $(this).parents('li');
    var depth = parseInt($li.attr('data-bk-depth'));
    if (depth == 2) return;
    $li.attr('data-bk-depth', depth+1);
    baked.alignPageManager();
  });

  $(document).on('click', 'ul#bk-page-manager a.bk-hide', function(){
    $li = $(this).parents('li');
    $li.attr('data-bk-hidden', 1);
    baked.alignPageManager();
  });

  $(document).on('click', 'ul#bk-page-manager a.bk-open', function(){
    $li = $(this).parents('li');
    $li.attr('data-bk-hidden', 0);
    baked.alignPageManager();
  });

  $(document).on('click', '[data-bk-add-page]', function(){
    var package = $(this).attr('data-bk-add-page');
    var $ul = $(this).parents('ul');
    var pageId = $ul.attr('data-bk-page-id');
    baked.savePageManager({
      ok: function(r){
        if (!baked.busyFilter()) return;

        baked.insertPage({
          'before_page_id': pageId,
          'package': package
        }, {
          ok: function(){
            baked.showPageManager();
          },
          complete: function(){
            baked.busyEnd();
          }
        });
      }
    });
  });

  $(document).on('click', 'ul#bk-page-manager a.bk-delete', function(){
    $li = $(this).parents('li');
    if ($li.hasClass('bk-home')) return;
    var pageId = $li.attr('data-page-id');
    baked.savePageManager({
      ok: function(r){
        if (!baked.busyFilter()) return;

        baked.deletePage({
          data: {
            'page_id': pageId
          },
          ok: function(r){
            baked.showPageManager();
            baked.reloadDynamic();
          },
          complete: function(){
            baked.busyEnd();
          }
        });
      }
    });
  });

  $(document).on('click', '[data-bk-editor-opener]', function(){
    var $block = $(this).parent();
    baked.openEditor($block);
  });

  $(document).on('click', '[data-bk-toggle-editor]', function(){
    var $block = $(this).parents('.bk-block');
    baked.toggleEditor($block);
  });

  $(document).on('click', '[data-bk-add-block]', function(){
    var $ul = $('#bk-available-blocks');
    var package = $(this).attr('data-bk-add-block');
    var sheet = $ul.attr('data-bk-sheet');
    var beforeBlockId = $ul.attr('data-bk-before-block-id');
    baked.addBlock(baked.pageId, sheet, package, beforeBlockId);
  });

  $(document).on('click', '[data-bk-delete-block]', function(){
    var blockId = $(this).attr('data-bk-delete-block');
    baked.deleteBlock(blockId);
  });

  $(document).on('click', '[data-bk-show-block-list]', function(e){
    var sheet = $(this).attr('data-bk-sheet');
    var beforeBlobkId = $(this).attr('data-bk-before-block-id');
    if (!beforeBlobkId) beforeBlobkId = 0;
    $('#bk-available-blocks')
      .attr('data-bk-sheet', sheet)
      .attr('data-bk-before-block-id', beforeBlobkId)
      .css({
        top: e.pageY,
        left: e.pageX
      })
      .show();
    baked.showingBlockBox = true;
  });

  $(document).on('click', '[data-bk-show-page-list]', function(e){
    var pageId = $(this).attr('data-bk-show-page-list');
    $('#bk-available-pages')
      .attr('data-bk-page-id', pageId)
      .css({
        top: e.pageY,
        left: e.pageX
      })
      .show();
    baked.showingPageBox = true;
  });

  $(document).on('click', '.bk-cancel-editmode', function(){
    baked.cancelEditmode(function(){
      baked.reload();
    });
  });

  $(document).on('click', '.bk-sign-out', function(){
    baked.signOut(function(){
      baked.reload();
    });
  });

  $(document).on('mouseenter', '.bk-add-block-outer', function(){
    $(this).parents('.bk-sheet').addClass('highlight');
  });

  $(document).on('mouseleave', '.bk-add-block-outer', function(){
    $('.bk-sheet.highlight').removeClass('highlight');
  });

  $(document).on('click', function(e){
    if (!baked.showingBlockBox) return;

    var attr = $(e.target).attr('data-bk-show-block-list');
    if ('undefined' != typeof attr) return;
    if ($(e.target).parents('[data-bk-show-block-list]').length > 0) return;

    $('#bk-available-blocks').hide();
    baked.showingBlockBox = false;
  });

  $(document).on('click', function(e){
    if (!baked.showingPageBox) return;

    var attr = $(e.target).attr('data-bk-show-page-list');
    if ('undefined' != typeof attr) return;
    if ($(e.target).parents('[data-bk-show-page-list]').length > 0) return;

    $('#bk-available-pages').hide();
    baked.showingPageBox = false;
  });

});

