$(document).ready(function () {
    $('#product_list_form').submit(function (e) {
        e.preventDefault();
        var skus = [];
        $('.delete-checkbox:checked').each(function () {
            skus.push($(this).val());
        });
        if (skus.length > 0) {
            $.post({
                url: 'src/php/controllers/ActionController.php',
                data: { skus: skus },
            }).done(function (response, status) {
                $response = JSON.parse(response);
                if (status === "success") {
                    location.reload();
                }
            });
        }
    });
});