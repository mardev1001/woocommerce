/**
 * Admin jQuery functions
 * Written by Hyunmoo Team
 *
 * 
 *
 * Built for use with the jQuery library
 *
 *
 */

// <![CDATA[


jQuery(document).ready(function($) {

//Tabs part
	var setIndex = $("#setIndex").val();
	$("div#tabs-wrap").tabs( {
        fx: {opacity: 'toggle', duration: 200},
	    selected: setIndex,
        show: function() {
            var newIdx = $('div#tabs-wrap').tabs('option', 'selected');
            $('#setTabIndex').val(newIdx); // hidden field
        }
    });

    /* strip out all the auto classes since they create a conflict with the calendar */
    $('#tabs-wrap').removeClass('ui-tabs ui-widget ui-widget-content ui-corner-all');
    $('ul.ui-tabs-nav').removeClass('ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all');
    $('div#tabs-wrap div').removeClass('ui-tabs-panel ui-widget-content ui-corner-bottom');
	
//Form validation part
	$('form').validate({
		onSubmit : true,
		eachInvalidField : function() {
			$(this).css("border", "#F84A62 solid 1px");
			$(this).css("color", "#F80A62");
			var notice = $('<small><i><strong><font color="#F80A62">&nbsp;&nbsp;&nbsp;Please fill in this field.</font></strong></i></small>');
			$(this).siblings('span.error').empty();
			$(this).siblings('span.error').append(notice);
		}
	});
	
//Tooltip part
	$('[description]').each(function() {
		$(this).tipsy({
			title: 'description',
			gravity: 'w',
		});
	});
});

// ]]>
