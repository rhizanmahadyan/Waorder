(function(w, d){
	let b = d.getElementsByTagName('body')[0],
	e = d.documentElement,
	wWidth = w.innerWidth || e.clientWidth || b.clientWidth,
	wHeight = w.innerHeight || e.clientHeight|| b.clientHeight;

	let dropDownMenu = document.querySelectorAll('.menu-item-has-children');
	for(let i=0; i < dropDownMenu.length; i++){
		dropDownMenu[i].onclick = function(){
		 	let submenu = dropDownMenu[i].querySelector('.sub-menu');
			if (submenu.classList.contains('submenushow')) {
				submenu.style.visibility = 'hidden';
				submenu.style.opacity = '0';
				submenu.style.height = '0px';
				submenu.classList.remove('submenushow');
			}else{
				submenu.style.visibility = 'visible';
				submenu.style.opacity = '1';
				submenu.style.height = 'auto';
				submenu.classList.add('submenushow');
			}
		}
	}

	let font = d.createElement('link');
	font.async = true;
	font.type = 'text/css';
	font.rel = 'stylesheet';
	font.href = 'https://fonts.googleapis.com/css?family=Quicksand:400,700';

	b.appendChild(font);

	let icon = d.createElement('link');
	icon.async = true;
	icon.type = 'text/css';
	icon.rel = 'stylesheet';
	icon.href = 'https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css';

	b.appendChild(icon);

	let lazyload = d.createElement('script'),
	lazyloadVersion = !('IntersectionObserver' in w) ? '8.17.0' : '10.19.0';
	lazyload.async = true;
	lazyload.src = 'https://cdn.jsdelivr.net/npm/vanilla-lazyload@' + lazyloadVersion + '/dist/lazyload.min.js';
	w.lazyLoadOptions = {elements_selector: '.lazy'};

	b.appendChild(lazyload);

	let slider = d.createElement('script');
	slider.async = true;
	slider.src = 'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.1/min/tiny-slider.js';
	b.appendChild(slider);

	slider.onload = function(){
		let slider = d.querySelector('.slider');
		if( typeof(slider) != 'undefined' && slider != null ){
			let sl = tns({
				container: '.slider',
				items: 1,
				slideBy: 'page',
				autoplay: true,
				speed: 300,
				autoplay: true,
				autoplayHoverPause: true,
				autoplayTimeout: 2500,
				swipeAngle: false,
				controls: false,
				arrowKeys: false,
				autoplayButton: false,
				autoplayText: ['▶','stop'],
				lazyload: '.tns-lazy-img',
			});
		}
	}
	/*
	zoomed photo on mouse hover
	 */
	let bigphoto = document.getElementById('bigphoto');
	if( typeof(bigphoto) != 'undefined' && bigphoto != null ){
		let zoomedImage = bigphoto.parentNode;

		zoomedImage.addEventListener('mouseenter', function(e) {
			this.style.backgroundImage = 'url('+ bigphoto.src +')';
			this.style.backgroundSize = "200%";
			bigphoto.style.opacity = 0;
		}, false);

		zoomedImage.addEventListener('mousemove', function(e) {
			// getBoundingClientReact gives us various information about the position of the element.
			var dimentions = this.getBoundingClientRect();

			// Calculate the position of the cursor inside the element (in pixels).
			var x = e.clientX - dimentions.left;
			var y = e.clientY - dimentions.top;

			// Calculate the position of the cursor as a percentage of the total size of the element.
			var xpercent = Math.round(100 / (dimentions.width / x));
			var ypercent = Math.round(100 / (dimentions.height / y));

			// Update the background position of the image.
			this.style.backgroundPosition = xpercent+'% ' + ypercent+'%';

		}, false);

		zoomedImage.addEventListener('mouseleave', function(e) {
			this.style.backgroundSize = "cover";
			this.style.backgroundPosition = "center";
			this.style.backgroundImage = '';
			this.style.backgroundSize = '100%';
			bigphoto.style.opacity = 1;
		}, false);
	}

	let productboxs = d.querySelectorAll('.productbox');
	for(let i=0; i < productboxs.length; i++){
		let height = productboxs[i].offsetWidth;
		let thumb = productboxs[i].querySelector('.thumb');
		thumb.style.height = height+'px';
	}

	let photoboxs = d.querySelectorAll('.photo');
	for(let i=0; i < photoboxs.length; i++){
		let height = photoboxs[i].offsetWidth;
		let img = photoboxs[i].querySelector('.photobig');
		img.style.height = height+'px';
	}

}(window, document));

