var Baked = function(){
  this.token;
  this.base;
  this.showingBlockBox;
  this.showingPageBox = false;
  this.saveBlockSortTimer;
  this.pageId;
  this.busy;
  this.blocks = {};
  this.events = {opened: {}};
};

//Baked.prototype.blocks = {};
//Baked.prototype.events = {opened: {}};

$.fn.bkCkeditor = function(options){
  var defaults = {
    enterMode : CKEDITOR.ENTER_BR,
    extraPlugins : 'youtube',
    allowedContent : true,
    forcePasteAsPlainText: true,
    toolbar : [
      ['Bold','Italic']
      ,['NumberedList','BulletedList','-','Outdent','Indent','Blockquote']
      ,['JustifyLeft','JustifyCenter','JustifyRight']
      ,['Table']
      ,['Link','Unlink']
      ,['TextColor','BGColor']
      ,['Undo','Redo']
      ,['ShowBlocks']
      ,['Youtube']
      ,['Source']
    ]
  };
  if (options) {
    $.extend(defaults, options);
  }
  $(this).ckeditor(defaults);
};

Baked.prototype.confirm = function(message){
  return window.confirm(message);
};

Baked.prototype.alert = function(message){
  alert(message);
};

Baked.prototype.saveSession = function(name, data, callback){
  this.post('system/api_system/save_session', {
    data: {
      'data[name]': name,
      'data[data]': data
    },
    ok: function(r){
      if (callback) callback(r);
    }
  });
};

Baked.prototype.showBox = function(html){
  $.fancybox({
    'content': html,
    'afterShow': function(){
      $('div.fancybox-inner').find('input:text,input:password,textarea,select').filter(':visible:first').focus();
    },
    beforeClose: function(){
      $('#bk-available-pages').hide();
      baked.showingPageBox = false;

      $('#bk-available-blocks').hide();
      baked.showingBlockBox = false;
    },
    'minHeight': 50
  });
};

Baked.prototype.params = function($dom){
  var params = {};
  $($dom.serializeArray()).each(function(i, v) {
    params[v.name] = v.value;
  });
  return params;
};

Baked.prototype.getPageInfo = function(params, callback){
  this.post('system/api_system/page_info', {
    data: params,
    ok: function(r){
      callback(r);
    }
  });
};

Baked.prototype.goEditModeOrShowSigninBox = function(){
  baked.post('system/api_system/signed_in', {
    ok: function(r){
      if (r.editmode == 1) {
        return;
      } if (r.signed == 1) {
        baked.goEditmode(function(){
          baked.reload();
        });
      } else {
        baked.showSigninBox();
      }
    }
  });
};

Baked.prototype.showSigninBox = function(){
  var self = this;
  this.showLoading();
  this.post('system/api_system/html_signin', {
    dataType: 'html',
    success: function(r){
      self.showBox(r);
      self.hideLoging();
    }
  });
};

Baked.prototype.goEditmode = function(callback){
  baked.post('system/api_system/go_editmode', {
    ok: function(r){
      if (callback) callback();
    }
  });
};

Baked.prototype.cancelEditmode = function(callback){
  baked.post('system/api_system/cancel_editmode', {
    ok: function(r){
      if (callback) callback();
    }
  });
};

Baked.prototype.signOut = function(callback){
  baked.post('system/api_system/sign_out', {
    ok: function(r){
      if (callback) callback();
    }
  });
};

Baked.prototype.reload = function(){
  location.reload();
};

/**
 * POST
 *
 * @param {Object} url
 * @param {Object} options
 */
