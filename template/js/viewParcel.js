$(document).ready(function() {

	let url = '../../router.php/parcel/',
		viewParcel = $('#view-parcel');

	//// Show PARCEL data in the view/parcel
    function loadParcelView() {

		$.ajax({
			type: 'GET',
			url: url,
			contentType: 'application/json',
			dataType: 'json',
			success: function(response){
				insertContentParcel(response);
			},
		    error: function(error) {
            	alert( "Wystąpił błąd");
            }
		})
	}
	loadParcelView();

	// PARCEL
    // Create table element to put data from db 
	// Do action (edit, delete) on data in table
    function insertContentParcel(parcel) {
    	$.each(parcel, function(){
    		let tr = $('<tr>'),
				tdId = $('<td>', {class: "id"}),
				tdAddress = $('<td>', {class: "address"}),
				tdName = $('<td>', {class: "name"}),
				tdSize = $('<td>', {class: "size"}),
				tdPrice = $('<td>', {class: "price"}),
				tdAction = $('<td>', {class: "action"}),
				actionDelete = $('<button>', {class: "delete-btn"}).text('Usuń'),
                actionEdit = $('<button>', {class: "edit-btn"}).text('Edytuj'),
				actionForm = $('<form>', {class: "edit-form hide"}),
				inputAddress = $('<input>', {name: "address", id: "address"}),
				inputName = $('<input>', {name: "name", id: "name"}),
				inputSize = $('<input>', {name: "size", id: "size"}),
				inputPrice = $('<input>', {name: "price", id: "price"}),
				inputSubmit = $('<input>', {type: "submit"});

			// Create table element
			tr.append(tdId);
			tr.append(tdAddress);
			tr.append(tdName);
			tr.append(tdSize);
			tr.append(tdPrice);
			tr.append(tdAction);
			tdAction.append(actionDelete);
            tdAction.append(actionEdit);
			tdAction.append(actionForm);
			actionForm.append(inputAddress);
			actionForm.append(inputName);
			actionForm.append(inputSize);
			actionForm.append(inputPrice);
			actionForm.append(inputSubmit);
			viewParcel.append(tr);

			// Insert proper address
		    function insertAddress(address) {
		    	$.each(address, function() {
		    		tdAddress.text(address.city + ' ' + address.code + ', ' +  address.street + ' ' + address.flat);
		    	})
		    }

			let addressId = this.address_id;
			let url = '../../router.php/address/';

			// Show data from database ADDRESS in table
			$.ajax({
				type: 'GET',
				url: url + addressId,
				contentType: 'application/json',
				dataType: 'json',
				success: function(response){
					insertAddress(response);
				},
			    error: function(error) {
	            	alert( "Wystąpił błąd");
	            }
			});

			// Insert proper name
			function insertName(user) {
		    	$.each(user, function() {
		    		tdName.text(user.name + ' ' + user.surname);
		    	})
		    }

			let userId = this.user_id;
			let url2 = '../../router.php/user/';

			// Show data from database USER in table
			$.ajax({
				type: 'GET',
				url: url2 + userId,
				contentType: 'application/json',
				dataType: 'json',
				success: function(response){
					insertName(response);
				},
			    error: function(error) {
	            	alert( "Wystąpił błąd");
	            }
			});

			// Insert proper size and price
			function insertSize(size) {
		    	$.each(size, function() {
		    		tdSize.text(size.size);
		    		tdPrice.text(size.price);
		    	})
		    }

			let sizeId = this.size_id;
			let url3 = '../../router.php/size/';

			// Show data from database SIZE in table
			$.ajax({
				type: 'GET',
				url: url3 + sizeId,
				contentType: 'application/json',
				dataType: 'json',
				success: function(response){
					insertSize(response);
				},
			    error: function(error) {
	            	alert( "Wystąpił błąd");
	            }
			});
			tdId.text(this.id);
    	});
		// Delete PARCEL data
		viewParcel.on('click', '.delete-btn', function(e){
			e.preventDefault();
		
			let id = $(this).parent().parent().find('td[class=id]').text();
			
			$.ajax({
                type: "DELETE",
                url: url,
                data: {
                    id: id
                },
                success: function(response) {
                    location.reload();
                    alert('Użytkownik zostanie usunięty');
                }    
            });
	       
		})

		//Edit PARCEL data
        viewParcel.on('click', '.edit-btn', function(){
            let editForm = $(this).next('form');
            let edit = $(this).next('form').find('input[type=submit]');

            editForm.toggleClass('hide');

            let id = $(this).parent().parent().find('td[class=id]').text();
            let addressValue = $(this).parent().parent().find('td[class=address]').text();
            let nameValue = $(this).parent().parent().find('td[class=name]').text();
            let sizeValue = $(this).parent().parent().find('td[class=size]').text();
            let priceValue = $(this).parent().parent().find('td[class=price]').text();

            editForm.children('input[name=address]').val(addressValue);
            editForm.children('input[name=name]').val(nameValue);
            editForm.children('input[name=size]').val(sizeValue);
            editForm.children('input[name=price]').val(priceValue);

            edit.on('click', function(e){
                e.preventDefault();

                //let addressid = this.address_id;
                let address = $(this).siblings('#address').val();
                let nameid = $(this).siblings('#name').val();
                let sizeid = $(this).siblings('#size').val();
                let price = $(this).siblings('#price').val();

                $.ajax({
                    type: "PUT",
                    url: url,
                    data: {
                        id: id,
                        address_id: address,
                        user_id: nameid,
                        size_id: sizeid,
                        price: price,

                    },
                    success: function(response) {
                        alert('Dane zostaną zaktualizowane');
                        location.reload();
                    },
                    error: function(error) {
                        alert( "Wystąpił błąd");
                    }
                });
            })
        })
    }

});