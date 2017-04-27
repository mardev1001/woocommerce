window.filter = false;
window.offset = 0;
window.howmany = 10;
var pposbot;
function arrange(records) {
	$ = jQuery;
	$.each(records, function(key, record) {
		var content = '<p><span class="user"></span>&nbsp;&nbsp;: <i>' + record.name + '</i></p>';
		content += '<p><span class="email"></span>&nbsp;&nbsp;: <i class="email">' + record.email + '</i></p>';
		content += '<p><span class="note"></span>&nbsp;&nbsp;: <i class="subject">' + record.subject + '</i></p>';
		content += '<p><span class="time"></span>&nbsp;&nbsp;: <i>' + record.date + '</i></p>';
		content += '<input type="hidden" class="data" value="' + encodeURI(record.note) + '" />';
		content += '<div class="recordbg"></div>';
		content += '<a class="button view">View</div>';
		if( record.status == 'solved' )
			content += '<a class="button unsolved">Mark Unsolved</div>';
		else if( record.status == 'unsolved' )
			content += '<a class="button solved">Mark Solved</div>';
		content += '<a class="button trash">Trash</div>';
		var elem = $('<div class="record" rel="' + record.id + '"></div>');
		elem.html(content);
		$('#main').append(elem).masonry( 'appended', elem );
	//	$('#main').append(elem).masonry( 'reload' );
		
	});
	$('.record a.view').click(function() {
		var to = $(this).parent().find('i.email').text();
		to = to.replace(/\\'/g, '\'').replace(/\\"/g, '"');
		var inquiry = $(this).parent().find('input.data').val();
		inquiry = decodeURI(inquiry);
		inquiry = inquiry.replace(/\\'/g, '\'').replace(/\\"/g, '"');
		var subject = $(this).parent().find('i.subject').text();
		subject = subject.replace(/\\'/g, '\'').replace(/\\"/g, '"');
		$(".popupdiag #to").val(to);
		$(".popupdiag #inquiry").text(inquiry);
		$(".popupdiag #subject").val(subject);
		
		$("#popupbg").css("opacity",0.5);
		$("#popupbg").css("z-index",1000);
		$(".popupdiag").show();
		pposbot=($(window).height()-$(".popupdiag").height())/2;
		$(".popupdiag").animate({bottom:pposbot},100);
	});
	$('.record a.solved').click(function() {
		var record = $(this).parent().attr('rel');
		var obj = $(this);
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'mark_solved',
				id:	record
			},
			success: function(response) {
				obj.text("Mark Unsolved");
				obj.removeClass('solved').addClass('unsolved');
			}
		});
	});
	$('.record a.unsolved').click(function() {
		var record = $(this).parent().attr('rel');
		var obj = $(this);
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'mark_unsolved',
				id:	record
			},
			success: function(response) {
				obj.text("Mark Solved");
				obj.removeClass('unsolved').addClass('solved');
			}
		});
	});
	$('.record a.trash').click(function() {
		var record = $(this).parent().attr('rel');
		var obj = $(this).parent();
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'remove',
				id:	record
			},
			success: function(response) {
				$('#main').masonry('remove', obj);
				$('#main').masonry('reload');
			}
		});
	});
}
jQuery(document).ready(function($) {
	$('#main').masonry({
		itemSelector: '.record',
		columnWidth: 20,
		isOriginLeft: true
	});
	
	$('#tabs ul.group li').click(function() {
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		
		var filter = $(this).attr('rel');
		if( window.filter === filter ) return;
		
		window.filter = filter;
		window.offset = 0;
		$('#main div.record').remove();
		$('#main').masonry( 'reload' );
		if( window.offset > 0 ) {
			window.howmany = 10;
		}
		else {
			window.howmany = 30;
		}
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'get_inquiry',
				filter: window.filter,
				howmany: window.howmany,
				offset: window.offset
			},
			success: function(response) {
				var records = $.parseJSON(response);
				if(records.length < 1) return;
				window.offset += records.length;
				
				arrange(records);
			}
		});
		
	});
	$("#popupbg").click(function(){
		$(".popupdiag").hide();
		$(this).css("opacity",0);
		$(this).css("z-index",-1);
	});
	$("#main .popupdiag .ptitle .pclose").click(function(){
		$(".popupdiag").hide();
		$("#popupbg").css("opacity",0);
		$("#popupbg").css("z-index",-1);
	});
	$(".popupdiag #reply").click(function() {
		var to = $('.popupdiag #to').val();
		var subject = $('.popupdiag #subject').val();
		var response = $('.popupdiag #response').val();
		if(to.trim() == '' || subject.trim() == '' || response.trim() == '') {
			alert("All the fields are required");
			return;
		}
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'reply',
				to: to,
				subject: subject,
				body: response
			},
			success: function(response) {
				if(response == 'true')
					alert('Email successfully sent.');
				else
					alert('Cannot send mail');
			}
		});
	});
	$('#tabs ul.group li').first().trigger('click');
	
	$(window).scroll(function(){
		if( window.offset > 0 ) {
			window.howmany = 10;
		}
		else {
			window.howmany = 30;
		}
		if($(document).height()-$(this).scrollTop()==$(window).height()){
			$.ajax({
				type: "POST",
				url: ajaxurl,
				data: {
					action: 'get_inquiry',
					filter: window.filter,
					howmany: window.howmany,
					offset: window.offset
				},
				success: function(response) {
					var records = $.parseJSON(response);
					if(records.length < 1) return;
					window.offset += records.length;
					
					arrange(records);
				}
			});
		}
	});
});
