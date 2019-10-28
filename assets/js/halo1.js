(function($){
	'user strict';
	$(function(){
		new WOW().init();

		const xs = window.matchMedia( "(max-width: 767px)" );
		const sm = window.matchMedia( "(min-width: 768px) and (max-width: 991px)");
		const md = window.matchMedia( "(min-width: 992px) and (max-width: 1198px)" );
		const lg = window.matchMedia( "(min-width: 1199px)" );
		var menu = $('.header_menu_outer_container');
		var trigger = $('.header_menu_trigger');


		$('.datepicker').on('click', function(e) {
			e.preventDefault();
			$(this).attr("autocomplete", "off");
		});

		$.each($('input[type="date"],.datepicker'),function(index, value) {
			new Pikaday({
				field: value ,
				format: 'DD/MM/YYYY',
				minDate: moment().toDate()
			});
		});

		checkHeaderMenu();

		$(window).scroll(function()
		{
			checkHeaderMenu();
		});

		$(window).resize(function()
		{
			checkHeaderMenu();
		});


		function checkHeaderMenu()
		{
			if(!menu.length) return;
			if(md.matches || lg.matches){
				var screen_top = $(window).scrollTop() ;
				if(screen_top > trigger.offset().top){
					if(!menu.hasClass('fixed')){
						menu.css('margin-top',0);
						trigger.css('margin-top',menu.outerHeight(true));
						menu.addClass('fixed');
						menu.css('top',0+$('#wpadminbar').height());
						menu.css({'left':$('body').offset().left,'right':$('body').offset().left}); // fix for very large screen
					}
				} else {
					menu.css('top','-50px');
					menu.css('margin-top',0);
					menu.removeClass('fixed');
					trigger.css('margin-top','');
				}
			} else {
				menu.css('top','-50px');
				menu.removeClass('fixed');
				trigger.css('margin-top','');
			}
		}


		$('a[href^="#"]').on('click',function (e) {
		    e.preventDefault();

		    var target = this.hash;
		    var $target = $(target);
		    var extra = 0;

			var scroll = $target.offset().top;

			if(menu.length && (md.matches || lg.matches))
			{
				//extra = menu.outerHeight(true);
			}

		    $('html, body').stop().animate({
		        'scrollTop': scroll
		    }, 900, 'swing', function () {
		        window.location.hash = target;
		    });
		});

		$('div.post_content').magnificPopup({
            delegate: 'a.popup-image, .attachment a ',
            type: 'image'
    });

    $('.halo1-gallery a').magnificPopup({
				type:'image',
				gallery:{
		    	enabled:true
				}
		});





  	});
})(jQuery);
