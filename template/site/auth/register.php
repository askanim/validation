<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/template/" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Panel / Регистрация</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">

<div>
    <input id="csrf_n" type="hidden" name="<?php echo $csrf['keys']['name']; ?>" value="<?php echo $csrf['name']; ?>">
    <input id="csrf_v" type="hidden" name="<?php echo $csrf['keys']['value']; ?>" value="<?php echo $csrf['value']; ?>">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form id="register" class="form-horizontal form-label-left" data-action="/register" novalidate>
                    <h1>Создать Аккаунт</h1>
                    <div class="item form-group">

                            <input id="name" class="form-control col-md-12 col-xs-12" data-validate-length-range="1" data-validate-words="1" name="name" placeholder="Имя пользователя" required="required" type="text">

                    </div>
                    <div class="item form-group">


                            <input type="email" id="email" name="email" required="required" placeholder="Email" class="form-control col-md-12 col-xs-12">

                    </div>
                    <div class="item form-group">

                            <input id="password" type="password" name="password" data-validate-length="6,50" placeholder="Пароль" class="form-control col-md-12 col-xs-12" required="required">

                    </div>
                    <div class="item form-group">

                            <input id="password_confirm" type="password" name="password_confirm" data-validate-linked="#password" placeholder="Повторите пароль" class="form-control col-md-12 col-xs-12" required="required">

                    </div>
                    <div class="form-group">
                        <button id="send" type="submit" class="btn btn-success">Создать</button>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link">Зарегестрированы?
                            <a href="/login#signin" class="to_register"> Войти </a>
                        </p>

                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><i class="fa fa-paw"></i> WOM Площадка! </h1>
                            <p>©2017 Все права защищены. WOM Площадка!</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<!-- validator -->
<script src="vendors/validator/validator.js"></script>
<script>
    function isEmpty(object) {

        for (var key in object)

            if (object.hasOwnProperty(key)) return true;

        return false;
    }
</script>
<script language="JavaScript">
    // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
    $('form')
        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
        .on('change', 'select.required', validator.checkField)
        .on('keypress', 'input[required][pattern]', validator.keypress);

    $('.multi.required').on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
    });

    $('form').on("submit", function(e) {
        e.preventDefault();


        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
            console.log("validate error");
        }else {
            var uri = $(this).data('action');
            console.log(uri);
            uri = 'http://ford-domodedovo.ru'+uri;
            var c_nm_name =  $("#csrf_n").attr("name");
            var c_Val_name = $("#csrf_v").attr("name");
            var c_nm_value = $("#csrf_n").val();
            var c_Val_value = $("#csrf_v").val();

            var id = $(this).attr("id");
            formData = new FormData(document.querySelector('form[id$="'+id+'"]'));

            formData.append(c_nm_name, c_nm_value);
            formData.append(c_Val_name, c_Val_value);



                $.ajax({
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    url: uri,
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                               
                        //error = data.error;
                        console.log('--------START REQUEST--------');
                        if(isEmpty(data.error) === true)
                        {
                            console.log('hello err');
                            console.log(data.error);
                             $("input[name="+data.csrf.keys.name+"]").val(data.csrf.name);
                             $("input[name="+data.csrf.keys.value+"]").val(data.csrf.value);
                         }
                        else
                        {
                            console.log(data);
                            if(data.success === true){
                                location.replace("/admin");
                            }
                        }
                        console.log('--------END REQUEST--------');
                    },
                    error:  function(xhr, str){
                        alert('Возникла ошибка: ' + xhr.responseCode);
                    }
                });




        }
        return false;
    });
</script>
</body>
</html>
