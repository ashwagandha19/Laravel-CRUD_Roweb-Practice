//* WORKING
$('#boardEditModal').on('shown.bs.modal', function(event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let board = button.data('board');

    let modal = $(this);
    
    modal.find('#boardEditId').val(board.id);
    modal.find('#boardEditName').val(board.name);
});

$('#boardEditModalAjax').on('shown.bs.modal', function(event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let board = button.data('board');
    let modal = $(this);

    modal.find('#boardEditIdAjax').val(board.id);
    modal.find('#boardEditNameAjax').val(board.name);
});

$('#userDeleteModal').on('shown.bs.modal', function(event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let board = button.data('board');

    let modal = $(this);

    modal.find('#boardDeleteId').val(board.id);
    modal.find('#boardDeleteName').text(board.name);
});
//* WORKING


$(document).ready(function() {
    $('#boardEditButtonAjax').on('click', function() {
        $('#boardEditAlert').addClass('hidden');
        

        let id = $('#boardEditIdAjax').val();
        let name = $('#boardEditNameAjax').val(); 
        $.ajax({
            type: 'POST',
            url: '/board-update/' + id,
            data: {name: name}
        }).done(function(response) {
            if (response.error !== '') {
                $('#boardEditAlert').text(response.error).removeClass('hidden');
            } else {
                window.location.reload();
            }
        });
    });

    $('#userDeleteButton').on('click', function() {
        $('#userDeleteAlert').addClass('hidden');
        let id = $('#userDeleteId').val();

        $.ajax({
            method: 'POST',
            url: '/user/delete/' + id
        }).done(function(response) {
            if (response.error !== '') {
                $('#userDeleteAlert').text(response.error).removeClass('hidden');
            } else {
                window.location.reload();
            }
        });
    });

    $('#changeBoard').on('change', function() {
        let id = $(this).val();

        window.location.href = '/board/' + id;
    });
    });