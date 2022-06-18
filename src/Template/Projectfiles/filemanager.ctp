
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="file-wrap">
                    <div class="file-sidebar">
                        <div class="file-header justify-content-center">
                            <span>Projects</span>
                            <a href="javascript:void(0);" class="file-side-close"><i class="fa fa-times"></i></a>
                        </div>
                        <form class="file-search">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <i class="fa fa-search"></i>
                                </div>
                                <?php $total = count($projectObjects) ?>
                                <input type="text" id="myInput" onkeyup="projectsearchbox(<?= $total ?>)" class="form-control" placeholder="Search">
                            </div>
                        </form>


                        <div class="file-pro-list">
                            <div class="file-scroll">

                                <ul class="file-menu">
                                    <li>
                                        <a href="#" id="allprojects" onclick="showAllfilefunction(event,'<?= $type ?>')">All Projects</a>
                                    </li>
                                    <?php foreach ($projectObjects as $index => $projectObject) : ?>
                                        <?php if ($index < 2) : ?>
                                            <li class="showsidebarprojects" id="tablink_<?= $index ?>">
                                                <a class="tablinks" href="#" onclick="showfunction(event, <?= $projectObject->id ?>, '<?= $type ?>')"> <?= $projectObject->name ?></a>
                                            </li>
                                        <?php else : ?>
                                            <li class="showsidebarprojects" id="tablink_<?= $index ?>" style="display: none;">
                                                <a class="tablinks" href="#" onclick="showfunction(event, <?= $projectObject->id ?>, '<?= $type ?>')"> <?= $projectObject->name ?></a>
                                            </li>
                                        <?php endif; ?>

                                    <?php endforeach; ?>
                                </ul>
                                <div class="show-more">
                                    <a onclick="showallprojects(event);" style="cursor: pointer;">Show More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="file-cont-wrap">
                        <div class="file-cont-inner" style="min-width: 928px;">
                            <div class="file-cont-header">
                                <div class="file-options">
                                    <a href="javascript:void(0)" id="file_sidebar_toggle" class="file-sidebar-toggle">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                </div>
                                <span>File Manager</span>

                                <div class="file-options" id="uploadfileoption">
                                </div>

                            </div>
                            <div class="file-content">
                                <form class="file-search">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <i class="fa fa-search"></i>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                </form>
                                <div class="file-body">
                                    <div class="file-scroll">
                                        <div class="file-content-inner">
                                            <h4>Recent Files</h4>

                                            <div class="row row-sm" id="fileCardContainer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
