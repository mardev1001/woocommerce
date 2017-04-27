jQuery(document).ready(function($) {

	// Tabs
	$('.woocommerce-tabs .panel').hide();

	$('.woocommerce-tabs ul.tabs li a').click(function(){

		var $tab = $(this);
		var $tabs_wrapper = $tab.closest('.woocommerce-tabs');

		$('ul.tabs li', $tabs_wrapper).removeClass('active');
		$('div.panel', $tabs_wrapper).hide();
		$('div' + $tab.attr('href')).show();
		$tab.parent().addClass('active');

		return false;
	});

	$('.woocommerce-tabs').each(function() {
		var hash = window.location.hash;
		if (hash.toLowerCase().indexOf("comment-") >= 0) {
			$('ul.tabs li.reviews_tab a', $(this)).click();
		} else {
			$('ul.tabs li:first a', $(this)).click();
		}
	});

	// Star ratings for comments

	$("p.stars").remove();
	$('#rating').hide().before('<p class="stars"><span><a class="star-1 skin-primary-text" href="#" rate="1"></a><a class="star-2 skin-primary-text" href="#" rate="2"></a><a class="star-3 skin-primary-text" href="#" rate="3"></a><a class="star-4 skin-primary-text" href="#" rate="4"></a><a class="star-5 skin-primary-text" href="#" rate="5"></a></span></p>');

	$("#respond p.stars a").mouseover(function(){
		var rate= parseInt($(this).attr("rate"));
		$("#respond p.stars a").removeClass("active1");
		$("#respond p.stars a").removeClass("active");
		$("#respond p.stars a").each(function(){
			if(parseInt($(this).attr("rate"))<=rate)
				$(this).addClass("hover");
			else
				$(this).removeClass("hover");
		});
	});
	$("#respond p.stars a").mouseleave(function(){
		$("#respond p.stars a").removeClass("hover");
	});
	$('body')
		.on( 'click', '#respond p.stars a', function(){
			var $star   = $(this);
			var $rating = $(this).closest('#respond').find('#rating');

			$rating.val( $star.attr("rate") );
			$("#respond p.stars a").each(function(){
				if(parseInt($(this).attr("rate"))<parseInt($star.attr("rate")))
					$(this).addClass("active1");
				else
					$(this).removeClass("active1");
			});
			$(this).addClass("active");
			return false;
		})
		.on( 'click', '#respond #submit', function(){
			var $rating = $(this).closest('#respond').find('#rating');
			var rating  = $rating.val();

			if ( $rating.size() > 0 && ! rating && woocommerce_params.review_rating_required == 'yes' ) {
				alert(woocommerce_params.i18n_required_rating_text);
				return false;
			}
		});

	// prevent double form submission
	$('form.cart').submit(function(){
		$(this).find(':submit').attr( 'disabled','disabled' );
	});

});