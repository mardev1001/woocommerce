$ = jQuery;
function searchResults(type, response) {
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
	$(".search-content").append("<div style='clear:both'></div>");
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
			$(".search-content #product"+i).children("a").append(value['image1']);
			$(".search-content #product"+i).append("<div class='proddetails'></div>");
			$(".search-content #product"+i).find(".proddetails").append("<h3>"+value['title']+"</h3>");
			$(".search-content #product"+i).find(".proddetails").append("<span class='searchprice'></span><div class='clear'></div>");
			$(".search-content #product"+i).find(".searchprice").append(value['price']);
			$(".search-content #product"+i).append("<div class='prodcart'>");
			$(".search-content #product"+i).find(".prodcart").append("<a href='"+value['cart']+"' class='addtocart'>");
			$(".search-content #product"+i).find(".prodcart a.addtocart").append("<i class='fa fa-shopping-cart'></i><span>Add to Cart</span>");
			$(".search-content #product"+i).find(".prodcart").append("<a href='"+value['link']+"' class='showdetails'>");
			$(".search-content #product"+i).find(".prodcart a.showdetails").append("<i class='fa fa-list'></i><span>Show Details</span>");
			$(".search-content #product"+i).find(".prodcart").append("<div class='clear'></div>");
		});
	}
}
function searchPosts(response) {
	var i=$(".search-content .searchitem").size();
	var posts=$.parseJSON(response);
	$.each(posts,function(key,value){
		i++;
		if(i%4==1)
			$(".search-content").append("<div class='itemgroup' id='postgroup"+(i-1)/4+"'>");
		if(i%4!=0)
			$("#postgroup"+(i-i%4)/4).append("<div class='post searchitem' id='post"+i+"'></div>");
		else{
			$("#postgroup"+(i/4-1)).append("<div class='post searchitem' id='post"+i+"'></div>");
			$("#postgroup"+(i/4-1)).append("<div style='clear:both'></div>");
		}
		if(!value['image'])
			$(".search-content #post"+i).append("<div class='noimage search'></div>");
		else
			$(".search-content #post"+i).append(value['image']);
		$(".search-content #post"+i).append("<a href='"+value['link']+"'><h3>"+value['title']+"</h3></a>");
	});
		
	$("div.hmslider-post").owlCarousel({
		navigation : true, // Show next and prev buttons
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		transitionStyle:"fade",
	});
}
function searchPages(response) {
	var i=$(".search-content .searchitem").size();
	var pages=$.parseJSON(response);
	$.each(pages,function(key,value){
		i++;
		if(i%4==1)
			$(".search-content").append("<div class='itemgroup' id='pagegroup"+(i-1)/4+"'>");
		if(i%4!=0)
			$("#pagegroup"+(i-i%4)/4).append("<div class='page searchitem' id='page"+i+"'></div>");
		else{
			$("#pagegroup"+(i/4-1)).append("<div class='page searchitem' id='page"+i+"'></div>");
			$("#pagegroup"+(i/4-1)).append("<div style='clear:both'></div>");
		}
		if(!value['image'])
			$(".search-content #page"+i).append("<div class='noimage search'></div>");
		else
			$(".search-content #page"+i).append(value['image']);
		$(".search-content #page"+i).append("<a href='"+value['link']+"'><h3>"+value['title']+"</h3></a>");
	});
}
function searchUsers(response) {
	var i=$(".search-content .searchitem").size();
	var users=$.parseJSON(response);
	$.each(users,function(key,value){
		i++;
		$(".search-content").append("<div class='user searchitem' id='user"+i+"'></div>");
		$(".search-content #user"+i).append("<img src='"+value['image']+"'>");
		$(".search-content #user"+i).append("<a href='"+value['link']+"'><h3>"+value['title']+"</h3></a>");
	});
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
		$("ul.products li#product"+i).append("<a href='"+value['link']+"'></a>");
		$("ul.products li#product"+i).children("a").append(value['image1']);
		$("ul.products li#product"+i).append("<div class='proddetails'></div>");
		$("ul.products li#product"+i).find(".proddetails").append("<h3>"+value['title']+"</h3>");
		$("ul.products li#product"+i).find(".proddetails").append("<span class='price'></span><div style='clear:both'></div>");
		$("ul.products li#product"+i).find(".price").append(value['price']);
		$("ul.products li#product"+i).append("<div class='prodcart'>");
		$("ul.products li#product"+i).find(".prodcart").append("<a href='"+value['cart']+"' rel='" + value['id'] + "' class='addtocart'>");
		$("ul.products li#product"+i).find(".prodcart a.addtocart").append("<i class='fa fa-shopping-cart'></i><span>Add to Cart</span>");
		$("ul.products li#product"+i).find(".prodcart").append("<a href='"+value['link']+"' class='showdetails'>");
		$("ul.products li#product"+i).find(".prodcart a.showdetails").append("<i class='fa fa-list'></i><span>Show Details</span>");
		$("ul.products li#product"+i).find(".prodcart").append("<div style='clear:both'></div>");
	});
	//AJAX Add To Cart		
	$('.prodcart a.addtocart').click(function(e) {
		var id = $(this).attr('rel');
		$.ajax({
			type: "POST",
			url:  window.ajaxurl,
			data: {
				action:  'addcart',
				product: id
			},
			success: function(response) {
				var cart = $.parseJSON(response);
				updateCart(cart);
				alert("Product added to your cart.");
			}
		});
		e.preventDefault();
	});
}