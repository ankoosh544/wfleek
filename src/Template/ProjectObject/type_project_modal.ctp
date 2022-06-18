<style>
    .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }
</style>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" id="create-project-header" style="background: url(../../images/top-bar-background.png) no-repeat top left/100% 100%; color: white">
            <h4 align="left" class="modal-title" id="create-project-modalLabel"><?= __('Create Project') ?></h4>
            <button onclick="modalProjectClose(); return false; " type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
            <form method="post" action="/projectObject/add-project" id="add" enctype="multipart/form-data">



                <div class="dropdown form-project">


                    <label for="name"><?= __('Please Select the Type of Project') ?></label>

                    <select id="myDropDown">
                        <option value='' disabled selected>Commessa</option>
                        <option value='4353'>Ricerca Accadenica</option>
                        <option value='3333'>Raccocta Dondi</option>
                        <option value='66666'>Venture Capital</option>
                    </select>

                    <div class="text-center" style="margin-top: 150px;">
                        <button class="btn btn-secondary margin-t-1" onclick="modalProjectClose(); return false; "><?= __('Annulla') ?></button>
                        <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('Select') ?></button>
                    </div>
                </div>





                <!--- <label for="name"><?= __('Project name') ?></label>
                <input name="name" id="name" type="text" class="form-control btn-mod-input" placeholder="<?= __('Your project\'s name...') ?>" required/>
                <div class="form-project">
                    <label for="description"><?= __('Description') ?></label>
                    <textarea name="description" id="description" type="text" class="form-control btn-mod-input height10" placeholder="<?= __('Describe your project...') ?>" required></textarea>
                </div>
                <div class="form-project">
                    <label for="visibilityDiv"><h4><?= __('Project type') ?></h4></label>
                    <div id="visibilityDiv">
                        <input type="radio" name="visibility" id="visibility" value="P" checked required><?= __('Public') ?>
                        <input type="radio" name="visibility" id="visibility" value="V"><?= __('Private') ?>
                        <input type="radio" name="visibility" id="visibility" value="S"><?= __('Secret') ?>
                    </div>
                    <label for="priceDiv">
                        <h4>Prezzo</h4>
                        <input name="price" id="price" type="text" class="form-control btn-mod-input" placeholder="<?= __('The price...') ?>" required/>
                    </label>
                </div>
                <div class="form-project">
                    <label for="allowedDiv"><h4><?= __('Permissions') ?></h4></label>
                    <div id="allowedDiv" style="text-align: center;">
                        <div id="membership_request_div" style="display:inline-block; float:left">
                            <label style="display:block" for="membership_request_span"><?= __('Membership requests are allowed') ?></label>
                            <span class="switch" id="membership_request_span" style="float:left">
                                <label for="membership_request"><?= __('Yes') ?></label>
                                <input type="checkbox" class="switch" id="membership_request" name="membership_request" checked="">
                                <label for="membership_request"><?= __('No') ?></label>
                            </span>
                        </div>
                        <div id="ban_div" style="display:inline-block; float:center">
                            <label style="display:block" for="ban_span"><?= __('Ban is allowed') ?></label>
                            <span class="switch" id="ban_span">
                                <label for="ban"><?= __('Yes') ?></label>
                                <input type="checkbox" class="switch" id="ban" name="ban" checked="">
                                <label for="ban"><?= __('No') ?></label>
                            </span>
                        </div>
                        <div id="invitation_div" style="display:inline-block; float:right">
                            <label style="display:block" for="invitation_span"><?= __('Invitations are allowed') ?></label>
                            <span class="switch" id="invitation_span" style="float:right">
                                <label for="invitation"><?= __('Yes') ?></label>
                                <input type="checkbox" class="switch" id="invitation" name="invitation" checked="">
                                <label for="invitation"><?= __('No') ?></label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-project">
                    <label for="father_projects_div"><h4><?= __('Progetto Padre') ?></h4></label>
                    <div id="father_projects_div">
                        <!--<div class="form-control">

                            <div style="display: block">
                                <select style="margin-bottom: 1em" class="form-control" id="father_id" name="father_id">
                                    <option selected value="0"><?= __('Choose a father project.') ?></option>
                                    <?php foreach ($projects_owned_by_user as $owned) : ?>
                                    <option value="<?= $owned['id'] ?>"><?= $owned['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                    </div>
                </div>
                <div class="form-project">
                    <label for="projectIMG"><?= __('Project Image') ?></label>
                    <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="projectIMG" name="projectIMG" type="file" onchange="validateFileSize(); return false;"/>
                    <p><small id="errorFileSize" style="color: rgba(255,0,0,1);"></small></p>
                    <div class='label label-info' id="upload-file-info"></div>
                    <!--<h6 style="margin-top: 1em;">Il file deve essere in formato JPG o JPEG, con estensione massima 2MB.</h6>
                </div>
                <div class="text-center">
                    <button class="btn btn-secondary margin-t-1" onclick="modalProjectClose(); return false; "><?= __('Annulla') ?></button>
                    <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('Create project') ?></button>
                </div>--->
            </form>
        </div>
    </div>
</div>




<script type="text/javascript">
    //console.log(<?= $projects_owned_by_user ?> + "ciao")

    function modalProjectClose() {
        $('#create-project-modal').modal('hide');

    }



    function createProject() {

        visibility = "";
        if (document.getElementById('visibilityP').checked) {
            visibility = $('#visibilityP').val();
        } else if (document.getElementById('visibilityV').checked) {
            visibility = $('#visibilityV').val();
        } else if (document.getElementById('visibilityS').checked) {
            visibility = $('#visibilityS').val();
        }

        var form_data = new FormData($('#add'))
        console.log(form_data)

        $.ajax({
            url: '/projectObject/add-project',
            method: 'POST',
            dataType: 'json',
            data: {
                'name': $('#name').val(),
                'description': $('#description').val(),
                'project_type': visibility,
                'price': $('#price').val(),
                'fatherId': $('#father_id').val(),
                'membership': !document.getElementById('membership_request').checked,
                'ban': !document.getElementById('ban').checked,
                'invitation': !document.getElementById('invitation').checked,
                //'projectIMG': form_data
            },
            success: function(data) {
                //window.location.href = "/projectObject"
                console.log(data)

            },
            error: function(a, b, c) {
                console.log(a)
                console.log(b)
                console.log(c)
            }

        })

    }



    function validateFileSize() {
        $('#errorFileSize').text("");
        var fileTag = document.getElementById('projectIMG');
        for (var i = 0; i < fileTag.files.length; i++) {
            if (fileTag.files[i].size > 1048576) {
                $('#projectIMG').val('');
                $('#errorFileSize').text("<?= __('Image size is too big') ?>");
            }
        }

    }
</script>



<script>
    $(document).ready(function() {
        $('#myDropDown').change(function() {
            //Selected value
            var inputValue = $(this).val();
            // alert("value in js "+inputValue);

            //Ajax for calling php function
            $.post('submit.php', {
                dropdownValue: inputValue
            }, function(data) {
                //alert('ajax completed. Response:  '+data);
                //do after submission operation in DOM
            });
        });
    });
</script>
