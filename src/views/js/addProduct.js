$(document).ready(function () {
    $(productType).change(function () {
        var productTypeId = $(this).val();
        $(".type").hide();
        $(".type_" + productTypeId).show();
    });

    $("#product_form").submit(function (e) {
        e.preventDefault();
        var formData = $(this);
        $.ajax({
            type: 'POST',
            url: formData.attr('action'),
            data: formData.serialize(),
            success: function (data) {
                data = JSON.parse(data);
                if (data.error) {
                    alert(data.error);
                }
            },
        }).done(function (response, status) {
            $response = JSON.parse(response);
            if (status == 'success') {
                window.location.href = '/';
            }
        })
    });
});