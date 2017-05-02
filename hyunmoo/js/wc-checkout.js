jQuery(document).ready(function($) {
	
	$('body').bind('country_to_state_changed', function(event, country, wrapper) {
		$('div#s2id_billing_state').remove();
		$('div#s2id_shipping_state').remove();
		$('select.state_select').select2({placeholder: "Select a State"});
		$('input[type=text]').addClass("form-control");
	});
		
	$("#customer_details .col-1 label").remove();
	$("#editbillingaddress label").remove();
	$("#billing_country").attr("data-required","true");
	$("#billing_country").select2({placeholder: "Select a Country"});
	$("#shipping_country").select2({placeholder: "Select a Country"});
	if($("#billing_state").is("select"))
		$("#billing_state").select2({placeholder: "Select a State"});
	if($("#shipping_state").is("select"))
		$("#shipping_state").select2({placeholder: "Select a State"});
	
	$("#billing_first_name").attr("placeholder","First Name");
	$("#billing_first_name").attr("data-required","true");
	$("#billing_last_name").attr("placeholder","Last Name");
	$("#billing_last_name").attr("data-required","true");
	$("#billing_first_name_field").attr("id","billing_name_field");
	$("#billing_name_field").append($("#billing_last_name").detach());
	$("#billing_last_name_field").remove();
	$("#billing_name_field").append("<div class='clear'></div>");
	$("#billing_address_1_field").attr("id","billing_address_field");
	$("#billing_address_field").append($("#billing_address_2").detach());
	$("#billing_address_2_field").remove();
	$("#billing_address_field").append("<div class='clear'></div>");
	$("#billing_company").attr("placeholder","Company Name(optional)");
	$("#billing_email").attr("placeholder","Email Address");
	$("#billing_phone").attr("placeholder","Phone Number");
	$("#billing_address_1").attr("data-required","true");
	$("#billing_city").attr("data-required","true");
	$("#billing_state").attr("data-required","true");
	$("#billing_postcode").attr("data-required","true");
	$("#billing_email").attr("data-required","true");
	$("#billing_phone").attr("data-required","true");
	if(!$("#shiptobilling-checkbox").is(":checked")){
		$("#shipping_country").attr("data-required","true");
		$("#shipping_first_name").attr("data-required","true");
		$("#shipping_last_name").attr("data-required","true");
		$("#shipping_phone").attr("data-required","true");
		$("#shipping_address_1").attr("data-required","true");
		$("#shipping_city").attr("data-required","true");
		$("#shipping_state").attr("data-required","true");
		$("#shipping_postcode").attr("data-required","true");
		$("#shipping_email").attr("data-required","true");
	}
	$("#customer_details .shipping_address label").remove();
	$("#shipping_country").val("");
	$("#shipping_first_name").attr("placeholder","First Name");
	$("#shipping_last_name").attr("placeholder","Last Name");
	$("#shipping_first_name_field").attr("id","shipping_name_field");
	$("#shipping_name_field").append($("#shipping_last_name").detach());
	$("#shipping_name_field").append("<div class='clear'></div>");
	$("#shipping_last_name_field").remove();
	$("#shipping_address_1_field").attr("id","shipping_address_field");
	$("#shipping_address_field").append($("#shipping_address_2").detach());
	$("#shipping_address_2_field").remove();
	$("#shipping_address_field").append("<div class='clear'></div>");
	$("#shipping_company").attr("placeholder","Company Name(optional)");
});