function photoChanger(ini){
	let parent = ini.parentNode.parentNode,
	photo = parent.querySelector('img#bigphoto'),
	changer = ini.getAttribute('data-image-full');

	photo.src = changer;
	return;
}

function productsFilter(ini){
	window.location.replace(ini.value);
}

function productOptionSize(ini){
	document.querySelector('[name="order_item_size"]').value = ini.value;
}

function productOptionColor(ini){
	document.querySelector('[name="order_item_color"]').value = ini.value;
}

function productOptionCustom(ini, customPrice){
	document.querySelector('[name="order_item_custom_value"]').value = ini.value;
	if( customPrice !== 0 ){
		document.querySelector('[name="order_item_price"]').value = parseInt(customPrice);
		document.querySelector('#price-view').innerHTML = main.currency.format(customPrice);
	}
}

function productOptionQty(ini,plusminus){
	let inputQty = ini.parentNode.querySelector('input[type=number]'),
	oldInputQtyValue = inputQty.value,
	newInputQtyValue = 1
	if( plusminus == 'minus' ){
		if( oldInputQtyValue <= 1 ){
			newInputQtyValue = 1;
		}else{
			newInputQtyValue  = parseInt(oldInputQtyValue) - 1;
		}
	}else{
		newInputQtyValue  = parseInt(oldInputQtyValue) + 1;
	}

	inputQty.value = newInputQtyValue;
}

function cartItemChangeQty(ini,plusminus){
	let inputQty = ini.parentNode.querySelector('input[type=number]'),
	cartItems = localStorage.getItem('cart_items') ? JSON.parse(localStorage.getItem('cart_items')) : [],
	order_button = localStorage.getItem('order_button') ? localStorage.getItem('order_button') : 'multi',
	oldInputQtyValue = inputQty.value,
	newInputQtyValue = 1,
	newCartItems = [];

	if( order_button == 'single' ){
		cartItems = localStorage.getItem('single_cart_item') ? JSON.parse(localStorage.getItem('single_cart_item')) : [];
	}

	if( plusminus == 'minus' ){
		if( oldInputQtyValue <= 1 ){
			newInputQtyValue = 1;
		}else{
			newInputQtyValue  = parseInt(oldInputQtyValue) - 1;
		}
	}else{
		newInputQtyValue  = parseInt(oldInputQtyValue) + 1;
	}

	inputQty.value = newInputQtyValue;

	cartItems.forEach( function(item, i) {
		if( inputQty.getAttribute('item_id') == item.cart_id ){
			item.order_item_qty = newInputQtyValue;
		}
		newCartItems.push(item);
	});

	if( order_button == 'single' ){
		localStorage.setItem('single_cart_item', JSON.stringify(newCartItems));
	}else{
		localStorage.setItem('cart_items', JSON.stringify(newCartItems));
	}
	loadCartItems();
}

function basketItemsCounter(){
	let basket = document.getElementById('basketItemsCounter');
	cartItems = localStorage.getItem('cart_items') ? JSON.parse(localStorage.getItem('cart_items')) : [];

	if( basket ){
		basket.innerHTML = cartItems.length;
	}
}
basketItemsCounter();

