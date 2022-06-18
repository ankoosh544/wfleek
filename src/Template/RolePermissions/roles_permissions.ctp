<!-- Sidebar -->


<?= $this->element('settings_sidebar',[
    'companyId' => $companyId
]) ?>
<!-- /Sidebar -->

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Roles & Permissions</h3>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3">
                <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_module"><i class="fa fa-plus"></i> Add Module</a>
                <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_role"><i class="fa fa-plus"></i> Add Roles</a>
                <div class="roles-menu">

                    <ul>
                        <?php foreach ($companyrolepermissions as $companyrolepermission) : ?>
                            <?php if (!empty($roledata) && $companyrolepermission->designation_id == $roledata->designation_id) : ?>
                                <li class="active">
                                    <a href="/role-permissions/roles-permissions?companyId=<?= $companyId ?>&&roleId=<?= $companyrolepermission->designation_id ?>"><?= $companyrolepermission->designation->name ?>
                                        <span class="role-action">
                                            <span class="action-circle large" data-toggle="modal" data-target="#edit_role" onclick="return false">
                                                <i class="material-icons">edit</i>
                                            </span>
                                            <span class="action-circle large delete-btn" data-toggle="modal" data-target="#delete_role" onclick="return false">
                                                <i class="material-icons">delete</i>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li>
                                    <a href="/role-permissions/roles-permissions?companyId=<?= $companyId ?>&&roleId=<?= $companyrolepermission->designation_id ?>"><?= $companyrolepermission->designation->name ?>
                                        <span class="role-action">
                                            <span class="action-circle large" data-toggle="modal" data-target="#edit_role">
                                                <i class="material-icons">edit</i>
                                            </span>
                                            <span class="action-circle large delete-btn" data-toggle="modal" data-target="#delete_role">
                                                <i class="material-icons">delete</i>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            <?php endif; ?>


                            <!-- Delete Role Modal -->
                            <div class="modal custom-modal fade" id="delete_role" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="form-header">
                                                <h3>Delete Role</h3>
                                                <p>Are you sure want to delete?</p>
                                            </div>
                                            <div class="modal-btn delete-action">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
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
                            <!-- /Delete Role Modal -->

                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-9">
                <h6 class="card-title m-b-20">Module Access</h6>
                <div class="m-b-30">
                    <ul class="list-group notification-list">
                        <?php if (!empty($roledata)) : ?>
                            <?php foreach ($roledata->designation->usermodulepermissions as $usermodulepermission) : ?>
                                <li class="list-group-item">
                                    <?= $usermodulepermission->module->name ?>
                                    <div class="status-toggle">
                                        <?php if ($usermodulepermission->isAccessed == true) : ?>
                                            <input type="checkbox" id="staff_module_<?= $usermodulepermission->id ?>" class="check" checked onchange="updatemoduleaccess(<?= $usermodulepermission->id ?>)">
                                        <?php else : ?>
                                            <input type="checkbox" id="staff_module_<?= $usermodulepermission->id ?>" class="check" onchange="updatemoduleaccess(<?= $usermodulepermission->id ?>)">
                                        <?php endif; ?>
                                        <label for="staff_module_<?= $usermodulepermission->id ?>" class="checktoggle">checkbox</label>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </ul>
                </div>
                <div class="table-responsive">
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
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($roledata)) : ?>
                                <?php foreach ($roledata->designation->usermodulepermissions as $usermodulepermission) : ?>
                                    <?php if ($usermodulepermission->isAccessed == true) : ?>
                                        <form action="/usermodule-permissions/update-permissions" method="post">
                                            <tr>
                                                <td><?= $usermodulepermission->module->name ?></td>
                                                <td class="text-center">
                                                    <?php if ($usermodulepermission->isRead == true) : ?>
                                                        <input type="checkbox" checked="" name="read">
                                                    <?php else : ?>
                                                        <input type="checkbox" name="read">
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($usermodulepermission->isWrite == true) : ?>
                                                        <input type="checkbox" checked="" name="write">
                                                    <?php else : ?>
                                                        <input type="checkbox" name="write">
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($usermodulepermission->isCreate == true) : ?>
                                                        <input type="checkbox" checked="" name="create">
                                                    <?php else : ?>
                                                        <input type="checkbox" name="create">
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($usermodulepermission->isDelete == true) : ?>
                                                        <input type="checkbox" checked="" name="delete">
                                                    <?php else : ?>
                                                        <input type="checkbox" name="delete">
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($usermodulepermission->isImport == true) : ?>
                                                        <input type="checkbox" checked="" name="import">
                                                    <?php else : ?>
                                                        <input type="checkbox" name="import">
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($usermodulepermission->isExport == true) : ?>
                                                        <input type="checkbox" checked="" name="export">
                                                    <?php else : ?>
                                                        <input type="checkbox" name="export">
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <button type="submit" class="btn btn-primary"> Update </button>
                                                    <input type="hidden" value="<?= $usermodulepermission->id ?>" name="usermodule">
                                                    <input type="hidden" value="<?= $companyId ?>" name="companyId">
                                                </td>
                                            </tr>
                                        </form>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add Role Modal -->
    <div id="add_role" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/role-permissions/add">
                        <div class="form-group">
                            <label>Role Name <span class="text-danger">*</span></label>
                            <select class="select floating" name="roleId">
                                <option value="">--Select Designation--</option>
                                <?php foreach ($departments as $department) : ?>
                                    <?php foreach ($department->designations as $designation) : ?>
                                        <option value="<?= $designation->id ?>"><?= $designation->name ?></option>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="submit-section">
                            <input type="hidden" name="companyId" value="<?= $companyId ?>">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Role Modal -->

    <!-- Add Module Modal -->
    <div id="add_module" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Module</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/company-modules/add">
                        <div class="form-group">
                            <label>Module Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="modulename">
                            <input type="hidden" name="companyId" value="<?= $companyId ?>">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Module Modal -->

    <!-- Edit Role Modal -->
    <div id="edit_role" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-md">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Role Name <span class="text-danger">*</span></label>
                            <input class="form-control" value="Team Leader" type="text">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Role Modal -->

    <!-- Delete Role Modal -->
    <div class="modal custom-modal fade" id="delete_role" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Role</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
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
    <!-- /Delete Role Modal -->

</div>
<!-- /Page Wrapper -->
<script>
    $(document).ready(function() {

    $(window.location.hash).modal('show');

    });

    function updatemoduleaccess(id) {
        var access = document.getElementById('staff_module_' + id).checked;
        $.ajax({
            url: '/usermodule-permissions/updatemoduleaccess',
            method: 'post',
            dataType: 'json',
            data: {
                'usermoduleId': id,
                'access': access
            },
            success: function(data) {
                if (data != null) {
                    location.reload();
                }
            },
            error: function() {}
        })

    }
</script>
