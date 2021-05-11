// Edit User
$(document).on('click', '.edit', function () {
    let user = $(this).closest('tr').data('id');
    let modal = $('#edit-user-form');

    $.ajax({
        type: 'GET',
        url: 'user/edit/' + user,
        success: function (data) {
            $(modal).find('#editName').val(data.name);
            $(modal).find('#editRole').val(data.role);
            $(modal).attr('data-id', data.id);
        },
        error: function (error) {
            console.log(error);
        }
    });
});

// Update User
$('#edit-user-form').submit(function (e) {
    e.preventDefault();

    let msg = $('#edit-user-message');
    let id = $('#edit-user-form').data('id');
    // Form data
    let input = $('#edit-user-form #editName');
    let selectRole = $('#edit-user-form #editRole');
    let formData  = {
        name: $(input).val(),
        role: $(selectRole).children("option:selected").val()
    }

    $.ajax({
        type: 'POST',
        url: '/user/update/'+ id,
        data: formData,
        success: function(data){
            // reqest message clear
            $(msg).html('');

            // Show success message
            $(msg).append('<div class="alert alert-success"> User updated successfully </div>');

            // input value clear
            $(input).val('');

            // append result
            let userRow = $('#user-table-body').find('tr[data-id="'+id+'"]');
            console.log(userRow);
            $(userRow).find('td.user-name').text(data.name);
            console.log(data);
            $(userRow).find('td.user-role').val(data.role);
        },
        error: function(error){
            $(msg).html('');

            $(msg).append('<ul id="errorMessage" class="alert alert-danger"></ul>')

            $.each(error.responseJSON.errors, function(index, value){
                console.log(value[0]);
                $(msg).find('#errorMessage').append(`
                    <li>`+ value[0] +` </li>
                `);
            });
        }
    })
});


// Delete Popup
$(document).on('click', '.delete', function () {
    let user = $(this).closest('tr').data('id');
    let modal = $('#delete-user-form');

    // Delete Confirmation
    $('#delete-user-form button[type="submit"]').click({
        id: user
    }, call_ajax);

    // Ajax call using function
    function call_ajax(event) {
        let msg = $('#delete-user-message');
        let id = event.data.id;
        $.ajax({
            type: 'POST',
            url: '/user/delete/' + id,
            success: function (data) {
                // reqest message clear
                $(msg).html('');

                $('#delete-user-form').find('h4').remove();
                $('#delete-user-form').find('button[type="submit"]').remove();

                // Show success message
                $(msg).append('<div class="alert alert-success"> User deleted successfully </div>');

                let userRow = $('#user-table-body').find('tr[data-id="' + id + '"]');
                $(userRow).remove();
                console.log('user deleted');
            },
            error: function (error) {

            }
        })
    }
});


$('#delete-user-form').submit(function (e) {
    e.preventDefault();
});

// edit modal set to default
$('#edit-modal').on('hidden.bs.modal', function (e) {
    $('#edit-user-form').find('#edit-user-message').html('');
})

// delete modal set to default
$('#delete-modal').on('hidden.bs.modal', function (e) {
    modal = $('#delete-user-form');
    $(modal).find('#delete-user-message').html('');
    $(modal).find('.modal-body').html('').append(`
        <div id="delete-user-message"></div>
        <h4>Are you you want to delete this?</h4>
    `);
    $(modal).find('.modal-footer').html('').append(`
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Yes, Delete</button>
    `);
})