<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script>
    /* $( document ).ready(function() {
   alert('hi');
}); */

    $(window).on('load', function() {
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false,
        });
    });
</script>



<!-- Modal -->

<div class="modal fade" id="myModal" role="dialog" style="background-color: black">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row" style="display: flex;flex-direction: column;padding: 30px;">
                    <h3>Dear <?= $verifyuser->firstname ?> <?= $verifyuser->lastname ?></h3>
                    <h3>Your Verification Code is Invalid, Please click below link to Resend</h3>
                    <a href="http://localhost/user/resendemail/<?= $verifyuser->email ?>"> Resend </a> verification link. Thank You,
                </div>

            </div>
        </div>
    </div>
</div>
