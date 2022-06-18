<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Leads</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leads</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-nowrap custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#Id</th>
                                <th>Lead Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Project</th>
                                <th>Assigned Staff</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leads as $lead) : ?>
                                <?php if($lead->designation->name == 'Project Manager') : ?>
                                <tr>
                                    <td>#<?= $lead->project_member->user->id ?></td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="#" class="avatar">
                                                <?php if ($lead->project_member->user->profileFilename != null && $lead->project_member->user->profileFilepath != null) : ?>
                                                    <img alt="" src="/<?= $lead->project_member->user->profileFilepath ?>/<?= $lead->project_member->user->profileFilename ?>"></a>
                                        <?php else : ?>
                                            <img alt="" src="/assets/img/profiles/avatar-11.jpg"></a>
                                        <?php endif; ?>
                                        <a href="#"><?= $lead->project_member->user->firstname ?> <?= $lead->project_member->user->lastname ?></a>
                                        </h2>
                                    </td>
                                    <td><?= $lead->project_member->user->email ?></td>

                                    <td><?= $lead->project_member->user->tel ?></td>
                                    <td><a href="/projectObject/view/<?= $lead->project_member->projectobject->id ?>"><?= $lead->project_member->projectobject->name ?></a></td>

                                    <td>
                                        <ul class="team-members">
                                            <?php foreach ($lead->project_member->projectobject->projectmembers as $projectmember) : ?>
                                                <li>
                                                    <a href="#" title="<?= $projectmember->user->firstname ?> <?= $projectmember->user->lastname ?>" data-toggle="tooltip">
                                                        <?php if ($projectmember->user->profileFilepath != null && $projectmember->user->profileFilename != null) : ?>
                                                            <img alt="" src="/<?= $projectmember->user->profileFilepath ?>/<?= $projectmember->user->profileFilename ?>"></a>
                                                <?php else : ?>
                                                    <img alt="" src="/assets/img/profiles/avatar-09.jpg"></a>
                                                <?php endif; ?>
                                                </li>
                                            <?php endforeach; ?>

                                            <li class="dropdown avatar-dropdown">
                                                <a href="#" class="all-users dropdown-toggle" data-toggle="dropdown" aria-expanded="false">+<?= count($lead->project_member->projectobject->projectmembers) ?></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <div class="avatar-group">
                                                        <a class="avatar avatar-xs" href="#">
                                                            <img alt="" src="/assets/img/profiles/avatar-02.jpg">
                                                        </a>
                                                        <a class="avatar avatar-xs" href="#">
                                                            <img alt="" src="/assets/img/profiles/avatar-09.jpg">
                                                        </a>

                                                    </div>
                                                    <div class="avatar-pagination">
                                                        <ul class="pagination">
                                                            <li class="page-item">
                                                                <a class="page-link" href="#" aria-label="Previous">
                                                                    <span aria-hidden="true">«</span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                            </li>
                                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                            <li class="page-item">
                                                                <a class="page-link" href="#" aria-label="Next">
                                                                    <span aria-hidden="true">»</span>
                                                                    <span class="sr-only">Next</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                    <td><span class="badge bg-inverse-success">Working</span></td>
                                    <td>
                                        <?php if ($lead->project_member->projectobject->createDate != null) : ?>
                                            <?= $lead->project_member->projectobject->createDate->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif ; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
