jQuery(document).ready(function($){
	$(".related-post ul").owlCarousel({
         items : 3,
		 navigation : true,
		 autoPlay : 3000
    });
	$("div.hmslider-post").owlCarousel({
		navigation : true, // Show next and prev buttons
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		transitionStyle:"fade",
		autoPlay:3000
	});
	$("div.hmslider-post .item").hover(function(){
		$(this).find(".caption").fadeIn(200);
	},function(){
		$(this).find(".caption").fadeOut(200);
	});
});