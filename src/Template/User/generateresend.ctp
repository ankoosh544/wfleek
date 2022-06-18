<?php
$this->assign('title', __('Reimposta la password'));
?>
<div class="account-content">
    <div class="container">
        <div class="account-box" style="width: 100%;">
            <div class="account-wrapper">
                <h3 class="account-title"><?= __('Reimposta la tua password') ?></h3>
                <p class="account-subtitle"><?= __('Click the link for Create New Password') ?></p>
                <div class="form-header">
                    <h3>Reset Password Link has Expired, Please click Resend link to Create New Password</h3>
                    <a class=" btn btn-info" href="/user/resendforpassword/<?=$authuser->id?>"> Resend </a>
                </div>
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


</script>
