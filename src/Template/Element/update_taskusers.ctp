<div id="update_taskusers_<?= $projecttask->id ?>" class="modal custom-modal fade" draggable="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign/UnAssign User to this task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group m-b-30">
                    <input placeholder="Search to add" id="myInput" onkeyup="myjava(<?= count($companymembers) ?>)" class="form-control search-input" type="text">
                </div>
                <div>
                    <ul class="chat-user-list">
                        <?php foreach ($companymembers as $companymember) : ?>
                            <?php if (!empty($projecttask->taskusers)) : ?>
                                <?php foreach ($projecttask->taskusers as $index => $taskuser) : ?>
                                    <?php if ($taskuser->assignee_id == $companymember->user_id) : ?>
                                        <li id="mycard_<?= $index ?>" class="media">
                                            <div class="col addedusers">
                                                <a href="#">
                                                    <div class="media" style="width: 100%;">
                                                        <span class="avatar">
                                                            <?php if ($companymember->user->profileFilename != null && $companymember->user->profileFilepath != null) : ?>
                                                                <img alt="" src="<?= $companymember->user->profileFilepath ?>/<?= $companymember->user->profileFilename ?>">
                                                            <?php else : ?>
                                                                <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                            <?php endif; ?>
                                                        </span>
                                                        <div class="media-body media-middle text-nowrap">
                                                            <div class="user-name" id="myrow_<?= $index ?>" >
                                                                <a href=""><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></a>
                                                            </div>
                                                            <span class="designation"><?=$companymember->designation->name?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col form-group form-focus select-focus">
                                                <select class="select floating taskuser" name="status">
                                                    <option selected value="<?= $companymember->user_id ?>">Assigned</option>
                                                    <option value="A_<?= $companymember->user_id ?>">Un Assigned</option>
                                                </select>
                                            </div>
                                        </li>
                                        <?php break; ?>
                                    <?php else : ?>
                                        <li class="media">
                                            <div class=" col addedusers">
                                                <a href="#">
                                                    <div class="media" style="width: 100%;">
                                                        <span class="avatar">
                                                            <?php if ($companymember->user->profileFilename != null && $companymember->user->profileFilepath != null) : ?>
                                                                <img alt="" src="<?= $companymember->user->profileFilepath ?>/<?= $companymember->user->profileFilename ?>">
                                                            <?php else : ?>
                                                                <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                            <?php endif; ?>
                                                        </span>
                                                        <div class="media-body media-middle text-nowrap">
                                                            <div class="user-name"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></div>
                                                            <span class="designation"><?=$companymember->designation->name?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="form-group form-focus select-focus col">
                                                <select class="select floating taskuser" name="status">
                                                    <option value="<?= $companymember->user_id ?>">Assigned</option>
                                                    <option selected value="A_<?= $companymember->user_id ?>">Un Assigned</option>
                                                </select>
                                            </div>
                                        </li>
                                        <?php break; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <li class="media">
                                    <div class=" col addedusers">
                                        <a href="#">
                                            <div class="media" style="width: 100%;">
                                                <span class="avatar">
                                                    <?php if ($companymember->user->profileFilename != null && $companymember->user->profileFilepath != null) : ?>
                                                        <img alt="" src="<?= $companymember->user->profileFilepath ?>/<?= $companymember->user->profileFilename ?>">
                                                    <?php else : ?>
                                                        <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                    <?php endif; ?>
                                                </span>
                                                <div class="media-body media-middle text-nowrap">
                                                    <div class="user-name"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></div>
                                                        <span class="designation"><?=$companymember->designation->name?></span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="form-group form-focus select-focus col">
                                        <select class="select floating taskuser" name="status">
                                            <option value="<?= $companymember->user_id ?>">Assigned</option>
                                            <option selected value="A_<?= $companymember->user_id ?>">Un Assigned</option>
                                        </select>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="submit-section">
                    <a class="btn btn-primary submit-btn" onclick="select2function(<?= $projecttask->id ?>)">Update</a>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    var values;
    var usersArr;
    $(document).ready(function() {
        $.ajax({
            url: '/companies-user/docready/',
            dataType: 'json',
            success: function(data) {

                usersArr = Array(data.length).fill(0);
                $(".taskuser").on("select2:select", function(event) {

                    $(event.currentTarget).find("option:selected").each(function(i, selected) {
                        values = parseInt($(selected).val());
                        data.forEach((user, index) => {
                            if (values === user.user_id) {
                                usersArr[index] = values;
                            }
                        })
                    });
                });


            },
            error: function(e) {}
        });

    });


    function select2function(tid) {
        $.ajax({
            url: '/projecttasks/updatetaskusers/',
            method: 'post',
            dataType: 'json',
            data: {
                'usersArr': usersArr,
                'tid': tid
            },
            success: function(data) {

                location.reload();
            },
            error: function(e) {}
        });
    }

    function myjava(total) {
        var input, filter, a, i, txtValue;
        input = $("#myInput").val();
        filter = input.toUpperCase();
        console.log(filter);

        for (i = 0; i < total; i++) {
            var mycard = document.getElementById('mycard_' + i);
            var myrow = document.getElementById('myrow_' + i);

            console.log(myrow);
            var txt = myrow.getElementsByTagName('a')[0].innerText
            console.log(txt);

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
