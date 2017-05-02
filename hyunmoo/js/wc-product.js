jQuery(document).ready(function($){
	$('div#s2id_rating').hide();		//Rate select wrapper
	
	$(".related ul.products li").addClass("item");
	$(".related ul.products").owlCarousel({
		 autoPlay : 3000 ,
         items : 3,
		 navigation : true
    });
	
	if($("#template").val()=="baby"){
		var width1,height1;
		if($(window).width()>1030){
			width1=660;
			height1=660;
		}else{
			if($(window).width()>=600)
				width1=($(window).width()-30)*7/10-25;
			else{
				width1=$(window).width()-55;
				$("#singleproductdescriptionpart").append($(".singleproductrightpart .summary.productdescription").detach());
			}
			height1=width1;
		}
		var jqzoomfirsthtml=$(".singleproductimage .images").html();
		$("#jqzoomimagehref").val($(".singleproductimage .images a").attr("href"));
		$("#jqzoomimagesrc").val($(".singleproductimage .images img").attr("src"));
		$('.jqzoom').jqzoom({
			zoomType: 'innerzoom',
			zoomWidth:width1,
			zoomHeight:height1,
			preloadImages: false,
			alwaysOn:false
		});

		$(window).resize(function() {
			$(".zoomWrapper").css("width",$(".singleproductimage img.wp-post-image").width());
			$(".zoomWrapperImage").css("height",$(".singleproductimage img.wp-post-image").height());
			$(".singleproductimage .images").html(jqzoomfirsthtml);
			$(".singleproductimage .images").find("a").attr("href",$("#jqzoomimagehref").val());
			$(".singleproductimage .images").find("img").attr("src",$("#jqzoomimagesrc").val());
			if($(this).width()>1030){
				width1=660;
				height1=660;
				$(".singleproductrightpart").append($(".summary.productdescription").detach());
			}else{
				if($(window).width()>=600){
					width1=($(window).width()-30)*7/10-25;
					$(".singleproductrightpart").append($(".summary.productdescription").detach());
				}else{
					width1=$(window).width()-55;
					$("#singleproductdescriptionpart").append($(".summary.productdescription").detach());
				}
				height1=width1;
			}
			$('.jqzoom').jqzoom({
				zoomType: 'innerzoom',
				zoomWidth:width1,
				zoomHeight:height1,
				preloadImages: false,
				alwaysOn:false
			});
		});
	}else{
		$(".thumbnails img").click(function(){
			var thumbdata=$.extend({}, eval("(" + $.trim($(this).parent().attr('rel')) + ")"));
			$(".singleproductimage .images a").attr("href",thumbdata.largeimage);
			$(".singleproductimage .images img").attr("src",thumbdata.smallimage);
		});
		$(".singleproductimage .thumbnails ul .owl-prev").html("&lsaquo;");
		$(".singleproductimage .thumbnails ul .owl-next").html("&rsaquo;");
	}
});