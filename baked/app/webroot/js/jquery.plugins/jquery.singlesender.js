(function($){
  var defaults = {
    selector: '[type=submit]',
    labeling: 'Loading',
    sentclass: 'singlesender-sent',
    originalLabelingAttr: 'data-original-labeling',
  };
  var options = {};

  var singlesend = function(e){
    $form = $(e.target);
    if ($form.hasClass(options.sentclass)) {
      e.preventDefault();
      return false;
    }
    $form.addClass(options.sentclass);
    //c($form.hasClass(options.sentclass));

    $(options.selector, $form).each(function(i,ele){
      $(ele).attr(options.originalLabelingAttr, $(ele).html());
      $(ele).html(options.labeling);
    });
    //$form.attr('onsubmit', 'event.returnValue = false; return false');
    return true;
  };

  $.fn.singlesender = function(config){
    options = $.extend(defaults, config);
    $(document).on('submit', this, singlesend);
    /*
    return this.each(function(i) {
      //$(this).on('submit', singlesend);
      $(document).on('submit', this, singlesend);
    });
    */
  };

  $.fn.resetSinglesender = function(){
    $('.'+defaults.sentclass).each(function(i,ele){
      $('[' + options.originalLabelingAttr + ']', $(this)).each(function(){
        $(this).html($(this).attr(options.originalLabelingAttr));
        $(this).removeAttr(options.originalLabelingAttr);
      });
      $(this).removeClass(defaults.sentclass);
    });
  };
})(jQuery);
