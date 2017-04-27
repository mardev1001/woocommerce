	jQuery(document).ready(function($){
		$("h5.toggle a").click(function(e){
			e.preventDefault();
			if($(this).parent().parent().parent().attr("class").indexOf("accordion")==-1){
				$(this).parent().parent().find(".toggle-content").toggle(300);
				if($(this).find("span.arrow").html()=="+") $(this).find("span.arrow").html("-");
				else if($(this).find("span.arrow").html()=="-") $(this).find("span.arrow").html("+");
			}else{
				$(this).parent().parent().parent().find("h5.toggle.active").find("span.arrow").html("+");
				$(this).parent().parent().parent().find("h5.toggle.active").parent().find(".toggle-content").toggle(300);
				$(this).parent().parent().parent().find("h5.toggle.active").removeClass("active");
				$(this).parent().parent().find(".toggle-content").toggle(300);
			}
			if($(this).parent().attr("class").indexOf("active")==-1)
				$(this).parent().addClass("active");
			else
				$(this).parent().removeClass("active");
		});
		
		$(".accordion h5.toggle a").click(function(){
			$(this).parent().parent().find(".toggle-content").slideDown(300);
			if($(this).find("span.arrow").html()=="+") $(this).find("span.arrow").html("-");
			else if($(this).find("span.arrow").html()=="-") $(this).find("span.arrow").html("+");
		});
		
		$("div.hmslider-container").owlCarousel({
			navigation : true, // Show next and prev buttons
			slideSpeed : 300,
			paginationSpeed : 400,
			singleItem:true,
			transitionStyle:"fade",
			autoHeight:true,
			autoPlay:3000
		});
		if(window.template!="baby"){
			$("div.hmslider-container .item .caption").css("opacity",1);
		}
		$(".salert .close-alert").click(function(){
			$(".salert").fadeOut(500);
		});
		
		$.fn.count = function (start,end) {
			var container = $(this[0]).html(start);
			var count = setInterval(function () {
				if (++start && start<=end) {
					container.html(start);
				} else {
					clearInterval(count);
				}
			}, 50);
		
		};
		$(".display-percentage").each(function(){
			$(this).count(parseInt($(this).html()),parseInt($(this).attr("data-percentage")));
		});
		
		$(".hmbestseller ul.products li").addClass("item");
		$(".hmbestseller ul.products").owlCarousel({
			 items : $("#bestsellerpercolumn").val(),
			 navigation : true,
			 autoPlay:10000
		});

		$(".hmfeatured ul.products li").addClass("item");
		$(".hmfeatured ul.products").owlCarousel({
			 items : $("#featuredpercolumn").val(),
			 navigation : true,
			 autoPlay:10000
		});

		$("div.hmprodcats_slider ul.categories").owlCarousel({
			 items : $("#catspercolumn").val(),
			 navigation : true,
  			 autoPlay:10000
		});
		
		$(".testimonial_slider .testimonial").addClass("item");
		$(".testimonial_slider").owlCarousel({
			autoPlay : 6000,
			stopOnHover : true,
			navigation:false,
			paginationSpeed : 1000,
			goToFirstSpeed : 2000,
			singleItem : true,
			transitionStyle:"fade",
			autoHeight:true
		});
		
		var pricingcolumns=0;
		$(".pricingtable .column").each(function(){
			pricingcolumns++;
		});
		$(".pricingtable .column").css("width",(100/pricingcolumns-1)+"%");
		
		$('.hmparallax').each(function(){
			var url = $(this).data("bgimage");
			var speed = parseFloat($(this).data("speed"));
			if(url.trim() != '') {
				$(this).css("background", "url('" + url + "') no-repeat fixed");
				$(this).css("background-size", "cover !important");
				$(this).parallax('100%', speed);
			}
		});

		$('.hmcircle.bgimg').each(function(){
			var url = $(this).data("bgimg");
			$(this).css("background", "url('" + url + "') no-repeat");
			$(this).css("background-size", "cover");
		});
		$(".hmcircle").each(function(){
			$(this).height($(this).width());
		});
	});