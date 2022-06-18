<style>
    .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }

    .user-hamburger {
        cursor: pointer;
    }

</style>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" id="create-project-header" style="background: url(../../images/top-bar-background.png) no-repeat top left/100% 100%; color: white">
            <h4 align="left" class="modal-title" id="create-project-modalLabel"><?= __('Manage Users') ?></h4>
            <button onclick="modalProjectClose(); return false; " type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
            <div class="tab-content-wrapper" >
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" href="#utenti-mod" role="tab" data-toggle="tab" onClick="">Utenti</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#inviti-mod" role="tab" data-toggle="tab" onClick="getFriends()">Inviti</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" style="margin-top: 1em">
                    <div role="tabpanel" class="tab-pane fade show active" id="utenti-mod">
                        <div class="card">
                            <ul class="list-project ">
                            <?php foreach($project_members as $member) : ?>


                                <li class="list-project-item"><?= $member['u']['firstname'] . ' ' . $member['u']['lastname'] . ' - ' . $member['accessLevelName']?> <?php if($member['isBanned']): ?> <?= " --- " . __('User Banned') ?> <?php endif; ?>
                                    <!--<div class="dropdown">-->
                                        <a class="user-hamburger" id="ddmb" data-toggle="dropdown" style="float: right"><i class="fas fa-bars"></i></a>
                                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="ddmb">
                                            <a class="dropdown-item" href="/user/profile/<?= $member['u']['id'] ?>"><?= __('Show Profile') ?></a>
                                            <?php if ($member['accessLevel'] > 1) : ?>
                                                <?php if ($member['accessLevel'] > 2) : ?>
                                                <a class="dropdown-item" href="#" onclick="promoteOrDemoteUser(event, 0, '<?= $member['memberId']; ?>', '<?= $member['projectId']; ?>')"><?= __('Promote User') ?></a>
                                                <?php elseif ($member['accessLevel'] <=2) : ?>
                                                <a class="dropdown-item" href="#" onclick="promoteOrDemoteUser(event, 1, '<?= $member['memberId']; ?>', '<?= $member['projectId']; ?>')"><?= __('Demote User') ?></a>
                                                <?php endif; ?>
                                                <?php if (!$member['isBanned']) : ?>
                                                <a class="dropdown-item" href="#" onclick="banUser(event, 0, '<?= $member['memberId']; ?>', '<?= $member['projectId']; ?>')"><?= __('Ban User') ?></a>
                                                <?php else : ?>
                                                <a class="dropdown-item" href="#" onclick="banUser(event, 1, '<?= $member['memberId']; ?>', '<?= $member['projectId']; ?>')"><?= __('Unban User') ?></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    <!--</div>-->
                                </li>


                            <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="inviti-mod">

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


<script type="text/javascript">


function modalProjectClose(){
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
            'description':$('#description').val(),
            'project_type': visibility,
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

function promoteOrDemoteUser(e, promoteOrDemote, memberId, projectId) {

    //promoteOrDemote = 0       => promote
    //promoteOrDemote = 1       => demote

    e.preventDefault();

    $.ajax({
        url: '/project-member/promote-or-demote-user',
        method: 'POST',
        dataType: 'json',
        data: {
            'PoD': promoteOrDemote,
            'memberId': memberId,
            'projectId': projectId
            //'projectIMG': form_data
        },
        success: function(data) {
            if (data) {
                if (promoteOrDemote) {
                    alert("<?= __('User demoted successfully') ?>")
                } else {
                    alert("<?= __('User promoted successfully') ?>")
                }
            } else {
                alert("<?= __('Error') ?>")
            }

            modalProjectClose()
            modManageUsers(projectId)

        },
        error: function(a, b, c) {
            console.log(a)
            console.log(b)
            console.log(c)
        }

    })


}



function banUser(e, banOrUnban, memberId, projectId) {

    //banOrUnban = 0       => ban
    //banOrUnban = 1       => unban

    e.preventDefault();

    $.ajax({
        url: '/project-member/ban-or-unban-user',
        method: 'POST',
        dataType: 'json',
        data: {
            'BoU': banOrUnban,
            'memberId': memberId,
            'projectId': projectId
        },
        success: function(data) {
            if (data) {
                if (banOrUnban) {
                    alert("<?= __('User unbanned successfully') ?>")
                } else {
                    alert("<?= __('User banned successfully') ?>")
                }
            } else {
                alert("<?= __('Error') ?>")
            }

            modalProjectClose()
            modManageUsers(projectId)

        },
        error: function(a, b, c) {
            console.log(a)
            console.log(b)
            console.log(c)
        }

    })
}


function getFriends() {

    $.ajax({
        url: '/projectObject/get-friendship-for-invite',
        method: 'POST',
        dataType: 'json',
        data: {
            'projectId': <?= $projectId ?>,
        },
        success: function(data) {
            console.log(data)
            $('#inviti-mod').html("")
            html = ''


            if (data.length > 0) {
                html += '<div class="card">'
                html +=     '<ul class="list-project ">'
                for (i = 0; i < data.length; i++) {
                    html +=        '<li class="list-project-item">'
                    html +=         data[i][data[i]['notMe']]['firstname'] + " "
                    html +=         data[i][data[i]['notMe']]['lastname']
                    html +=         '<button class="btn btn-success" onclick="inviteUser(' + <?= $projectId ?> + ', ' + data[i][data[i]['notMe']]['id'] + ');" style="float: right; padding:0 0.75em 0 0.75em; font-size: 0.8em">Invita</button>'
                    html +=        '</li>'
                }

                html +=     '</ul>'
                html += '</div>'

            } else {
                html += '<p>Non ci sono utenti da invitare</p>'
            }

            $('#inviti-mod').html(html)

        },
        error: function(a, b, c) {
            console.log(a)
            console.log(b)
            console.log(c)
        }
    })
}

function inviteUser(projectId, userId) {

    $.ajax({
        url: '/project-member/invite_user',
        method: 'POST',
        dataType: 'json',
        data: {
            'projectId': projectId,
            'userId': userId
        },
        success: function(data) {
            console.log(data)

            if (data) {
                alert('Invito inviato con successo!')
                getFriends()
            } else {
                alert('Errore: prova a invitare di nuovo l\'utente')
            }

        },
        error: function(a, b, c) {
            console.log(a)
            console.log(b)
            console.log(c)
        }
    })

}





</script>
