<?php
$this->assign('title', __('Reimposta la password'));
?>
<div class="account-content">
    <div class="container">
        <div class="account-box">
            <div class="account-wrapper">
                <h3 class="account-title"><?= __('Reimposta la tua password') ?></h3>
                <p class="account-subtitle"><?= __('Compila i campi sottostanti') ?></p>

                <!-- Account Form -->
                <div class="form-header">
                    <h3>ReSet Password</h3>
                </div>
                <form action="/user/saveresetpassword" method="POST">
                    <div class="form-group">
                        <label>Enter Security Code</label>
                        <input type="text" class="form-control" id="securitycode" name="securitycode" />
                    </div>
                    <div class="form-group">
                        <label>Enter Password</label>
                        <input type="password" class="form-control" id="password" name="password" onchange="checkpassword();" />
                    </div>
                    <div class="form-group">
                        <label>Enter Confirm Password</label>
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" onchange="checkrepeatpassword();" />
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-primary account-btn" type="submit">Save</button>
                        </div>

                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">close</a>
                        </div>
                    </div>
                </form>
</br>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div><span id="successMsg"></span></div>
                        <div><span> Go to Login Page</span><a href="/user/login"> Login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
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
        var repeat = $('#confirmpassword').val();
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
</script>
