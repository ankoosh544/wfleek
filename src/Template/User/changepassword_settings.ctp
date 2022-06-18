<style>
    .eyecss {
        width: 25px;
        float: right;

        margin-top: -28px;
        margin-left: -4px;
    }
</style>


<?= $this->element('settings_sidebar', [
    'companyId' => $companyId
]) ?>

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Change Password</h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <form action="/user/updatepassword" method="post">
                    <div class="form-group">
                        <label>Old password</label>
                        <input type="password" class="form-control" id="oldpassword" name="oldpassword">
                        <img src="/assets/img/invisible.png" class="eyecss"  onclick="showoldpassword()">
                    </div>
                    <div class="form-group">
                        <label>New password</label>
                        <input type="password" class="form-control" id="newpassword" name="newpassword">
                        <img src="/assets/img/invisible.png" class="eyecss"  onclick="shownewpassword()">
                    </div>
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
                        <img src="/assets/img/invisible.png" class="eyecss"  onclick="showconfirmpassword()">
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->

<script>
    function showoldpassword() {
        var x = document.getElementById("oldpassword");
        console.log(x, 'v');
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function shownewpassword() {
        var x = document.getElementById("newpassword");
        console.log(x, 'v');
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function showconfirmpassword() {
        var x = document.getElementById("confirmpassword");
        console.log(x, 'v');
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
