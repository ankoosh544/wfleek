<?php

use Cake\I18n\Number;

?>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>--->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">New Group</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/project-member/privatedashboard/">Dashboard</a></li>
                        <li class="breadcrumb-item active">New Group</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" action="/groups/grouppage/" enctype="multipart/form-data">
                            <div class="newgroup-view">
                                <div class="form-group">
                                    <label for="name">Group Name</label>
                                    <input class="form-control" type="text" name="group_name">
                                </div>
                                <div class="form-group">
                                    <label for="name">Group Description</label>
                                    <textarea class="form-control" rows="5" type="text" name="group_description" style="resize: none; "></textarea>
                                </div>
                               <div class="form-group">
                                   <label>Group Profile Image</label>
                                  <input type="file" name="group_profile" class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png">

                               </div>

                                <div class="footer">
                                    <button class="btn btn-info" type="submit">Create</button>
                                    <input type="hidden" name="companyId" value="<?=$companyId?>">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- /Page Wrapper -->
