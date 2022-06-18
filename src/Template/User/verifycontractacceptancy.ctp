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

<div class="modal fade" id="myModal" role="dialog" >
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row" style="display: flex;flex-direction: column;padding: 30px;">

                    <form action="/user/verifycredentials" method="POST">
                        <div class="form-group">
                            <input class="form-control" type="text" name="email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password" placeholder="Enter Password">
                        </div>

                        <div>
                            <button class="btn btn-info" type="submit">Submit</button>
                            <input type="hidden" name="contract_id" value="<?=$contract_id?>">
                            <input type="hidden" name="pid" value="<?=$pid?>">
                            <input type="hidden" name="versionId" value="<?=$versionId?>">

                        </div>


                    </form>

                </div>

            </div>
        </div>
    </div>
</div>



