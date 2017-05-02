jQuery(document).ready(function($){

//	$('select').select2();
	
	var ij=0,menucollpased,ic=0;
	var aniflag=1,aniflag1=1;
	var searchclick=0; var ppos;
	
//Common interface section
	$("img").addClass("img-responsive");
	$("input[type='text']").addClass("form-control");
	$("#coupon_code").addClass("form-control");
	$("input[type='email']").addClass("form-control");
	$("input[type='password']").addClass("form-control");
	$(".searchbut").removeClass("btn");
	$(".searchbut").removeClass("btn-primary");
	$("textarea").addClass("form-control");
	
	$("input[type='submit']").each(function(index, element) {
		$(this).addClass("btn").addClass("btn-primary");
	});
	$("input[type='button']").each(function(index, element) {
		$(this).addClass("btn").addClass("btn-primary");
	});
	$("button").each(function(index, element) {
		$(this).addClass("btn").addClass("btn-primary");
	});
	
	var popupStatus = 0; $(".mainmenu").hide();
	var menuwidthset;
	$(".mainmenu").append("<div id='leftnavarrow' class='navarrow'>&laquo;</div>");
	$(".mainmenu").append("<div id='rightnavarrow' class='navarrow'>&raquo;</div>");
	$(".mainmenu").append("<div class='nav2'></div>");
	$(".mainmenu ul").addClass("nav1");
	$(".mainmenu ul ul").removeClass("nav1");
	$(".mainmenu ul li").addClass("navli");
	$(".mainmenu ul li li").removeClass("navli");
	$(".mainmenu .nav2").append($(".mainmenu ul.nav1").detach());
	var menuwidth=0,menuflag=0;
	$(".mainmenu ul.nav1 li").has("ul.sub-menu").children("a").attr("href","#");
	$("#menuicon").click(function(){
		menuflag++;
		if(menuflag % 2==1){
			$(".mainmenu").show();
		//	$("#logo").css("float","left");
			$("#logo").hide();
			menuwidthset=$(window).width()-55;
			$(".mainmenu").width(menuwidthset);
			$(".nav2").width(menuwidthset);
			ij=0; menuwidth=0;
			$(".mainmenu ul.nav1 li").each(function(){
				menuwidth+=$(this).width();
			});
			$(".mainmenu ul.nav1 li:first-child a").css("border-left","1px solid #343c4b");
			var ji=0;
			$(".mainmenu ul.nav1 li").each(function(){
				ji+=$(this).width();
				if(ji>menuwidthset)
					$(this).hide();
				else
					$(this).show();
			});
			if($(".mainmenu ul.nav1").width()>=menuwidth){
				$(".navarrow").hide();	
			}else{
				$(".navarrow").show();	
			}
		}else{
			$(".mainmenu").hide();
		//	$("#logo").css("float","none");
			$("#logo").show();
		}
	});
	$(window).resize(function(){
		$(".popupdialog").each(function(){
			ppos=($(window).height()-$(this).height())/2;
			$(this).css("bottom",ppos);
		});
		if($(window).height()>$(window).width()){
			ppos=$(window).height()-140;
			$("#searchresultbox").css("top",140);
		}else{
			ppos=$(window).height()-100;
			$("#searchresultbox").css("top",100);
		}
		$("#searchpopup").css("bottom",ppos);
		if(menuflag % 2==1){
			$(".mainmenu").show();
			$("#logo").css("float","left");
			menuwidthset=$(window).width()-55;
			$(".mainmenu").width(menuwidthset);
			$(".nav2").width(menuwidthset);
			ij=0; menuwidth=0;ic=0;
			$(".mainmenu ul.nav1 li").each(function(){
				menuwidth+=$(this).width();
				$(this).removeClass("opened");
				$(this).children("a").removeClass("active");
				$(this).find("ul.sub-menu").hide();
			});
			$(".mainmenu ul.nav1 li:first-child a").css("border-left","1px solid #343c4b");
			var ji=0;
			$(".mainmenu ul.nav1 li").each(function(){
				ji+=$(this).width();
				if(ji>menuwidthset)
					$(this).hide();
				else
					$(this).show();
			});
			if($(".mainmenu ul.nav1").width()>=menuwidth){
				$(".navarrow").hide();	
			}else{
				$(".navarrow").show();	
			}
		}else{
			$(".mainmenu").hide();
			$("#logo").css("float","none");
		}
	});
	$(".mainmenu #rightnavarrow").click(function(){
		if(aniflag==1 && $(".mainmenu ul.nav1").width()<menuwidth){
			if(ic>(menuwidth-menuwidth%menuwidthset)/menuwidthset-1)
				return false;
			else{
				ic++;
				$(".mainmenu ul.nav1 li").removeClass("opened");
				$(".mainmenu ul.nav1 li").children("a").removeClass("active");
				$(".mainmenu ul.nav1 li").find("ul.sub-menu").hide();
				$(".mainmenu ul.nav1").css("marginLeft",-ij);
				if(ic==(menuwidth-menuwidth%menuwidthset)/menuwidthset){
					var icc=menuwidth; var icc1=0,icc2=0;
					$(".mainmenu ul.nav1 li.navli").each(function(){
						icc-=$(this).width();
						if(icc>=menuwidthset){
							icc1+=$(this).width();
						}else{
							icc2++;
							if(icc2==1){
								icc1+=$(this).width();
							}
						}
					});
					ij=icc1;
				}else{
					ij+=$(".mainmenu ul.nav1").width();
				}
				$(".mainmenu").width(menuwidthset);
				$(".nav2").width(menuwidthset);
				$(".nav2").height(43);
				$(".mainmenu ul.nav1").css("position","absolute");
				$(".nav2").css("overflow","hidden");
				$(".mainmenu ul.nav1 li").show();
				$(".mainmenu ul.nav1 li a").css("border-left","none");
				$(".mainmenu ul.nav1").animate({marginLeft:-ij},1000,function(){
					aniflag=1;
					var ijj=0,ijj1=0;
					$(".mainmenu ul.nav1 li").each(function(){
						ijj+=$(this).width();
						if(ijj-ij<=(menuwidth-menuwidth%menuwidthset)/menuwidthset || ijj-ij>=menuwidthset-(menuwidth-menuwidth%menuwidthset)/menuwidthset)
							$(this).hide(); 
						else{
							ijj1++;
							$(this).show();
							if(ijj1==1){
								$(this).find("a").css("border-left","1px solid #343944");
								$(this).find("sub-menu").find("a").css("border","none");
							}
						}
					});
					$(this).css("marginLeft",0);
					$(".nav2").css("overflow","visible");
					$(".nav2").width(menuwidthset);
					$(".mainmenu").width(menuwidthset);
					$(".nav2").css("height","auto");
					$(".mainmenu ul.nav1").css("position","relative");
				});	
				aniflag=0;
			}
		}
	});
	$(".mainmenu #leftnavarrow").click(function(){
		var ij1,ij2;
		if(aniflag1==1 && $(".mainmenu ul.nav1").width()<menuwidth){
			if(ic<1)
				return false;
			else{
				ic--;
				$(".mainmenu ul.nav1 li").removeClass("opened");
				$(".mainmenu ul.nav1 li").children("a").removeClass("active");
				$(".mainmenu ul.nav1 li").find("ul.sub-menu").hide();
				$(".mainmenu ul.nav1").css("marginLeft",-ij);
				if(ic==0){
					var icc=0,icc1=0,icc2;
					$(".mainmenu ul.nav1 li.navli").each(function(){
						icc+=$(this).width();
						if(!$(this).attr("style"))
							icc2="";
						else
							icc2=$(this).attr("style");
						if((icc<menuwidthset) && (icc2.indexOf("display: none")==-1))
							icc1+=$(this).width();
					});
					ij1=ij-$(".mainmenu ul.nav1").width()+icc1;
				}else
					ij1=ij-$(".mainmenu ul.nav1").width();
				$(".mainmenu").width(menuwidthset);
				$(".nav2").width(menuwidthset);
				$(".nav2").height(43);
				$(".mainmenu ul.nav1").css("position","absolute");
				$(".nav2").css("overflow","hidden");
				$(".mainmenu ul.nav1 li").show();
				$(".mainmenu ul.nav1 li a").css("border-left","none");
				$(".mainmenu ul.nav1").animate({marginLeft:-ij1},1000,function(){
					aniflag1=1;
					var ijj=0,ijj1=0;
					if(ic==0){
						$(".mainmenu ul.nav1 li").each(function(){
							if($(this).parent().attr("class").indexOf("nav1")!=-1){
								ijj+=$(this).width();
								if(ijj<menuwidthset){
									$(this).show();
									ijj1++;
									if(ijj1==1){
										$(this).find("a").css("border-left","1px solid #343944");
										$(this).find("sub-menu").find("a").css("border","none");
									}
								}else{
									$(this).hide();
								}
							}
						});
					}else{
						$(".menu ul.nav1 li").each(function(){
							if($(this).parent().attr("class").indexOf("nav1")!=-1){
								if(ij-ijj<=(menuwidth-menuwidth%menuwidthset)/menuwidthset || ij-ijj>=menuwidthset-(menuwidth-menuwidth%menuwidthset)/menuwidthset){
									$(this).hide();
								}else{
									ijj1++;
									$(this).show();
									if(ijj1==1){
										$(this).find("a").css("border-left","1px solid #343944");
										$(this).find("sub-menu").find("a").css("border","none");
									}
								}
								ijj+=$(this).width();
							}
						});
					}
					if(ic==0)
						ij=0;
					else
						ij-=$(".mainmenu ul.nav1").width();
					$(this).css("marginLeft",0);
					$(".nav2").css("overflow","visible");
					$(".nav2").width(menuwidthset);
					$(".mainmenu").width(menuwidthset);
					$(".nav2").css("height","auto");
					$(".mainmenu ul.nav1").css("position","relative");
				});
				aniflag1=0;
			}
		}
	});
	$(".mainmenu ul.nav1 li a").click(function(){
		if($(this).parent().attr("class").indexOf("opened")==-1){
			if($(this).parent().parent().attr("class").indexOf("sub-menu")==-1){
				$(".mainmenu ul.nav1 li").removeClass("opened");
				$(".mainmenu ul.nav1 li a").removeClass("active");
				$(".mainmenu ul.nav1 li").find("ul.sub-menu").hide();
			}
			$(this).parent().addClass("opened");
			$(this).parent().find("ul.sub-menu").show();
			$(this).parent().find("ul.sub-menu").find("ul.sub-menu").hide();
			$(this).addClass("active");
		}else{
			$(this).parent().removeClass("opened");
			$(this).parent().find("li").removeClass("opened");
			$(this).parent().find("ul.sub-menu").hide();
			$(this).removeClass("active");
			$(this).parent().find("li").children("a").removeClass("active");
		}
	});
	$("#searchicon").click(function(){
		if(popupStatus == 0){
			$("#searchpopup").show();
			$("#backgroundPopup").css("opacity",0.7);
			$("#backgroundPopup").css("z-index",1000);
			if($(window).height()>$(window).width()){
				ppos=$(window).height()-140;
				$("#searchresultbox").css("top",140);
			}else{
				ppos=$(window).height()-100;
				$("#searchresultbox").css("top",100);
			}
			$("#searchpopup").animate({bottom:ppos},200);
			popupStatus=1;
		}
	});
	$("#contacticon").click(function(){
		if(popupStatus == 0){
			$("#contactpopup").show();
			$("#backgroundPopup").css("opacity",0.7);
			$("#backgroundPopup").css("z-index",1000);
			ppos=($(window).height()-250)/2;
			$("#contactpopup").animate({bottom:ppos},200);
			
			$("#contactpopup #formheading").remove();
			$('#contactpopup #formcontent').slimScroll({
				height: '200px'
			});
			popupStatus=1;
		}
	});
	$("#filtericon").click(function(){
		if(popupStatus == 0){
			$("#filterpopup").show();
			$("#backgroundPopup").css("opacity",0.7);
			$("#backgroundPopup").css("z-index",1000);
			ppos=($(window).height()-250)/2;
			$("#filterpopup").animate({bottom:ppos},200);
			
			$("#filterpopup div.tool-title").remove();
			$("#filterpopup div.tool-content.style").remove();
			$("#filterpopup #pdt_display").parent().remove();
			$("#filterpopup select").select2();
			$('#filterpopup .tool-content').slimScroll({
				height: '220px'
			});
			popupStatus=1;
		}
	});
	
	$("#backgroundPopup").click(function() {
		if(popupStatus == 1) { 
			$(".popupdialog").hide();  
			$("#backgroundPopup").css("opacity",0);
			$("#backgroundPopup").css("z-index",-1);
			$(".popupdialog").css("bottom",-100);
			popupStatus = 0;
		}
	});
	$(".pclose").click(function(){
		if(popupStatus == 1) { 
			$(".popupdialog").hide();  
			$("#backgroundPopup").css("opacity",0);
			$("#backgroundPopup").css("z-index",0);
			$(".popupdialog").css("bottom",-100);
			popupStatus = 0;
		}
	});
		
});
jQuery(document).ready(function($) {
	$('#pdt_filter').click(function() {
		var category = '';
		$('select#pdt_subcats option:selected').each(function() {
			category += $(this).val() + ',';
		});
		category = category.slice(0,-1);
		window.pdt_cat = category;
		
		var tags = '';
		$('select#pdt_tags option:selected').each(function() {
			tags += $(this).val() + ',';
		});
		tags = tags.slice(0,-1);
		window.pdt_tag = tags;
		
		var prices = $('#price').val().split(';');
		
		window.atts.minPrice = prices[0];
		window.atts.maxPrice = prices[1];
		
		$('#toolbox select.shop_att_list').each(function() {
			var key = $(this).attr('id');
			var value = '';
			$(this).children('option:selected').each(function() {
				value += $(this).val() + ',';
			});
			value = value.slice(0,-1);
			window.atts[key] = value;
		});
		
		var display = $('select#pdt_display').val();
		$('body').trigger('pdt_display_change', [ 'classicview' ]);
		
		$('#filterpopup .pclose').trigger('click');
	});
});