<script>
    function renderprojectfiles(data, pid) {
        console.log('hello  ', data);
        $('#fileCardContainer').empty();
        $('#uploadfileoption').empty();
        var fileupload = '<button class="btn btn-info" onclick="uploadFile(' + pid + ');">Upload</button>' +
            '<input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="images_' + pid + '" name="images" type="file"  multiple/>'+
            '<input type = hidden value ="' + pid + '" name= projectId>';

        var filecard = " ";

        // let projectfiledata = pid === null ? allprojectfiles : data;
        data.forEach((card, index) => {
            var ext = card.filename.split(".")[1];
            //  if (index < 4) {
            filecard += '<div  class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">' +
                '<div class="card card-file">' +
                '<div class="dropdown-file">' +
                '<a href="" class="dropdown-link" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>' +
                '<div class="dropdown-menu dropdown-menu-right">' +
                '<a href="" class="dropdown-item"  data-toggle="modal" data-target="#view_fileData_' + card.id + '">View Details</a>' +
                '<a href="/projectemail/composeEmail' + '?fileid=' + card.id + '&' + 'projectid=' + pid + '" class="dropdown-item">Share</a>' +
                '<a href="/projectfiles/downloadfile' + '?fileid=' + card.id + '" class="dropdown-item">Download</a>' +
                //'<a href="#" class="dropdown-item">Rename</a>' +
                //'<a href="/projectfiles/deletefile' + '?fileid=' + card.id + '&' + 'dummy=' +  '\''+ptype+ '\'' + '" class="dropdown-item">Delete</a>' +
                '<a onclick="deletefile(' + card.id + ' ,' + card.project_id + ' )"  class="dropdown-item">Delete</a>' +
                '</div>' +
                '</div>' +

                '<div class="card-file-thumb">';
            if (ext === 'jpg' || ext === 'png' || ext === 'jpeg') {
                filecard += '<i class="fa fa-image"></i>';
            } else if (ext == 'docx') {
                filecard += '<i class="fa fa-file-word-o"></i>';
            } else if (ext == 'pdf') {
                filecard += '<i class="fa fa-file-pdf-o"></i>';
            } else {
                filecard += '<i class="fa fa-file"></i>';

            }

            // '<img src="' + card.filepath + '/' + card.filename + '" class="img-fluid" alt="">'
            filecard += ' </div>' +
                '<div class="card-body">' +
                ' <h6><a href="">' + card.filename + '</a></h6>' +
                '<span>' + card.size + 'kb</span>' +
                '</div>' +
                '<div class="card-footer">' + card.creation_date + '</div>' +
                //modal
                '<div id="view_fileData_' + card.id + '" class="modal custom-modal fade" role="dialog">' +
                '<div class="modal-dialog modal-dialog-centered ">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<h4 class="modal-title"> File Details </h4>' +
                '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
                '</div>' +
                '<div class="modal-body">' +
                '<div class="form-group">' +
                ' <label>File name</label>' +
                ' <input type="text" class="form-control" value="' + card.filename + '">' +
                ' </div>' +
                '<div class="form-group">' +
                ' <label>File type</label>' +
                ' <input type="text" class="form-control" value="' + card.type + '">' +
                ' </div>' +
                '<div class="form-group">' +
                ' <label>File size</label>' +
                ' <input type="text" class="form-control" value="' + card.size + 'kb">' +
                ' </div>' +
                '<div class="form-group">' +
                ' <label>Uploaded by</label>' +
                ' <input type="text" class="form-control" value="' + card.user.firstname + ' ' + card.user.lastname + '">' +
                ' </div>' +
                '  </div>' +
                '</div>' +
                ' </div>' +
                ' </div>' +
                '  </div>' +
                ' </div>' +
                '</div>';
            /*   }else{
                       '<div class="row row-sm" id="fileCardContainer">' +
                       '<h4>Recent Files</h4>'+
                       '<div  class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">' +
                       '<div class="card card-file">' +
                       '<div class="dropdown-file">' +
                       '<a href="" class="dropdown-link" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>' +
                       '<div class="dropdown-menu dropdown-menu-right">' +
                       '<a href="" class="dropdown-item"  data-toggle="modal" data-target="#view_fileData_' + card.id + '">View Details</a>' +
                       '<a href="/projectemail/composeEmail' + '?fileid=' + card.id + '&' + 'projectid=' + pid + '" class="dropdown-item">Share</a>' +
                       '<a href="/projectfiles/downloadfile' + '?fileid=' + card.id + '" class="dropdown-item">Download</a>' +
                       //'<a href="#" class="dropdown-item">Rename</a>' +
                       //'<a href="/projectfiles/deletefile' + '?fileid=' + card.id + '&' + 'dummy=' +  '\''+ptype+ '\'' + '" class="dropdown-item">Delete</a>' +
                       '<a onclick="deletefile(' + card.id + ' ,' + card.project_id + ' )"  class="dropdown-item">Delete</a>' +
                       '</div>' +
                       '</div>' +

                       '<div class="card-file-thumb">' +
                       '<i class="fa fa-file-word-o"></i>' +
                       // '<img src="' + card.filepath + '/' + card.filename + '" class="img-fluid" alt="">'
                       ' </div>' +
                       '<div class="card-body">' +
                       ' <h6><a href="">' + card.filename + '</a></h6>' +
                       '<span>' + card.size + 'kb</span>' +
                       '</div>' +
                       '<div class="card-footer">' + card.creation_date + '</div>' +
                       //modal
                       '<div id="view_fileData_' + card.id + '" class="modal custom-modal fade" role="dialog">' +
                       '<div class="modal-dialog modal-dialog-centered ">' +
                       '<div class="modal-content">' +
                       '<div class="modal-header">' +
                       '<h4 class="modal-title"> File Details </h4>' +
                       '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
                       '</div>' +
                       '<div class="modal-body">' +
                       '<div class="form-group">' +
                       ' <label>File name</label>' +
                       ' <input type="text" class="form-control" value="' + card.filename + '">' +
                       ' </div>' +
                       '<div class="form-group">' +
                       ' <label>File type</label>' +
                       ' <input type="text" class="form-control" value="' + card.type + '">' +
                       ' </div>' +
                       '<div class="form-group">' +
                       ' <label>File size</label>' +
                       ' <input type="text" class="form-control" value="' + card.size + 'kb">' +
                       ' </div>' +
                       '<div class="form-group">' +
                       ' <label>Uploaded by</label>' +
                       ' <input type="text" class="form-control" value="' + card.user.firstname + ' ' + card.user.lastname + '">' +
                       ' </div>' +
                       '  </div>' +
                       '</div>' +
                       ' </div>' +
                       ' </div>' +
                       '  </div>' +
                       ' </div>' +
                       '</div>'+
                       '</div>';
               } */

            $('#fileCardContainer').html(filecard);
        });
        $('#uploadfileoption').html(fileupload);
        // window.location.reload();


    }

    function showAllfilefunction(ptype) {
        $.ajax({

            url: '/projectfiles/showAllfiles',
            /*  method: 'post', */
            dataType: 'json',
            /* data: {
                'dummy': dummy,


            }, */
            success: function(data) {
                $('#fileCardContainer').empty();
                $('#uploadfileoption').empty();


                var filecard = " ";
                // let projectfiledata = pid === null ? allprojectfiles : data;
                data.forEach((card) => {
                    var ext = card.filename.split(".")[1];

                    filecard += '<div  class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">' +
                        '<div class="card card-file">' +
                        '<div class="dropdown-file">' +
                        '<a href="" class="dropdown-link" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a href="" class="dropdown-item"  data-toggle="modal" data-target="#view_fileData_' + card.id + '">View Details</a>' +
                        '<a href="/projectemail/composeEmail' + '?fileid=' + card.id + '&' + 'projectid=' + card.project_id + '" class="dropdown-item">Share</a>' +
                        '<a href="/projectfiles/downloadfile' + '?fileid=' + card.id + '" class="dropdown-item">Download</a>' +
                        //'<a href="#" class="dropdown-item">Rename</a>' +
                        //'<a href="/projectfiles/deletefile' + '?fileid=' + card.id + '&' + 'dummy=' +  '\''+ptype+ '\'' + '" class="dropdown-item">Delete</a>' +
                        '<a onclick="deletefile(' + card.id + ' ,' + card.project_id + ' )"  class="dropdown-item">Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-file-thumb">';
                    if (ext === 'jpg' || ext === 'png' || ext === 'jpeg') {
                        filecard += '<i class="fa fa-image"></i>';
                    } else if (ext == 'docx') {
                        filecard += '<i class="fa fa-file-word-o"></i>';
                    } else if (ext == 'pdf') {
                        filecard += '<i class="fa fa-file-pdf-o"></i>';
                    } else {
                        filecard += '<i class="fa fa-file"></i>';

                    }
                    // '<img src="' + card.filepath + '/' + card.filename + '" class="img-fluid" alt="">'
                    filecard += ' </div>' +
                        '<div class="card-body">' +
                        ' <h6><a href="">' + card.filename + '</a></h6>' +
                        '<span>' + card.size + 'kb</span>' +
                        '</div>' +
                        '<div class="card-footer">' + card.creation_date + '</div>' +
                        ' </div>' +
                        '</div>';
                    $('#fileCardContainer').html(filecard);

                });

                // window.location.reload();


            },
            error: function(data) {
                console.log(data);


            }
        });

    }


    function uploadFile(pid) {

        var file_data = $('#images_' + pid).prop("files");
        // $("#image").val("");
        $('#uploadfileoption').val("");
        console.log(file_data);
        var form_data = new FormData();
        for (var i = 0; i < file_data.length; i++) {

            form_data.append("file[]", file_data[i]);

        }
        form_data.append("file", file_data);
        form_data.append("pid", pid);


        $.ajax({
            url: '/projectfiles/uploadfiles',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data) {
                $('#fileCardContainer').empty();
                var filecard = " ";
                data.forEach((card) => {
                    var ext = card.filename.split(".")[1];
                    filecard += '<div  class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">' +
                        '<div class="card card-file">' +
                        '<div class="dropdown-file">' +
                        '<a href="" class="dropdown-link" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a href="" class="dropdown-item"  data-toggle="modal" data-target="#view_fileData_' + card.id + '">View Details</a>' +
                        '<a href="/projectemail/composeEmail' + '?fileid=' + card.id + '&' + 'projectid=' + pid + '" class="dropdown-item">Share</a>' +
                        '<a href="/projectfiles/downloadfile' + '?fileid=' + card.id + '" class="dropdown-item">Download</a>' +
                        // '<a href="#" class="dropdown-item">Rename</a>' +
                        // '<a href="/projectfiles/deletefile' + '?fileid=' + card.id + '&' + 'dummy=' +  '\''+ptype+ '\'' + '" class="dropdown-item">Delete</a>' +
                        '<a onclick="deletefile(' + card.id + ' ,' + card.project_id + ')"  class="dropdown-item">Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-file-thumb">';
                    if (ext === 'jpg' || ext === 'png' || ext === 'jpeg') {
                        filecard += '<i class="fa fa-image"></i>';
                    } else if (ext == 'docx') {
                        filecard += '<i class="fa fa-file-word-o"></i>';
                    } else if (ext == 'pdf') {
                        filecard += '<i class="fa fa-file-pdf-o"></i>';
                    } else {
                        filecard += '<i class="fa fa-file"></i>';

                    }
                    // '<img src="' + card.filepath + '/' + card.filename + '" class="img-fluid" alt="">'
                    filecard += ' </div>' +
                        '<div class="card-body">' +
                        ' <h6><a href="">' + card.filename + '</a></h6>' +
                        '<span>' + card.size + 'kb</span>' +
                        '</div>' +
                        '<div class="card-footer">' + card.creation_date + '</div>' +
                        ' </div>' +
                        '</div>';
                    $('#fileCardContainer').html(filecard);

                });

                $('#images_' + pid).replaceWith($('#images_' + pid).val('').clone(true));


            },
            error: function(a, b, c) {
                console.log(a);
                console.log(b);
                console.log(c);
            }
        });
    }

    function showfunction(event, pid, ptype) {

        console.log(ptype, 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh');
        $.ajax({
            url: '/projectfiles/fileData',
            method: 'post',
            dataType: 'json',
            data: {
                'pid': pid,
            },
            success: function(data) {
                renderprojectfiles(data, pid)


            },
            error: function(a, b, c) {
                console.log(a);
                console.log(b);
                console.log(c);

            }
        });

    }

    function deletefile(fid, pid) {
        console.log(fid, pid);

        $.ajax({
            url: '/projectfiles/deletefile',
            method: 'post',
            dataType: 'json',
            data: {
                'fid': fid,
                'pid': pid
            },
            success: function(data) {
                renderprojectfiles(data, pid);
            },
            error: function(a, b, c) {}
        });

    }

    $(document).ready(function() {
        $.ajax({
            url: '/projectfiles/showAllfiles',
            /*  method: 'post', */
            dataType: 'json',
            /*  data: {
                 'pid': pid,
             }, */
            success: function(data) {
                console.log(data, 'all data');
                $('#allprojects').trigger('click');
            },
            error: function(a, b, c) {}
        });
    });

    function showallprojects() {
        console.log('hello');

        $('.showsidebarprojects').show();
    }


    function projectsearchbox(total) {
        var input, filter, a, i, txtValue;
        console.log(total);

        input = document.getElementById("myInput");

        filter = input.value.toUpperCase();

        for (i = 0; i < total; i++) {
            //var myrow = document.getElementById('tablink_' + i);
            var mycard = document.getElementById('tablink_' + i);
            var txt = mycard.getElementsByTagName('a')[0].innerText

            if (txt) {

                if (txt.toUpperCase().includes(filter)) {
                    mycard.style.display = "";
                } else {
                    mycard.style.display = "none";
                }
            }
        }
    }
</script>
