<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<style>
    .del-msg {
        color: red;
        display: none;
    }

    .title:hover .del-msg {
        display: block
    }
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Share Contract</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Compose</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group form-focus select-focus m-b-30">
                            <select id="toemailaddresses" placeholder="To" class="select2-icon floating" name="toemail" multiple>
                                <?php foreach ($allUsers as $singleUser) : ?>

                                    <option value="<?= $singleUser->id ?>"><?= $singleUser->email ?>
                                    </option>

                                <?php endforeach; ?>
                            </select>
                            <label class="focus-label">To</label>
                        </div>


                        <div class="form-group">
                            <input name="subject" type="text" id="compose_subject" placeholder="Subject" class="form-control">
                        </div>

                        <div class="form-group">
                            <textarea name="body" rows="4" class="form-control" id="compose_body" placeholder="Enter your message here"></textarea>
                        </div>


                        <div class="form-group mb-0">
                            <div class="form-group">
                                <?php if (!empty($latestversion)) : ?>
                                    <a href="/contracts/downloadFile?contract_id=<?= $latestversion->contract_id ?>&pid=<?= $latestversion->project_object_id ?>">

                                        <img src="/assets/img/attachment.png" alt="">
                                        <?= $latestversion->contract_filename ?></a>

                                <?php else : ?>
                                    <a href="/contracts/downloadFile?contract_id=<?= $contract->id ?>&pid=<?= $contract->project_object_id ?>">
                                        <img src="/assets/img/attachment.png" alt="">
                                        <?= $contract->contract_filename ?></a>
                                <?php endif; ?>

                            </div>

                            <div class="text-center">
                                <?php if (!empty($latestversion)) : ?>
                                    <button type="submit" class="btn btn-primary" onclick="sendfunction(<?= $latestversion->contract_id ?>,<?= $latestversion->project_object_id ?> )"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>
                                    <button class="btn btn-success m-l-5" type="button" onclick="deleteComposeDiv(<?= $latestversion->project_object_id ?>);"><span>Cancel</span> <i class="fa fa-trash-o m-l-5"></i></button>
                                <?php else : ?>
                                    <button type="submit" class="btn btn-primary" onclick="sendfunction(<?= $contract->id ?>,<?= $contract->project_object_id ?> )"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>
                                    <button class="btn btn-success m-l-5" type="button" onclick="deleteComposeDiv(<?= $contract->project_object_id ?>);"><span>Cancel</span> <i class="fa fa-trash-o m-l-5"></i></button>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6.0.0-alpha14/css/tempus-dominus.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>






<script>
    var tovalues;
    $("#toemailaddresses").on("select2:select", function(event) {
        console.log('hi toemails')
        tovalues = [];

        // copy all option values from selected
        $(event.currentTarget).find("option:selected").each(function(i, selected) {
            tovalues[i] = parseInt($(selected).val());
        });
        console.log(tovalues);
    });

    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };
    $('.select2-icon').select2({
        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });


    function sendfunction(contractId, pid) {
        var body = $('#compose_body').val();
        var subject = $('#compose_subject').val();
        var form_data = new FormData();
        form_data.append("subject", subject);
        form_data.append("body", body);
        form_data.append("tovalues", JSON.stringify(tovalues));
        form_data.append("contractId", contractId);

        $.ajax({
            url: '/contracts/sendemailcontract/',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                console.log(data, 'sucessData');
                window.location = '/project-object/contractsummary/' + pid + '';

            },
            error: function(e) {}
        });

    }

    function deleteComposeDiv(pid) {
        window.location = '/project-object/contractsummary/' + pid + '';

    }
</script>