function loadCartItems(){
	let cart = document.getElementById('cartItems');
	cartItems = localStorage.getItem('cart_items') ? JSON.parse(localStorage.getItem('cart_items')) : [],
	order_button = localStorage.getItem('order_button') ? localStorage.getItem('order_button') : 'multi',
	atc_button = localStorage.getItem('add_to_cart_button') ? localStorage.getItem('add_to_cart_button') : 'false',
	appendItems = '',
	varian = '',
	total = 0,
	subtotal = 0,
	weight = 0,
	subweight = 0,
	formbox = document.getElementById('cartWa'),
	form = formbox.querySelector('form'),
	cartEmpty = formbox.querySelector('#cartEmpty'),
	cartAdd = formbox.querySelector('#cartAdd'),
	subdistrict_id = form.querySelector('[name="subdistrict_id"]');

	if( order_button == 'single' ){
		cartItems = localStorage.getItem('single_cart_item') ? JSON.parse(localStorage.getItem('single_cart_item')) : [];
		formbox.querySelector('[name="multi_item_order"]').value = 0;
	}

	cartItems.forEach( function(item, i) {
		varian = '';
		subtotal = parseInt(item.order_item_price) * parseInt(item.order_item_qty);
		total = total + subtotal;
		subweight = parseInt(item.order_item_weight) * parseInt(item.order_item_qty);
		weight = weight + subweight;

		if( 'order_item_color' in item ){
			varian += '<span>Warna: '+item.order_item_color+'</span>';
		}

		if( 'order_item_custom_name' in item && 'order_item_custom_value' in item ){
			varian += '<span>'+item.order_item_custom_name+': '+item.order_item_custom_value+'</span>';
		}

		if( varian !== '' ){
			varian = varian.replace('</span><span>', '</span>, <span>');
			varian = '<div class="varian">'+varian+'</div>';
		}

		appendItems += '<div class="item clear"><div class="thumb"><img src="'+item.order_item_photo+'" id="orderItemPhoto"/></div><div class="detailbox"><div class="detail"><h3>'+item.order_item_name+'</h3></div>'+varian+'<div class="optione clear"><div class="optione-price">'+main.currency.format(item.order_item_price)+'</div><div class="optione-qty"><div class="optione-qty-changer clear"><button type="button" class="minus" onclick="cartItemChangeQty(this,\'minus\');">-</button><input min="1" type="number" value="'+item.order_item_qty+'" name="order_item_qty" item_id="'+item.cart_id+'"><button type="button" class="plus" onclick="cartItemChangeQty(this,\'plus\');">+</button></div><i class="icon ion-md-trash color-scheme-text" onclick="deleteCartItem(\''+item.cart_id+'\');"></i></div></div></div></div>';

		//let order_note = '<div class="order-note"><textarea placeholder="Catatan untuk penjual" id="orderNoteItem'+item.order_item_id+'"></textarea></div>';

	});

	cart.innerHTML = appendItems;

	if( cartItems.length < 1 ){
		form.style.display = 'none';
		cartEmpty.style.display = 'flex';
		cartAdd.style.display = 'none';
	}else{
		if( atc_button == 'false' ){
			form.style.display = 'block';
			cartAdd.style.display = 'none';
		}else{
			form.style.display = 'none';
			cartAdd.style.display = 'block';
		}
		cartEmpty.style.display = 'none';

		if( subdistrict_id && subdistrict_id.value.length !== 0 ){
			let url = main.ajax_url + '?action=get_ongkir&nonce='+main.nonce+'&destination='+subdistrict_id.value+'&weight='+weight,
			ongkirField = form.querySelector('#orderOngkir'),
			loader = form.querySelector('.loader');

			fetch(url)
			.then((respons) => respons.json())
			.then(function(json){
				if( json == '404' ){
					alert('Gagal mendapatkan data ongkir, silahkan hubungi admin');
				}else{
					ongkirField.options.length = 0;
					for (let i = 0; i < json.length; i++) {
						let name = main.currency.format(json[i].value)+' ( '+json[i].courier+' '+json[i].service+' )';
						ongkirField.options.add(new Option(name, json[i].value));
					}

					let totalPrice = parseInt(total) + parseInt(json[0].value);

					formbox.querySelector('#orderTotal').innerHTML = main.currency.format(totalPrice);
					formbox.querySelector('[name="order_total"]').value = totalPrice;
					formbox.querySelector('[name="order_courier"]').value = main.currency.format(json[0].value)+' ( '+json[0].courier+' '+json[0].service+' )';

					loader.style.display = 'none';
				}

			})
			.catch(function(error){
				console.log(error);
			});
		}else{

			formbox.querySelector('#orderTotal').innerHTML = main.currency.format(total);
			formbox.querySelector('[name="order_total"]').value = total;

		}
	}

	let subtotalview = formbox.querySelector('#orderSubTotal');
	if(subtotalview){
		subtotalview.innerHTML = main.currency.format(total);
	}
	formbox.querySelector('[name="order_sub_total"]').value = total;
	formbox.querySelector('[name="order_item_weight"]').value = weight;

	let formwa = formbox.querySelector('#formWA');
	let formwabody = formbox.querySelector('#formWABody');
	let formbodyheight = formwa.offsetHeight - 60;

	if( formwabody.offsetHeight < formbodyheight ){
		formwa.style.height = 'auto';
	}
	basketItemsCounter();

}

//loadCartItems();

function deleteCartItem(item_id){
	let cartItems = localStorage.getItem('cart_items') ? JSON.parse(localStorage.getItem('cart_items')) : [],
	newCartItems = [],
	order_button = localStorage.getItem('order_button') ? localStorage.getItem('order_button') : 'multi';

	if( order_button == 'single' ){
		window.location.reload();
	}else{
		cartItems.forEach( function(item, i) {
			if( item_id !== item.cart_id ){
				newCartItems.push(item);
			}
		});

		localStorage.setItem('cart_items', JSON.stringify(newCartItems));
		loadCartItems();
	}
}

