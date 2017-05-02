var productviewmode="gridview";
var sortmode="new";
var howmanyloaded = 0;
var prodsheight;
var productviewmodeselected;
var pagedisplaymode;
//Initialize global variables : Used in toolbox
window.pdt_cat = window.pdt_tag =  '';

jQuery(document).ready(function($){	
	$(".shopcontainer").addClass(productviewmode);
	var loadingflag=0;
	var howmany = 0;
	
	var ajaxurl=window.ajaxurl;
	pagedisplaymode=$("#pagedisplaymode").val();
	if(pagedisplaymode=="subcategories"){
		$("#productstopmenu").remove();
	}
	$(".shopcontainer ul.products").append("<div style='width:100%;margin-top:100px' align='center' id='loadingimage'><img src='" + window.loadimg + "'></div>");
	if(pagedisplaymode == 'subcategories') {
		$.ajax({
			type: "POST",
			url : ajaxurl,
			data : {
				action : 'get_categories',
				parent : $('input[type=hidden]#categoryid').val()
			},
			success : function(response) {
				var categories = $.parseJSON(response);
				$('#loadingimage').remove();
				$(".shopcontainer").removeClass(productviewmode);
				$(".shopcontainer").addClass("categoryview");
				var ii=0;
				$.each(categories, function(key,value) {
					ii++;
					$("ul.products").append("<li id='category"+ii+"' class='eachcategory'>");
					if(ii % 3 !=1)
						$("ul.products li#category"+ii).addClass("imageright");
					if(ii % 2 !=1)
						$("ul.products li#category"+ii).addClass("imageright1");
					$("ul.products li#category"+ii).append("<a href='"+value['link']+"'>");
					$("ul.products").append($("ul.products li#category"+ii));
					$("ul.products li#category"+ii+" a").append("<div class='prodimagecontainer' align='center' style='width:315px;background:#fff'>");
					$("ul.products li#category"+ii+" a div.prodimagecontainer").append(value['image']);
					var prodname=value['title'];
					if(prodname.length>15)
						prodname=prodname.substring(0,25)+"...";
					$("ul.products li#category"+ii+" a").append("<h3>"+prodname+" <span>("+value['count']+")</span></h3>");
				});
				if(pagedisplaymode=="subcategories"){
					if($(this).width()<335){
						$("ul.products li.eachcategory").each(function(){
							if($(this).find("img").length<=0)
								$(this).find(".prodimagecontainer").css("height",$(this).find(".prodimagecontainer").width());
							else
								$(this).find(".prodimagecontainer").css("height","auto");
						});
					}else{
						$("ul.products li.eachcategory").each(function(){
							if($(this).find("img").length<=0)
								$(this).find(".prodimagecontainer").css("height","315px");
							else
								$(this).find(".prodimagecontainer").css("height","auto");
						});
					}
				}
			}
		});
	}
	else if(pagedisplaymode=="" || pagedisplaymode=="both" || pagedisplaymode=="tags"){
		var query_cat = $("input[type=hidden]#categoryslug").val();
		if(window.pdt_cat != '')
			query_cat = window.pdt_cat;
		var query_tag = $("input[type=hidden]#tags").val()
		if(window.pdt_tag != '')
			query_tag = window.pdt_tag;
		if(productviewmode == 'classicview')
			howmany = 12;
		else if(productviewmode == 'gridview')
			howmany = 20;
		else if(productviewmode == 'compactview')
			howmany = 30;
		if(window.template=='mobile')
			howmany = 10;
		$.ajax({
			type: "POST",
			url : ajaxurl,
			data : {
				action : 'get_products',
				view : productviewmode,
				sort : sortmode,
				howmany: howmany,
				category: query_cat,
				tags: query_tag,
				atts: JSON.stringify(window.atts)
			},
			success : function(response) {
				howmanyloaded=howmany;
				productviewmodeselected=productviewmode;
				loadProducts(response);
				$(document).scrollTop(0);
			}
		});
	}
		
	$('body').on('pdt_display_change',function(event,display,sort){
		productviewmode=display;
		sortmode = sort;
		$(".shopcontainer").removeClass().addClass("shopcontainer");
		$(".shopcontainer").addClass(productviewmode);
		
		if(productviewmode!="compactview")
			$(".shopcontainer").css("width","auto");
		if($(this).attr("id")!=productviewmodeselected){
		$("ul.products").empty();
		$("ul.products").append("<div style='width:100%;margin-top:100px' align='center' id='loadingimage'><img src='" + window.loadimg + "'></div>");
		
		var query_cat = $("input[type=hidden]#categoryslug").val();
		if(window.pdt_cat != '')
			query_cat = window.pdt_cat;
		var query_tag = $("input[type=hidden]#tags").val()
		if(window.pdt_tag != '')
			query_tag = window.pdt_tag;
		if(productviewmode == 'classicview')
			howmany = 12;
		else if(productviewmode == 'gridview')
			howmany = 20;
		else if(productviewmode == 'compactview')
			howmany = 40;
		
		$.ajax({
			type: "POST",
			url : ajaxurl,
			data : {
				action : 'get_products',
				view : productviewmode,
				sort : sortmode,
				howmany: howmany,
				category: query_cat,
				tags: query_tag,
				atts: JSON.stringify(window.atts)
			},
			success : function(response) {
				$("ul.products").removeAttr("style");
				howmanyloaded=howmany;
				productviewmodeselected=productviewmode;
				if(productviewmode=="compactview"){
					$("ul.products").append("<div id='compactcolumn1' class='compactcolumn'>");
					$("ul.products").append("<div id='compactcolumn2' class='compactcolumn'>");
					$("ul.products").append("<div id='compactcolumn3' class='compactcolumn'>");
					$("ul.products").append("<div id='compactcolumn4' class='compactcolumn'>");
					$("ul.products").append("<div class='clear'>");
				}
				loadProducts(response);
			}
		});
		}
	});
	
	$(window).scroll(function(){
		if($(document).height()-$(this).scrollTop()==$(window).height()){
		//	var offset=$("ul.products li").size();
			var offset = window.offset_shop;
			loadingflag++;
			$("ul.products .clear").remove();
			if(parseInt($("ul.products li").length)!=howmanyloaded)
				loadingflag=0;
			
			if(loadingflag==1 && parseInt($("ul.products li").length)==howmanyloaded){
				$("ul.products").append("<div style='width:100%;margin-top:-100px' align='center' id='loadingimage'><img src='" + window.loadimg + "'></div>");
				
				var query_cat = $("input[type=hidden]#categoryslug").val();
				if(window.pdt_cat != '')
					query_cat = window.pdt_cat;
				var query_tag = $("input[type=hidden]#tags").val()
				if(window.pdt_tag != '')
					query_tag = window.pdt_tag;
				$.ajax({
					type: "POST",
					url : ajaxurl,
					data : {
						action : 'get_products',
						view : productviewmode,
						sort : sortmode,
						offset: offset,
						howmany: 12,
						category: query_cat,
						tags: query_tag,
						atts: JSON.stringify(window.atts)
					},
					success : function(response) {
						loadingflag=0;
						howmanyloaded+=12;
						loadProducts(response);
					}
				});
			}
		}
	});
});
jQuery(document).ready(function($) {
	$('div.cart_content table a.remove').click(function(e){
		var key = $(this).attr('rel');
		$.ajax({
			type: "POST",
			url:  window.ajaxurl,
			data: {
				action: 'removecart',
				key:	key
			},
			success: function(response) {
				var cart = $.parseJSON(response);
				updateCart(cart);
			}
		});
		e.preventDefault();
	});
});
jQuery(document).ready(function($) {
	$(window).resize(function(){
		var productorcategory;
		if(pagedisplaymode=="subcategories")
			productorcategory="category";
		else
			productorcategory="product";
		
		if(pagedisplaymode=="subcategories"){
			if($(this).width()<335){
				$("ul.products li.eachcategory").each(function(){
					if($(this).find("img").length<=0)
						$(this).find(".prodimagecontainer").css("height",$(this).find(".prodimagecontainer").width());
					else
						$(this).find(".prodimagecontainer").css("height","auto");
				});
			}else{
				$("ul.products li.eachcategory").each(function(){
					if($(this).find("img").length<=0)
						$(this).find(".prodimagecontainer").css("height","315px");
					else
						$(this).find(".prodimagecontainer").css("height","auto");
				});
			}
		}
		if(productviewmode=="compactview"){
			if($(this).width()>=930){
				$(".shopcontainer").width(900);
				$(".compactcolumn").css("marginRight",20);
				$("#compactcolumn4").css("marginRight",0);
				for(var kk=1;kk<=$("ul.products li").size();kk++){
					if(kk % 4==1){
						$("ul.products #compactcolumn1").append($("ul.products li#"+productorcategory+kk).detach());
					}else if(kk % 4==2){
						$("ul.products #compactcolumn2").append($("ul.products li#"+productorcategory+kk).detach());			
					}else if(kk % 4==3){
						$("ul.products #compactcolumn3").append($("ul.products li#"+productorcategory+kk).detach());			
					}else{
						$("ul.products #compactcolumn4").append($("ul.products li#"+productorcategory+kk).detach());	
					}
				}
			}else if($(this).width()<930 && $(this).width()>=700){
				$(".shopcontainer").width(670);
				$(".compactcolumn").css("marginRight",20);
				$("#compactcolumn3").css("marginRight",0);$("#compactcolumn4").css("marginRight",0);
				for(var kk=1;kk<=$("ul.products li").size();kk++){
					if(kk % 3==1){
						$("ul.products #compactcolumn1").append($("ul.products li#"+productorcategory+kk).detach());
					}else if(kk % 3==2){
						$("ul.products #compactcolumn2").append($("ul.products li#"+productorcategory+kk).detach());			
					}else{
						$("ul.products #compactcolumn3").append($("ul.products li#"+productorcategory+kk).detach());	
					}
				}
			}else if($(this).width()<700 && $(this).width()>=470){
				$(".shopcontainer").width(440);
				$(".compactcolumn").css("marginRight",0);
				$("#compactcolumn1").css("marginRight",20);
				for(var kk=1;kk<=$("ul.products li").size();kk++){
					if(kk % 2==1){
						$("ul.products #compactcolumn1").append($("ul.products li#"+productorcategory+kk).detach());
					}else{
						$("ul.products #compactcolumn2").append($("ul.products li#"+productorcategory+kk).detach());			
					}
				}
			}else{
				$(".shopcontainer").width(210);
				$(".compactcolumn").css("marginRight",0);
				for(var kk=1;kk<=$("ul.products li").size();kk++){
					$("ul.products #compactcolumn1").append($("ul.products li#"+productorcategory+kk).detach());
				}
			}
		}
	});
});