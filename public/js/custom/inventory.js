$(function () {

    /* ===============================
       ADD INVENTORY
    =============================== */
    $(document).on('click', '.add-inventory', function () {

        $('#loading-spinner').addClass('active');
        $('#inventories_modal').data('action', 'add');

        let url = $(this).data('url');

        $.get(url)
            .done(function (response) {
                $('#inventories_modal .modal-content').html(response);
                $('#inventories_modal').modal('show');
            })
            .fail(function () {
                Swal.fire("Error!", "Unable to load form.", "error");
            })
            .always(function () {
                $('#loading-spinner').removeClass('active');
            });
    });


    /* ===============================
       EDIT INVENTORY
    =============================== */
    $(document).on('click', '.edit', function () {

        $('#loading-spinner').addClass('active');
        $('#inventories_modal').data('action', 'update');

        let url = $(this).data('url');

        $.get(url)
            .done(function (response) {
                $('#inventories_modal .modal-content').html(response);
                $('#inventories_modal').modal('show');
            })
            .fail(function () {
                Swal.fire("Error!", "Unable to load form.", "error");
            })
            .always(function () {
                $('#loading-spinner').removeClass('active');
            });
    });


    /* ===============================
       DELETE INVENTORY
    =============================== */
    $(document).on('click', '.delete', function () {

        let url = $(this).data('url');

        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete",
            width: '400px'
        }).then((result) => {

            if (result.isConfirmed) {

                $('#loading-spinner').addClass('active');

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: "DELETE"
                    }
                })
                .done(function (response) {

                    $('#inventories_table tbody').html(response.html);
                    $('.total-items-number').text(response.totalItems);

                    Swal.fire({
                        icon: "success",
                        title: "Deleted!",
                        timer: 1000,
                        showConfirmButton: false
                    });

                })
                .fail(function () {
                    Swal.fire("Error!", "Something went wrong.", "error");
                })
                .always(function () {
                    $('#loading-spinner').removeClass('active');
                });
            }
        });
    });


    /* ===============================
       STORE / UPDATE INVENTORY
    =============================== */
    $(document).on('submit', '.form-submit', function (e) {

        e.preventDefault();
        $('#loading-spinner').addClass('active');

        let form = $(this);
        let url = form.attr('action');
        let method = form.attr('method');
        let data = form.serialize();

        $.ajax({
            url: url,
            type: method,
            data: data
        })
        .done(function (response) {

            $('#inventories_table tbody').html(response.html);
            $('.total-items-number').text(response.totalItems);

            if ($('#inventories_modal').data('action') === 'update') {
                $('#inventories_modal').modal('hide');
            }

            form[0].reset();

            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Data saved successfully!',
                timer: 1500,
                showConfirmButton: false
            });

        })
        .fail(function (xhr) {

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorText = '';

                $.each(errors, function (key, value) {
                    errorText += value[0] + '<br>';
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorText
                });
            } else {
                Swal.fire("Error!", "Something went wrong.", "error");
            }

        })
        .always(function () {
            $('#loading-spinner').removeClass('active');
        });
    });


    /* ===============================
       SEARCH INVENTORY (FILTER)
    =============================== */
    $(document).on('submit', '.form-search', function (e) {

        e.preventDefault();
        $('#loading-spinner').addClass('active');

        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();

        $.get(url, data)
            .done(function (response) {
                $('#inventories_table tbody').html(response);
            })
            .fail(function () {
                Swal.fire("Error!", "Search failed.", "error");
            })
            .always(function () {
                $('#loading-spinner').removeClass('active');
            });
    });


    /* ===============================
       RESET MODAL WHEN CLOSED
    =============================== */
    $('#inventories_modal').on('hidden.bs.modal', function () {
        $('#inventories_modal .modal-content').html('');
    });

});
