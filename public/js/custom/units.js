$(function () {
    //add button click
    $(document).on('click', '.add-unit', function () {
        $('#loading-spinner').addClass('active');
        url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                $('#units_modal .modal-content').html(response);
                $('#loading-spinner').removeClass('active'); // hide
                var modalEl = document.getElementById('units_modal');
                var modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                modalInstance.show();
            }
        })
    })
    //edit button click
    $(document).on('click', '.edit', function () {
        $('#loading-spinner').addClass('active');
        url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                $('#units_modal .modal-content').html(response);
                $('#loading-spinner').removeClass('active'); // hide
                var modalEl = document.getElementById('units_modal');
                var modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                modalInstance.show();
            }
        })
    })
    //delete button click
    $(document).on('click', '.delete', function () {
        url = $(this).data('url');
        if (confirm('Are you sure you want to delete this unit?')) {
            $('#loading-spinner').addClass('active');
            $.ajax({
                url: url,
                type: 'post',
                data: { '_token': $('meta[name="csrf-token"]').attr('content'), '_method': 'delete' },
                success: function (response) {
                    $('#units_table tbody').html(response);
                    $('#loading-spinner').removeClass('active'); // hide
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }, complete: function (obj) {
                    console.log('delete complete');
                }
            })
        }
    });

    //form submit
    $(document).on('submit', '#units_modal form', function (e) {
        e.preventDefault();
        $('#loading-spinner').addClass('active');
        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        var data = form.serialize();
        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function (response) {
                $('#units_table tbody').html(response);
                var modalEl = document.getElementById('units_modal');
                var modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                modalInstance.hide();
                form.find('input[type="text"], textarea').val('');
                $('#loading-spinner').removeClass('active'); // hide
            }
        })
    })
})