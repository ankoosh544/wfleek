<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Companies QR Codes</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">QR Codes</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <a href="/companies-user/downloadqrcodes?type=Entrance" class="btn btn-primary"> Entrance Qr PDF</a>

                    <a href="/companies-user/downloadqrcodes?type=Exit" class="btn btn-primary"> Exit Qr PDF</a>
                </div>

            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <div class="row filter-row mb-4">
            <div class="col-sm-6 col-md-9">
                <div class="form-group form-focus">
                    <input class="form-control floating" type="text">
                    <label class="focus-label">Company Name</label>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Entrace Pdf</th>
                                <th>Exit Pdf</th>

                            </tr>
                        </thead>
                        <?php foreach ($admincompanies as $company) : ?>
                            <?php if ($company->designation->name == 'Administrator') : ?>
                                <tr>
                                    <td>
                                        <?= $company->usercompany->name ?>
                                    </td>
                                    <td>
                                        <a href="/usercompanies/generateqrcode?companyId=<?= $company->usercompany->id ?>&&type=Entrance"" class=" btn btn-primary">PDF</a>
                                    </td>

                                    <td> <a href="/usercompanies/generateqrcode?companyId=<?= $company->usercompany->id ?>&&type=Exit"" class=" btn btn-primary">PDF</a></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <tbody>

                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
