	jQuery(document).ready(function($) {
		
		$('body').bind('country_to_state_changed', function(event, country, wrapper) {
			$('div#s2id_calc_shipping_state').remove();
			$('select.state_select').select2({placeholder: "Select a State"});
			$('input[type=text]').addClass("form-control");
		});
		$('#cartshippingcalculator select#calc_shipping_country').select2({placeholder: "Select a Country"});
		
		if($("#template").val()!="mobile"){
			if($(window).width()<864){
				if($(window).width()<584){
					if($(window).width()<=302){
						$("#cartform").parent().width(272);
						$("#cartform table td.product-thumbnail .product-name").css("max-width",100);
					}else{
						$("#cartform").parent().css("width","auto");
						$("#cartform table td.product-thumbnail .product-name").css("max-width",($(window).width()-52)*40/100);
					}
				}else{
					$("#cartform").parent().css("width","auto");
					$("#cartform table td.product-thumbnail .product-name").css("max-width",($(window).width()-52)*34/100);
				}
			}else{
				$("#cartform").parent().css("width","auto");
				$("#cartform table td.product-thumbnail .product-name").css("max-width",150);
			}
			$(window).resize(function(){
				if($(window).width()<864){
					if($(window).width()<584){
						if($(window).width()<=302){
							$("#cartform table td.product-thumbnail .product-name").css("max-width",100);
						}else{
							$("#cartform table td.product-thumbnail .product-name").css("max-width",($(window).width()-52)*40/100);
						}
					}else{
						$("#cartform table td.product-thumbnail .product-name").css("max-width",($(window).width()-52)*34/100);
					}
				}else{
					$("#cartform table td.product-thumbnail .product-name").css("max-width",150);
				}
			});
		}
	});