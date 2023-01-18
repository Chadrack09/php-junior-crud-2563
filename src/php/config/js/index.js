$(document).ready(function () {
    $('#mass-delete-form').submit(function (e) {
        e.preventDefault();
        var skus = [];
        $('.delete-checkbox:checked').each(function () {
            skus.push($(this).val());
        });
        if (skus.length > 0) {
            if (confirm("Are you sure you want to delete the selected products?")) {
                $.post({
                    url: 'src/php/controllers/MassDeleteController.php',
                    data: { skus: skus },
                })
                    .done(function (response, status) {
                        $response = JSON.parse(response);
                        if (status === "success") {
                            alert($response.message);
                            location.reload();
                            console.log($response.data);
                        }
                        else {
                            alert("An error occurred while deleting the selected products.");
                        }
                    });
            }
        } else {
            alert("Please select at least one product to delete.");
        }
    });
});