function openCartWA(){
	let form = document.getElementById('cartWa');
	localStorage.setItem('order_button', 'multi');
	localStorage.setItem('add_to_cart_button', 'false');

	loadCartItems();

	form.classList.add('open');
}

function addToCartWA(ini){
	let parentForm = ini.parentNode.parentNode,
	formData = parentForm.elements,
	inputs = {},
	formbox = document.getElementById('cartWa'),
	form = formbox.querySelector('form'),
	cartItems = localStorage.getItem('cart_items') ? JSON.parse(localStorage.getItem('cart_items')) : [],
	itemExists = false,
	cartId = '';

	localStorage.setItem('order_button', 'multi');
	localStorage.setItem('add_to_cart_button', 'true');

	for (let i = 0; i < formData.length; i++) {
		let key = formData[i].name;
		let type = formData[i].type;
		if( key !== '' && type !== 'radio' ){
			inputs[key] = formData[i].value;
			// let input = form.querySelector('[name="'+key+'"]');
			// if(typeof input !== 'undefined' && input !== null ){
			// 	input.value = formData[i].value;
			// }
		}
	}

	cartId = inputs.order_item_id;

	if(typeof inputs.order_item_color !== 'undefined' && inputs.order_item_color !== '' ){
		cartId = cartId + inputs.order_item_color;
	}
	if(typeof inputs.order_item_custom_name !== 'undefined' && inputs.order_item_custom_name !== '' ){
		cartId = cartId + inputs.order_item_custom_name;
	}
	if(typeof inputs.order_item_custom_name !== 'undefined' && inputs.order_item_custom_value !== '' ){
		cartId = cartId + inputs.order_item_custom_value;
	}

	inputs.cart_id = cartId;

	cartItems.forEach( function(item, i) {

		if( inputs.cart_id == item.cart_id ){
			cartItems[i].order_item_qty  = parseInt(item.order_item_qty) + parseInt(inputs.order_item_qty);
			itemExists = true;
		}

	});

	if( itemExists  == false ){
		cartItems.push(inputs);
	}

	localStorage.setItem('cart_items', JSON.stringify(cartItems));

	loadCartItems();

	formbox.classList.add('open');
}

function singleCartWA(ini){
	let parentForm = ini.parentNode.parentNode,
	formData = parentForm.elements,
	inputs = {},
	form = document.getElementById('cartWa'),
	cartItems = [],
	cartId = '';

	localStorage.setItem('order_button', 'single');
	localStorage.setItem('add_to_cart_button', 'false');

	for (let i = 0; i < formData.length; i++) {
		let key = formData[i].name;
		let type = formData[i].type;
		if( key !== '' && type !== 'radio' ){
			inputs[key] = formData[i].value;
			// let input = form.querySelector('[name="'+key+'"]');
			// if(typeof input !== 'undefined' && input !== null ){
			// 	input.value = formData[i].value;
			// }
		}
	}

	cartId = inputs.order_item_id;

	if(typeof inputs.order_item_color !== 'undefined' && inputs.order_item_color !== '' ){
		cartId = cartId + inputs.order_item_color;
	}
	if(typeof inputs.order_item_custom_name !== 'undefined' && inputs.order_item_custom_name !== '' ){
		cartId = cartId + inputs.order_item_custom_name;
	}
	if(typeof inputs.order_item_custom_name !== 'undefined' && inputs.order_item_custom_value !== '' ){
		cartId = cartId + inputs.order_item_custom_value;
	}

	inputs.cart_id = cartId;

	cartItems.push(inputs);

	localStorage.setItem('single_cart_item', JSON.stringify(cartItems));

	loadCartItems();

	form.classList.add('open');
}

function closeOrderWA(){
	window.location.reload();
}

function chooseOngkir(ini){
	let form = document.getElementById('cartWa'),
	weight = form.querySelector('[name="order_item_weight"]').value,
	ongkir = ini.value,
	orderSubTotal = form.querySelector('[name="order_sub_total"]').value,
	orderTotal = form.querySelector('[name="order_total"]'),
	orderTotalView = form.querySelector('#orderTotal');
	orderCourier = form.querySelector('[name="order_courier"]');

	let total = parseInt(orderSubTotal) + parseInt(ongkir);
	orderTotal.value = total;
	orderTotalView.innerHTML = main.currency.format(total);
	orderCourier.value = ini.options[ini.selectedIndex].text;
}

