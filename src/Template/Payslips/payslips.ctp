<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Payslip Reports</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Payslip Reports</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#"" class=" btn add-btn" data-toggle="modal" data-target="#upload_payslip"> Upload Payslip</a>
                </div>
            </div>
        </div>


        <!------------------Payslip----------------------------------------->

        <div class="modal custom-modal fade" id="upload_payslip" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Payslip</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="/payslips/addpayslip" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group form-focus select-focus ">
                                <label>Select Month</label>
                                <select id="searchprojecttype" class="select floating" name="month">
                                    <option value="01">gennaio</option>
                                    <option value="02">febbraio</option>
                                    <option value="03">marzo</option>
                                    <option value="04">aprile</option>
                                    <option value="05">maggio</option>
                                    <option value="06">giugno</option>
                                    <option value="07">luglio</option>
                                    <option value="08">agosto</option>
                                    <option value="09">settembre</option>
                                    <option value="10">ottobre</option>
                                    <option value="11">novembre</option>
                                    <option value="12">dicembre</option>
                                </select>
                            </div>
                            </br>
                            <?php
                            $year = date("Y");
                            ?>
                            <div class="form-group form-focus select-focus">
                                <label>Select Year</label>
                                <select id="searchprojecttype" class="select floating" name="year">
                                    <option value="<?= $year ?>"><?= $year ?></option>
                                </select>
                            </div>
                            </br>
                            <div class="form-group">
                                <label for="projectIMG"><?= __('Project Image') ?><span class="text-danger">*</span></label>
                                <?= $this->Form->control('images.',  ['type' => 'file', 'id' => 'image', 'name' => 'image', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                            </div>

                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="companyId" value="<?= $companyId ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!------------------Payslip----------------------------------------->
        <!-- /Page Header -->

        <!-- Content Starts -->
        <!-- Search Filter -->

        <form method="POST" action="/payslips/searchpayslips">
            <div class="row filter-row">

                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="employeename">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <select class="form-control floating select" name="month">
                                <option value="null">Select Month</option>
                                <option value="01">Jan</option>
                                <option value="02">Feb</option>
                                <option value="03">Mar</option>
                                <option value="04">Apr</option>
                                <option value="05">May</option>
                                <option value="06">Jun</option>
                                <option value="07">Jul</option>
                                <option value="08">Aug</option>
                                <option value="09">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select>
                        </div>
                        <label class="focus-label">Month</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <select class="form-control floating select" name="year">
                                <option value="null">Select Year</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                            </select>
                        </div>
                        <label class="focus-label">Year</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <button type="submit" class="btn btn-success btn-block"> Search </button>
                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                    <input type="hidden" name="companyId" value="<?= $companyId ?>">
                </div>
            </div>
        </form>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee Name</th>
                                <th>Paid Amount</th>
                                <th>Payment Month</th>
                                <th>Payment Year</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payslips as $index =>$payslip) : ?>
                                <tr>
                                    <td><?=$index +1?></td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="profile.html" class="avatar"><img alt="" src="/assets/img/profiles/avatar-13.jpg"></a>
                                            <a href="profile.html"><?= $payslip->user->firstname ?> <?= $payslip->user->lastname ?>
                                                <?php foreach ($allemployees as $employee) : ?>
                                                    <?php if ($employee->user_id == $payslip->user->id) : ?>
                                                            <span class="badge bg-inverse-danger"><?=$employee->designation->name?></span>
                                                    <?php endif; ?>

                                                <?php endforeach; ?>
                                            </a>
                                        </h2>
                                    </td>
                                    <td>$200</td>
                                    <td>
                                        <?php if ($payslip->month == '01') : ?> Jan
                                        <?php elseif ($payslip->month == '02') : ?> Feb
                                        <?php elseif ($payslip->month == '03') : ?> Mar
                                        <?php elseif ($payslip->month == '04') : ?> Aprl
                                        <?php elseif ($payslip->month == '05') : ?> May
                                        <?php elseif ($payslip->month == '06') : ?> Jun
                                        <?php elseif ($payslip->month == '07') : ?> Jul
                                        <?php elseif ($payslip->month == '08') : ?> Aug
                                        <?php elseif ($payslip->month == '09') : ?> Sept
                                        <?php elseif ($payslip->month == '10') : ?> Oct
                                        <?php elseif ($payslip->month == '11') : ?> Nov
                                        <?php elseif ($payslip->month == '12') : ?> Dec
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $payslip->year ?></td>
                                    <td class="text-center"> <a href="/payslips/downloadpayslip/<?= $payslip->id ?>" class="btn btn-sm btn-primary"> <?= $payslip->payslip_filename ?> Download</a></td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
