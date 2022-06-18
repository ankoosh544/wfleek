<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Search</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Search</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <div class="row">
            <div class="col-12">

                <!-- Search Form -->
                <div class="main-search">
                    <form action="/project-object/search" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name="input_keyword" value="<?= $searchkeyword ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /Search Form -->

                <div class="search-result">
                    <h3>Search Result Found For: <u><?= $searchkeyword ?></u></h3>

                    <?php if ($allmatchedproject != null ||  $matchedusers != null) : ?>
                        <?php $totalsearch = (count($allmatchedproject) + count($matchedusers)); ?>
                    <?php else : ?>
                        <?php $totalsearch = "NO MAATCH FOUND" ?>

                    <?php endif; ?>
                    <p><?= $totalsearch ?> Results found</p>
                </div>

                <div class="search-lists">
                    <ul class="nav nav-tabs nav-tabs-solid">
                        <li class="nav-item"><a class="nav-link active" href="#results_projects" data-toggle="tab">Projects</a></li>
                        <!--     <li class="nav-item"><a class="nav-link" href="#results_clients" data-toggle="tab">Clients</a></li> -->
                        <li class="nav-item"><a class="nav-link" href="#results_users" data-toggle="tab">Users</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="results_projects">

                            <div class="row">
                                <?php if ($allmatchedproject != null) : ?>
                                    <?php foreach ($allmatchedproject  as $index => $projectObject) : ?>
                                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                                            <div class="card" id="mycard_<?= $index ?>">
                                                <div class="card-body" id="mytype_<?= $index ?>">
                                                    <div class="dropdown dropdown-action profile-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project_<?= $projectObject->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project_<?= $projectObject->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                    <h4 id="myrow_<?= $index ?>" class="project-title"><a href="/project-object/view/<?= $projectObject->id ?>" onclick="checkuserType(<?= $projectObject->id ?>, <?= $user_id ?>)"><?= $projectObject->name ?></a></h4>

                                                    <p><?= $projectObject->projecttype->name ?></p>

                                                    <small class="block text-ellipsis m-b-15">
                                                        <?php $opentask = 0;
                                                        $completedtask = 0;

                                                        foreach ($projectObject->projecttasks as $projecttask) {
                                                            if ($projecttask->status == 'T' or $projecttask->status == 'I') {
                                                                $opentask = $opentask + 1;
                                                            } else {
                                                                $completedtask = $completedtask + 1;
                                                            }
                                                        }

                                                        $totaltasks = $opentask + $completedtask;

                                                        ?>



                                                        <span class="text-xs"><?= $opentask ?></span> <span class="text-muted">open tasks, </span>
                                                        <span class="text-xs"><?= $completedtask ?></span> <span class="text-muted">tasks completed</span>
                                                    </small>
                                                    <p class="text-muted"><?= nl2br($projectObject->description) ?></p>
                                                    <div class="pro-deadline m-b-15">
                                                        <div class="sub-title">
                                                            Deadline:
                                                        </div>
                                                        <div class="text-muted">
                                                            <?= $projectObject->expirydate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="project-members m-b-15">
                                                        <div>Project Leader :</div>
                                                        <ul class="team-members">
                                                            <?php if(!empty($projectObject->projectmembers)): ?>
                                                            <?php foreach ($projectObject->projectmembers as $manager) : ?>
                                                                <?php if ($manager->type == 'Z') : ?>
                                                                    <li>
                                                                        <a href="#" data-toggle="tooltip" title="<?= $manager->user->firstname ?> <?= $manager->user->lastname ?>">
                                                                            <?php if ($manager->user->profileFilepath != null && $manager->user->profileFilename != null) : ?>
                                                                                <img alt="" src="<?= $manager->user->profileFilepath ?>/<?= $manager->user->profileFilename ?>">
                                                                            <?php else : ?>
                                                                                <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                                            <?php endif; ?>
                                                                        </a>
                                                                    </li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                    <div class="project-members m-b-15">
                                                        <div>Team :</div>
                                                        <ul class="team-members">
                                                            <?php foreach ($projectObject->projectmembers as $projectMember) : ?>
                                                                <?php if ($projectMember->type != 'C') : ?>
                                                                    <li id="myli_<?= $index ?>">
                                                                        <?php $allemps = array();
                                                                        array_push($allemps, $projectMember->user->firstname . ' ' . $projectMember->user->lastname);
                                                                        ?>
                                                                        <input id="allemps" type="hidden" value="<?= $projectMember->user->firstname ?> <?= $projectMember->user->lastname ?>">
                                                                        <a href="#" data-toggle="tooltip" title="<?= $projectMember->user->firstname ?> <?= $projectMember->user->lastname ?>">
                                                                            <?php if ($projectMember->user->profileFilepath != null && $projectMember->user->profileFilename != null) : ?>
                                                                                <img alt="" src="<?= $projectMember->user->profileFilepath ?>/<?= $projectMember->user->profileFilename ?>">
                                                                            <?php else : ?>
                                                                                <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                                            <?php endif; ?>
                                                                        </a>
                                                                    </li>
                                                                <?php endif; ?>

                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                    <div class="priority m-b-15">
                                                        <div>Priority :</div>
                                                        <select class="select2-icon floating" onchange="updatepriority(<?= $projectObject->id ?>)" id="priority_project_<?= $projectObject->id ?>">
                                                            <?php if ($projectObject->priority == 'H') : ?>
                                                                <option value="H" data-icon="fa fa-dot-circle-o text-danger" selected>High</option>
                                                                <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                                <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                                            <?php elseif ($projectObject->priority == 'M') : ?>
                                                                <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                                <option value="M" data-icon="fa fa-dot-circle-o text-warning" selected>Medium</option>
                                                                <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                                            <?php else : ?>
                                                                <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                                <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                                <option value="L" data-icon="fa fa-dot-circle-o text-success" selected>Low</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    </br>
                                                    <div class="project_status m-b-30">
                                                        <div>Status :</div>
                                                        <select class="select2-icon floating" onchange="updatestatus(<?= $projectObject->id ?>)" id="status_project_<?= $projectObject->id ?>">
                                                            <?php if ($projectObject->status == 'A') : ?>
                                                                <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                                <option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                            <?php else : ?>
                                                                <option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                                <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    </br>
                                                    <?php if ($totaltasks != 0) : ?>
                                                        <?php $progress = round($completedtask / ($totaltasks) * 100); ?>
                                                        <p class="m-b-5">Progress <span class="text-success float-right"><?= $progress = round($completedtask / ($opentask + $completedtask) * 100); ?>%</span></p>
                                                        <div class="progress progress-xs mb-0">
                                                            <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="40%" style="width: <?= $progress ?>%"></div>
                                                        </div>
                                                    <?php else : ?>
                                                        <p class="m-b-5">Progress <span class="text-success float-right">0%</span></p>
                                                        <div class="progress progress-xs mb-0">
                                                            <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="0%" style="width: 0%"></div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="tab-pane" id="results_users">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Company</th>
                                            <th>Created Date</th>
                                            <th>Role</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php if ($allcompanyusers != null) : ?>
                                            <?php foreach ($matchedusers as $matcheduser) : ?>
                                                <tr>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="profile.html" class="avatar">
                                                                <?php if ($matcheduser->user->profileFilepath != null && $matcheduser->user->profileFilename != null) : ?>
                                                                    <img src="<?= $matcheduser->user->profileFilepath ?>/<?= $matcheduser->user->profileFilename ?>" alt="">
                                                                <?php else : ?>
                                                                <?php endif; ?>
                                                            </a>
                                                            <a href="profile.html"><?= $matcheduser->user->firstname ?> <?= $matcheduser->user->lastname ?> <span>Admin</span></a>
                                                        </h2>
                                                    </td>
                                                    <td><?= $matcheduser->user->email ?></td>
                                                    <td><?= $matcheduser->usercompany->name ?></td>
                                                    <td>1 Jan 2013</td>
                                                    <td>
                                                        <span class="badge bg-inverse-danger">Admin</span>
                                                    </td>
                                                    <td class="text-right">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>
                                        <?php else : ?>

                                            <?php foreach ($matchedusers as $matcheduser) : ?>
                                                <tr>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="profile.html" class="avatar">
                                                                <?php if ($matcheduser->profileFilepath != null && $matcheduser->profileFilename != null) : ?>
                                                                    <img src="<?= $matcheduser->profileFilepath ?>/<?= $matcheduser->profileFilename ?>" alt="">
                                                                <?php else : ?>
                                                                <?php endif; ?>
                                                            </a>
                                                            <a href="profile.html"><?= $matcheduser->firstname ?> <?= $matcheduser->lastname ?> <span>Admin</span></a>
                                                        </h2>
                                                    </td>
                                                    <td><?= $matcheduser->email ?></td>
                                                    <td>---------</td>
                                                    <td>1 Jan 2013</td>
                                                    <td>
                                                        <span class="badge bg-inverse-danger">Admin</span>
                                                    </td>
                                                    <td class="text-right">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>


                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


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
</script>