function orderWA(ini){
	let formData = ini.elements,
	inputs = {},
	wa = 'https://web.whatsapp.com/send',
	orderDetail = '',
	subtoal = 0,
	total = 0,
	number = '';
	subdistrict = '',
	ajax = new XMLHttpRequest(),
	cartItems = localStorage.getItem('cart_items') ? JSON.parse(localStorage.getItem('cart_items')) : [],
	cart = document.getElementById('cartWa'),
	order_button = localStorage.getItem('order_button') ? localStorage.getItem('order_button') : 'multi';

	if( order_button == 'single' ){
		cartItems = localStorage.getItem('single_cart_item') ? JSON.parse(localStorage.getItem('single_cart_item')) : [];
	}

	if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        wa = 'whatsapp://send';
	}

	for (let i = 0; i < formData.length; i++) {
		let key = formData[i].name;
		if( key !== '' ){
			inputs[key] = formData[i].value;
		}
	}

	cartItems.forEach( function(item, i) {
		subtotal = parseInt(item.order_item_price) * parseInt(item.order_item_qty);
		total = total + subtotal;

		if( inputs.multi_item_order == '1' ){
			number = i + 1;
			number = number + '.';
		}

		orderDetail += '%0A*' + number + item.order_item_name + '* %0A';

		orderDetail += '  Quantity : ' + item.order_item_qty + ' pcs%0A';

		// if(typeof item.order_item_size !== 'undefined' && item.order_item_size !== '' ){
		// 	orderDetail += '  Ukuran : ' + item.order_item_size + '%0A';
		// }
		if(typeof item.order_item_color !== 'undefined' && item.order_item_color !== '' ){
			orderDetail += '  Warna : ' + item.order_item_color + '%0A';
		}
		if(typeof item.order_item_custom_name !== 'undefined' && item.order_item_custom_name !== '' ){
			orderDetail += '  '+item.order_item_custom_name+' : ' + item.order_item_custom_value + '%0A';
		}
		orderDetail += '  Harga Satuan : ' + main.currency.format(item.order_item_price) + '%0A';
		orderDetail += '  Total Harga : ' + main.currency.format(subtotal) + '%0A';
		// orderDetail += '  Catatan : ' + cart.querySelector('#orderNoteItem'+item.order_item_id).value + '%0A';
		//
		// cartItems[i].order_note = cart.querySelector('#orderNoteItem'+item.order_item_id).value;
	});

	if(typeof inputs.order_courier !== 'undefined' && inputs.order_courier !== '' ){
		orderDetail += '%0ASub Total : *' + main.currency.format(total) + '*%0A';
		orderDetail += 'Ongkir : *' + inputs.order_courier+ '*%0A';
		orderDetail += 'Total : *' + main.currency.format(inputs.order_total) + '*%0A';
		subdistrict = '%0A' + inputs.subdistrict;
	}else{
		orderDetail += '%0ASub Total : *' + main.currency.format(total) + '* ( _belum termasuk ongkir_ )%0A';
	}

	if(typeof inputs.payment_type !== 'undefined' && inputs.payment_type !== '' ){
		orderDetail += 'Pembayaran : *' + inputs.payment_type + '*%0A';
	}

	let url = wa + '?phone=' + inputs.admin_phone + '&text=' + inputs.gretings + '.%0A' + orderDetail + '--------------------------------%0A*Nama :*%0A' + inputs.full_name + ' (' + inputs.phone + ') %0A%0A*Alamat :*%0A' + inputs.address.replace(/(\r\n|\n|\r)/gm,'%0A') + subdistrict + '%0A%0A' +'Via ' + location.href;

	inputs.order_items = JSON.stringify(cartItems);

	ajax.open('POST', main.ajax_url + '?action=order_create');
	ajax.setRequestHeader('Content-Type', 'application/json');
	ajax.setRequestHeader('nonce', inputs.nonce);
	ajax.onload = function() {
		if (ajax.status === 200) {

			console.log(ajax.responseText);
		}
	};

	ajax.send(JSON.stringify(inputs));


	//console.log(url);


	let w = 960,h = 540,left = Number((screen.width / 2) - (w / 2)),top = Number((screen.height / 2) - (h / 2)),popupWindow = window.open(url, '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=1, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

	popupWindow.focus();

	if( order_button == 'multi' ){
		localStorage.removeItem('cart_items');
		loadCartItems();
	}

	return false;
}

