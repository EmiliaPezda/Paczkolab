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
				selectAddress = $('<select>', {name: "select address", id: "address_option"}),
                selectUser = $('<select>', {name: "select user", id: "user_option"}),
                selectSize = $('<select>', {name: "select size", id: "size_option"}),
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
			actionForm.append(selectAddress);
            actionForm.append(selectUser);
            actionForm.append(selectSize);
			actionForm.append(inputSubmit);
			viewParcel.append(tr);

			// Insert proper address
		    function insertAddress(address) {
		    	$.each(address, function() {
		    		tdAddress.text(address.city + ' ' + address.code + ', ' +  address.street + ' ' + address.flat);
		    	})
		    }

			let addressId = this.address_id;
			let urlAddress = '../../router.php/address/';

			// Show data from database ADDRESS in table
			$.ajax({
				type: 'GET',
				url: urlAddress + addressId,
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
			let urlUser = '../../router.php/user/';

			// Show data from database USER in table
			$.ajax({
				type: 'GET',
				url: urlUser + userId,
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
			let urlSize = '../../router.php/size/';

			// Show data from database SIZE in table
			$.ajax({
				type: 'GET',
				url: urlSize + sizeId,
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
        viewParcel.on('click', '.edit-btn', function() {

            let editForm = $(this).next('form');
            let edit = $(this).next('form').find('input[type=submit]');

            editForm.toggleClass('hide');

            let id = $(this).parent().parent().find('td[class=id]').text();
            let addressValue = $(this).parent().parent().find('td[class=address]').text();
            let nameValue = $(this).parent().parent().find('td[class=name]').text();
            let sizeValue = $(this).parent().parent().find('td[class=size]').text();


            //showing options during editing parcel
            let urlAddress = '../../router.php/address/',
                urlUser = '../../router.php/user/',
                urlSize = '../../router.php/size/';


            // Functions which get data from other classes
            let formEditSelect = $(this).siblings('form');

            let optionAddress = formEditSelect.children("#address_option"),
                optionUser = formEditSelect.children("#user_option"),
                optionSize = formEditSelect.children("#size_option");

            function showAddressOption(address) {
                $.each(address, function () {
                    let option = $('<option>');

                    optionAddress.append(option);
                    option.text(this.city + ' ' + this.code + ', ' + this.street + ' ' + this.flat);
                    option.val(this.id);

                })
            }

            function showUserOption(user) {
                $.each(user, function () {
                    let option = $('<option>');

                    optionUser.append(option);
                    option.text(this.name + ' ' + this.surname);
                    option.val(this.id);
                })
            }

            function showSizeOption(size) {
                $.each(size, function () {
                    let option = $('<option>');

                    optionSize.append(option);
                    option.text(this.size);
                    option.val(this.id);
                })
            }

            function loadDataToEditParcel() {

                $.ajax({
                    type: 'GET',
                    url: urlAddress,
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function (response) {
                        showAddressOption(response);
                    },
                    error: function (error) {
                        alert("Wystąpił błąd");
                        console.log(error);
                    }
                })

                $.ajax({
                    type: 'GET',
                    url: urlUser,
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function (response) {
                        showUserOption(response);
                    },
                    error: function (error) {
                        alert("Wystąpił błąd");
                    }
                })

                $.ajax({
                    type: 'GET',
                    url: urlSize,
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function (response) {
                        showSizeOption(response);
                    },
                    error: function (error) {
                        alert("Wystąpił błąd");
                    }
                })
            }

            loadDataToEditParcel();



            edit.on('click', function (e) {
                e.preventDefault();
                let addressid =  optionAddress.find(':selected').val();
                let nameid =  optionUser.find(':selected').val();
                let sizeid =  optionSize.find(':selected').val();



                $.ajax({
                    type: "PUT",
                    url: url,
                    data: {
                        id: id,
                        address_id: addressid,
                        user_id: nameid,
                        size_id: sizeid,

                    },
                    success: function (response) {
                        alert('Dane zostaną zaktualizowane');
                        location.reload();
                    },
                    error: function (error) {
                        alert("Wystąpił błąd");
                    }
                });
            })
        })
        }


});