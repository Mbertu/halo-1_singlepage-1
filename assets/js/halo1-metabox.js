(function($){
	'user strict';
	$(function(){
		$('.field_after_title').focusin(function(){
			$(this).parent().find('label').addClass('screen-reader-text');
		});
		$('.field_after_title').focusout(function(){
			var current_subtitle = $(this).val();
			if(current_subtitle == '')
				$(this).parent().find('label').removeClass('screen-reader-text');
		});
        return;
    });
})(jQuery);