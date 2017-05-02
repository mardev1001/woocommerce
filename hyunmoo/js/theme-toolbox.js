jQuery(document).ready(function($) {
	$('#toolbox-main').slimScroll({
		height: '400px'
	});
	$("#toolbox-container").hide();
//Toggle Button section
	var sidebartoggle=1;
	$("#toolbox-toggle").click(function(){
		sidebartoggle++;
		if(sidebartoggle==1){
			$("#toolbox-container").hide();
		}else if(sidebartoggle==2){
			$("#toolbox-container").show();
			sidebartoggle=0;
		}
	});
//Style Layout section
	$('#toolbox input#round').click(function() {
		$('style#style_layout').remove();
		$.cookie('hyunmoo-layout','round',{expires: 7, path: '/'});
	});
	$('#toolbox input#angular').click(function() {
		$('style#style_layout').remove();
		var style = '* {border-radius: 0px !important;}';
		style += '.hmslider-post .owl-page span {border-radius: 20px !important;}';
		$('<style>').attr('type','text/css').attr('id', 'style_layout').text(style).appendTo('head');		
		$.cookie('hyunmoo-layout','angular',{expires: 7, path: '/'});
	});
	var layout = $.cookie('hyunmoo-layout');
	if(layout == 'angular') {
		$('#toolbox input#angular').attr('checked',true);
		$('#toolbox input#angular').trigger('click');
	}
	else {
		$('#toolbox input#round').attr('checked',true);
		$('#toolbox input#round').trigger('click');
	}
//Style Skin section
	$('#toolbox span.skin').click(function() {
		$(this).parent().children().css('opacity','0.5');
		$(this).css('opacity','1.0');
		
		var skin = $(this).attr('id');
		$.cookie('hyunmoo-skin', skin,{expires: 7, path: '/'});
		var style = '';
		
		switch(skin) {
		case 'skin1':
			style += '.skin-primary {background: #f75083 !important;}';
			style += 'a.skin-primary:hover, button.skin-primary:hover, input.skin-primary:hover {background: #f53d75 !important;}';
			style += '.skin-primary-text {color: #f75083 !important;}';
			style += 'a.skin-primary-text {color: #333 !important; }';
			style += 'a.skin-primary-text:hover {color: #f53d75 !important;}';
			style += 'p.stars a {color: #f53d75 !important;}';
			style += '.skin-secondary {background: #5BA0D0 !important;}';
			style += 'a.skin-secondary:hover, button.skin-secondary:hover, input.skin-secondary:hover {background: #73b0da !important;}';
			style += 'a.skin-secondary:active, button.skin-secondary:active, input.skin-secondary:active {border-color: #5BA0D0 !important;color: #5BA0D0 !important;background: transparent !important;}';
			style += '.skin-secondary-text {color: #5BA0D0 !important;}';
			style += 'a.skin-secondary-text {color: #333 !important; }';
			style += 'a.skin-secondary-text:hover {color: #73b0da !important;}';
			style += '.product_meta span a:hover {border-color: #5BA0D0 !important;color: #5BA0D0 !important;}';
			style += '#scroll-to-top:active {border-color: #f75083 !important;color: #f75083 !important;}';
			style += 'blockquote {border-color: #f75083 !important;}';
			style += '.skin-primary-border-top {border-color: #f75083 !important;}';
			
			break;
		case 'skin2':
			style += '.skin-primary {background: #84bd4e !important;}';
			style += 'a.skin-primary:hover, button.skin-primary:hover, input.skin-primary:hover {background: #7aa253 !important;}';
			style += '.skin-primary-text {color: #84bd4e !important;}';
			style += 'a.skin-primary-text {color: #333 !important; }';
			style += 'a.skin-primary-text:hover {color: #7aa253 !important;}';
			style += 'p.stars a {color: #84bd4e !important;}';
			style += '.skin-secondary {background: #46A5E3 !important;}';
			style += 'a.skin-secondary:hover, button.skin-secondary:hover, input.skin-secondary:hover {background: #57b0eb !important;}';
			style += 'a.skin-secondary:active, button.skin-secondary:active, input.skin-secondary:active {border-color: #46A5E3 !important;color: #46A5E3 !important;background: transparent !important;}';
			style += '.skin-secondary-text {color: #46A5E3 !important;}';
			style += 'a.skin-secondary-text {color: #333 !important; }';
			style += 'a.skin-secondary-text:hover {color: #57b0eb !important;}';
			style += '.product_meta span a:hover {border-color: #7aa253 !important;color: #7aa253 !important;}';
			style += '#scroll-to-top:active {border-color: #84bd4e !important;color: #84bd4e !important;}';
			style += 'blockquote {border-color: #84bd4e !important;}';
			style += '.skin-primary-border-top {border-color: #84bd4e !important;}';
			
			break;
		case 'skin0':
		default:
			style = 'p.stars a {color: #4b61af !important;}';
			
			break;
		}
		$('style#style_skin').remove();
		$('<style>').attr('type','text/css').attr('id', 'style_skin').text(style).appendTo('head');	
	});
	var skin = $.cookie('hyunmoo-skin');
	if( skin == undefined )
		skin = 'skin0';
	$('#toolbox span#' + skin).trigger('click');
//Style Background section
	$('#toolbox span.bg').click(function() {
		$(this).parent().children().css('opacity','0.7');
		$(this).css('opacity','1.0');
		var bg = $(this).attr('id');
		$.cookie('hyunmoo-bg', bg,{expires: 7, path: '/'});
		
		switch(bg) {
		case 'bg1':
			var style = 'body {background-color: #ebe5d1 !important;}';
			break;
		case 'bg2':
			var style = 'body {background-color: #d5c8b8 !important;}';
			break;
		case 'bg3':
			var style = 'body {background-color: #fff !important;}';
			break;
		case 'bg4':
			var siteurl = window.root;
			var style = 'body{background:url(' + siteurl + '/images/bg-01.png) !important;background-repeat:repeat !important;}';
			break;
		case 'bg5':
			var siteurl = window.root;
			var style = 'body{background:url(' + siteurl + '/images/bg-02.png) !important;background-repeat:repeat !important;}';
			break;
		case 'bg6':
			var siteurl = window.root;
			var style = 'body{background:url(' + siteurl + '/images/bg-03.png) !important;background-repeat:repeat !important;}';
			break;
		case 'bg7':
			var siteurl = window.root;
			var style = 'body{background:url(' + siteurl + '/images/bg-04.png) !important;background-repeat:repeat !important;}';
			break;
		case 'bg0':
		default:
			var style = 'body {background-color: #EEF0F3 !important}';
			break;
		}
		$('style#style_bg').remove();
		$('style#style_bgurl').remove();
		$('<style>').attr('type','text/css').attr('id', 'style_bg').text(style).appendTo('head');
	});
	var bg = $.cookie('hyunmoo-bg');
	if( bg == undefined )
		bg = 'bg0';
	$('#toolbox span#' + bg).trigger('click');
//Style Background Image section
	$('#usebgimg').click(function() {
		if($(this).is(':checked'))
			$('div#bgurl i').trigger('click');
		else
			$('style#style_bgurl').remove();
	});
	$('div#bgurl i').click(function() {
		var mode = $(this).attr('rel');
		var speed = 0.3;
		if( mode == 'parallax' ) {
			speed = 0.3;
			$(this).attr('rel','fixed');
			$(this).text('*').css('color','#16bf3e');
		}
		else if( mode == 'fixed' ) {
			speed = 0.0;
			$(this).attr('rel','none');
			$(this).text('').css('color','#555');
		}
		else if( mode == 'none' ) {
			speed = 1.0;
			$(this).attr('rel','parallax');
			$(this).text('!').css('color','#2f5bcf');
		}
		var use = $('#usebgimg').is(':checked');
		if( use == true ) {
			var url = $('#toolbox input#bgurl').val();
			if(url.trim() != '') {
				var style = 'body {background: url(' + url + ') no-repeat fixed;}';
				$('style#style_bg').remove();
				$('style#style_bgurl').remove();
				$('<style>').attr('type','text/css').attr('id', 'style_bgurl').text(style).appendTo('head');
				$('body').parallax('100%', speed);
			}
		}
		else
			$('style#style_bgurl').remove();
	});
//Style Header section
	$('#toolbox span.header').click(function() {
		$(this).parent().children().css('border','none');
		$(this).css('border-bottom','2px solid #DA1AD3');
		var header = $(this).attr('id');
		$.cookie('hyunmoo-header', header,{expires: 7, path: '/'});
		
		switch(header) {
			case 'header0':
			default:
				var style = '';
				break;
		}
		$('style#style_header').remove();
		$('<style>').attr('type','text/css').attr('id', 'style_header').text(style).appendTo('head');
	});
	var header = $.cookie('hyunmoo-header');
	if(header == undefined)
		header = 'header0';
	$('#toolbox span#' + header).trigger('click');
//Shop Price Range section
//Shop Display section
	$('select#pdt_display').select2();
	$('select#pdt_display').change(function() {
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
		var display = $(this).val();
		var sort = $('#toolbox select#sort').val();
		$('body').trigger('pdt_display_change', [ display, sort ]);
	});
//Shop Category section
	$('select#pdt_subcats').select2({
		placeholder: "Select categories"
	});
//Shop Tag section
	$('select#pdt_tags').select2({
		placeholder: "Select tags"
	});
//Shop Attributes section
	$('#toolbox select.shop_att_list').each(function(){
		var holdertext = $(this).attr('id').substr(3);
		$(this).select2({
			placeholder: holdertext
		});
	});
//Shop Sort section
	$('#toolbox select#sort').select2();
	$('#toolbox select#sort').change(function() {
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
		var display = $('#toolbox select#pdt_display').val();
		var sort = $(this).val();
		$('body').trigger('pdt_display_change', [ display, sort ]);
	});
//Shop Filter section
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
		var sort = $('#toolbox select#sort').val();
		$('body').trigger('pdt_display_change', [ display, sort ]);
	});
});