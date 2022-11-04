(function () {
	'use strict';

	var initParent = BX.Sale.OrderAjaxComponent.init,
		getBlockFooterParent = BX.Sale.OrderAjaxComponent.getBlockFooter,
		editOrderParent = BX.Sale.OrderAjaxComponent.editOrder,
		initOptionsParent = BX.Sale.OrderAjaxComponent.initOptions,
		editDeliveryInfoParent = BX.Sale.OrderAjaxComponent.editDeliveryInfo,
		editFadeDeliveryContentParent = BX.Sale.OrderAjaxComponent.editFadeDeliveryContent;

	BX.namespace('BX.Sale.OrderAjaxComponentExt');

	// Скопировать ссылку с BX.Sale.OrderAjaxComponent в BX.Sale.OrderAjaxComponentExt
	BX.Sale.OrderAjaxComponentExt = BX.Sale.OrderAjaxComponent;

	// Вызвать родительский init и удалить ссылки «изменить» у всех блоков
	BX.Sale.OrderAjaxComponentExt.init = function (parameters) {
		initParent.apply(this, arguments);

		var editSteps = this.orderBlockNode.querySelectorAll('.bx-soa-editstep'), i;
		for (i in editSteps) {
			if (editSteps.hasOwnProperty(i)) {
				BX.remove(editSteps[i]);
			}
		}
	};

	// Удалить кнопки «Назад» и «Вперед» у блоков, т.к. все блоки должны быть развёрнуты
	BX.Sale.OrderAjaxComponentExt.getBlockFooter = function (node) {
		var parentNodeSection = BX.findParent(node, {className: 'bx-soa-section'});

		getBlockFooterParent.apply(this, arguments);

		BX.remove(parentNodeSection.querySelector('.pull-left'));
		BX.remove(parentNodeSection.querySelector('.pull-right'));
	};

	// Ненужным блокам-секциям добавляем css-класс bx-soa-section-hide. По нему можно скрыть ненужные блоки в css.
	// Раскрыть только нужные блоки.
	BX.Sale.OrderAjaxComponentExt.editOrder = function (section) {
		editOrderParent.apply(this, arguments);
		this.show(BX('bx-soa-basket')); // фокус на блок "Товары в корзине"

		this.editActivePropsBlock(true); // развернуть блок "Пользователь"
		this.editActiveRegionBlock(true); // развернуть блок "Регион доставки"
		this.editActiveDeliveryBlock(true); // развернуть блок "Доставка"
		this.editActivePaySystemBlock(true); // развернуть блок "Платежные системы"

		this.alignBasketColumns();

		if (!this.result.IS_AUTHORIZED) {
			this.switchOrderSaveButtons(true);
		}

		//setDescriptionDelivery(); // добававить описание, срок доставки и цену всем видам доставки
		// удалить описание выбранной доставки под списком доставок
		var neededHtml = $.parseHTML($('.order-page #bx-soa-delivery .bx-soa-pp-desc-container .bx-soa-pp-company-desc').html());
		if (neededHtml.length > 0) {
			if (neededHtml.length > 1) {
				$('.order-page #bx-soa-delivery .bx-soa-pp-desc-container .bx-soa-pp-company-desc').html(neededHtml[neededHtml.length - 1]);
			} else {
				$('.order-page #bx-soa-delivery .bx-soa-pp-desc-container .bx-soa-pp-company-desc').empty();
			}
		}
		//setDescriptionPaySystem(); // добававить описание всем видам платежных систем
		//$('#soa-property-3').mask('+7 (999) 999-99-99'); // маска на поле ввода телефона
	};

	// Оставить пустым. Если этого не сделать, то у анонимов при попытке оформления будет вываливаться эксепшен, по поводу отсутствия необходимых обязательных полей
	BX.Sale.OrderAjaxComponentExt.initFirstSection = function (parameters) {

	};

	//// Следующие функции нужны, чтобы вывести поля "Адрес доставки", убранные из блока "Пользователь" (в событиях в init.php), в блоке "Доставка"
    //
	//// Чтобы обращаться к "новым" свойствам, создать экземпляр "коллекции" и добавить его в наш объект.
	//// Для этого наследуется метод initOptions, но весь его текст не нужен, поэтому вызвать родительский метод и добавить нужную строку в конце.
	//BX.Sale.OrderAjaxComponentExt.initOptions = function() {
	//	initOptionsParent.apply(this, arguments);
	//	this.propertyDeliveryCollection = new BX.Sale.PropertyCollection(BX.merge({publicMode: true}, this.result.DELIVERY_PROPS));
	//};
    //
	//// Наследовать метод editDeliveryInfo
	//BX.Sale.OrderAjaxComponentExt.editDeliveryInfo = function(deliveryNode) {
	//	editDeliveryInfoParent.apply(this, arguments); //вызываем родителя
	//	var deliveryInfoContainer = deliveryNode.querySelector('.bx-soa-pp-company-desc'); //найти блок с описанием службы доставки
	//	var group, property, groupIterator = this.propertyDeliveryCollection.getGroupIterator(), propsIterator, htmlAddress;
    //
	//	//использовать коллекцию, инициализированную в предыдущем методе
	//	//var deliveryItemsContainer = BX.create('DIV', {props: {className: 'col-sm-12 bx-soa-delivery'}}); //создать контейнер для будущего поля
	//	var deliveryItemsContainer = BX.create('DIV', {props: {className: 'bx-soa-delivery'}}); //создать контейнер для будущего поля
	//	while (group = groupIterator()) {
	//		propsIterator =  group.getIterator();
	//		while (property = propsIterator()) {
	//			if (property.getGroupId() == 3) { //если это свойство является параметром доставки
	//				this.getPropertyRowNode(property, deliveryItemsContainer, false); //вставить свойство в подготовленный контейнер
	//				deliveryInfoContainer.appendChild(deliveryItemsContainer); //контейнер вместе со свойством в нём добавить в конце блока с описанием (deliveryInfoContainer)
	//			}
	//		}
	//	}
    //
     //   setTimeout(function () {
     //       if ($('#soa-property-7').length > 0 && typeof window.addresDostavki !== 'undefined') {
     //           $('#soa-property-7').val(window.addresDostavki);
     //       }
     //   }, 500);
	//	//var elemSoaProp7 = document.getElementById('soa-property-7');
	//	//if (this.result.DELIVERY_PROPS.properties[0].VALUE[0] !== undefined) {
	//	//	document.getElementById('soa-property-7').value = this.result.DELIVERY_PROPS.properties[0].VALUE[0];
	//	//	console.log(this.result.DELIVERY_PROPS.properties[0].VALUE[0]);
	//	//}
	//};
	//$('body').on('input', '#soa-property-7', function() {
	//	var soa7 = $(this);
     //   window.addresDostavki = soa7.val();
	//});
	//// Добиться того, чтобы ошибки о незаполненных полях выводились в тех блоках, в которых нужно
    //
	//// Унаследовать метод initValidation
	//// Помимо массива ORDER_PROP появляется массив DELIVERY_PROPS, который нужно показать компоненту при инициализации валидации.
	//// Записать его в отдельное свойство объекта - this.validation.deliveryProperties.
	//BX.Sale.OrderAjaxComponentExt.initValidation = function() {
	//	if (!this.result.ORDER_PROP || !this.result.ORDER_PROP.properties)
	//		return;
    //
	//	var properties = this.result.ORDER_PROP.properties,
	//		deliveryProps = this.result.DELIVERY_PROPS.properties,
	//		obj = {},
	//		deliveryObj = {},
	//		i;
    //
	//	for (i in properties) {
	//		if (properties.hasOwnProperty(i))
	//			obj[properties[i].ID] = properties[i];
	//	}
	//	for (i in deliveryProps) {
	//		if (deliveryProps.hasOwnProperty(i))
	//			deliveryObj[deliveryProps[i].ID] = deliveryProps[i];
	//	}
    //
	//	this.validation.properties = obj;
	//	this.validation.deliveryProperties = deliveryObj;
	//};
    //
	//// Создать свою функцию isValidDeliveryBlock: она будет создана по образу и подобию функции isValidPropertiesBlock
	//// Функция возвращает массив с ошибками, касающимися полей доставки, используя для валидации список полей js-массива this.validation.deliveryProperties.
	//BX.Sale.OrderAjaxComponentExt.isValidDeliveryBlock = function(excludeLocation) {
	//	if (!this.options.propertyValidation)
	//		return [];
    //
	//	var props = this.orderBlockNode.querySelectorAll('.bx-soa-customer-field[data-property-id-row]'),
	//		propsErrors = [],
	//		id, propContainer, arProperty, data, i;
    //
	//	for (i = 0; i < props.length; i++) {
	//		id = props[i].getAttribute('data-property-id-row');
    //
	//		if (!!excludeLocation && this.locations[id])
	//			continue;
    //
	//		propContainer = props[i].querySelector('.soa-property-container');
	//		if (propContainer) {
	//			arProperty = this.validation.deliveryProperties[id];
	//			data = this.getValidationData(arProperty, propContainer);
	//			propsErrors = propsErrors.concat(this.isValidProperty(data, true));
	//		}
	//	}
	//	return propsErrors;
	//};
    //
	//// editFadeDeliveryContent отвечает за содержимое блока "Доставка" в закрытом виде.
	//// В этом состоянии он должен выводить красный блок с описанием ошибки, при нажатии на который блок будет раскрываться.
	//BX.Sale.OrderAjaxComponentExt.editFadeDeliveryContent = function(node) {
	//	editFadeDeliveryContentParent.apply(this, arguments);
	//	if (this.initialized.delivery) { //проверить, была ли инициализирована доставка
	//		var validDeliveryErrors = this.isValidDeliveryBlock(); //вызывать наш метод
	//		if (validDeliveryErrors.length && BX.hasClass(BX.findParent(node),'bx-selected') == true) {
	//			this.showError(this.deliveryBlockNode, validDeliveryErrors);
	//		} else { //если ошибок нет и всё в порядке
	//			node.querySelector('.alert.alert-danger').style.display = 'none';
    //
	//			var section = BX.findParent(node.querySelector('.alert.alert-danger'), {className: 'bx-soa-section'});
    //
	//			node.setAttribute('data-visited', 'true');
	//			BX.removeClass(section, 'bx-step-error'); //убирать иконку, что есть ошибка в этом шаге
	//			BX.addClass(section, 'bx-step-completed'); //выставить, что блок валиден и готов
	//		}
	//	}
	//};
    //
	//// Метод saveOrder следует переопределять целиком, так как там изменения будут в середине кода внутри условия else.
	//// Этот метод получает объект result, внутри которого есть order.ERROR.PROPERTY, куда он и складывает по умолчанию все ошибки, связанные с пользовательскими свойствами.
	//BX.Sale.OrderAjaxComponentExt.saveOrder = function(result) {
	//	var res = BX.parseJSON(result), redirected = false;
	//	if (res && res.order)
	//	{
	//		result = res.order;
	//		this.result.SHOW_AUTH = result.SHOW_AUTH;
	//		this.result.AUTH = result.AUTH;
    //
	//		if (this.result.SHOW_AUTH) {
	//			this.editAuthBlock();
	//			this.showAuthBlock();
	//			this.animateScrollTo(this.authBlockNode);
	//		} else {
	//			if (result.REDIRECT_URL && result.REDIRECT_URL.length) {
	//				if (this.params.USE_ENHANCED_ECOMMERCE === 'Y') {
	//					this.setAnalyticsDataLayer('purchase', result.ID);
	//				}
    //
	//				redirected = true;
	//				document.location.href = result.REDIRECT_URL;
	//			}
    //
	//			if (result.ERROR.hasOwnProperty('PROPERTY')) {
	//				result.ERROR['DELIVERY'] = result.ERROR.PROPERTY;
	//				delete result.ERROR.PROPERTY;
	//			}
    //
	//			this.showErrors(result.ERROR, true, true);
	//		}
	//	}
    //
	//	if (!redirected) {
	//		this.endLoader();
	//		this.disallowOrderSave();
	//	}
	//};
})();