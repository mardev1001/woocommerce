jQuery(document).ready(function($) {
	$("input[type='radio'].input-radio").each(function(){
		if($(this).is(":checked")) {
			$(this).parent().find("i").addClass("fa-dot-circle-o").addClass("skin-secondary-text");
			$(this).parent().find("i").removeClass("fa-circle-o").addClass("skin-secondary-text");
		}else{
			$(this).parent().find("i").addClass("fa-circle-o").addClass("skin-secondary-text");
			$(this).parent().find("i").removeClass("fa-dot-circle-o").addClass("skin-secondary-text");
		}
		$(this).click(function(){
			var rname=$(this).attr("name");
			if($(this).is(":checked")) {
				$("input[type='radio'].input-radio").each(function(){
					if($(this).attr("name")==rname){
						$(this).parent().find("i").removeClass("fa-dot-circle-o").addClass("skin-secondary-text");
						$(this).parent().find("i").addClass("fa-circle-o").addClass("skin-secondary-text");
					}
				});
				$(this).parent().find("i").addClass("fa-dot-circle-o").addClass("skin-secondary-text");
				$(this).parent().find("i").removeClass("fa-circle-o").addClass("skin-secondary-text");
			}else{
				$(this).parent().find("i").addClass("fa-circle-o").addClass("skin-secondary-text");
				$(this).parent().find("i").removeClass("fa-dot-circle-o").addClass("skin-secondary-text");
			}
		});
	});
	$("input[type='checkbox'].input-checkbox").each(function(){
		if($(this).is(":checked")) {
			$(this).parent().find("i").addClass("fa-check-square-o").addClass("skin-secondary-text");
			$(this).parent().find("i").removeClass("fa-square-o").addClass("skin-secondary-text");
		}else{
			$(this).parent().find("i").addClass("fa-square-o").addClass("skin-secondary-text");
			$(this).parent().find("i").removeClass("fa-check-square-o").addClass("skin-secondary-text");
		}
		$(this).click(function(){
			if($(this).is(":checked")) {
				$(this).parent().find("i").addClass("fa-check-square-o").addClass("skin-secondary-text");
				$(this).parent().find("i").removeClass("fa-square-o").addClass("skin-secondary-text");
			}else{
				$(this).parent().find("i").addClass("fa-square-o").addClass("skin-secondary-text");
				$(this).parent().find("i").removeClass("fa-check-square-o").addClass("skin-secondary-text");
			}
		});
	});
	$(".slideThree input[type='checkbox']").each(function(){
		if($(this).is(":checked")){
			$(this).parent().removeClass("checkoff");
			$(this).parent().addClass("checkon").addClass("skin-secondary-text");
		}else{
			$(this).parent().removeClass("checkon").addClass("skin-secondary-text");
			$(this).parent().addClass("checkoff").addClass("skin-secondary-text");
		}
		$(this).click(function(){
			if($(this).is(":checked")){
				$(this).parent().removeClass("checkoff").addClass("skin-secondary-text");
				$(this).parent().addClass("checkon").addClass("skin-secondary-text");
			}else{
				$(this).parent().removeClass("checkon").addClass("skin-secondary-text");
				$(this).parent().addClass("checkoff").addClass("skin-secondary-text");
			}
		});
	});
});