$(document).ready(function () {
    $(select_types).change(function () {
        var productTypeId = $(this).val();
        $(".type").hide();
        $(".type_" + productTypeId).show();
    });

    $("#add-product-form").submit(function (e) {
        e.preventDefault();
        if (confirm("Are you sure you want to add this product?")) {
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
            })
                .done(function (response, status, xhr) {
                    $response = JSON.parse(response);
                    if (status == 'success') {
                        alert($response.message);
                        location.reload();
                    }
                    else {
                        alert("An error occurred while creating the products.");
                    }
                })
        }
    });
});