Baked.prototype.post = function(url, options){
  var newOptions = $.extend({
    type: 'post',
    dataType: 'json',
    data: {}
  }, options);
  newOptions.data.token = this.token;
  newOptions.url = this.base + url;

  $.ajax({
    cache: false,
    url: newOptions.url,
    type: newOptions.type,
    dataType: newOptions.dataType,
    data: newOptions.data,
    beforeSend: function(x) {
      if ('beforeSend' in newOptions) { newOptions.beforeSend(x); };
    },
    success: function(r) {
      if (newOptions.dataType == 'json') {
        if (r.result == 'OK') {
          if ('ok' in newOptions) { newOptions.ok(r); };
        } else {
          if (r.message) alert(r.message);
          //common.showFloatingMessage(r.mes, 'error');
          if ('ng' in newOptions) { newOptions.ng(r); };
        }
        return;
      }

      if ('success' in newOptions) { newOptions.success(r); };
    },
    error: function(r) {
      if ('error' in newOptions) { newOptions.error(r); };
    },
    complete: function() {
      $.fn.resetSinglesender();
      if ('complete' in newOptions) { newOptions.complete(); };
    }
  });
};

Baked.prototype.domBlockById = function(blockId){
  return $('#bk-block-'+blockId);
};

Baked.prototype.showPageManager = function(){
  this.post('system/api_pages/html_manager', {
    ok: function(r){
      baked.showBox(r.html);
    }
  });
};

Baked.prototype.savePageManager = function(callbacks){
  var self = this;

  $form = $('#bk-page-manager-form');
  var params = baked.params($form);

  this.post('system/api_pages/update_all', {
    data: params,
    ok: function(r){
      self.reloadDynamic();
      if (callbacks && callbacks.ok) callbacks.ok(r);
    },
    complete: function(){
    }
  });
};

Baked.prototype.alignPageManager = function(){
  var beforeDepth = -1;
  var order = 0;
  $('#bk-page-manager > li').each(function(){
    $li = $(this);
    $li.removeClass('bk-bottom-page');
    $li.removeClass('bk-home');
    var hidden = parseInt($li.attr('data-bk-hidden'));
    var depth = parseInt($li.attr('data-bk-depth'));
    var name = $li.find('input.name').val();
    newDepth = depth;

    if (newDepth > beforeDepth+1) newDepth = beforeDepth+1;
    if (beforeDepth == -1
      || newDepth > beforeDepth
      || newDepth == 2
    ) {
      $li.addClass('bk-bottom-page');
    }

    beforeDepth = newDepth;

    if (depth != newDepth) {
      $li.attr('data-bk-depth', newDepth);
    }

    if (newDepth == 0 && name == 'index') {
      $li.addClass('bk-home');
    }

    $li.attr('data-bk-name', name);
    $li.find('input.order').val(order);
    $li.find('input.depth').val(newDepth);
    $li.find('input.hidden').val(hidden);
    order++;
  });
};

Baked.prototype.insertPage = function(params, callbacks){
  var self = this;

  this.post('system/api_pages/insert', {
    data: params,
    ok: function(r){
      if (callbacks && callbacks.ok) callbacks.ok(r);
      self.reloadDynamic();
    },
    complete: function(){
      if (callbacks && callbacks.complete) callbacks.complete();
    }
  });
};

Baked.prototype.deletePage = function(opts){
  var self = this;

  this.post('system/api_pages/delete', opts);
};

/**
 * Add the block.
 *
 * @param int pageId
 * @param string sheet
 * @param string package
 * @param int beforeBlockId
 */
Baked.prototype.addBlock = function(pageId, sheet, package, beforeBlockId){
  var self = this;

  this.post('system/api_blocks/add', {
    data: {
      'page_id': pageId,
      sheet: sheet,
      package: package,
      'before_block_id': beforeBlockId
    },
    ok: function(r){
      if (beforeBlockId != 0) {
        $beforeBlock = self.domBlockById(beforeBlockId);
        $beforeBlock.before(r.html);
      } else {
        $('#bk-sheet-'+sheet+' > .bk-blocks').append(r.html);
      }
    }
  });
};

/**
 * Load block html.
 *
 * @param {Object} blockId
 */
Baked.prototype.loadBlock = function(blockId, callbacks){
  var self = this;

  this.post('system/api_blocks/html_block', {
    data: {
      'block_id': blockId
    },
    ok: function(r){
      if (callbacks && callbacks.ok) callbacks.ok(r);
    }
  });
};

