<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script>
    $(window).on('load', function() {
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false,
        });
    });
</script>

<!-- Modal -->

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row" style="display: flex;flex-direction: column;padding: 30px;">
                    <h3>Dear <?= $verifyuser->firstname ?> <?= $verifyuser->lastname ?></h3>
                    <h3>Please Enter Your Security code</h3>
                    <form action="/user/verifysecuritycode" method="POST">
                        <div class="form-group">
                            <input class="form-control" type="text" name="securitycode">
                            <input type="hidden" value="<?=$verifyuser->id?>" name="userid">
                            </br>
                            <button class="btn btn-info" type="submit">Submit</button>

                        </div>


                    </form>

                </div>

            </div>
        </div>
    </div>
</div>



