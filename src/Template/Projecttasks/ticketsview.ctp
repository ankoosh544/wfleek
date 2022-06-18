<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <?php if (!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)) : ?>
            <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
                <?php if ($usermodule->module->name == 'Tickets' && $usermodule->isAccessed == true && $usermodule->isRead == true) : ?>
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Tickets</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Tickets</li>
                                </ul>
                            </div>
                            <?php if ($usermodule->isCreate == true) : ?>
                                <div class="col-auto float-right ml-auto">
                                    <?php $typeticket = 'tickets'; ?>
                                    <a href="/projecttasks/newticket?typeticket=<?= $typeticket ?>" class="btn add-btn"><i class="fa fa-plus"></i> <?= __(' New Ticket') ?></a>
                                </div>
                            <?php endif; ?>
                            <div class="col-auto float-right ml-auto">
                                <a href="/projecttasks/ticketsview?status=T" class="btn add-btn"> <?= __(' Opened Tickets') ?></a>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <a href="/projecttasks/ticketsview?status=I" class="btn add-btn"> <?= __(' InProgress Tickets') ?></a>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <a href="/projecttasks/ticketsview?status=D" class="btn add-btn"> <?= __(' Resolved Tickets') ?></a>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ticket Id</th>
                                            <th>Ticket Subject</th>
                                            <th>Description</th>
                                            <th>Created Date</th>
                                            <th>Expiry Date</th>
                                            <?php if ($companyrole->designation->name == 'Administrator' || $companyrole->designation->name == 'Functional Analyst') : ?>
                                                <th>Priority</th>
                                            <?php endif; ?>
                                            <th class="text-center">Status</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($alltickets as $ticket) : ?>
                                            <tr>
                                                <td>1</td>
                                                <td><a>#TKT-<?= $ticket->id ?></a></td>
                                                <td><?= $ticket->title ?></td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <span><?= $ticket->description ?></span>
                                                    </h2>
                                                </td>

                                                <td>
                                                    <?php if ($ticket->startdate != null) : ?>
                                                        <?= $ticket->startdate->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($ticket->expiration_date != null) : ?>
                                                        <?= $ticket->expiration_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                    <?php endif; ?>
                                                </td>
                                                <?php if ($usermodule->isWrite == true && $companyrole->designation->name == 'Administrator' || $companyrole->designation->name == 'Functional Analyst') : ?>
                                                    <td>
                                                        <select class="select2-icon" id="ticketpriority_<?= $ticket->id ?>" name="ticketpriority" onchange="updatepriority(<?= $ticket->id ?>)">
                                                            <?php if ($ticket->priority == 'H') : ?>
                                                                <option selected value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                                <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                                <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>

                                                            <?php elseif ($ticket->priority == 'M') : ?>
                                                                <option selected value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                                <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                                <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>

                                                            <?php else : ?>
                                                                <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                                <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                                <option selected value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>

                                                            <?php endif; ?>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <select class="select2-icon" id="ticketstatus_<?= $ticket->id ?>" name="ticketstatus" onchange="updateticketStatus(<?= $ticket->id ?>)">
                                                            <?php if ($ticket->status == 'T') : ?>
                                                                <option value="T" selected data-icon="fa fa-dot-circle-o text-purple">Inviato</option>
                                                                <option value="I" data-icon="fa fa-dot-circle-o text-info">In lavorazione</option>
                                                                <option value="D" data-icon="fa fa-dot-circle-o text-danger">Risolto</option>
                                                            <?php elseif ($ticket->status == 'I') : ?>
                                                                <option value="T" data-icon="fa fa-dot-circle-o text-purple">Inviato</option>
                                                                <option value="I" selected data-icon="fa fa-dot-circle-o text-info">In lavorazione</option>
                                                                <option value="D" data-icon="fa fa-dot-circle-o text-danger">Risolto</option>
                                                            <?php else : ?>
                                                                <option value="T" data-icon="fa fa-dot-circle-o text-purple">Inviato</option>
                                                                <option value="I" data-icon="fa fa-dot-circle-o text-info">In lavorazione</option>
                                                                <option value="D" selected data-icon="fa fa-dot-circle-o text-danger">Risolto</option>
                                                            <?php endif; ?>

                                                        </select>

                                                    </td>
                                                <?php else : ?>
                                                    <td>
                                                        <select class="select2-icon">
                                                            <?php if ($ticket->priority == 'H') : ?>
                                                                <option selected value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                            <?php elseif ($ticket->priority == 'M') : ?>
                                                                <option selected value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                            <?php else : ?>
                                                                <option selected value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <select class="select2-icon">
                                                            <?php if ($ticket->status == 'T') : ?>
                                                                <option value="T" selected data-icon="fa fa-dot-circle-o text-purple">Inviato</option>
                                                            <?php elseif ($ticket->status == 'I') : ?>
                                                                <option value="I" selected data-icon="fa fa-dot-circle-o text-info">In lavorazione</option>
                                                            <?php else : ?>
                                                                <option value="D" selected data-icon="fa fa-dot-circle-o text-danger">Risolto</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </td>
                                                <?php endif; ?>
                                                <td class="text-right">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <?php if ($companyrole->designation->name == 'Administrator' || $companyrole->designation->name == 'Functional Analyst') : ?>
                                                                <?php if ($usermodule->isWrite == true && $usermodule->isDelete == true) : ?>
                                                                    <a class="dropdown-item" href="/projecttasks/chargetickets?ticketid=<?= $ticket->id ?>&&alltickets=<?= $ticket->id ?>&&status=<?= $ticket->status ?>"><i class="fa fa-pencil m-r-5"></i> Charge Ticket</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_task_<?= $ticket->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                <?php elseif ($usermodule->isWrite == true && $usermodule->isDelete != true) : ?>
                                                                    <a class="dropdown-item" href="/projecttasks/chargetickets?ticketid=<?= $ticket->id ?>&&alltickets=<?= $ticket->id ?>&&status=<?= $ticket->status ?>"><i class="fa fa-pencil m-r-5"></i> Charge Ticket</a>
                                                                <?php elseif ($usermodule->isWrite != true && $usermodule->isDelete == true) : ?>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_task_<?= $ticket->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                <?php endif; ?>

                                                            <?php else : ?>
                                                                <a class="dropdown-item" href="/projecttasks/chargetickets?ticketid=<?= $ticket->id ?>&&alltickets=<?= $ticket->id ?>&&status=<?= $type ?>"><i class="fa fa-pencil m-r-5"></i> Manage Ticket</a>
                                                                <?php if ($ticket->status == 'T') : ?>
                                                                    <?php if ($usermodule->isDelete == true) : ?>)
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_task_<?= $ticket->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                <?php endif; ?>

                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>


                                            <!-- Delete Ticket Modal -->
                                            <?= $this->element('delete_task', [
                                                'ticket' => $ticket,
                                                'alltickets' => 'tickets'

                                            ]) ?>
                                            <!-- /Delete Ticket Modal -->
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
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

    function updatepriority(ticketId) {

        var priority = $('#ticketpriority_' + ticketId).val();

        $.ajax({
            url: '/projecttasks/updatepriority',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': ticketId,
                'priority': priority
            },
            success: function(data) {
                location.reload();
            },
            error: function() {}
        });

    }

    function updateticketStatus(ticketId) {
        var status = $('#ticketstatus_' + ticketId).val();
        $.ajax({
            url: '/projecttasks/updateticketStatus',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': ticketId,
                'status': status
            },
            success: function(data) {
                location.reload();
                // window.location = '/projecttasks/tickets/'+user_id+'';
            },
            error: function() {}
        });


    }
</script>
