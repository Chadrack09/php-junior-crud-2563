$(document).ready(function () {

    $("input[name='size']").keyup(function (event) {
        $(this).val($(this).val().replace(/[^\d.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    $("input[name='weight']").keyup(function (event) {
        $(this).val($(this).val().replace(/[^\d.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    $("input[name='height']").keyup(function (event) {
        $(this).val($(this).val().replace(/[^\d.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    $("input[name='width']").keyup(function (event) {
        $(this).val($(this).val().replace(/[^\d.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    $("input[name='length']").keyup(function (event) {
        $(this).val($(this).val().replace(/[^\d.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

});