Baked.prototype.setupCkeditor = function(){
  $('.ckeditor-textarea').bkCkeditor();
};

Baked.prototype.sortableBlocks = function(){
  var self = this;
  $('.bk-blocks').sortable({
    zIndex: 2000,
    handle: 'a.bk-block-move-handle',
    connectWith: '.bk-blocks',
    revert: true,
    placeholder: 'bk-sortable-placeholder',
    tolerance: 'pointer',
    start: function () {
      $('.ckeditor-textarea').each(function () {
        $(this).ckeditorGet().destroy();
      });
    },
    stop: function(){
      self.setupCkeditor();
    },
    update: function(){
      self.saveSort();
    }
  });
  //$('.bk-sheet').disableSelection();
};

Baked.prototype.saveSort = function(){
  var self = this;
  clearTimeout(self.saveBlockSortTimer);
  self.saveBlockSortTimer = setTimeout(function(){
    var sortedIds = {};
    $('.bk-sheet').each(function(){
      var sheet = $(this).attr('data-bk-sheet');
      sortedIds[sheet] = [];
      $('.bk-block', this).each(function(){
        var blockId = $(this).attr('data-bk-block-id');
        sortedIds[sheet].push(blockId);
      });
    });
    self.post('system/api_blocks/save_sort', {
      data: {
        'page_id': this.pageId,
        'sorted_ids': sortedIds
      }
    });
  }, 500);
};

Baked.prototype.reloadDynamic = function(){
  $.ajax({
    url: location.href,
    type: 'get',
    dataType: 'html',
    success: function(r){
      var $body = $('body');
      var $html = $('<div>'+r+'</div>');
      $html.find('[data-bk-dynamic]').each(function(){
        var dynamic = $(this).attr('data-bk-dynamic');
        var selector = '[data-bk-dynamic='+dynamic+']';
        $body.find(selector).replaceWith(this);
      });
    }
  });
};

/**
 * Delete the block.
 *
 * @param {Object} blockId
 */
Baked.prototype.deleteBlock = function(blockId){
  var self = this;

  this.post('system/api_blocks/delete', {
    data: {
      'block_id': blockId
    },
    ok: function(r){
      $block = self.domBlockById(blockId);
      $block.slideUp('first', function(){
        $block.remove();
      });
    }
  });
};

// 編集エリアを表示
Baked.prototype.openEditor = function($block){
  this.closeAllEditor();
  $block.addClass('bk-open');

  var package = $block.attr('data-bk-block-package');
  if (this.events.opened[package]) {
    this.events.opened[package]($block.attr('data-bk-block-id'));
  }
};

// 編集エリアをToggle
Baked.prototype.toggleEditor = function($block){
  if ($block.hasClass('bk-open')) {
    this.closeAllEditor();
  } else {
    this.openEditor($block);
  }
};

// 全ての編集エリアを閉じる
Baked.prototype.closeAllEditor = function(){
  $('div.bk-block.bk-open').removeClass('bk-open');
};

// コメント投稿エリアを表示
Baked.prototype.showCommentEditorBox = function(entryId){
  var self = this;

  baked.post('system/api_comments/html_editor', {
    data: {
      'entry_id': entryId
    },
    dataType: 'html',
    success: function(r){
      self.showBox(r);
    }
  });
};

// コメントを送信
Baked.prototype.submitComment = function(params){
  var self = this;

  this.post('system/api_comments/send', {
    data: params,
    ok: function(r){
      self.showBox(r.html);
      baked.reloadDynamic();
    }
  });
};

Baked.prototype.busyFilter = function(){
  if (this.busy > 0) {
    return false;
  }
  if (!this.busy) this.busy = 0;
  this.busy++;
  $.fancybox.showLoading();
  return true;
};

Baked.prototype.busyEnd = function(){
  this.busy--;
  if (this.busy == 0) $.fancybox.hideLoading();
};

Baked.prototype.showLoading = function(){
  $.fancybox.showLoading();
};

Baked.prototype.hideLoading = function(){
  $.fancybox.hideLoading();
};



