

<?php
$this->assign('title', __('Il link di verifica è scaduto'));
?>
<div class="account-content">
    <div class="container">
        <div class="account-box" style="width: 100%;">
            <div class="account-wrapper">
                <div class="form-header">
                <h3>Dear <?= $verifyuser->firstname ?> <?= $verifyuser->lastname ?></h3>
                <h3>Your Verification Link has Expired, Please click below link to Resend</h3>

                <a href="http://localhost/registrations/resendemail/<?= $verifyuser->email_id ?>"> Resend </a>. Thank You,

                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div><span id="successMsg"></span></div>
                     <h4><div><span> Go to Login Page</span><a href="/user/login"> Login</a></div></h4>
                    </div>

                </div>


                <!-------------------/SucessModal------------------------------------------->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">


</script>

