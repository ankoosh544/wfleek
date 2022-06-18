<?php

?>
<div class="container">
    <!-- Account Logo -->
    <div class="account-logo">
        <a href="#"><img src="/assets/img/logo2.png" alt="WFleek"></a>
    </div>
    <!-- /Account Logo -->

    <div class="account-box " style="width: 100%;">
        <div class="account-wrapper">
            <h3 class="account-title"><?= __('Registrazione') ?></h3>

            <p class="account-subtitle"><?= __('Registra la tua azienda') ?></p>

            <!-- Account Form -->
            <form action="/registrations/saveregistrationuser/" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= __('Nome del rappresentante legale') ?><span class="text-danger">*</span></label>
                                <input type="text" name="firstname" id="firstname" class="form-control" type="text" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= __('Cognome del rappresentante legale') ?><span class="text-danger">*</span></label>
                                <input type="text" name="lastname" id="lastname" class="form-control" type="text" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label><?= __('Codice fiscale') ?><span class="text-danger">*</span></label>
                            <input class="form-control" name="taxcode" id="taxcode" required>
                        </div>
                        <div class="form-group col-6">
                            <label><?= __('Partita IVA') ?><span class="text-danger">*</span></label>
                            <input class="form-control" name="vatcode" id="vatcode" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-focus select-focus">
                                <label><?= __('Genere') ?><span class="text-danger">*</span></label>
                                <select class="select2-icon floating" name="gender" id="gender" required>
                                    <option value="MALE"><?= __('Maschio') ?></option>
                                    <option value="FEMALE"><?= __('Femmina') ?></option>
                                    <option value="OTHER"><?= __('Altro') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= __('Data di nascita') ?><span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control floating datetimepicker" name="dob" id="dateofbirth" type="text" required>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?= __('Ragione sociale') ?><span class="text-danger">*</span></label>
                                <input class="form-control" name="businessname" id="businessname">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?= __('Indirizzo della sede legale') ?><span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="company_address" name="company_address">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label><?= __('Stato') ?><span class="text-danger">*</span></label>
                            <select class="form-control select" id="country">
                                <option selected value="ITALIA"><?= __('Italia') ?></option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label><?= __('Città') ?><span class="text-danger">*</span></label>
                            <select class="form-control select" id="city">
                                <option selected value="MILANO"><?= __('Milano') ?></option>
                                <option value="ROMA"><?= __('Roma') ?></option>
                                <option value="VARESE"><?= __('Varese') ?></option>
                                <option value="FIRENZE"><?= __('Firenze') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?= __('E-mail') ?><span class="text-danger">*</span></label>
                                <input type="email" name="email" id="emailid" class="form-control" onchange="checkemail()" type="text" required>
                                <span id="errormessage" style="color:red"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= __('Password') ?><span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" id="password" onchange="checkpassword();" type="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= __('Riscrivi la password che hai scelto') ?><span class="text-danger">*</span></label>
                                <input type="password" name="repeatpassword" id="repeatepassword" onchange="checkrepeatpassword();" class="form-control" type="password" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit"><?= __('Procedi') ?></button>
                    <input type="hidden" name="companyinfo" value="notnull">
                </div>
            </form>
        </div>



        <div class="account-footer">
            <p><?= __('Hai già un account?') ?> <a href="/user/login"><?= __('Effettua il login') ?></a>.</p>
        </div>

        <!-- /Account Form -->
    </div>
</div>
</div>
<script>
    function checkemail() {
        //  url: '/user/checkmailid',
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

    function saveregistrationcompany() {
        var companyinfo = $('#emailid').val();
        var splittedDate = $("#dateofbirth").val().split("/");
        var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
        var dob = new Date(dateToString);
        days = (new Date() - dob) / (1000 * 60 * 60 * 24) + 1;
        ndays = Math.round(days / 365);
        if (ndays < 16) {
            alert('Registet User Should have minimum 16 years old');
            return;
        } else {
            var dob = $("#dateofbirth").val()

        }
        var repeat = $('#repeatepassword').val();
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
        if (p != repeat) {
            errors.push("Password Incorrect");
        }
        if (errors.length > 0) {
            alert(errors.join("\n"));
            return false;
        } else {
            var password = $('#password').val();
            var repeatpassword = $('#repeatepassword').val();

        }

        $.ajax({

            url: '/registrations/saveregistrationuser',
            method: 'post',
            dataType: 'json',
            data: {
                'companyinfo': companyinfo,
                'firstname': $('#firstname').val(),
                'lastname': $('#lastname').val(),
                'gender': $('#gender').val(),
                'dob': dob,
                'email': $('#emailid').val(),
                'password': password,
                'repeatepassword': repeatpassword,
                'address': $('#company_address').val(),
                'city': $('#city').val(),
                'country': $('#country').val(),
                'businessname': $('#businessname').val(),
                'taxcode': $('#taxcode').val(),
                'vatcode': $('#vatcode').val()


            },
            success: function(data) {
                window.location = '/user/login';

            },
            error: function(data) {
                console.log(data, 'error');
            }
        });

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
