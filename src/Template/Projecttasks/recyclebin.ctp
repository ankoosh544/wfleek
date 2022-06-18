<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="page-content" style="padding: 15px;">

        <h5>Recycle Bin</h5>
        <div class="container" style="background: whitesmoke;">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Task/Ticket Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($binData as $item) : ?>
                                    <tr>

                                        <td>
                                            <?= $item->title ?>
                                        </td>
                                        <td>
                                            <?= $item->description ?>
                                        </td>
                                        <td>
                                            <i class="fa fa-dot-circle-o text-danger"></i> Inactive
                                        </td>
                                        <td style="text-align: end;">
                                            <form method="post" action="/projecttasks/deletetask" id="" enctype="multipart/form-data">
                                                <input type="hidden" name="id" id="id" value="<?= $item->id ?>">
                                                <button type="submit" style="text-align: end;">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>



                        </table>
                        <div style="text-align: end;">
                            <form method="post" action="/projecttasks/deletetask" id="" enctype="multipart/form-data">
                                <button type="submit">Delete All</button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
