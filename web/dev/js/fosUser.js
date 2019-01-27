
$(function () {
    $checkbox1id = $("#fos_user_registration_form_roles_0");
    $checkbox2id = $("#fos_user_registration_form_roles_1");
    i = 0;
    $('input[type=checkbox]').each(function () {
        $(this).prop("checked", false);
    })
    $checkbox1id.prop("checked", true);
    $('input[type=checkbox]').click(function () {
        if ($(this).attr("id") == $checkbox1id.attr('id')) {
            if ($(this).prop('checked')) {
                $checkbox2id.prop("checked", false);

            }

        } else if ($(this).attr("id") == $checkbox2id.attr('id')) {
            if ($(this).prop('checked')) {
                $checkbox1id.prop("checked", false);

            }
        }
        // console.log($(this).prop("checked"));

    })
    $('.btnSUbmitRegister').click(function () {
        console.log($checkbox1id.prop('checked'));
        $('input[type=checkbox]').each(function () {
            if ($(this).prop("checked")){

                i++;
            }
        })
        if (i !== 1) {
            $('.registerError').text("")
            $('.registerError').prepend("Vous n'avez pas choisi de type de compte.")
            return false
        }
    });

});