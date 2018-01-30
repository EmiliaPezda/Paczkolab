$(document).ready(function() {

	let viewUser = $('#view-user'),
		url = '../../router.php/user/';

	//// Show USER data in the view/user
    function loadUserView() {

		$.ajax({
			type: 'GET',
			url: '../../router.php/user/',
			contentType: 'application/json',
			dataType: 'json',
			success: function(response){
				insertContentUser(response);
			},
		    error: function(error) {
            	alert( "Wystąpił błąd");
            }
		})
	}

	loadUserView();

	// USER
    // Create table element to put data from db 
	// Do action (edit, delete) on data in table
    function insertContentUser(user) {
    	$.each(user, function(){
    		let tr = $('<tr>'),
				tdId = $('<td>', {class: "id"}),
				tdAddress = $('<td>', {class: "address"}),
				tdName = $('<td>', {class: "name"}),
				tdSurname = $('<td>', {class: "surname"}),
				tdCredits = $('<td>', {class: "credits"}),
				tdAction = $('<td>', {class: "action"}),
				addressName = $('<p>', {class: "address_p"}),
				actionDelete = $('<button>', {class: "delete-btn"}).text('Usuń'),
				actionEdit = $('<button>', {class: "edit-btn"}).text('Edytuj'),
				actionForm = $('<form>', {class: "edit-form hide"}),
				inputAddress = $('<input>', {name: "address", id: "address"}),
				inputName = $('<input>', {name: "name", id: "name"}),
				inputSurname = $('<input>', {name: "surname", id: "surname"}),
				inputCredits = $('<input>', {name: "credits", id: "credits"}),
				inputSubmit = $('<input>', {type: "submit"});

			// Create table element
			tr.append(tdId);
			tr.append(tdAddress);
			tr.append(tdName);
			tr.append(tdSurname);
			tr.append(tdCredits);
			tr.append(tdAction);
			tdAddress.append(addressName);
			tdAction.append(actionDelete);
			tdAction.append(actionEdit);
			tdAction.append(actionForm);
			actionForm.append(inputName);
			actionForm.append(inputSurname);
			actionForm.append(inputCredits);
			actionForm.append(inputSubmit);
			viewUser.append(tr);

		    function insertAddress(address) {
		    	$.each(address, function() {
		    		addressName.text(address.city + ' ' + address.code + ' ' +  address.street + ' ' + address.flat);
		    	})
		    }

			let id = this.address_id;
			let url = '../../router.php/address/';

			// Show address from database ADDRESS in table
			$.ajax({
				type: 'GET',
				url: url + id,
				contentType: 'application/json',
				dataType: 'json',
				success: function(response){
					insertAddress(response);
				},
			    error: function(error) {
	            	alert( "Wystąpił błąd");
	            }
			})
			
			// Show content from database - USER
			tdId.text(this.id);
			tdName.text(this.name);
			tdSurname.text(this.surname);
			tdCredits.text(this.credits);
			tdAction.text(this.action);
    	})
    	// Edit USER data
    	viewUser.on('click', '.edit-btn', function(){
			let editForm = $(this).next('form');
			let edit = $(this).next('form').find('input[type=submit]');

			editForm.toggleClass('hide');

			let id = $(this).parent().parent().find('td[class=id]').text();
			let nameValue = $(this).parent().parent().find('td[class=name]').text();
			let surnameValue = $(this).parent().parent().find('td[class=surname]').text();
			let creditsValue = $(this).parent().parent().find('td[class=credits]').text();
			
			editForm.children('input[name=name]').val(nameValue);
			editForm.children('input[name=surname]').val(surnameValue);
			editForm.children('input[name=credits]').val(creditsValue);
			
			edit.on('click', function(e){
				e.preventDefault();
                                
				let addressid = this.address_id;
				let name = $(this).siblings('#name').val();
				let surname = $(this).siblings('#surname').val();
				let credits = $(this).siblings('#credits').val();

				$.ajax({
	                type: "PUT",
	                url: url,
	                data: {
	                	id: id,
						address_id: addressid,
						name: name,
						surname: surname,
						credits: credits,

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

		// Delete USER data
		viewUser.on('click', '.delete-btn', function(e){
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
    }
});