(function ($) {
    $.fn.delayKeyup = function(callback, ms){
       var timer = 0;
		var el = $(this);
		$(this).keyup(function(){                   
		clearTimeout (timer);
		timer = setTimeout(function(){
			callback(el)
			}, ms);
		});
		return $(this);
    };
})(jQuery);
(function ($) {
	$.urlParam = function(name){
		 name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
		return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	};
})(jQuery);

var howmany = 0;
var loaded = 0;
var offset = 0;
var term = $.urlParam('s');
var type = $.urlParam('for');
if(type=='')
	type = window.defaultsearch;

jQuery(document).ready(function($) {
	$('form.searchform input#search').keyup(function() {
		if($(this).val() == '')
			$('#searchresultbox').hide();
		else{
			$('#searchresultbox').show();
			$("#searchresults").empty();
		}
	});
	var shover;
	$(document).click(function(){
		$("#searchresultbox").hide();
	});
	$("#searchresultbox").click(function(e){
		e.stopPropagation();
	});
	$('form.searchform input#search').delayKeyup(function(el){
		var term = el.val();
		if( window.prevterm == term || term.trim() == '' )
			return;	//Only search when search content changes
			
		ajaxurl = window.ajaxurl;
		$("#searchresults").append("<div align='center'><img src='" + window.loadimg + "'></div>");
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'search',
				query: term
			},
			success: function(response) {
				var search = $.parseJSON(response);
				var str = ''; 
				$("#searchresults").empty();
				if(search.length==0){
					$("#searchresults").append("<p>No Suggestions</p>");
				}else{
					$.each(search, function(name, section) {
						$("#searchresults").append("<div id='search"+name+"' class='searchresult'>");
						var cb=0,cs=0,cu=0;
						$.each(section, function(id, item){
							if(name=="blog"){
								cb++;
								$("#searchblog.searchresult").append("<li id='sblog"+cb+"'><a href='"+item['link']+"'>"+item['title']+"</a></li>");
							}else if(name=="shop"){
								cs++;
								$("#searchshop.searchresult").append("<li id='sshop"+cs+"'>");
								$("#searchshop.searchresult li#sshop"+cs).append("<img src='"+item['image']+"' width='24'>");
								$("#searchshop.searchresult li#sshop"+cs).append("<a href='"+item['link']+"'>"+item['title']+"</a>");
							}else if(name=="users"){
								cu++;
								$("#searchusers.searchresult").append("<li id='suser"+cu+"'>");
								$("#searchusers.searchresult li#suser"+cu).append("<a href='"+item['link']+"'><img style='border-radius: 100% !important;' src='"+item['image']+"' /></a>");
								$("#searchusers.searchresult li#suser"+cu).append("<a href='"+item['link']+"'>"+item['title']+"</a>");
							}
						});
					});
					if(window.template!="mobile"){
						$('#searchresults').slimScroll({
							height: '250px'
						});
					}else{
						$('#searchresults').slimScroll({
							height: '200px',
							alwaysVisible: true
						});
					}
				}
			}
		});
		window.prevterm = term;
	},500);
});
jQuery(document).ready(function($) {
	if( term.trim() == '' ) return;
	howmany = 12;
	if(window.template=='mobile')
		howmany = 5;
	$.ajax({
		type : 'POST',
		url : window.ajaxurl,
		data: {
			action : 'complete_search',
			howmany : howmany,
			offset : offset,
			term : term,
			type: type			
		},
		success : function(response) {
			loaded += howmany;
			offset += howmany;
			$(".search-content").empty();
			searchResults(type, response);
		}
	});

	$(".search-tabs ul.tabs li a").click(function(e){
		offset=0;
		howmany=12;
		$(".search-tabs ul.tabs li a").removeClass('skin-primary-border-top');
		$(this).addClass('skin-primary-border-top');
		$(".search-tabs ul.tabs li").removeClass('sactive');
		$(this).parent().addClass("sactive");
		e.preventDefault();
		type=$(this).attr("rel");
		$.ajax({
			type : 'POST',
			url : window.ajaxurl,
			data: {
				action : 'complete_search',
				howmany : howmany,
				offset : offset,
				term : term,
				type: type			
			},
			success : function(response) {
				loaded += howmany;
				offset += howmany;
		//		alert(response);
				$(".search-content").empty();
				searchResults(type, response);
			}
		});
	});
	$(window).scroll(function(){
		if($(document).height()-$(this).scrollTop()==$(window).height()){
			howmany=8;
			$.ajax({
				type : 'POST',
				url : window.ajaxurl,
				data: {
					action : 'complete_search',
					howmany : howmany,
					offset : offset,
					term : term,
					type: type			
				},
				success : function(response) {
					loaded += howmany;
					offset+=howmany;
			//		alert(response);
					if(response!="[]")
						searchResults(type, response);
				}
			});
		}
	});

	if(window.template!="mobile" ){
		$(window).resize(function(){
			var cols;
			var i=$(".search-content .searchitem").size();
			if($(".search-content").width()==1000)
				cols=4;
			else if($(".search-content").width()<1000 && $(".search-content").width()>=748)
				cols=3;
			else if($(".search-content").width()<748 && $(".search-content").width()>=496)
				cols=2;
			else if($(".search-content").width()<496 && $(".search-content").width()>=244)
				cols=1;
			if(i % cols ==0)
				i1 = i/cols;
			else
				i1 = (i-i%cols)/cols+1;
			for(var ii=1;ii<=i1;ii++){
				$(".search-content").append("<div id='searchgroup"+ii+"' class='searchgroup'></div>");
				for(var iii=1;iii<=cols;iii++){
					$("#searchgroup"+ii).append($(".search-content #"+type+((ii-1)*cols+iii)).detach());
				}
			}
			$(".search-content .clear").each(function(){
				if( $(this).parent().attr("class").indexOf("search-content")!=-1 || $(this).parent().attr("class").indexOf("searchgroup")!=-1 )
					$(this).remove();
			});
			$(".searchgroup").each(function(){
				if($(this).html()=="")
					$(this).remove();
				$(this).css("marginLeft",0);
				var sgm=($(".search-content").width()-$(this).width())/2;
				$(this).css("marginLeft",sgm);
			});
			$(".search-content").append("<div class='clear'>");
		});
	}
});