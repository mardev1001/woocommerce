$ = jQuery;
var cols,i1,i2;
function searchResults(type, response) {
	i1=$(".search-content .searchitem").size();
	if($(".search-content").width()==1000)
		cols=4;
	else if($(".search-content").width()<1000 && $(".search-content").width()>=748)
		cols=3;
	else if($(".search-content").width()<748 && $(".search-content").width()>=496)
		cols=2;
	else if($(".search-content").width()<496 && $(".search-content").width()>=244)
		cols=1;
	if(type=='')
		type=window.defaultsearch;
	if(type=='product')
		searchProducts(response);
	else if(type=='post')
		searchPosts(response);
	else if(type=='page')
		searchPages(response);
	else if(type=='user')
		searchUsers(response);
	var ii=$(".search-content .searchitem").size()-i1;
	if(ii % cols ==0)
		i2 = ii/cols+i1/cols;
	else
		i2 = (ii-ii%cols)/cols+1+i1/cols;
	for(var iii=i1/cols+1;iii<=i2;iii++){
		$(".search-content").append("<div id='searchgroup"+iii+"' class='searchgroup'></div>");
		for(var iiii=1;iiii<=cols;iiii++){
			$("#searchgroup"+iii).append($(".search-content #"+type+((iii-1)*cols+iiii)).detach());
			if(iiii%cols==0)
				$(".search-content #"+type+((iii-1)*cols+iiii)).css("marginRight",0);
		}
		$("#searchgroup"+iii).append("<div class='clear'></div>");
	}
	$(".searchgroup").each(function(){
		var sgm=($(".search-content").width()-$(this).width())/2;
		$(this).css("marginLeft",sgm);
	});
	$(".search-content").append("<div class='clear'></div>");
}
function searchProducts(response) {
	var i=$(".search-content .searchitem").size();
	var data=$.parseJSON(response);
	var products = data['products'];
	if(products.length == 0){
		$(".search-content .trailer").html("<h4>There are no products.</h4>");
	}else{
		$.each(products,function(key,value){
			i++;
			$(".search-content").append("<div class='product searchitem' id='product"+i+"'></div>");
			$(".search-content #product"+i).append("<a href='"+value['link']+"'></a>");
			$(".search-content #product"+i).children("a").append(value['image2']);
			$(".search-content #product"+i).append("<div class='proddetails'></div>");
			var title = value['title'];
			if(title.length>25)
				title = title.substring(0,25) + ' ...';
			$(".search-content #product"+i).find(".proddetails").append("<h3>"+title+"</h3>");
			$(".search-content #product"+i).find(".proddetails").append("<span class='searchprice'></span><div style='clear:both'></div>");
			$(".search-content #product"+i).find(".searchprice").append(value['price']);
			$(".search-content #product"+i).append("<div class='prodcart'>");
			$(".search-content #product"+i).find(".prodcart").append("<a href='"+value['cart']+"' class='addtocart'>");
			$(".search-content #product"+i).find(".prodcart a.addtocart").append("<i class='fa fa-shopping-cart '></i><span>Add to Cart</span>");
			$(".search-content #product"+i).find(".prodcart").append("<a href='"+value['link']+"' class='showdetails'>");
			$(".search-content #product"+i).find(".prodcart a.showdetails").append("<i class='fa fa-list '></i><span>Show Details</span>");
			$(".search-content #product"+i).find(".prodcart").append("<div style='clear:both'></div>");
		});
	}
}
function searchPosts(response) {
	var i=$(".search-content .post").size();
	var posts=$.parseJSON(response);
	if(posts.length==0){
		$(".search-content").append("There are no posts");
	}else{
		$.each(posts,function(key,value){
			i++;
			$(".search-content").append("<div class='post' id='post"+i+"'></div>");
			$(".search-content #post"+i).append("<h1><a class='skin-primary-text' href='"+value['link']+"'>"+value['title']+"</a></h1>");
			$(".search-content #post"+i).append("<div class='postotherinfo'>");
			$(".search-content #post"+i+" .postotherinfo").append(value['date']+" By <a class='skin-primary-text' href='"+value['authorlink']+"'>"+value['author']+"</a>");
			$(".search-content #post"+i).append("<div class='postcontent'>");
			if(value['image'])
				$(".search-content #post"+i+" .postcontent").append(value['image']);
			$(".search-content #post"+i+" .postcontent").append(value['content']);
			$(".search-content #post"+i+" .postcontent").append("<div class='readmore'><a class='skin-primary-text' href='"+value['link']+"'>Read More</a></div>");
			$(".search-content #post"+i+" .postcontent").append("<div class='clear'>");
			$(".search-content #post"+i).append("<div class='posttagcat'>");
			if(value['tag'])
				$(".search-content #post"+i+" .posttagcat").append("<p><span>Tags:</span> "+value['tag']+"</p>");
			if(value['category'])
				$(".search-content #post"+i+" .posttagcat").append("<p><span>Categories:</span> "+value['category']+"</p>");
		});
	}
		
	$("div.hmslider-post").owlCarousel({
		navigation : true, // Show next and prev buttons
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		transitionStyle:"fade",
	});
}
function searchPages(response) {
	var i=$(".search-content .post").size();
	var pages=$.parseJSON(response);
	if(pages.length==0){
		$(".search-content").append("There are no pages");
	}else{
		$.each(pages,function(key,value){
			i++;
			$(".search-content").append("<div class='post' id='page"+i+"'></div>");
			$(".search-content #page"+i).append("<h1><a class='skin-primary-text' href='"+value['link']+"'>"+value['title']+"</a></h1>");
			$(".search-content #page"+i).append("<div class='postotherinfo'>");
			$(".search-content #page"+i+" .postotherinfo").append(value['date']+" By  <a class='skin-primary-text' href='"+value['authorlink']+"'>"+value['author']+"</a>");
			$(".search-content #page"+i).append("<div class='postcontent'>");
			if(value['image'])
				$(".search-content #page"+i+" .postcontent").append(value['image']);
			$(".search-content #page"+i+" .postcontent").append(value['content']);
			$(".search-content #page"+i+" .postcontent").append("<div class='readmore'><a class='skin-primary-text' href='"+value['link']+"'>Read More</a></div>");
			$(".search-content #page"+i+" .postcontent").append("<div class='clear'>");
		});
	}
}
function searchUsers(response) {
	var i=$(".search-content .searchitem").size();
	var users=$.parseJSON(response);
	if(!users || users.length==0){
		$(".search-content").append("There are no users");
	}else{
		$.each(users,function(key,value){
			i++;
			$(".search-content").append("<div class='user searchitem' id='user"+i+"'></div>");
			$(".search-content #user"+i).append("<img src='"+value['image']+"'>");
			$(".search-content #user"+i).append("<a href='"+value['link']+"'><h3>"+value['title']+"</h3></a>");
			$(".search-content #user"+i).append("<div class='userbiography'>"+value['biography']+"</div>");
		});
	}
}
function updateCart(cart) {
	var currency = cart['currency'];
	var total = cart['total'];
	var totalcount = cart['totalcount'];
	$(".header_cart .cart_content table tbody").empty();
	$(".header_cart .cart_heading span.count").html(totalcount);
	$(".ordertotal b").html(total);
	$.each( cart['items'], function( key,item ) {
		$(".header_cart .cart_content table tbody").append('<tr id="'+item['id']+'"><td class="thumb">');
		$(".header_cart .cart_content table tbody tr#"+item['id']+" td.thumb").append('<a href="'+item['link']+'">');
		$(".header_cart .cart_content table tbody tr#"+item['id']+" td.thumb a").append('<img src="'+item['image']+ '"><strong>'+item['title']+'</strong>');                     
		$(".header_cart .cart_content table tbody tr#"+item['id']).append('<td class="qty">'+item['quantity']+"</td>");
		$(".header_cart .cart_content table tbody tr#"+item['id']).append('<td class="price">');
		$(".header_cart .cart_content table tbody tr#"+item['id']+" td.price").append('<div><a rel="'+item['key']+'" href="'+item['removeurl']+'" class="remove" title="Remove this item">&times;</a></div>');
		$(".header_cart .cart_content table tbody tr#"+item['id']+" td.price").append('<span class="amount">'+currency+item['formatted']+'</span>');
	});
	
	$(".header_cart .cart_content table tbody tr").hover(function(){
		$(this).find("a.remove").show();
	},function(){
		$(this).find("a.remove").hide();
	});
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
}
function loadProducts(response) {
	$("#loadingimage").remove();
	var i=$("ul.products li").size();
	var data = $.parseJSON(response);
	var products = data['products'];
	window.offset_shop = data['offset'];
	if(products.length == 0)
		$('div.productsmain').append('<h4>No products found.</h4>');
	$.each(products, function(key,value) {
		i++;
		$("ul.products").append("<li id='product"+i+"' class='eachproduct'>");
		$("ul.products li#product"+i).append("<a href='"+value['link']+"'>");
		
		if(productviewmode=="classicview"){
			if(i % 3 ==1){
				$("ul.products li#product"+i).addClass("class1");
				$("ul.products li#product"+i+" a").append("<div class='prodimagecontainer' align='center'>");
				$("ul.products li#product"+i+" a div").append("<div class='prodimageback'>");
				$("ul.products li#product"+i+" a div").append(value['image1']);
			}else{
				$("ul.products li#product"+i).addClass("class2");
				$("ul.products li#product"+i+" a").append("<div class='prodimagecontainer' align='center'>");
				$("ul.products li#product"+i+" a div").append("<div class='prodimageback'>");
				$("ul.products li#product"+i+" a div.prodimagecontainer").append(value['image2']);
				if(i % 3==0)
					$("ul.products li#product"+i).addClass("imageright");
				}
		}
		else if(productviewmode=="gridview"){
			if(i % 5 ==1 || i % 5==2){
				$("ul.products li#product"+i).addClass("grid1");
				$("ul.products li#product"+i+" a").append("<div class='prodimagecontainer' align='center'>");
				$("ul.products li#product"+i+" a div").append("<div class='prodimageback'>");
				$("ul.products li#product"+i+" a div").append(value['image1']);
				if(i % 5==2)
					$("ul.products li#product"+i).addClass("imageright");
			}else{
				$("ul.products li#product"+i).addClass("grid2");
				$("ul.products li#product"+i+" a").append("<div class='prodimagecontainer' align='center'>");
				$("ul.products li#product"+i+" a div").append("<div class='prodimageback'>");
				$("ul.products li#product"+i+" a div.prodimagecontainer").append(value['image2']);
				if(i % 5==4 || i % 5==0)
					$("ul.products li#product"+i).addClass("imageright");
			}
			if(i % 3==1)
				$("ul.products li#product"+i).addClass("grid3");
			else{
				$("ul.products li#product"+i).addClass("grid4");
				if(i % 3==0)
					$("ul.products li#product"+i).addClass("imageright1");
			}
		}
		else if(productviewmode=="compactview"){
			if($(window).width()>=930){
				$(".shopcontainer").width(900);
				$(".compactcolumn").css("marginRight",20);
				$("#compactcolumn4").css("marginRight",0);
				if(i%4==1)
					$("ul.products #compactcolumn1").append($("ul.products li#product"+i));
				else if(i%4==2)
					$("ul.products #compactcolumn2").append($("ul.products li#product"+i));
				else if(i%4==3)
					$("ul.products #compactcolumn3").append($("ul.products li#product"+i));
				else
					$("ul.products #compactcolumn4").append($("ul.products li#product"+i));
			}else if($(window).width()<930 && $(window).width()>=700){
				$(".shopcontainer").width(670);
				$(".compactcolumn").css("marginRight",20);
				$("#compactcolumn3").css("marginRight",0);$("#compactcolumn4").css("marginRight",0);
				if(i%3==1)
					$("ul.products #compactcolumn1").append($("ul.products li#product"+i));
				else if(i%3==2)
					$("ul.products #compactcolumn2").append($("ul.products li#product"+i));
				else
					$("ul.products #compactcolumn3").append($("ul.products li#product"+i));
			}else if($(window).width()<700 && $(window).width()>470){
				$(".shopcontainer").width(440);
				$(".compactcolumn").css("marginRight",0);
				$("#compactcolumn1").css("marginRight",20);
				if(i%2==1)
					$("ul.products #compactcolumn1").append($("ul.products li#product"+i));
				else
					$("ul.products #compactcolumn2").append($("ul.products li#product"+i));
			}else{
				$(".shopcontainer").width(210);
				$(".compactcolumn").css("marginRight",0);	
				$("ul.products #compactcolumn1").append($("ul.products li#product"+i));
			}
			$("ul.products li#product"+i).addClass("compact");
			$("ul.products li#product"+i+" a").append("<div class='prodimagecontainer' align='center'>");
			$("ul.products li#product"+i+" a div").append("<div class='prodimageback'>");
			$("ul.products li#product"+i+" a div.prodimagecontainer").append(value['image1']);
		}
						
		if(value['sale']!="not sale"){
			$("ul.products li#product"+i+" a div").append("<span class='onsale'></span>");
		}
		if(navigator.userAgent.indexOf("MSIE")!=-1){
			$("span.onsale").css("marginLeft",-50);
			$("span.onsale").css("marginTop",0);
		}
				
		$("ul.products li#product"+i).append("<div class='priceandnamecontainer'>");
		var prodname=value['title'];
		if(prodname.length>10)
			prodname=prodname.substring(0,10)+"...";
		$("ul.products li#product"+i+" div.priceandnamecontainer").append("<h3>"+prodname+"</h3>");
		$("ul.products li#product"+i+" div.priceandnamecontainer").append("<span class='price'>"+value['price']+"</span>");
		if(value['rating']){
					$("ul.products li#product"+i+" div.priceandnamecontainer").append("<div class='star-rating onload'><span style='width:"+parseFloat(value['rating'])/5*100+"%;'></span></div>"); }
					for(var kk=0;kk<5;kk++){
						$("ul.products li#product"+i+" div.priceandnamecontainer .star-rating").append("<i class='fa fa-star-o' style='left:"+kk*16+"px;'></i>");
						$("ul.products li#product"+i+" div.priceandnamecontainer .star-rating span").append("<i class='fa fa-star' style='left:"+kk*16+"px;'></i>");
					} 
		$("ul.products li#product"+i).append("<div class='prodcart'>");
		$("ul.products li#product"+i).find(".prodcart").append("<a href='"+value['cart']+"' rel='" + value['id'] + "' class='addtocart'>");
		$("ul.products li#product"+i).find(".prodcart a.addtocart").append("<i class='fa fa-shopping-cart'></i><span>Add to Cart</span>");
		$("ul.products li#product"+i).find(".prodcart").append("<a href='"+value['link']+"' class='showdetails'>");
		$("ul.products li#product"+i).find(".prodcart a.showdetails").append("<i class='fa fa-list'></i><span>Show Details</span>");
		$("ul.products li#product"+i).find(".prodcart").append("<div style='clear:both'></div>");

	});
	//AJAX Add To Cart		
	$('a.add_to_cart_button').click(function(e) {
		var id = $(this).attr('rel');
		$(".header_cart .cart_heading").animate({opacity:0.5},100);
		$.ajax({
			type: "POST",
			url:  window.ajaxurl,
			data: {
				action:  'addcart',
				product: id
			},
			success: function(response) {
				$(".header_cart .cart_heading").animate({opacity:1},100);
				var cart = $.parseJSON(response);
				updateCart(cart);
			}
		});
		e.preventDefault();
	});
}