$(function () {

    // ADD
    $(document).on('click', '.add-item', function () {

        $('#loading-spinner').addClass('active');
        $('#items_modal').data('action', 'add');

        $.get($(this).data('url'), function (response) {
            $('#items_modal .modal-content').html(response);
            $('#items_modal').modal('show');
        }).always(function () {
            $('#loading-spinner').removeClass('active');
        });

    });


    // EDIT
    $(document).on('click', '.edit-item', function () {

        $('#loading-spinner').addClass('active');
        $('#items_modal').data('action', 'update');

        $.get($(this).data('url'), function (response) {
            $('#items_modal .modal-content').html(response);
            $('#items_modal').modal('show');
        }).always(function () {
            $('#loading-spinner').removeClass('active');
        });

    });


    // DELETE
    $(document).on('click', '.delete-item', function () {

        let url = $(this).data('url');

        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, delete"
        }).then((result) => {

            if (result.isConfirmed) {

                $('#loading-spinner').addClass('active');

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: "DELETE"
                    },
                    success: function (response) {

                        $('#items_table tbody').html(response.html);
                        $('.total-items').text(response.totalItems);

                        Swal.fire({
                            icon: "success",
                            title: "Deleted!",
                            timer: 1200,
                            showConfirmButton: false
                        });
                    },
                    complete: function () {
                        $('#loading-spinner').removeClass('active');
                    }
                });
            }
        });

    });


    // SUBMIT
    $(document).on('submit', '#items_form', function (e) {

        e.preventDefault();
        $('#loading-spinner').addClass('active');

        let formData = new FormData(this);
        let url = $(this).attr('action');
        let method = $(this).attr('method');

        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,

            success: function (response) {

                $('#items_table tbody').html(response.html);
                $('.total-items').text(response.totalItems);
                $('#items_modal').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    timer: 1200,
                    showConfirmButton: false
                });
            },

            complete: function () {
                $('#loading-spinner').removeClass('active');
            }

        });

    });

});
