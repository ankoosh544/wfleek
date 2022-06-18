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

            </br>
            <form action="/workinghours/searchempattendencepdfs/<?= $companyId ?>">
                <!-- Search Filter -->
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="select floating" id="month" name="month">
                                <option value="">---Month---</option>
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
                            <label class="focus-label">Select Month</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus focused">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" name="fromdate">
                            </div>
                            <label class="focus-label">From</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus focused">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" name="todate">
                            </div>
                            <label class="focus-label">To</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button type="submit" class="btn btn-success btn-block"> Search </button>
                    </div>

                </div>
            </form>
            <!-- /Search Filter -->
        </div>

        <div class="search-result">
            <h3>Search Result Found For: <u>
                    <?php if (!empty($month)) : ?>
                        <?= $month ?>
                    <?php else : ?>
                        <?= $first_day_this_month->format('d-m-Y') ?> - <?=$last_day_this_month->format('d-m-Y')?>
                    <?php endif; ?> </u></h3>


                <?php $totalsearch = 1; ?>

            <p><?= $totalsearch ?> Results found</p>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Month</th>

                                <th>Document</th>

                            </tr>

                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                <?= $first_day_this_month->format('d-m-Y') ?> - <?=$last_day_this_month->format('d-m-Y')?>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="/workinghours/downloadpdf?companyId=<?= $companyId ?>&fromdate=<?= $first_day_this_month->format('d-m-Y') ?>&todate=<?= $last_day_this_month->format('d-m-Y') ?>"><img src="">
                                        Download Pdf</a>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
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
