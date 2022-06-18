<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">


        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Clients</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Clients</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_client"><i class="fa fa-plus"></i> Add Client</a>
                    <div class="view-icons">
                        <a href="clients.html" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                        <a href="clients-list.html" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <?php $total = count($companymembers); ?>
                    <input type="text" id="client_id" class="form-control floating" onkeyup="filterById(this, <?= $total ?>)">
                    <label class="focus-label">Client ID</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label" id="myInput">Client Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option>Select Company</option>
                        <option>Global Technologies</option>
                        <option>Delta Infotech</option>
                    </select>
                    <label class="focus-label">Company</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
        <!-- Search Filter -->
        <?php if (!empty($companymembers)) : ?>
            <div class="row staff-grid-row" id="myTable">
                <?php foreach ($companymembers as $companymember) : ?>

                        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3" id="mydiv">
                            <div class="profile-widget">
                                <div class="profile-img">
                                    <?php if ($companymember->user->profileFilepath != null && $companymember->user->profileFilename != null) : ?>
                                        <a href="/user/view/<?= $companymember->user->id ?>" class="avatar"><img alt="" src="<?= $companymember->user->profileFilepath ?>/<?= $companymember->user->profileFilename ?>"></a>
                                    <?php else : ?>
                                        <a href="/user/view/<?= $companymember->user->id ?>" class="avatar"><img alt="" src="/assets/img/profiles/avatar-19.jpg"></a>
                                    <?php endif; ?>

                                </div>
                                <div class="dropdown profile-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_client_<?= $companymember->user->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_client_<?= $companymember->user->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="/user/view/<?= $companymember->user->id ?>"><?= $companymember->usercompany->name ?></a></h4>

                                <h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="/user/view/<?= $companymember->user->id ?>"></a><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></h5>

                                <div class="small text-muted"><?=$companymember->designation->name?></div>
                                <a href="/user/chatsystem/<?= $companymember->user->id ?>" class="btn btn-white btn-sm m-t-10">Message</a>
                                <a href="/user/view/<?= $companymember->user->id ?>" class="btn btn-white btn-sm m-t-10">View Profile</a>
                            </div>


                        </div>
                        <!-- Edit Client Modal -->
                        <div id="edit_client_<?= $companymember->user->id ?>" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Client Data</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/project-member/updateclientinfo" method="post">

                                            <div class="form-group">
                                                <label>First Name <span class="text-danger">*</span></label>
                                                <input class="form-control" name="firstname" value="<?= $companymember->user->firstname ?>" type="text">
                                            </div>

                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input class="form-control" name="lastname" value="<?= $companymember->user->lastname ?>" type="text">
                                            </div>

                                            <div class="form-group">
                                                <label>
                                                    Address
                                                </label>
                                                <input class="form-control" name="address" value="<?= $companymember->user->address ?>" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    gender
                                                </label>
                                                <select class="select" name="gender">
                                                    <?php if ($companymember->user->gender == 'Male') : ?>
                                                        <option value="Male" selected>Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    <?php elseif ($companymember->user->gender == 'Female') : ?>

                                                        <option value="Male">Male</option>
                                                        <option value="Female" selected>Female</option>
                                                        <option value="Other">Other</option>
                                                    <?php else : ?>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other" selected>Other</option>
                                                    <?php endif; ?>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Email <span class="text-danger">*</span></label>
                                                <input class="form-control" name="email" value="<?= $companymember->user->email ?>" type="email">
                                            </div>

                                            <div class="form-group">
                                                <label>Password</label>
                                                <input class="form-control" name="password" type="password" value="<?= $companymember->user->password ?>">
                                            </div>


                                            <div class="form-group">
                                                <label> Password Expirationdate</label>
                                                <input class="form-control datetimepicker" name="passwordExpitydate" type="text" value="<?= $companymember->user->passwordExpirationDate ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Phone </label>
                                                <input class="form-control" name="tel" value="<?= $companymember->user->tel ?>" type="text">
                                            </div>

                                    </div>

                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                        <input type="hidden" name="userid" value="<?= $companymember->user->id ?>">
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /Edit Client Modal -->

                        <!-- Delete Client Modal -->
                        <div class="modal custom-modal fade" id="delete_client_<?= $companymember->user->id ?>" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="form-header">
                                            <h3>Delete Client</h3>
                                            <p>Are you sure want to delete?</p>
                                        </div>
                                        <div class="modal-btn delete-action">
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="/project-member/deleteclient/<?= $companymember->user->id ?>" class="btn btn-primary continue-btn">Delete</a>
                                                </div>
                                                <div class="col-6">
                                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Delete client Modal -->

                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <!-- /Page Content -->

    <!-- Add Client Modal
    <div id="add_client" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Last Name</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Username <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input class="form-control floating" type="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <input class="form-control" type="password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Confirm Password</label>
                                    <input class="form-control" type="password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Client ID <span class="text-danger">*</span></label>
                                    <input class="form-control floating" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Phone </label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Company Name</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive m-t-15">
                            <table class="table table-striped custom-table">
                                <thead>
                                    <tr>
                                        <th>Module Permission</th>
                                        <th class="text-center">Read</th>
                                        <th class="text-center">Write</th>
                                        <th class="text-center">Create</th>
                                        <th class="text-center">Delete</th>
                                        <th class="text-center">Import</th>
                                        <th class="text-center">Export</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Projects</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tasks</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Chat</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Estimates</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Invoices</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Timing Sheets</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     /Add Client Modal -->
    <!------Assign Client Modal---->
    <?= $this->element('addclient_tocompany', [
        'allclientData' => $companymembers
    ]) ?>
    <!------/Assign Client Modal------>





</div>
<!-- /Page Wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };

    $('.select2-icon').select2({

        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });

    $(function() {
        $(document).ready(function() {

        });
    });

    function filterById(allusers) {
        console.log(allusers);
        allusers.filter((user) => {
            return user.id.includes($('#client_id').val());
        });
    }



    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementById("mydiv");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            console.log(td);
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
