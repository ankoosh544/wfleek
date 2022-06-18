<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js"></script>
<link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<style>
    canvas#horizontalBarChartCanvas {
        max-width: 768px;
        margin: 40px auto;

    }

    .button-sk {
        display: flex;
        margin-top: 10 px;
        justify-content: end;
        width: 100%;
        padding: 15 px;

    }

    .innerbuttonsweb {

        display: flex;
        justify-content: space-between;
        width: 28%;
    }
</style>

<?php

use Cake\I18n\Number;

?>
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">


                <div class="col" style="display: flex;justify-content: space-between;">
                    <div>
                        <h3 class="page-title"><?= $projectObject->name ?></h3>
                        <input type="hidden" id="projectId" value="<?= $projectObject->id ?>">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Project</li>
                        </ul>
                    </div>
                    <span>
                        <a href="/project-object/taskboard/<?= $projectObject->id ?>" class="btn btn-white float-right m-r-10" data-toggle="tooltip" title="Task Board"><i class="fa fa-bars"></i></a>
                    </span>
                </div>

                <div class="float-left ml-auto button-sk mobilebutton-sk">


                    <div>
                        <a class="btn btn-info" href="/project-object/ganttdata/<?= $projectObject->id ?>" data-mdb-ripple-color="dark">Add Info</a>
                    </div>
                </div>


            </div>
        </div>
        <!-- Add Ticket Modal -->
        <div id="add_ticket" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/projecttasks/createTicket" id="add" enctype="multipart/form-data">
                            <?php if ($data2->type == 'Y') : ?>
                                <div class="form-group form-focus select-focus">
                                    <label for="ticketstatus">Ticket Status<span class="text-danger">*</span></label>
                                    <select id="ticketstatus" class="select floating" name="ticketstatus" required style="height:60%;">
                                        <option id='' disabled selected>-------</option>
                                        <option value=1>Approved</option>
                                        <option value=0>Not Approved</option>

                                    </select>
                                </div>
                            <?php endif; ?>
                            <br />
                            <div class="form-group form-focus select-focus">
                                <label for="grouptype"><?= __('Select the Task Group') ?><span class="text-danger">*</span></label>
                                <select name="grouptype" id="grouptype" class="select floating" name="type" required>
                                    <option id='' disabled selected>-------</option>
                                    <?php foreach ($taskgroups as $group) : ?>
                                        <option value="<?= $group->id ?>"><?= $group->title ?></option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <br />

                            <div class="form-group">
                                <label for="name"><?= __('Ticket name') ?><span class="text-danger">*</span></label>
                                <input name="name" id="name" type="text" class="form-control btn-mod-input" placeholder="<?= __('Your project\'s name...') ?>" required />
                            </div>
                            <div class="form-group">
                                <label for="description"><?= __('Description') ?><span class="text-danger">*</span></label>
                                <textarea name="description" id="description" type="text" class="form-control btn-mod-input height10" placeholder="<?= __('Describe your project...') ?>" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="startdate"><?= __('Start Date') ?></label> <span class="text-success" id="ticketstartdateMsg"></span>
                                <input type="text" name="startdate" id="ticketstartdate" class="datetimepicker form-control" placeholder="dd/mm/yyyy" required />

                            </div>

                            <div class="form-group">
                                <label>Expire Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="expirydate" id="ticketexpirydate" type="text" placeholder="<?= __('dd/mm/yyyy') ?>" required>
                                    <span class="text-success" id="ticketexpirydateMsg"></span>
                                </div>
                            </div>
                            <?php if ($data2->type != 'C') : ?>
                                <div class="form-group">
                                    <label for="price"><?= __('Price') ?><span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="<?= __('Enter Price...') ?> " required>
                                </div>

                                <div class="form-group">
                                    <label for="tax"><?= __('Tax') ?><span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="tax" id="tax" placeholder="<?= __('Enter Tax...') ?> " required>

                                </div>
                            <?php endif; ?>

                            <div class="text-center">
                                <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('create Ticket') ?></button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- /Add Ticket Modal -->

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Gantt Diagram for Tasks</h3>
                                <!--  <div id="bar"></div> -->
                                <canvas id="bar-chart-horizontal"></canvas>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6.0.0-alpha14/css/tempus-dominus.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        var projectId = $('#projectId').val();
        console.log(projectId);
        $.ajax({
            url: '/project-object/ganttdata/' + projectId + '',

            dataType: 'json',
            success: function(data) {
                let durArr = [];
                let labels = [];
                var xLabels = [];
                var expirydates = [];

                data.forEach((task) => {
                    const time_difference = (new Date(task.expiration_date).getTime() - (new Date(task.startdate)).getTime());
                    const days_difference = time_difference / (1000 * 60 * 60 * 24);
                    xLabels.push(new Date(task.startdate));
                    durArr.push([new Date(task.startdate), new Date(task.expiration_date)]);
                    expirydates.push(new Date(task.expiration_date));
                    labels.push(task.title);
                });
                var maxDate=new Date(Math.max.apply(null,expirydates));

                var MeSeChart = new Chart(document.getElementById("bar-chart-horizontal").getContext("2d"), {
                    type: 'horizontalBar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: labels,
                            data: durArr,
                            backgroundColor: 'lightblue',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            xAxes: [{
                                type: 'time',
                                time: {
                                    unit: 'day',
                                    displayFormats: {
                                        day: 'YYYY-MM-DD'
                                    }

                                },
                                ticks: {
                                    min: new Date().getTime(),
                                    max: maxDate.getTime(),
                                }
                            }]
                        }
                    }
                });
            },
            error: function(e) {}
        });
    });
</script>
