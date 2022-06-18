<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Attendence</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employees</li>
                    </ul>
                </div>
            </div>
            <div class="row" style="justify-content: center;">
                <div class="col-lg-11 col-md-11">
                    <div class="">
                        <section>
                            <h5 class="dash-title"></h5>
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="/workinghours/monthlyattendence/<?= $companyId ?>">
                                        <div class="row filter-row">
                                            <div class="col">
                                                <div class="form-group form-focus select-focus">
                                                    <select class="select floating" id="month" name="month">
                                                        <option>Select Month</option>
                                                        <option value="01">01/2022</option>
                                                        <option value="02">02/2022</option>
                                                        <option value="03">03/2022</option>
                                                        <option value="04">04/2022</option>
                                                        <option value="05">05/2022</option>
                                                        <option value="06">06/2022</option>
                                                        <option value="07">07/2022</option>
                                                        <option value="08">08/2022</option>
                                                        <option value="09">09/2022</option>
                                                        <option value="10">10/2022</option>
                                                        <option value="11">11/2022</option>
                                                        <option value="12">12/2022</option>
                                                    </select>
                                                    <label class="focus-label">Months</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-success btn-block"> Search </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="row" style="justify-content: center;">
                <div class="col-lg-12 col-md-12">
                    <div class="">
                        <section>
                            <h5 class="dash-title"></h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row filter-row" id="attendencepdf_block">
                                        <?php if (!empty($daily_attendence)) : ?>
                                            <div class="col">
                                                <?= $daily_attendence->month ?>
                                            </div>
                                            <div class="col">
                                                <a href="/dailyattendencepdfs/downloadpdf/<?=$daily_attendence->id?>"><img src="">
                                                    Download Pdf</a>
                                            </div>
                                        <?php else : ?>
                                            <h3 style="align-items: center;">No Attendence Record Found</h3>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->


    </div>
    <!-- /Page Content -->


</div>
<!-- /Page Wrapper -->
<script>
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };


    $('.select2-icon').select2({

        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });

    function searchattendencepdf(companyId) {

        date = $('#month').val();
        console.log(date, 'this is month');


        $.ajax({
            url: '/workinghours/attendencepdf',
            method: 'post',
            dataType: 'json',
            data: {
                'date': date,
                'companyId': companyId,

            },
            success: function(data) {
                $('#attendencepdf_block').empty();

                var str = "";
                str += '<div class="col">' +
                    '<span>' + data.month + '/2022</span>' +
                    '</div>' +
                    '<div class="col">' +
                    '<a href="/dailyattendencepdfs/downloadpdf/' + data.id + '"><img src="' + data.filepath + '/' + data.filename + '" alt="">Download Pdf</a>' +
                    '</div>';

                $('#attendencepdf_block').html(str);

            },
            error: function() {}
        });

    }
</script>
