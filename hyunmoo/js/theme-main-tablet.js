jQuery(document).ready(function($){

//	$('select').select2();
	
	var ij=0,ic=0;
	var aniflag=1,aniflag1=1;
	var searchclick=0; var ppos;
	
//Common interface section
	$("img").addClass("img-responsive");
	$("input[type='text']").addClass("form-control");
	$("#coupon_code").addClass("form-control");
	$("input[type='email']").addClass("form-control");
	$("input[type='password']").addClass("form-control");
	$("input[type='submit']").each(function(index, element) {
		$(this).addClass("btn").addClass("btn-primary");
		if(!$(this).hasClass("skin-secondary"))
			$(this).addClass("skin-primary");
	});
	$("input[type='button']").each(function(index, element) {
		$(this).addClass("btn").addClass("btn-primary");
		if(!$(this).hasClass("skin-secondary"))
			$(this).addClass("skin-primary");
	});
	$("button").each(function(index, element) {
		$(this).addClass("btn").addClass("btn-primary");
		if(!$(this).hasClass("skin-secondary") && !$(this).hasClass("sbutton"))
			$(this).addClass("skin-primary");
	});
	$('.skin-secondary').removeClass('btn').removeClass('btn-primary');
	$("div#content a").each(function(index,element) {
		if(!$(this).hasClass("skin-secondary-text") && !$(this).hasClass("skin-primary") && !$(this).hasClass("skin-secondary")) {
			$(this).addClass("skin-primary-text");
		}
	});
	$(".searchbut").removeClass("btn");
	$(".searchbut").removeClass("btn-primary");
	$("textarea").addClass("form-control");
	
	$(".menu").addClass("navbar");$(".menu").addClass("navbar-fixed-top");
	$(".menu ul").addClass("nav");$(".menu ul li").addClass("navli");$(".menu ul").addClass("navbar-nav");
	$(".menu ul ul").removeClass("nav");$(".menu ul li li").removeClass("navli");$(".menu ul ul").removeClass("navbar-nav");
	$(".menu").append("<div class='container'>");
	$(".menu .container").append("<div class='navbar-header'>");
	$(".menu .container .navbar-header").append("<button data-target='.navbar-collapse' data-toggle='collapse' class='navbar-toggle collapsed' type='button'><span class='icon-bar'></span><span class='icon-bar'></span><span class='icon-bar'></span></button>");
	$(".menu .container .navbar-header").append("<i class='fa fa-search' id='searchclick'>");
	$(".menu .container .navbar-header").append("<div id='search-form1'>");
	$(".menu").append($("#logo").detach());
	if($(window).width()<500){
		$(".mainpart").append($("form#searchformm1").detach());
		if(window.adminbar == "disable"){
			if(searchclick==1)
				$(".menu").css("top",30);
			else
				$(".menu").css("top",0);
		}else{
			if(searchclick==1)
				$(".menu").css("top",58);
			else
				$(".menu").css("top",28);
		}
	}else{
		if(window.adminbar == "disable"){
			$(".menu").css("top",0);
		}else{
			$(".menu").css("top",28);
		}
		$(".menu .container .navbar-header #search-form1").append($("form#searchformm1").detach());
	}
	$(".menu .container").append("<div class='navbar-collapse collapse'>");
	$(".menu .container .navbar-collapse").append($("#searchformandcart").detach());
	$(".menu .container .navbar-collapse").append("<div class='navmenu'>");
	$(".menu .container .navbar-collapse .navmenu").append("<div class='navmainmenu'>");
	$(".menu .container .navbar-collapse .navmainmenu").append($(".menu ul.nav").detach());
	$(".menu .container .navbar-collapse .navmenu").append("<div id='leftnavarrow' class='navarrow'>&laquo;</div>");
	$(".menu .container .navbar-collapse .navmenu").append("<div id='rightnavarrow' class='navarrow'>&raquo;</div>");
	$(".menu ul.nav li ul.sub-menu li").find("ul.sub-menu").wrap("<div class='submenuparent'>");
	$(".navmenu ul.nav li").each(function(){
		if($(this).find("ul.sub-menu").length>0)
			$(this).children("a").attr("href","#");
	});
	var menuwidth=0;
	var nitem=0;
	$(".navmenu ul.nav li.navli").each(function(){
		menuwidth+=$(this).width();
		nitem++;
	});
	var menuwidthset=$(window).width()-$("#logo").width()-$("#searchformandcart").width()-150;
	var ji=0;
	$(".menu ul.nav li.navli").each(function(){
		ji+=$(this).width();
		if(ji>menuwidthset)
			$(this).hide();
		else
			$(this).show();
	});
	$(".navmenu").width(menuwidthset);
	if($(".navmenu ul.nav").width()>=menuwidth){
		$(".navarrow").hide();	
	}else{
		$(".navarrow").show();	
	}
	$(window).focus(function(){
		if($(".navmenu ul.nav").width()>=menuwidth){
			$(".navarrow").hide();	
		}else{
			$(".navarrow").show();	
		}
	});
	$(window).resize(function(){
		menuwidthset=$(window).width()-$("#logo").width()-$("#searchformandcart").width()-150;
		$(".navmenu ul.nav li a").css("border-left","none");
		$(".navmenu").width(menuwidthset);
		$(".navmainmenu").width(menuwidthset);
		menuwidth=0;
		$(".navmenu ul.nav li.navli").each(function(){
			menuwidth+=$(this).width();
		});
		if(menuwidthset>=menuwidth){
			$(".navarrow").hide();	
		}else{
			$(".navarrow").show();	
		}
		
		ij=0;ji=1;var jji=0;ic=0;
		$(".menu ul.nav li.navli").each(function(){
			ji+=$(this).width();
			if(ji>menuwidthset)
				$(this).hide();
			else{
				jji++;
				$(this).show();
				$(this).parent().css("marginLeft",0);
				if(jji==1){
					$(this).find("a").css("border-left","1px solid #343944");
					$(this).find("sub-menu").find("a").css("border","none");
				}
			}
		});
		searchclick=0;
		$("#search-form1").hide();
		$(".navmenu ul.nav li").has("ul.sub-menu").children("a").children("i").remove();
		$(".navmenu ul.nav li").has("ul.sub-menu").children("a").removeAttr("disabled");
		$(".navmenu ul.nav li").removeClass("open1");
		$(".navmenu ul.sub-menu").hide();
		if($(this).width()<500){
			$(".mainpart").append($("form#searchformm1").detach());
			if(window.adminbar == "disable"){
				if(searchclick==1)
					$(".menu").css("top",30);
				else
					$(".menu").css("top",0);
			}else{
				if(searchclick==1)
					$(".menu").css("top",58);
				else
					$(".menu").css("top",28);
			}
		}else{
			if(window.adminbar == "disable"){
				$(".menu").css("top",0);
			}else{
				$(".menu").css("top",28);
			}
			$(".menu .container .navbar-header #search-form1").append($("form#searchformm1").detach());
		}
	});
	$(".navmenu #rightnavarrow").click(function(e){
		if(aniflag==1 && $(".navmenu ul.nav").width()<menuwidth){
			if(ic>(menuwidth-menuwidth%menuwidthset)/menuwidthset-1)
				return false;
			else{
				ic++;
				$(".navmenu ul.nav").css("marginLeft",-ij);
				if(ic==(menuwidth-menuwidth%menuwidthset)/menuwidthset){
					var icc=menuwidth; var icc1=0,icc2=0;
					$(".navmenu ul.nav li.navli").each(function(){
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
					ij+=$(".navmenu ul.nav").width();
				}
				$(".navmenu ul.nav li").removeClass("open1");
				$(".navmenu ul.nav li").find("ul.sub-menu").hide();
				$(".navmenu ul.nav li a").removeClass("active");
				$(".navmenu").width(menuwidthset);
				$(".navmainmenu").width(menuwidthset);
				$(".navmainmenu").height(43);
				$(".navmenu ul.nav").css("position","absolute");
				$(".navmainmenu").css("overflow","hidden");
				$(".navmenu ul.nav li").show();
				$(".navmenu ul.nav li a").css("border-left","none");
				$(".navmenu ul.nav").animate({marginLeft:-ij},1000,function(){
					aniflag=1;
					var ijj=0,ijj1=0;
					$(".menu ul.nav li.navli").each(function(){
						ijj+=$(this).width();
						if(ijj-ij<=nitem || ijj-ij>=menuwidthset-nitem)
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
					$(".navmainmenu").css("overflow","visible");
					$(".navmainmenu").width(menuwidthset);
					$(".navmenu").width(menuwidthset);
					$(".navmainmenu").css("height","auto");
					$(".navmenu ul.nav").css("position","relative");
				});	
				aniflag=0;
			}
		}
	});
	$(".navmenu #leftnavarrow").click(function(){
		var ij1,ij2;
		if(aniflag1==1 && $(".navmenu ul.nav").width()<menuwidth){
			if(ic<1)
				return false;
			else{
				ic--;
				$(".navmenu ul.nav").css("marginLeft",-ij);
				if(ic==0){
					var icc=0,icc1=0,icc2;
					$(".menu ul.nav li.navli").each(function(){
						icc+=$(this).width();
						if(!$(this).attr("style"))
							icc2="";
						else
							icc2=$(this).attr("style");
						if((icc<menuwidthset) && (icc2.indexOf("display: none")==-1))
							icc1+=$(this).width();
					});
					ij1=ij-$(".navmenu ul.nav").width()+icc1;
				}else
					ij1=ij-$(".navmenu ul.nav").width();
				$(".navmenu ul.nav li").removeClass("open1");
				$(".navmenu ul.nav li").find("ul.sub-menu").hide();
				$(".navmenu ul.nav li a").removeClass("active");
				$(".navmenu").width(menuwidthset);
				$(".navmainmenu").width(menuwidthset);
				$(".navmainmenu").height(43);
				$(".navmenu ul.nav").css("position","absolute");
				$(".navmainmenu").css("overflow","hidden");
				$(".navmenu ul.nav li").show();
				$(".navmenu ul.nav li a").css("border-left","none");
				$(".navmenu ul.nav").animate({marginLeft:-ij1},1000,function(){
					aniflag1=1;
					var ijj=0,ijj1=0;
					if(ic==0){
						$(".menu ul.nav li").each(function(){
							if($(this).parent().attr("class").indexOf("nav")!=-1){
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
						$(".menu ul.nav li").each(function(){
							if($(this).parent().attr("class").indexOf("nav")!=-1){
								if(ij-ijj<=nitem || ij-ijj>=menuwidthset-nitem){
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
						ij-=$(".navmenu ul.nav").width();
					$(this).css("marginLeft",0);
					$(".navmainmenu").css("overflow","visible");
					$(".navmenu").width(menuwidthset);
					$(".navmainmenu").width(menuwidthset);
					$(".navmainmenu").css("height","auto");
					$(".navmenu ul.nav").css("position","relative");
				});
				aniflag1=0;	
			}
		}
	});
	$(".menu ul.nav li a").click(function(){
		if($(this).parent().attr("class").indexOf("open1")==-1){
			if($(this).parent().parent().attr("class").indexOf("sub-menu")==-1){
				$(".menu ul.nav li").removeClass("open1");
				$(".menu ul.nav li a").removeClass("active");
				$(".menu ul.nav li").find("ul.sub-menu").hide();
			}else{
				$(this).parent().parent().find("li").removeClass("open1");
				$(this).parent().parent().find("li").children("a").removeClass("active");
				$(this).parent().parent().find("li").find("ul.sub-menu").hide();
			}
			$(this).parent().addClass("open1");
			$(this).parent().find("ul.sub-menu").slideDown(400);
			$(this).parent().find("ul.sub-menu").find("ul.sub-menu").hide();
			$(this).addClass("active");
		}else{
			$(this).parent().removeClass("open1");
			$(this).parent().find("ul.sub-menu").slideUp(400);
			$(this).removeClass("active");
		}
	});
//He cart section
	var browsername=navigator.userAgent;
	if(browsername.indexOf('Firefox')==-1){
		$(".menu ul.nav li a").css("paddingBottom",14);
		if(browsername.indexOf("MSIE")!=-1){
			$(".menu ul.nav li a").css("paddingBottom",15);
		}
	}
	var cclick=0;
	$(".cart_heading").click(function(e){
		e.preventDefault();
		e.stopPropagation();
		cclick++;
		if(cclick % 2 == 1){
			$(".cart_content").slideDown();
			$(this).addClass("active");
		}else{
			$(".cart_content").slideUp();
			$(this).removeClass("active");
		}
	});
	$(document).click(function(e){
		if($(".cart_heading").attr("class").indexOf("active")!=-1){
			cclick++;
			$(".cart_content").slideUp();
			$(".cart_heading").removeClass("active");
		}
	});
	$(".cart_content").click(function(e){
		e.stopPropagation();
	});
	$(".cart_content table tbody tr").hover(function(){
		$(this).find("a.remove").show();
	},function(){
		$(this).find("a.remove").hide();
	});
//CotUs section
	$("#contactusform #formcontent").hide();
	var ci=0;
	$(".searchbut").hover(function(){
		$(this).addClass("hover");
	},function(){
		$(this).removeClass("hover");
	});
	$("#contactusform #formheading").click(function(){
		ci++;
		if(ci %2==1){
			$("#contactusform #formcontent").show();
			$("#contactusform .arrow").addClass("active");
		}else{
			$("#contactusform #formcontent").hide();
			$("#contactusform .arrow").removeClass("active");
		}
	});
//Resive search form section
	$("#searchclick").click(function(){
		searchclick++;
		if(searchclick==1){
			if($(window).width()>500)
				$("#search-form1").show("slide",{direction: "right" }, 1000);
			else{
				$("#search-form1").slideDown(400);
				if(window.adminbar == "disable")
					$(".menu").animate({top:30},400);
				else
					$(".menu").animate({top:58},400);
			}
		}else if(searchclick==2){
			if($(window).width()>500){
				$("#search-form1").hide("slide",{direction: "right" }, 1000);
			}else{
				$("#search-form1").slideUp(400);
				if(window.adminbar == "disable")
					$(".menu").animate({top:0},400);
				else
					$(".menu").animate({top:28},400);
			}
			searchclick=0;
		}
	});
	
	$(window).scroll(function(){
		if($(this).scrollTop()==0)
			$("#scroll-to-top").fadeOut(300);
		else
			$("#scroll-to-top").fadeIn(300);
	});
	$("#scroll-to-top").click(function(){
		$("html,body").animate({scrollTop:0});
	});
	var scb=0;
	$("#cartshippingcalculator a").click(function(){
		scb++;
		if(scb%2==1)
			$(this).find("span").html("&uarr;");
		else 
			$(this).find("span").html("&darr;");
	});
	
	$("ul.woocommerce-error li").addClass("alert");
	$("ul.woocommerce-error li").addClass("alert-danger");

//	$(".widget select").select2();
	
});