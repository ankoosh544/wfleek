<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

                <div class="row" style="display: flex;flex-direction: column;padding: 30px;">

                    <div class="form-group">
                        <label>Choose Profile<span class="text-danger">*</span></label>
                        <a href="/user/profiledashboard/<?=$authuser->id?>" class="btn btn-info form-control">Private Profile</a>
                    </div>

                    </br>
                    <form method="post" action="/user/dashboard/">
                        <div class="form-group form-focus select-focus">
                            <label for="ticketstatus">Choose Company<span class="text-danger">*</span></label>
                            <select id="ticketstatus" class="select floating" name="companyId" required>
                                <option disabled selected>Select Company</option>
                                <?php foreach ($companies as $company) : ?>
                                    <option value="<?= $company->company_id ?>"><?= $company->usercompany->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div></br>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Continue</button>
                            <input type="hidden" value="<?=$authuser->id?>" name="userid">
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
