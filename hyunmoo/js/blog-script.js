var cols;
var howmany = 10;
jQuery(document).ready(function($){	
	var postcategory,postauthor;
	if($("#postcategoryslug").length!=0)
		postcategory = $("#postcategoryslug").val();
	else
		postcategory = "";
	if($("#postauthor").length!=0)
		postauthor = $("#postauthor").val();
	else
		postauthor = "";
	if($("#posttag").length!=0)
		posttag = $("#posttag").val();
	else
		posttag = "";
	var howmanyloaded=0;
	var blogsidebarcss="", postcontainercss="";
	if($("#sidebarcheck").val()=="right"){
		blogsidebarcss="float:right;";
		postcontainercss="float:left;";
		if($("#blogview").val()!="grid")
			postcontainercss+="width:74%;";
		else{
			postcontainercss+="padding:0;";
			blogsidebarcss+="width:254px;";
		}
	}else if($("#sidebarcheck").val()=="left"){
		blogsidebarcss="float:left;";
		postcontainercss="float:right;";
		if($("#blogview").val()!="grid")
			postcontainercss+="width:74%;";
		else{
			postcontainercss+="padding:0;";
			blogsidebarcss+="width:254px;";
		}
	}else if($("#sidebarcheck").val()=="nosidebar"){
		if($("#blogview").val()!="grid"){
			postcontainercss="width:100%;";
		}else{
			postcontainercss+="padding:0;";
		}
	}
	if($("#postauthor").length!=0)
		blogsidebarcss+="margin-top:0";
	
	if($("#blogview").val()=="grid")
		howmany=20;
	else if($("#blogview").val()=="smallimage")
		howmany=15;
	else if($("#blogview").val()=="largeimage")
		howmany=10;
	if($("#sidebarcheck").val()=="nosidebar")
		cols=3;
	else if($("#sidebarcheck").val()=="left" || $("#sidebarcheck").val()=="right")
		cols=2;
	$(".post-container").append("<div style='width:100%;margin-top:100px' align='center' id='loadingimage'><img src='" + window.loadimg + "'></div>");
	$.ajax({
		type: "POST",
		url : ajaxurl,
		data : {
			action : 'get_posts',
			howmany : howmany,
			category : postcategory,
			author : postauthor,
			tags : posttag,
			view : $("#blogview").val(),
			sidebar : $("#sidebarcheck").val()
		},
		success : function(response) {
			$('.post-container #loadingimage').remove();
			var posts= $.parseJSON(response);
			howmanyloaded+=howmany;
			var i=0;
			if($(".post-container").length==0)
				$(".page-container").append("<div class='post-container'>");
			if($("#postauthor").length==0)
				$(".post-container").attr("style",postcontainercss);
			else
				$(".pagecontainer1").attr("style",postcontainercss);
			if($("#blogview").val()=="grid"){
				for(var aa=1;aa<=cols;aa++)
					$(".post-container").append("<div id='postcolumn"+aa+"' class='postcolumn'>");
				$(".post-container").append("<div class='clear'>");
			}
			if($("#blogview").val()!="grid")
				$(".post-container").addClass("wrapper");
			if($("#blogview").val()!="grid"){
				$(".post-container").addClass("nogrid");
				$("#blogsidebar").addClass("nogrid");
			}else{
				$("#blogsidebar").addClass("grid");
			}
			if(response==null){
				$(".post-container").append("There are no posts");
			}else{
				$.each(posts, function(key,value) {
					i++;
					if($("#blogview").val()=="grid"){
						if(cols==3){
							if($(window).width()>=1030){
								$(".page-container").width(1010);
								$(".postcolumn").css("marginRight",10);
								$("#postcolumn3").css("marginRight",0);
								if(i % 3==1){
									$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
								}else if(i % 3==2){
									$(".page-container #postcolumn2").append("<div id='post-"+i+"' class='post wrapper'>");
								}else{
									$(".page-container #postcolumn3").append("<div id='post-"+i+"' class='post wrapper'>");			
								}
							}else if($(window).width()<1030 && $(window).width()>690){
								$(".page-container").width(670);
								$(".postcolumn").css("marginRight",10);
								$("#postcolumn3").css("marginRight",0);$("#postcolumn2").css("marginRight",0);
								if(i % 2==1){
									$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
								}else{
									$(".page-container #postcolumn2").append("<div id='post-"+i+"' class='post wrapper'>");
								}
							}else{
								$(".page-container").width(330);
								$(".postcolumn").css("marginRight",0);
								$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
							}
						}else if(cols==2){
							$(".postcolumn").width(366);
							if($(window).width()>=1030){
								$(".page-container").width(1010);
								$(".postcolumn").css("marginRight",10);
								$("#postcolumn2").css("marginRight",0);
								if(i % 2==1){
									$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
								}else{
									$(".page-container #postcolumn2").append("<div id='post-"+i+"' class='post wrapper'>");
								}
							}else if($(window).width()<1030 && $(window).width()>=650){
								$(".page-container").width(630);
								$(".postcolumn").css("marginRight",0);
								$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
								$("#postcolumn2").css("width",0);
							}else{
								$(".page-container").width(366);
								$(".postcolumn").css("marginRight",0);
								$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
							}
						}
					}else if($("#blogview").val()=="smallimage" || $("#blogview").val()=="largeimage")
						$(".post-container").append("<div id='post-"+i+"' class='post'>");
					$(".post-container #post-"+i).append("<div class='postthumb'>");
					if($("#blogview").val()=="smallimage")
						$(".post-container #post-"+i+" .postthumb").css("float","left");
					if(value['image'])
						$(".post-container #post-"+i+" .postthumb").append(value['image']);
					$(".post-container #post-"+i).append("<div class='postcontent'>");
					if($("#blogview").val()=="smallimage" && value['image']){
						$(".post-container #post-"+i+" .postthumb").css("float","left");
						$(".post-container #post-"+i+" .postthumb").css("width","49.5%");
						$(".post-container #post-"+i+" .postcontent").css("float","right");
						$(".post-container #post-"+i+" .postcontent").css("width","49.5%");
						$(".post-container #post-"+i+" .postcontent").css("marginTop","5px");
					}
					$(".post-container #post-"+i+" .postcontent").append("<h3><a class='skin-primary-text' href='"+value['link']+"' title='"+value['title']+"'>"+value['title']+"</a></h3>");
					if($("#blogview").val()=="grid"){
						$(".post-container #post-"+i+" .postcontent").append("<span class='postauthor' style='padding-left: 10px;'>By <a class='skin-primary-text' href='"+value['authorlink']+"'>"+value['author']+"</a></span><span class='postdate'> on "+value['date']+"</span>");
					}
					$(".post-container #post-"+i+" .postcontent").append("<p>"+value['content']+"</p>");
					if($("#blogview").val()=="grid")
						$(".post-container #post-"+i+" .postcontent").css("marginTop",0);
					$(".post-container #post-"+i).append("<div style='clear:both'></div>");
					$(".post-container #post-"+i).append("<div class='postotherinfo'>");
					if($("#blogview").val()=="grid"){
						$(".post-container #post-"+i+" .postotherinfo").append("<span class='postcomment'><a  class='skin-primary-text' href='"+value['commentlink']+"' title='Comment on "+value['title']+"'><i class='fa fa-comments-o'></i> "+value['commenttxt']+"</a></span>");
					}else{
						$(".post-container #post-"+i+" .postotherinfo").append("<span class='postauthor'>By <a  class='skin-primary-text' href='"+value['authorlink']+"' title='Posts by "+value['author']+"'>"+value['author']+"</a></span> <span class='postdate'> on "+value['date']+"</span> <span class='sepa'>|</span> <span class='postcategory'>"+value['category']+"</span> <span class='sepa'>|</span> <span class='postcomment'><a class='skin-primary-text' href='"+value['commentlink']+"' title='Comment on "+value['title']+"'><i class='fa fa-comments-o'></i> "+value['commenttxt']+"</a></span>");
					}
					$(".post-container #post-"+i+" .postotherinfo").append("<span id='postreadmore'><a class='skin-primary-text' href='"+value['link']+"'>Read More &raquo;</a></span><div style='clear:both'></div>");
				});
			}
			$("#blogsidebar").attr("style",blogsidebarcss);
			if($("#blogview").val()!="grid")
				$("#blogsidebar").addClass("nogrid");
			$(".postcomment").hover(function(){
				$(this).find("i").removeClass("fa-comments-o");
				$(this).find("i").addClass("fa-comments");	
			},function(){
				$(this).find("i").removeClass("fa-comments");
				$(this).find("i").addClass("fa-comments-o");
			});
			$("div.hmslider-post").owlCarousel({
				navigation : true, // Show next and prev buttons
				slideSpeed : 300,
				paginationSpeed : 400,
				singleItem:true,
				transitionStyle:"fade",
				autoPlay:3000
			});
		}
		
	});

	$(window).scroll(function(){
		if($("#blogview").val()=="grid")
			howmany=4;
		else if($("#blogview").val()=="smallimage")
			howmany=3;
		else if($("#blogview").val()=="largeimage")
			howmany=2;
		var loadingflag;
		
		if($(document).height()-$(this).scrollTop()==$(window).height()){
			var offset=$(".post-container .post").size();
			if(howmanyloaded==$(".post-container .post").size()){
				$(".post-container").append("<div style='width:100%;margin-top:100px' align='center' id='loadingimage'><img src='" + window.loadimg + "'></div>");
				howmanyloaded+=howmany;
				$.ajax({
					type: "POST",
					url : ajaxurl,
					data : {
						action : 'get_posts',
						offset : offset,
						howmany : howmany,
						view : $("#blogview").val(),
						sidebar : $("#sidebarcheck").val()
					},
					success : function(response) {
						var posts= $.parseJSON(response);
						$('.post-container #loadingimage').remove();
						var i=$(".post-container .post").size();
						$.each(posts, function(key,value) {
							i++;
							if($("#blogview").val()=="grid"){
								if(cols==3){
									if($(window).width()>=1030){
										$(".page-container").width(1010);
										$(".postcolumn").css("marginRight",10);
										$("#postcolumn3").css("marginRight",0);
										if(i % 3==1){
											$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
										}else if(i % 3==2){
											$(".page-container #postcolumn2").append("<div id='post-"+i+"' class='post wrapper'>");
										}else{
											$(".page-container #postcolumn3").append("<div id='post-"+i+"' class='post wrapper'>");			
										}
									}else if($(window).width()<1030 && $(window).width()>690){
										$(".page-container").width(670);
										$(".postcolumn").css("marginRight",10);
										$("#postcolumn3").css("marginRight",0);$("#postcolumn2").css("marginRight",0);
										if(i % 2==1){
											$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
										}else{
											$(".page-container #postcolumn2").append("<div id='post-"+i+"' class='post wrapper'>");
										}
									}else{
										$(".page-container").width(330);
										$(".postcolumn").css("marginRight",0);
										$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
									}
								}else if(cols==2){
									$(".postcolumn").width(366);
									if($(window).width()>=1030){
										$(".page-container").width(1010);
										$(".postcolumn").css("marginRight",10);
										$("#postcolumn2").css("marginRight",0);
										if(i % 2==1){
											$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
										}else{
											$(".page-container #postcolumn2").append("<div id='post-"+i+"' class='post wrapper'>");
										}
									}else if($(window).width()<1030 && $(window).width()>=650){
										$(".page-container").width(630);
										$(".postcolumn").css("marginRight",0);
										$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
										$("#postcolumn2").css("width",0);
									}else{
										$(".page-container").width(366);
										$(".postcolumn").css("marginRight",0);
										$(".page-container #postcolumn1").append("<div id='post-"+i+"' class='post wrapper'>");
									}
								}
							}else if($("#blogview").val()=="smallimage" || $("#blogview").val()=="largeimage")
								$(".post-container").append("<div id='post-"+i+"' class='post'>");
							$(".post-container #post-"+i).append("<div class='postthumb'>");
							if($("#blogview").val()=="smallimage")
								$(".post-container #post-"+i+" .postthumb").css("float","left");
							if(value['image'])
								$(".post-container #post-"+i+" .postthumb").append(value['image']);
							$(".post-container #post-"+i).append("<div class='postcontent'>");
							if($("#blogview").val()=="smallimage" && value['image']){
								$(".post-container #post-"+i+" .postthumb").css("float","left");
								$(".post-container #post-"+i+" .postthumb").css("width","49.5%");
								$(".post-container #post-"+i+" .postcontent").css("float","right");
								$(".post-container #post-"+i+" .postcontent").css("width","49.5%");
								$(".post-container #post-"+i+" .postcontent").css("marginTop","5px");
							}
							$(".post-container #post-"+i+" .postcontent").append("<h3><a class='skin-primary-text' href='"+value['link']+"' title='"+value['title']+"'>"+value['title']+"</a></h3>");
							if($("#blogview").val()=="grid"){
								$(".post-container #post-"+i+" .postcontent").append("<span class='postauthor' style='padding-left: 10px;'>By <a class='skin-primary-text' href='"+value['authorlink']+"'>"+value['author']+"</a></span><span class='postdate'> on "+value['date']+"</span>");
							}
							$(".post-container #post-"+i+" .postcontent").append("<p>"+value['content']+"</p>");
							if($("#blogview").val()=="grid")
								$(".post-container #post-"+i+" .postcontent").css("marginTop",10);
							$(".post-container #post-"+i).append("<div style='clear:both'></div>");
							$(".post-container #post-"+i).append("<div class='postotherinfo'>");
							if($("#blogview").val()=="grid"){
								$(".post-container #post-"+i+" .postotherinfo").append("<span class='postcomment'><a class='skin-primary-text' href='"+value['commentlink']+"' title='Comment on "+value['title']+"'><i class='fa fa-comments-o'></i> "+value['commenttxt']+"</a></span>");
							}else{
								$(".post-container #post-"+i+" .postotherinfo").append("<span class='postauthor'>By <a class='skin-primary-text' href='"+value['authorlink']+"' title='Posts by "+value['author']+"'>"+value['author']+"</a></span> <span class='postdate'> on "+value['date']+"</span> <span class='sepa'>|</span> <span class='postcategory'>"+value['category']+"</span> <span class='sepa'>|</span> <span class='postcomment'><a class='skin-primary-text' href='"+value['commentlink']+"' title='Comment on "+value['title']+"'><i class='fa fa-comments-o'></i> "+value['commenttxt']+"</a></span>");
							}
							$(".post-container #post-"+i+" .postotherinfo").append("<span id='postreadmore'><a  class='skin-primary-text' href='"+value['link']+"'>Read More &raquo;</a></span><div style='clear:both'></div>");
						});
						$("div.hmslider-post").each(function(){
							$(this).owlCarousel({
								navigation : true, // Show next and prev buttons
								slideSpeed : 300,
								paginationSpeed : 400,
								singleItem:true,
								transitionStyle:"fade",
							});
						});

						$(".postcomment").hover(function(){
							$(this).find("i").removeClass("fa-comments-o");
							$(this).find("i").addClass("fa-comments");	
						},function(){
							$(this).find("i").removeClass("fa-comments");
							$(this).find("i").addClass("fa-comments-o");
						});
					}
				});
			}
		}
	});
});
jQuery(document).ready(function($) {
	$(window).resize(function(){
		for(var kk=1;kk<=$(".post.wrapper").size();kk++){
			if(cols==3){
				if($(this).width()>=1030){
					$(".page-container").width(1010);
					$(".postcolumn").css("marginRight",10);
					$("#postcolumn3").css("marginRight",0);
					if(kk % 3==1){
						$(".page-container #postcolumn1").append($(".post.wrapper#post-"+kk).detach());
					}else if(kk % 3==2){
						$(".page-container #postcolumn2").append($(".post.wrapper#post-"+kk).detach());
					}else{
						$(".page-container #postcolumn3").append($(".post.wrapper#post-"+kk).detach());			
					}
				}else if($(this).width()<1030 && $(this).width()>=690){
					$(".page-container").width(670);
					$(".postcolumn").css("marginRight",10);
					$("#postcolumn3").css("marginRight",0);$("#postcolumn2").css("marginRight",0);
					if(kk % 2==1){
						$(".page-container #postcolumn1").append($(".post.wrapper#post-"+kk).detach());
					}else{
						$(".page-container #postcolumn2").append($(".post.wrapper#post-"+kk).detach());
					}
				}else{
					$(".page-container").width(330);
					$(".postcolumn").css("marginRight",0);
					$(".page-container #postcolumn1").append($(".post.wrapper#post-"+kk).detach());
				}
			}else if(cols==2){
				$(".postcolumn").width(366);
				if($(window).width()>=1030){
					$(".page-container").width(1010);
					$(".postcolumn").css("marginRight",10);
					$("#postcolumn2").css("marginRight",0);
					if(kk % 2==1){
						$(".page-container #postcolumn1").append($(".post.wrapper#post-"+kk).detach());
					}else{
						$(".page-container #postcolumn2").append($(".post.wrapper#post-"+kk).detach());
					}
				}else if($(window).width()<1030 && $(window).width()>=650){
					$(".page-container").width(630);
					$(".postcolumn").css("marginRight",0);
					$(".page-container #postcolumn1").append($(".post.wrapper#post-"+kk).detach());
					$("#postcolumn2").css("width",0);
				}else{
					$(".page-container").width(366);
					$(".postcolumn").css("marginRight",0);
					$(".page-container #postcolumn1").append($(".post.wrapper#post-"+kk).detach());
				}
			}
		}
	});
});