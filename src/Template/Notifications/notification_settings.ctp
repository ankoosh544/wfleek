<?= $this->element('settings_sidebar', [
    'companyId' => $companyId
]) ?>


<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Notifications Settings</h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div>
                    <ul class="list-group notification-list">
                        <?php foreach ($companymodules as $module) : ?>
                            <li class="list-group-item">
                                <?= $module->name ?>
                                <div class="status-toggle">
                                    <?php if ($module->isNotify == true) : ?>
                                        <input type="checkbox" id="staff_module_<?= $module->id ?>" class="check" checked onchange="updatemoduleaccess(<?= $module->id ?>)">
                                    <?php else : ?>
                                        <input type="checkbox" id="staff_module_<?= $module->id ?>" class="check" onchange="updatemoduleaccess(<?= $module->id ?>)">
                                    <?php endif; ?>

                                    <label for="staff_module_<?= $module->id ?>" class="checktoggle">checkbox</label>
                                </div>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->

<script>
    function updatemoduleaccess(id) {
        var access = document.getElementById('staff_module_' + id).checked;
        $.ajax({
            url: '/company-modules/updatemoduleaccess',
            method: 'post',
            dataType: 'json',
            data: {
                'moduleId': id,
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

