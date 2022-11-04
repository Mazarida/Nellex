var basketTimeout;
var totalSum;
var timerBasketUpdate = false;

function deleteItemFromBasket(id){
	$('.basket-container').addClass('loaded');
	$.ajax({
		type: "POST",
		url: '/ajax/delete_from_basket.php',
		data: { id: id },
		success: function (data) {
			if (data != '') {
				$('#big_basket').html(data);
			}
		}
	});
}

function setQuantity(basketId, ratio, direction){
	$('.basket-container').addClass('loaded');
	var currentValue = BX("QUANTITY_INPUT_" + basketId).value,
		newVal;

	ratio = parseInt(ratio, 10);
	curValue = parseInt(currentValue, 10);
	curValue = (direction == 'up') ? curValue + ratio : curValue - ratio;

	if (curValue < 0) {
		curValue = 0;
	}

	if (curValue > 0) {
		BX("QUANTITY_INPUT_" + basketId).value = curValue;
		BX("QUANTITY_INPUT_" + basketId).defaultValue = currentValue;

		totalSum = 0;
		$('#basket_line .basket_fly tr[data-id='+basketId+']').closest('table').find("tbody tr[data-id]").each(function(i, element) {
			id = $(element).attr("data-id");
			count = BX("QUANTITY_INPUT_" + id).value;

			price = $(document).find("#basket_form input[name=item_price_"+id+"]").val();
			sum = count*price;
			totalSum += sum;
			$(document).find("#basket_form [data-id="+id+"] .summ-cell .price").html(sum);
		});

		$("#basket_form .itog span.price").html(totalSum);
		$("#basket_form .itog div.discount").fadeTo("slow", 0.2);

		if (timerBasketUpdate){
			clearTimeout(timerBasketUpdate);
			timerBasketUpdate = false;
		}

		timerBasketUpdate = setTimeout(function(){
			updateQuantity('QUANTITY_INPUT_' + basketId, basketId, ratio);
			timerBasketUpdate = false;
		}, 700);
	}
}

function updateQuantity(controlId, basketId, ratio, animate) {
	$('.basket-container').addClass('loaded');
	var oldVal = BX(controlId).defaultValue,
		newVal = parseFloat(BX(controlId).value) || 0,
		is_int_ratio = (ratio % 1 == 0);
	bValidChange = false; // if quantity is correct for this ratio

	if (!newVal) {
		bValidChange = false;
		BX(controlId).value = oldVal;
	}

	if ($("#"+controlId).hasClass('focus')) {
		newVal -= newVal % ratio;
	}

	newVal = is_int_ratio ? parseInt(newVal) : parseFloat(newVal).toFixed(1);

	if (isRealValue(BX("QUANTITY_SELECT_" + basketId))) {
		var option,
			options = BX("QUANTITY_SELECT_" + basketId).options,
			i = options.length;
	}

	while (i--) {
		option = options[i];
		if (parseFloat(option.value).toFixed(2) == parseFloat(newVal).toFixed(2)) option.selected = true;
	}

	BX("QUANTITY_" + basketId).value = newVal; // set hidden real quantity value (will be used in POST)
	BX("QUANTITY_INPUT_" + basketId).value = newVal; // set hidden real quantity value (will be used in POST)

	$('form[name^=basket_form]').prepend('<input type="hidden" name="BasketRefresh" value="Y" />');

	$.post('/include/basket/basket.php', $("form[name^=basket_form]").serialize(), $.proxy(function(data) {
		$('#big_basket').html(data);
		//if (timerBasketUpdate == false) {
		//	basketFly('open');
		//}
		$('form[name^=basket_form] input[name=BasketRefresh]').remove();
	}));
}

function changePropBasket(id, prop_id, value) {
	//$('.basket-container').addClass('loaded');
	$.ajax({
		type: "POST",
		url: '/ajax/change_prop_basket_size.php',
		data: {
			id: id,
			prop_id: prop_id,
			value: value
		},
		success: function (data) {
			if (data != '') {
				$('#big_basket').html(data);
			}
		}
	});
}

//function delete_all_items(type, item_section, correctSpeed){
//	var index=(type=="delay" ? "2" : "1");
//	if(type == "na")
//		index = 4;
//	$.post( arNextOptions['SITE_DIR']+'ajax/show_basket_fly.php', 'PARAMS='+$("#basket_form").find("input#fly_basket_params").val()+'&TYPE='+index+'&CLEAR_ALL=Y', $.proxy(function( data ) {
//		basketFly('open');
//		$('.in-cart').hide();
//		$('.in-cart').closest('.button_block').removeClass('wide');
//		$('.to-cart').show();
//		$('.to-cart').removeClass("clicked");
//		$('.counter_block').show();
//		$('.wish_item').removeClass("added");
//		$('.wish_item').find('.value').show();
//		$('.wish_item').find('.value.added').hide();
//		getActualBasket();
//
//		var eventdata = {action:'loadBasket'};
//		BX.onCustomEvent('onCompleteAction', [eventdata]);
//	}));
//}

function deleteProduct(basketId, itemSection, item, th){
	function _deleteProduct(basketId, itemSection, product_id){
		arStatusBasketAspro = {};
		$.post('/ajax/item.php', 'delete_item=Y&item='+product_id, $.proxy(function( data ){
			basketFly('open');
			getActualBasket();
			$('.to-cart[data-item='+product_id+']').removeClass("clicked");
		}));
	}

	var product_id = th.attr("product-id");
	if (checkCounters()) {
		console.log(basketId);
		console.log(itemSection);
		console.log(item);
		console.log(th);
		//delFromBasketCounter(item);
		//setTimeout(function(){
		//	_deleteProduct(basketId, itemSection, product_id);
		//}, 100);
	} else{
		console.log(basketId);
		console.log(itemSection);
		console.log(item);
		console.log(th);
		//_deleteProduct(basketId, itemSection, product_id);
	}
}

//function delayProduct(basketId, itemSection, th){
//	var product_id=th.attr("product-id");
//	$.post( arNextOptions['SITE_DIR']+'ajax/item.php', 'wish_item=Y&item='+product_id+'&quantity='+th.find('#QUANTITY_'+basketId).val(), $.proxy(function( data ){
//		basketFly('open');
//		getActualBasket(th.attr('data-iblockid'));
//		$('.to-cart[data-item='+product_id+']').removeClass("clicked");
//		arStatusBasketAspro = {};
//		var eventdata = {action:'loadBasket'};
//		BX.onCustomEvent('onCompleteAction', [eventdata]);
//	}));
//}

//function addProduct(basketId, itemSection, th){
//	var product_id=th.attr("product-id");
//	$.post( arNextOptions['SITE_DIR']+'ajax/item.php', 'add_item=Y&item='+product_id+'&quantity='+th.find('#QUANTITY_'+basketId).val(), $.proxy(function( data ) {
//		basketFly('open');
//		getActualBasket(th.attr('data-iblockid'));
//		arStatusBasketAspro = {};
//		var eventdata = {action:'loadBasket'};
//		BX.onCustomEvent('onCompleteAction', [eventdata]);
//	}));
//}

//function checkOutFly(event){
//	event = event || window.event;
//	var th = $(event.target).parent();
//	if (checkCounters('google')) {
//		checkoutCounter(1, th.data('text'), th.data('href'));
//	}
//	setTimeout(function(){
//		location.href = th.data('href');
//	}, 50);
//
//	return true;
//}

function isRealValue(obj){
	return obj && obj !== "null" && obj!== "undefined";
}