function openHelpWA(tujuan = false){
	let form = document.getElementById('helpViaWa');

	if( tujuan ){
		form.querySelector('[name=destination]').value = tujuan;
	}
	form.classList.add('open');

	let formwa = form.querySelector('#formHelpWA');
	let formwabody = form.querySelector('#formHelpWABody');
	let formbodyheight = formwa.offsetHeight - 60;

	if( formwabody.offsetHeight < formbodyheight ){
		formwa.style.height = 'auto';
	}
}

function closeHelpWA(){
	let form = document.getElementById('helpViaWa');
	form.classList.remove('open');
}

function helpWA(ini){
	let formData = ini.elements,
	inputs = {},
	wa = 'https://web.whatsapp.com/send',
	ajax = new XMLHttpRequest();

	if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        wa = 'whatsapp://send';
	}

	for (let i = 0; i < formData.length; i++) {
		let key = formData[i].name;
		if( key !== '' ){
			inputs[key] = formData[i].value;
		}
	}

	let message = inputs.message.replace(/\n/g, '%0A');

	let url = wa + '?phone=' + inputs.destination + '&text=' + inputs.gretings + '.%0A' + 'Saya *' + inputs.full_name + '*%0A%0A ' + '💬 ' + message + '%0A%0A ' + 'Via ' + location.href;


	let w = 960,h = 540,left = Number((screen.width / 2) - (w / 2)),top = Number((screen.height / 2) - (h / 2)),popupWindow = window.open(url, '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=1, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

	popupWindow.focus();

	return false;
}

window.addComment=function(a){function b(){c(),g()}function c(a){if(t&&(m=j(r.cancelReplyId),n=j(r.commentFormId),m)){m.addEventListener("touchstart",e),m.addEventListener("click",e);for(var b,c=d(a),g=0,h=c.length;g<h;g++)b=c[g],b.addEventListener("touchstart",f),b.addEventListener("click",f)}}function d(a){var b,c=r.commentReplyClass;return a&&a.childNodes||(a=q),b=q.getElementsByClassName?a.getElementsByClassName(c):a.querySelectorAll("."+c)}function e(a){var b=this,c=r.temporaryFormId,d=j(c);d&&o&&(j(r.parentIdFieldId).value="0",d.parentNode.replaceChild(o,d),b.style.display="none",a.preventDefault())}function f(b){var c,d=this,e=i(d,"belowelement"),f=i(d,"commentid"),g=i(d,"respondelement"),h=i(d,"postid");e&&f&&g&&h&&(c=a.addComment.moveForm(e,f,g,h),!1===c&&b.preventDefault())}function g(){if(s){var a={childList:!0,subTree:!0};p=new s(h),p.observe(q.body,a)}}function h(a){for(var b=a.length;b--;)if(a[b].addedNodes.length)return void c()}function i(a,b){return u?a.dataset[b]:a.getAttribute("data-"+b)}function j(a){return q.getElementById(a)}function k(b,c,d,e){var f=j(b);o=j(d);var g,h,i,k=j(r.parentIdFieldId),p=j(r.postIdFieldId);if(f&&o&&k){l(o),e&&p&&(p.value=e),k.value=c,m.style.display="",f.parentNode.insertBefore(o,f.nextSibling),m.onclick=function(){return!1};try{for(var s=0;s<n.elements.length;s++)if(g=n.elements[s],h=!1,"getComputedStyle"in a?i=a.getComputedStyle(g):q.documentElement.currentStyle&&(i=g.currentStyle),(g.offsetWidth<=0&&g.offsetHeight<=0||"hidden"===i.visibility)&&(h=!0),"hidden"!==g.type&&!g.disabled&&!h){g.focus();break}}catch(t){}return!1}}function l(a){var b=r.temporaryFormId,c=j(b);c||(c=q.createElement("div"),c.id=b,c.style.display="none",a.parentNode.insertBefore(c,a))}var m,n,o,p,q=a.document,r={commentReplyClass:"comment-reply-link",cancelReplyId:"cancel-comment-reply-link",commentFormId:"commentform",temporaryFormId:"wp-temp-form-div",parentIdFieldId:"comment_parent",postIdFieldId:"comment_post_ID"},s=a.MutationObserver||a.WebKitMutationObserver||a.MozMutationObserver,t="querySelector"in q&&"addEventListener"in a,u=!!q.documentElement.dataset;return t&&"loading"!==q.readyState?b():t&&a.addEventListener("DOMContentLoaded",b,!1),{init:c,moveForm:k}}(window);
