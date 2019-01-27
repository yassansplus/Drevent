$(function () {
    // $('form').on('keyup keypress', function (e) {
    //     var keyCode = e.keyCode || e.which;
    //     if (keyCode === 13) {
    //         e.preventDefault();
    //         return false;
    //     }
    // });
    // $('.fa-spin').hide()
    //
    // $(function () {
    //     $('.date').datetimepicker({
    //         locale: 'fr',
    //         minDate: moment(), // Current day,
    //
    //     });
    //     $('.dateDay').datetimepicker({
    //         locale: 'fr',
    //         format: 'DD/MM/YYYY'
    //     });
    // })
    // $('[data-toggle="tooltip"]').tooltip();


    $('.date').datetimepicker({
        locale: 'fr',
        maxDate: moment(), // Current day,
        format: 'DD/MM/YYYY'

    });


    var options = {

        url: Routing.generate('association_ajax'),

        getValue: "name",

        list: {
            match: {
                enabled: true
            }
        },

        theme: "square"
    };

    $("#ajaxSearch").easyAutocomplete(options);

    $.ajax({
        url: Routing.generate('tag_ajax'),

        dataType: 'json',
        async: true,
        success: function (data) {
            $('#basic').magicsearch({
                dataSource: data,
                fields: ['tag'],
                id: 'id',
                format: '%tag%',
                multiple: true,
                multiField: 'tag',
                multiStyle: {
                    space: 5,
                    width: 80
                }
            });

        },
    });

    $('.fa-spin').hide()
    $('.AjaxForm').submit(function (event) {
            var form = $(this);
            var attribute = form.attr('action')
            event.preventDefault();
            form.hide()
            $('.fa-spin').show();

            $.ajax({
                url: Routing.generate('publication_new_ajax'),
                method: form.attr('method'),
                data: form.serialize(),
                dataType: 'json',
                async: true,
                success: function (data) {
                    $('.fa-spin').hide();
                    form.show()
                    iziToast.success({
                        title: 'Et HOP ! ',
                        message: 'Nos meilleurs coursiers  viennent d\'envoyer votre publication !',
                        position: 'topCenter',
                        zindex: 999999999
                    });

                    if (data = "OK") {
                        form.trigger('reset');
                        // form.closest('.modal').modal('close');
                    }
                },
                error: function (data) {
                    console.log(msg)
                }

            })
        }
    )

    $('.validTag').submit(function (event) {
            var form = $(this);
            var attribute = form.attr('action')
            event.preventDefault();

            $.ajax({
                url: Routing.generate('tag_ajax_set'),
                method: form.attr('method'),
                data: $('.magicsearch  ').attr("data-id"),
                dataType: 'json',
                async: true,
                success: function (data) {
                    console.log(data);
                    iziToast.success({
                        title: 'Et HOP ! ',
                        message: 'Nos meilleurs coursiers  viennent d\'envoyer votre publication !',
                        position: 'topCenter',
                        zindex: 999999999
                    });

                    window.location.replace(Routing.generate('result'));

                },
                error: function (data) {
                    console.log(msg)
                }

            })
        }
    )

    $('.validTag-assoc').submit(function (event) {
            var form = $(this);
            var attribute = form.attr('action')
            event.preventDefault();

            $.ajax({
                url: Routing.generate('tag_ajax_set'),
                method: form.attr('method'),
                data: $('.magicsearch  ').attr("data-id"),
                dataType: 'json',
                async: true,
                success: function (data) {
                    console.log(data);
                    iziToast.success({
                        title: 'Eh HOP ! ',
                        message: 'Nos secretaires  viennent de vous référencer à ce tag!',
                        position: 'topCenter',
                        zindex: 999999999
                    });


                },
                error: function (data) {
                    console.log(msg)
                }

            })
        }
    )

    $('.form-commentaire').submit(function (event) {
            var form = $(this);
            var attribute = form.attr('action')
            event.preventDefault();

            $.ajax({
                url: Routing.generate('tag_ajax_set'),
                method: form.attr('method'),
                data: $('.magicsearch  ').attr("data-id"),
                dataType: 'json',
                async: true,
                success: function (data) {
                    console.log(data);
                    iziToast.success({
                        title: 'Eh HOP ! ',
                        message: 'Nos secretaires  viennent de vous référencer à ce tag!',
                        position: 'topCenter',
                        zindex: 999999999
                    });


                },
                error: function (data) {
                    console.log(msg)
                }

            })
        }
    )



    $('.addAssoc').click(function () {
            $.ajax({
                url: Routing.generate('follower',{ id  : $(this).attr("data-id") }),
                data: $('.magicsearch  ').attr("data-id"),
                dataType: 'json',
                async: true,
                success: function (data) {
                    console.log(data);
                    iziToast.success({
                        title: 'Eh HOP ! ',
                        message: 'Nos meilleures coursiers  vienne d\'envoyer votre publication!',
                        position: 'topCenter',
                        zindex: 999999999
                    });

                    // window.location.replace(Routing.generate('result'));

                },
                error: function (data) {
                    console.log(msg)
                }

            })
        }
    )

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

})