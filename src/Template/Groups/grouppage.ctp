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
                    <h3 class="page-title">Group Page</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/project-member/privatedashboard/">Dashboard</a></li>
                        <li class="breadcrumb-item active">Group Page</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                      <h3><?=$group->name?></h3>

                    <a  href="/groups/addmembers/<?=$group->id?>" class="btn btn-info" type="submit">ADD MEMBERS</a>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- /Page Wrapper -->
