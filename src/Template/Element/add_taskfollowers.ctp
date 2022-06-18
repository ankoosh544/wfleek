<div id="task_followers_<?= $projecttask->id ?>" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add followers to this task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group m-b-30">
                    <input placeholder="Search to add" class="form-control search-input" type="text">
                    <span class="input-group-append">
                        <button class="btn btn-primary">Search</button>
                    </span>
                </div>
                <?php
                $follwerIds = array();
                foreach ($projecttask->followers as $follower) {
                    array_push($follwerIds, $follower->user_id);
                }
                ?>

                <div>
                    <ul class="chat-user-list">
                        <?php foreach ($companymembers as $companymember) : ?>
                            <?php if (!empty($projecttask->followers)) : ?>
                                <?php if (in_array($companymember->user_id, $follwerIds)) : ?>
                                    <li class="media" id="unfollowers_<?= $companymember->user_id ?>">
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
                                                        <div class="user-name"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></div>
                                                        <span class="designation"><?= $companymember->designation->name ?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="form-group col" id="unfollowfunction_<?=$companymember->user_id?>">
                                            <a class="btn btn-primary" onclick="unfollowfunction(<?= $companymember->user->id ?>, <?= $projecttask->id ?>)">UnFollow</a>
                                        </div>
                                    </li>
                                <?php else : ?>
                                    <li class="media" id="followers_<?= $companymember->user_id ?>">
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
                                                        <span class="designation"><?= $companymember->designation->name ?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="form-group col">
                                            <a class="btn btn-primary danger" onclick="followfunction(<?= $companymember->user->id ?>, <?= $projecttask->id ?>)">Follow</a>
                                        </div>
                                    </li>
                                <?php endif; ?>

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
                                                    <span class="designation"><?= $companymember->designation->name ?></span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="form-group col">
                                        <a class="btn btn-primary" onclick="followfunction(<?= $companymember->user->id ?>, <?= $projecttask->id ?>)">Follow</a>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </ul>
                </div>
                <!--  <div class="submit-section">
                    <button class="btn btn-primary submit-btn" onclick="followersfunction(<?= $projecttask->id ?>)">Add to Follow</button>
                </div> -->

            </div>
        </div>
    </div>
</div>

<script>
    var newvalues;
    var followersArr;
    $(document).ready(function() {
        $.ajax({
            url: '/companies-user/docready/',
            dataType: 'json',
            success: function(data) {

                followersArr = Array(data.length).fill(0);
                $(".taskuser").on("select2:select", function(event) {

                    $(event.currentTarget).find("option:selected").each(function(i, selected) {
                        newvalues = 0;
                        newvalues = parseInt($(selected).val());
                        console.log(newvalues, 'values');
                        data.forEach((user, index) => {
                            if (newvalues === user.user_id) {
                                followersArr[index] = newvalues;
                            } else if (newvalues == 1) {
                                followersArr[index] = newvalues;
                            } else {
                                followersArr[index] = 0;

                            }
                        })
                    });
                });


            },
            error: function(e) {}
        });

    });

    function followersfunction(tid) {
        console.log(followersArr, 'follwers');
        console.log(tid);
        $.ajax({
            url: '/followers/addfollowers/',
            method: 'post',
            dataType: 'json',
            data: {
                'usersArr': usersArr,
                'tid': tid
            },
            success: function(data) {
                console.log(data);
                location.reload();
            },
            error: function(e) {}
        });
    }

    function followfunction(user_id, tid) {

        $.ajax({
            url: '/followers/addfollowers/',
            method: 'post',
            dataType: 'json',
            data: {
                'user_id': user_id,
                'tid': tid
            },
            success: function(data) {
                location.reload();

                $('#followers_' + user_id).empty();
                var str = "";
                data[0].forEach(function(companymember) {
                    data[1].followers.forEach(function(follower) {
                        if (companymember.user_id == follower.id)
                            str += '<li class="media">' +
                            '<div class=" col addedusers">' +
                            '<a href="#">' +
                            '<div class="media" style="width: 100%;">' +
                            '<span class="avatar">';
                        if (follower.user.profileFilename != null && follower.user.profileFilepath != null) {
                            str += '<img alt="" src="' + follower.user.profileFilepath + '/' + follower.user.profileFilename + '">';
                        } else {
                            str += '<img alt="" src="/assets/img/profiles/avatar-16.jpg">';
                        }

                        str += '</span>' +
                            '<div class="media-body media-middle text-nowrap">' +
                            '<div class="user-name">' +follower . user . firstname+' ' +follower . user . lastname +'</div>' +
                            ' <span class="designation">'+ companymember . designtion . name +'</span>+'+
                        '</div>' +
                        '</div>' +
                        '</a>' +
                        '</div>' +
                        '<div class="form-group col">' +
                        '<a class="btn btn-primary" onclick="unfollowfunction(' + follower.user.id + ',' + data.id + ')">Follow</a>' +
                            '</div>' +
                            '</li>';
                    });
                });

               // $('#followers_' + user_id).html(str);


            },
            error: function(e) {}
        });
    }

    function unfollowfunction(user_id, tid) {
        $.ajax({
            url: '/followers/deletefollowers/',
            method: 'post',
            dataType: 'json',
            data: {
                'user_id': user_id,
                'tid': tid
            },
            success: function(data) {
                location.reload();
               $('#unfollowfunction_'+user_id).empty();
               var str ="";
               str +='<a class="btn btn-primary" onclick="unfollowfunction(<?= $companymember->user->id ?>, <?= $projecttask->id ?>)">Follow</a>';

            },
            error: function(e) {}
        });

    }
</script>
