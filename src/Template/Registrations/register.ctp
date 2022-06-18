<?php

?>
<div class="container">
    <!-- Account Logo -->
    <div class="account-logo">
        <a href="#"><img src="/assets/img/logo2.png" alt="WFleek"></a>
    </div>
    <!-- /Account Logo -->

    <div class="account-box">
        <div class="account-wrapper">
            <h3 class="account-title"><?= __('Registrati') ?></h3>

            <p class="account-subtitle"><?= __('Registra il tuo account') ?></p>

            <!-- Account Form -->
            <form action="/registrations/saveregistrationuser/" method="post">
                <div class="container">
                    <h5 class="text-center"><?= __('Sei un\'azienda?') ?> <a href="/registrations/register-company"><?= __('Clicca qui per registrarti') ?></a>.</h3>
                        <div class="form-group">
                            <label><?= __('Nome') ?><span class="text-danger">*</span></label>
                            <input type="text" name="firstname" id="firstname" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <label><?= __('Cognome') ?><span class="text-danger">*</span></label>
                            <input type="text" name="lastname" id="lastname" class="form-control" type="text" required>
                        </div>

                        <div class="form-group form-focus select-focus">
                            <label><?= __('Genere') ?><span class="text-danger">*</span></label>
                            <select class="select2-icon floating" name="gender" id="gender" required>
                                <option value="MALE" selected><?= __('Maschio') ?></option>
                                <option value="FEMALE"><?= __('Femmina') ?></option>
                                <option value="NOT_BINARY"><?= __('Non binario') ?></option>
                                <option value="NOT_SPECIFIED"><?= __('Non specificato') ?></option>
                            </select>
                        </div>
                        </br>
                        <div class="form-group">
                            <label><?= __('Data di nascita') ?><span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" name="dob" id="dateofbirth" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?= __('E-mail') ?><span class="text-danger">*</span></label>
                            <input type="email" name="email" id="emailid" class="form-control" onkeyup="checkemail()" type="text" required>
                            </br>
                            <span id="errormessage" style="color:red"></span>
                        </div>
                        <div class="text-muted passreqs" style="display: none;">
                            <p><span class="text-danger">*Your password must contain at least one letter.</span></p>
                            <p><span class="text-danger">*Your password must contain at least one digit.</span></p>
                            <p><span class="text-danger">*Your password length must be at least 6 .</span></p>
                        </div>
                        <div class="form-group">
                            <label><?= __('Password') ?><span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" id="password" type="password" onkeyup="showdiv()" required>
                        </div>
                        <div class="form-group">
                            <label><?= __('Riscrivi la password') ?><span class="text-danger">*</span></label>
                            <input type="password" name="repeatpassword" id="repeatepassword" class="form-control" type="password" required>
                        </div>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit"><?= __('Procedi') ?></button>
                </div>
            </form>

        </div>



        <div class="account-footer">
            <p><?= __('Hai già un account?') ?> <a href="/user/login"><?= __('Clicca qui per accedere') ?></a>.</p>
        </div>

        <!-- /Account Form -->
    </div>
</div>
</div>
<script>
    function checkemail() {
        var email = $('#emailid').val();
        console.log(email);
        $.ajax({

            url: '/user/checkmailid',
            method: 'post',
            dataType: 'json',

            data: {
                'email': email
            },
            success: function(data) {
                $('#errormessage').empty();
                console.log("emails", data);
                $('#errormessage').append(data);

            },
            error: function(data) {}
        });
    }


    function checkpassword() {
        var p = $('#password').val();
        errors = [];
        if (p.length < 6) {
            errors.push("Your password must be at least 6 characters");
        }
        if (p.search(/[a-z]/i) < 0) {
            errors.push("Your password must contain at least one letter.");
        }
        if (p.search(/[0-9]/) < 0) {
            errors.push("Your password must contain at least one digit.");
        }
        if (errors.length > 0) {
            alert(errors.join("\n"));
            return false;
        }
        return true;
    }


    function checkrepeatpassword() {
        var p = $('#password').val();
        var repeat = $('#repeatepassword').val();
        console.log(p, repeat, 'passwords');
        errors = [];
        if (p != repeat) {
            errors.push("Password Incorrect");
        }
        if (errors.length > 0) {
            alert(errors.join("\n"));
            return false;
        }
        return true;

    }

    function showdiv() {
        $('.passreqs').show();

    }


    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };
    $('.select2-icon').select2({
        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });

    function alerts() {
        var splittedDate = $("#dateofbirth").val().split("/");

        var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];


        var dob = new Date(dateToString);

        days = (new Date() - dob) / (1000 * 60 * 60 * 24) + 1;
        ndays = Math.round(days / 365);
        if (ndays < 16) {
            alert('Registet User Should have minimum 16 years old');
            return;
        }
    }
</script>





