
<?= $this->element('projectemail_sidebar') ?>
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div>


            </div>
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">View Message</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">View Message</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="/projectemail/composeEmail" class="btn add-btn"><i class="fa fa-plus"></i> Compose</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="mailview-content">
                            <?php $loadmore = null; ?>

                            <div>
                                <?php if ($projectemail->parentemail_id != null || $projectemail->forwarded_id != null) : ?>

                                    <?php if ($projectemail->parentemail_id != null) : ?>
                                        <a class="btn btn-info" onclick="showparentmaildata(<?= $projectemail->parentemail_id ?>, <?= $user_id ?>);" id="showMore">Load More...</a>
                                    <?php endif; ?>
                                    <?php if ($projectemail->forwarded_id != null) : ?>
                                        <a class="btn btn-info" onclick="showforwardedmails(<?= $projectemail->forwarded_id ?>, <?= $user_id ?>);" id="showMoreForwards"> ....</a>
                                    <?php endif; ?>

                                    </br>
                                    <div id="ajax_parentmails">
                                    </div>
                                    </br>
                                    <div id="ajax_forwardedmails">
                                    </div>

                                    </br>
                                    <div>
                                        <div class="mailview-header">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="text-ellipsis m-b-10">
                                                        <span class="mail-view-title">
                                                            <?php if ($projectemail->replies) : ?>
                                                                Re:<?= $projectemail->subject ?>
                                                            <?php elseif ($projectemail->forwardemails) : ?>
                                                                Fwd: <?= $projectemail->subject ?>
                                                            <?php else : ?>
                                                                <?= $projectemail->subject ?>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4" style="display:flex;justify-content:space-between;">
                                                    <div class="mail-view-action">
                                                        <div class="btn-group">
                                                            <form action="/projectemail/deleteEmail" method="post">
                                                                <button type="submit" class="btn btn-white btn-sm" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash-o"></i></button>
                                                                <input type="hidden" name="mid" value="<?= $projectemail->id ?>">
                                                            </form>
                                                            <button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Reply" onclick="showreplyDiv(<?= $projectemail->id ?>)"> <i class="fa fa-reply"></i></button>
                                                            <button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Forward" onclick="showforwardDiv(<?= $projectemail->id ?>);"> <i class="fa fa-share"></i></button>
                                                            <button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Print"> <i class="fa fa-print"></i></button>
                                                        </div>

                                                    </div>
                                                    <div class="form-group form-focus">

                                                        <select class="select2-icon floating" id="worklabel" name="worklabel" onchange="updateworklable(<?= $projectemail->id ?>)">
                                                            <option selected>Select Worklabel Type</option>
                                                            <option value="W" data-icon="fa fa-circle text-success mail-label">Work</option>
                                                            <option value="P" data-icon="fa fa-circle text-warning mail-label">Personal</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sender-info">
                                                <div class="sender-img">
                                                    <img width="40" alt="" src="<?= $projectemail->from_user->profileFilepath ?>/<?= $projectemail->from_user->profileFilename ?>" class="rounded-circle">
                                                </div>
                                                <div class="receiver-details float-left">
                                                    <span class="sender-name"><?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?> (<?= $projectemail->from_user->email ?>)</span>
                                                    <span class="receiver-name">
                                                        to:
                                                        <?php if ($projectemail->tousers) : ?>

                                                            <?php foreach ($projectemail->tousers as $touser) : ?>
                                                                <?php if ($touser->user->id == $user_id) : ?>
                                                                    me <a onclick="showtouserme(<?= $touser->user->id ?>, <?= $projectemail->id ?>)"> <img src="/assets/img/down.png" style="width: 20px;"></a> </br>
                                                                    <div id="showtouserme_<?= $touser->user->id ?>_<?= $projectemail->id ?>" style="display: none;border:solid;">
                                                                        <span>
                                                                            <p>
                                                                                From:<?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?> (<?= $projectemail->from_user->email ?>)</br>
                                                                                To :<?= $touser->user->firstname ?><?= $touser->user->lastname ?>(<?= $touser->user->email ?>)</br>
                                                                                Subject : <?= $projectemail->subject ?></br>
                                                                                Date: <?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></br>
                                                                            </p>
                                                                        </span>
                                                                    </div>
                                                                <?php else : ?>
                                                                    <span><a onclick="showtouserothers(<?= $touser->user->id ?>, <?= $projectemail->id ?>)"> <img src="/assets/img/down.png" style="width: 20px;"></a><?= $touser->user->firstname ?> </span><span><?= $touser->user->lastname ?></span>
                                                                    <div id="showtouserothers_<?= $touser->user->id ?>_<?= $projectemail->id ?>" style="display: none; border:solid;">
                                                                        <span>
                                                                            <p>
                                                                                From:<?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?> (<?= $projectemail->from_user->email ?>)</br>
                                                                                To :<?= $touser->user->firstname ?><?= $touser->user->lastname ?>(<?= $touser->user->email ?>)</br>
                                                                                Subject : <?= $projectemail->subject ?></br>
                                                                                Date: <?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></br>
                                                                            </p>
                                                                        </span>

                                                                    </div>

                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                        <?php if ($projectemail->ccusers) : ?>
                                                            cc:
                                                            <?php foreach ($projectemail->ccusers as $ccuser) : ?>
                                                                <?php if ($ccuser->user->id == $user_id) : ?>
                                                                    me<a onclick="showccuserme(<?= $touser->user->id ?>)"> <img src="/assets/img/down.png" style="width: 20px;"></a></br>
                                                                    <div id="showccuserme_<?= $touser->user->id ?>" style="display: none;border:solid;">
                                                                        <span>
                                                                            <p>
                                                                                From:<?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?> (<?= $projectemail->from_user->email ?>)</br>
                                                                                To :<?= $ccuser->user->firstname ?><?= $ccuser->user->lastname ?>(<?= $ccuser->user->email ?>)</br>
                                                                                Subject : <?= $projectemail->subject ?></br>
                                                                                Date: <?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></br>
                                                                            </p>
                                                                        </span>

                                                                    </div>
                                                                <?php else : ?>

                                                                    <span><?= $ccuser->user->firstname ?> </span><span><?= $ccuser->user->lastname ?>
                                                                        <!-- <a> <img src="/assets/img/down.png" style="width: 20px;"></a> --> </br>
                                                                    </span><a>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>

                                                            <?php if ($projectemail->bccusers) : ?>
                                                                Bcc:
                                                                <?php foreach ($projectemail->bccusers as $bccuser) : ?>
                                                                    <?php if ($bccuser->user->id == $user_id) : ?>
                                                                        me <a onclick="showbccuserme"> <img src="/assets/img/down.png" style="width: 20px;"></a></br>
                                                                        <div id="showbccuserme_<?= $touser->user->id ?>" style="display: none;">
                                                                            <span>
                                                                                <p>
                                                                                    From:<?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?> (<?= $projectemail->from_user->email ?>)</br>
                                                                                    To :<?= $ccuser->user->firstname ?><?= $ccuser->user->lastname ?>(<?= $ccuser->user->email ?>)</br>
                                                                                    Subject : <?= $projectemail->subject ?></br>
                                                                                    Date: <?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></br>
                                                                                </p>
                                                                            </span>

                                                                        </div>
                                                                    <?php else : ?>

                                                                        <span><?= $bccuser->user->firstname ?> </span><span><?= $bccuser->user->lastname ?>
                                                                            <!-- <a> <img src="/assets/img/down.png" style="width: 20px;"></a> --></br></br>
                                                                        </span>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                    </span>

                                                </div>
                                                <div class="mail-sent-time">
                                                    <span class="mail-time"><?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></span>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="mailview-inner">
                                            <p><?= nl2br($projectemail->body) ?></p>
                                        </div>
                                        <?php if ($projectemail->emailfiles) : ?>
                                            <div class="mail-attachments">
                                                <?php $total = count($emailfiles) ?>
                                                <p><i class="fa fa-paperclip"></i> <?= $total ?> Attachments -
                                                    <!-- <a href="/projectemail/downloadall?mid=<?= $projectemail->id ?>&fid=<?= $emailfiles ?>">Download all</a>-->
                                                </p>

                                                <div class="row">
                                                    <?php foreach ($projectemail->emailfiles as $emailfile) : ?>
                                                        <?php
                                                        $path = WWW_ROOT . str_replace('/', '\\', $emailfile->filepath . DS . $emailfile->filename);
                                                        $ext  = (new SplFileInfo($path))->getExtension();
                                                        ?>
                                                        <ul class="attachments clearfix">
                                                            <li>
                                                                <?php if ($ext == "word") : ?>
                                                                    <div class="attach-file"><i class="fa fa-file-word-o"></i></div>
                                                                <?php elseif ($ext == "pdf") : ?>
                                                                    <div class="attach-file"><i class="fa fa-file-pdf-o"></i></div>
                                                                <?php else : ?>
                                                                    <div class="attach-file"><i class="fa fa-image"></i></div>
                                                                <?php endif; ?>
                                                                <div class="attach-info"> <a href="#" class="attach-filename"><?= $emailfile->filename ?></a>
                                                                    <div class="attach-fileize"> <?= $emailfile->size ?></div>
                                                                    <a href="/projectemail/downloadall?mid=<?= $projectemail->id ?>&fid=<?= $emailfile->id ?>"> <i class="fa fa-download" aria-hidden="true"></i></a>
                                                                </div>
                                                            </li>
                                                        </ul>

                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php else : ?>
                                    <div>
                                        <div class="mailview-header">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="text-ellipsis m-b-10">
                                                        <span class="mail-view-title">
                                                            <?php if ($projectemail->replies) : ?>
                                                                Re:<?= $projectemail->subject ?>
                                                            <?php elseif ($projectemail->forwardemails) : ?>
                                                                Fwd: <?= $projectemail->subject ?>
                                                            <?php else : ?>
                                                                <?= $projectemail->subject ?>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4" style="display:flex;justify-content:space-between;">
                                                    <div class="mail-view-action">
                                                        <div class="btn-group">
                                                            <form action="/projectemail/deleteEmail" method="post">
                                                                <button type="submit" class="btn btn-white btn-sm" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash-o"></i></button>
                                                                <input type="hidden" name="mid" value="<?= $projectemail->id ?>">
                                                            </form>
                                                            <button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Reply" onclick="showreplyDiv(<?= $projectemail->id ?>)"> <i class="fa fa-reply"></i></button>
                                                            <button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Forward"> <i class="fa fa-share"></i></button>
                                                            <button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Print"> <i class="fa fa-print"></i></button>
                                                        </div>

                                                    </div>
                                                    <div class="form-group form-focus">

                                                        <select class="select2-icon floating" id="worklabel" name="worklabel" onchange="updateworklable(<?= $projectemail->id ?>)">
                                                            <option selected>Select Worklabel Type</option>
                                                            <option value="W" data-icon="fa fa-circle text-success mail-label">Work</option>
                                                            <option value="P" data-icon="fa fa-circle text-warning mail-label">Personal</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sender-info">
                                                <div class="sender-img">
                                                    <img width="40" alt="" src="<?= $projectemail->from_user->profileFilepath ?>/<?= $projectemail->from_user->profileFilename ?>" class="rounded-circle">
                                                </div>
                                                <div class="receiver-details float-left">
                                                    <span class="sender-name"><?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?> (<?= $projectemail->from_user->email ?>)</span>
                                                    <span class="receiver-name">
                                                        to:
                                                        <?php if ($projectemail->tousers) : ?>

                                                            <?php foreach ($projectemail->tousers as $touser) : ?>
                                                                <?php if ($touser->user->id == $user_id) : ?>
                                                                    me <a onclick="showtouserme(<?= $touser->user->id ?>, <?= $projectemail->id ?>)"> <img src="/assets/img/down.png" style="width: 20px;"></a> </br>
                                                                    <div id="showtouserme_<?= $touser->user->id ?>_<?= $projectemail->id ?>" style="display: none;border:solid;">
                                                                        <span>
                                                                            <p>
                                                                                From:<?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?> (<?= $projectemail->from_user->email ?>)</br>
                                                                                To :<?= $touser->user->firstname ?><?= $touser->user->lastname ?>(<?= $touser->user->email ?>)</br>
                                                                                Subject : <?= $projectemail->subject ?></br>
                                                                                Date: <?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></br>
                                                                            </p>
                                                                        </span>
                                                                    </div>

                                                                <?php else : ?>
                                                                    <span><a onclick="showtouserothers(<?= $touser->user->id ?>, <?= $projectemail->id ?>)"> <img src="/assets/img/down.png" style="width: 20px;"></a><?= $touser->user->firstname ?> </span><span><?= $touser->user->lastname ?></span>
                                                                    <div id="showtouserothers_<?= $touser->user->id ?>_<?= $projectemail->id ?>" style="display: none; border:solid;">
                                                                        <span>
                                                                            <p>
                                                                                From:<?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?> (<?= $projectemail->from_user->email ?>)</br>
                                                                                To :<?= $touser->user->firstname ?><?= $touser->user->lastname ?>(<?= $touser->user->email ?>)</br>
                                                                                Subject : <?= $projectemail->subject ?></br>
                                                                                Date: <?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></br>
                                                                            </p>
                                                                        </span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>


                                                        <?php if ($projectemail->ccusers) : ?>
                                                            cc:
                                                            <?php foreach ($projectemail->ccusers as $ccuser) : ?>
                                                                <?php if ($ccuser->user->id == $user_id) : ?>
                                                                    me<a onclick="showccuserme(<?= $touser->user->id ?>)"> <img src="/assets/img/down.png" style="width: 20px;"></a></br>
                                                                    <div id="showccuserme_<?= $touser->user->id ?>" style="display: none;border:solid;">
                                                                        <span>
                                                                            <p>
                                                                                From:<?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?> (<?= $projectemail->from_user->email ?>)</br>
                                                                                To :<?= $ccuser->user->firstname ?><?= $ccuser->user->lastname ?>(<?= $ccuser->user->email ?>)</br>
                                                                                Subject : <?= $projectemail->subject ?></br>
                                                                                Date: <?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></br>
                                                                            </p>
                                                                        </span>

                                                                    </div>
                                                                <?php else : ?>

                                                                    <span><?= $ccuser->user->firstname ?> </span><span><?= $ccuser->user->lastname ?>
                                                                        <!-- <a> <img src="/assets/img/down.png" style="width: 20px;"></a>  --></br>
                                                                    </span><a>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>

                                                            <?php if ($projectemail->bccusers) : ?>
                                                                Bcc:
                                                                <?php foreach ($projectemail->bccusers as $bccuser) : ?>
                                                                    <?php if ($bccuser->user->id == $user_id) : ?>
                                                                        me <a onclick="showbccuserme"> <img src="/assets/img/down.png" style="width: 20px;"></a></br>
                                                                        <div id="showbccuserme_<?= $touser->user->id ?>" style="display: none;">
                                                                            <span>
                                                                                <p>
                                                                                    From:<?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?> (<?= $projectemail->from_user->email ?>)</br>
                                                                                    To :<?= $ccuser->user->firstname ?><?= $ccuser->user->lastname ?>(<?= $ccuser->user->email ?>)</br>
                                                                                    Subject : <?= $projectemail->subject ?></br>
                                                                                    Date: <?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></br>
                                                                                </p>
                                                                            </span>

                                                                        </div>
                                                                    <?php else : ?>

                                                                        <span><?= $bccuser->user->firstname ?> </span><span><?= $bccuser->user->lastname ?>
                                                                            <!-- <a> <img src="/assets/img/down.png" style="width: 20px;"></a> --></br></br>
                                                                        </span>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                    </span>

                                                </div>
                                                <div class="mail-sent-time">
                                                    <span class="mail-time"><?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></span>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="mailview-inner">
                                            <p><?= nl2br($projectemail->body) ?></p>
                                        </div>
                                        <?php if ($projectemail->emailfiles) : ?>
                                            <div class="mail-attachments">
                                                <?php $total = count($emailfiles) ?>
                                                <p><i class="fa fa-paperclip"></i> <?= $total ?> Attachments -
                                                    <!-- <a href="/projectemail/downloadall?mid=<?= $projectemail->id ?>&fid=<?= $emailfiles ?>">Download all</a>-->
                                                </p>

                                                <div class="row">
                                                    <?php foreach ($projectemail->emailfiles as $emailfile) : ?>
                                                        <?php
                                                        $path = WWW_ROOT . str_replace('/', '\\', $emailfile->filepath . DS . $emailfile->filename);
                                                        $ext  = (new SplFileInfo($path))->getExtension();
                                                        ?>
                                                        <ul class="attachments clearfix">
                                                            <li>
                                                                <?php if ($ext == "word") : ?>
                                                                    <div class="attach-file"><i class="fa fa-file-word-o"></i></div>
                                                                <?php elseif ($ext == "pdf") : ?>
                                                                    <div class="attach-file"><i class="fa fa-file-pdf-o"></i></div>
                                                                <?php else : ?>
                                                                    <div class="attach-file"><i class="fa fa-image"></i></div>
                                                                <?php endif; ?>
                                                                <div class="attach-info"> <a href="#" class="attach-filename"><?= $emailfile->filename ?></a>
                                                                    <div class="attach-fileize"> <?= $emailfile->size ?></div>
                                                                    <a href="/projectemail/downloadall?mid=<?= $projectemail->id ?>&fid=<?= $emailfile->id ?>"> <i class="fa fa-download" aria-hidden="true"></i></a>
                                                                </div>
                                                            </li>
                                                        </ul>

                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="mailview-footer">
                                    <div class="row">
                                        <div class="col-sm-6 left-action">
                                            <button type="button" class="btn btn-white" onclick="showreplyDiv(<?= $projectemail->id ?>);"><i class="fa fa-reply"></i> Reply</button>
                                            <button type="button" class="btn btn-white" onclick="showforwardDiv(<?= $projectemail->id ?>);"><i class="fa fa-share"></i> Forward</button>
                                        </div>
                                        <div class="col-sm-6 right-action">
                                            <button type="button" class="btn btn-white"><i class="fa fa-print"></i> Print</button>
                                            <form action="/projectemail/deleteEmail/<?= $projectemail->id ?>" method="post">
                                                <button type="submit" class="btn btn-white" onclick="deleteComposemailDiv(<?= $projectemail->id ?>)"><i class="fa fa-trash-o"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!---Reply Div----->
                                <div class="row" id="replay_<?= $projectemail->id ?>" style="display: none;">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div>
                                                    <div class="form-group form-focus select-focus m-b-30">
                                                        <select id="reply_tousers" placeholder="To" class="select2-icon floating" name="toemail" multiple>
                                                            <?php foreach ($allusers as $singleuser) : ?>
                                                                <?php if ($singleuser->id == $projectemail->from_user->id) : ?>
                                                                    <option selected value="<?= $projectemail->from_user->id ?>"><?= $projectemail->from_user->email ?></option>
                                                                <?php else : ?>
                                                                    <option value="<?= $singleuser->id ?>"><?= $singleuser->email ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <label class="focus-label">To</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus select-focus">
                                                            <select id="reply_ccusers" class="select2-icon floating" name="cc" multiple>

                                                                <?php if ($projectemail->ccusers) : ?>
                                                                    <?php foreach ($projectemail->ccusers as $ccuser) : ?>
                                                                        <?php foreach ($allusers as $singleuser) : ?>
                                                                            <?php if ($singleuser->id == $ccuser->user->id) : ?>
                                                                                <option selected value="<?= $ccuser->user->id ?>"><?= $ccuser->user->email ?> </option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $singleuser->id ?>"><?= $singleuser->email ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endforeach; ?>
                                                                <?php else :  ?>
                                                                    <?php foreach ($allusers as $singleuser) : ?>
                                                                        <option value="<?= $singleuser->id ?>"><?= $singleuser->email ?></option>

                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                            <label class="focus-label">cc</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus select-focus">
                                                            <select id="reply_bccusers" class="select2-icon floating" name="bcc" multiple>
                                                                <?php if ($projectemail->bccusers) : ?>
                                                                    <?php foreach ($projectemail->bccusers as $bccuser) : ?>
                                                                        <?php foreach ($allusers as $singleuser) : ?>
                                                                            <?php if ($singleuser->id == $bccuser->user->id) : ?>
                                                                                <option selected value="<?= $bccuser->user->id ?>"><?= $bccuser->user->email ?> </option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $singleuser->id ?>"><?= $singleuser->email ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endforeach; ?>
                                                                <?php else :  ?>
                                                                    <?php foreach ($allusers as $singleuser) : ?>
                                                                        <option value="<?= $singleuser->id ?>"><?= $singleuser->email ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>

                                                            </select>
                                                            <label class="focus-label">Bcc</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input name="subject" type="text" id="replysubject_<?= $projectemail->id ?>" placeholder="Subject" value="Re:<?= $projectemail->subject ?>" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <textarea name="body" id="replybody_<?= $projectemail->id ?>" rows="4" class="form-control"></textarea>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <div class="form-group">

                                                        <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="images_<?= $projectemail->id ?>" name="attachment" type="file" multiple />

                                                    </div>

                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary" onclick="replyfunction(<?= $projectemail->id ?>)"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>

                                                        <button class="btn btn-success m-l-5" type="submit" onclick="senddraftfunction(<?= $projectemail->id ?>)"><span>Draft</span> <i class="fa fa-floppy-o m-l-5"></i></button>
                                                        <button class="btn btn-success m-l-5" type="button" onclick="deleteComposemailDiv(<?= $projectemail->id ?>)"><span>Delete</span> <i class="fa fa-trash-o m-l-5"></i></button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-----/Reply Div--------->

                                <!------Forward Div-------------------->
                                <div class="row" id="forward_<?= $projectemail->id ?>" style="display: none;">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="">

                                                    <div class="form-group form-focus select-focus m-b-30">
                                                        <select id="forward_tousers" placeholder="To" class="select2-icon floating" name="toemail" multiple>
                                                            <?php foreach ($allusers as $singleuser) : ?>
                                                                <option value="<?= $singleuser->id ?>"><?= $singleuser->email ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <label class="focus-label">To</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus select-focus">
                                                            <select id="forward_ccusers" class="select2-icon floating" name="cc" multiple>

                                                                <?php if ($projectemail->ccusers) : ?>
                                                                    <?php foreach ($projectemail->ccusers as $ccuser) : ?>
                                                                        <?php foreach ($allusers as $singleuser) : ?>
                                                                            <?php if ($singleuser->id == $ccuser->user->id) : ?>
                                                                                <option selected value="<?= $ccuser->user->id ?>"><?= $ccuser->user->email ?> </option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $singleuser->id ?>"><?= $singleuser->email ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endforeach; ?>

                                                                <?php else : ?>
                                                                    <?php foreach ($allusers as $singleuser) : ?>
                                                                        <option value="<?= $singleuser->id ?>"><?= $singleuser->email ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                            <label class="focus-label">cc</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus select-focus">
                                                            <select id="forward_bccusers" class="select2-icon floating" name="bcc" multiple>
                                                                <?php if ($projectemail->bccusers) : ?>
                                                                    <?php foreach ($projectemail->bccusers as $bccuser) : ?>
                                                                        <?php foreach ($allusers as $singleuser) : ?>
                                                                            <?php if ($singleuser->id == $bccuser->user->id) : ?>
                                                                                <option selected value="<?= $bccuser->user->id ?>"><?= $bccuser->user->email ?> </option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $singleuser->id ?>"><?= $singleuser->email ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endforeach; ?>
                                                                <?php else : ?>
                                                                    <?php foreach ($allusers as $singleuser) : ?>
                                                                        <option value="<?= $singleuser->id ?>"><?= $singleuser->email ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                            <label class="focus-label">Bcc</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input name="forwardsubject" type="text" id="forwardsubject_<?= $projectemail->id ?>" placeholder="Subject" value="Frd:<?= $projectemail->subject ?>" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <textarea name="forwardbody" id="forwardbody_<?= $projectemail->id ?>" rows="4" class="form-control">

                                                    </textarea>
                                                </div>


                                                <div class="form-group mb-0">
                                                    <div class="form-group">
                                                        <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="forwardimages_<?= $projectemail->id ?>" name="attachment" type="file" multiple />
                                                    </div>

                                                    <div class="text-center">
                                                        <button type="submit" onclick="forwardfunction(<?= $projectemail->id ?>)" class="btn btn-primary"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>
                                                        <button class="btn btn-success m-l-5" type="submit" formaction="/projectemail/senddraft"><span>Draft</span> <i class="fa fa-floppy-o m-l-5"></i></button>
                                                        <button class="btn btn-success m-l-5" type="button" onclick="deleteforwardmailDiv( <?= $projectemail->id ?>)"><span>Delete</span> <i class="fa fa-trash-o m-l-5"></i></button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!----------/Forward Div-------------------->
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
        function formatText(icon) {
            return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
            console.log("hh")
        };


        $('.select2-icon').select2({

            width: "100%",
            templateSelection: formatText,
            templateResult: formatText
        });


        var tovalues;
        var ccvalues;
        var bccvalues;


        $(document).ready(function() {

            $("#reply_tousers").on("select2:select", function(event) {
                console.log('hi toemails')
                tovalues = [];

                // copy all option values from selected
                $(event.currentTarget).find("option:selected").each(function(i, selected) {
                    tovalues[i] = parseInt($(selected).val());
                });
                //console.log(tovalues, 'values');
            });
            $("#reply_ccusers").on("select2:select", function(event) {
                console.log('hi ccemails')
                ccvalues = [];

                // copy all option values from selected
                $(event.currentTarget).find("option:selected").each(function(i, selected) {
                    ccvalues[i] = parseInt($(selected).val());
                });
            });

            $("#reply_bccusers").on("select2:select", function(event) {
                console.log('hi bccemails')
                bccvalues = [];

                // copy all option values from selected
                $(event.currentTarget).find("option:selected").each(function(i, selected) {
                    bccvalues[i] = parseInt($(selected).val());
                });
            });
            var forwardtovalues;
            var forwardccvalues;
            var forwardbccvalues;
            $("#forward_tousers").on("select2:select", function(event) {
                console.log('hi toemails')
                forwardtovalues = [];

                // copy all option values from selected
                $(event.currentTarget).find("option:selected").each(function(i, selected) {
                    forwardtovalues[i] = parseInt($(selected).val());
                });
                console.log(forwardtovalues, 'values');
            });
            $("#forward_ccusers").on("select2:select", function(event) {
                console.log('hi ccemails')
                forwardccvalues = [];

                // copy all option values from selected
                $(event.currentTarget).find("option:selected").each(function(i, selected) {
                    forwardccvalues[i] = parseInt($(selected).val());
                });
            });

            $("#forward_bccusers").on("select2:select", function(event) {
                console.log('hi bccemails')
                forwardbccvalues = [];

                // copy all option values from selected
                $(event.currentTarget).find("option:selected").each(function(i, selected) {
                    forwardbccvalues[i] = parseInt($(selected).val());
                });
            });











        });

        var reply = 0





        function replyfunction(parentemail) {
            var sharedfile;
            console.log(parentemail, 'parentemail');

            var body = $('#replybody_' + parentemail).val();
            console.log(body);
            var subject = $('#replysubject_' + parentemail).val();

            var file_data = $("#images_" + parentemail).prop("files");
            console.log(file_data, 'filedata');
            var form_data = new FormData();
            var isFileNotAttached = 0;
            if (file_data.length > 0) {
                for (var i = 0; i < file_data.length; i++) {
                    form_data.append("file[]", file_data[i]);
                }
            } else {
                isFileNotAttached = 123;
            }
            console.log($('#reply_ccusers').val(), 'hhhhhhhhhhhhhhhhh');



            if (tovalues == null && ($('#reply_tousers').val().length > 0)) {
                var to = $('#reply_tousers').val();
                tovalues = to;
            }

            if (ccvalues == null && ($('#reply_ccusers').val().length > 0)) {
                var cc = $('#reply_ccusers').val();
                ccvalues = cc;
            }
            if (bccvalues == null && ($('#reply_bccusers').val().length > 0)) {
                var bcc = $('#reply_bccusers').val();
                bccvalues = bcc;
            }
            form_data.append('sharedfile', sharedfile);
            form_data.append("subject", subject);
            form_data.append("body", body);
            form_data.append("parentemail", parentemail);
            console.log(tovalues, 'tousers');
            form_data.append("bccvalues", JSON.stringify(bccvalues));
            form_data.append("ccvalues", JSON.stringify(ccvalues));
            form_data.append("tovalues", JSON.stringify(tovalues));
            form_data.append("isFileNotAttached", isFileNotAttached);


            $.ajax({
                url: '/projectemail/sendemail/',
                method: 'post',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    window.location = '/projectemail/inbox';
                    console.log(data);

                },
                error: function(e) {}
            });
        }

        function forwardfunction(forwardeid) {

            var body = $('#forwardbody_' + forwardeid).val();
            var subject = $('#forwardsubject_' + forwardeid).val();

            var file_data = $("#forwardimages_" + forwardeid).prop("files");
            console.log(file_data, 'filedata');
            var form_data = new FormData();
            var isFileNotAttached = 0;
            if (file_data.length > 0) {
                for (var i = 0; i < file_data.length; i++) {
                    form_data.append("file[]", file_data[i]);
                }
            } else {
                isFileNotAttached = 123;
            }


            if (forwardtovalues == null && ($('#forward_tousers').val().length > 0)) {

                console.log(to)
                var to = $('#forward_tousers').val();
                forwardtovalues = to;
            }
            if (forwardccvalues == null && ($('#forward_ccusers').val().length > 0)) {
                var cc = $('#forward_ccusers').val();
                forwardccvalues = cc;
            }
            if (forwardbccvalues == null && ($('#forward_bccusers').val().length > 0)) {
                var bcc = $('#forward_bccusers').val();
                forwardbccvalues = bcc;
            }

            form_data.append("subject", subject);
            form_data.append("body", body);
            form_data.append("forwardeid", forwardeid);
            form_data.append("bccvalues", JSON.stringify(forwardbccvalues));
            form_data.append("ccvalues", JSON.stringify(forwardccvalues));
            form_data.append("tovalues", JSON.stringify(forwardtovalues));
            form_data.append("isFileNotAttached", isFileNotAttached);
            $.ajax({
                url: '/projectemail/sendemail/',
                method: 'post',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    window.location = '/projectemail/inbox';
                    console.log(data);

                },
                error: function(e) {}
            });
        }



        function ajaxfunctionforward(forwardeid) {


            forwardtovalues = [];
            forwardccvalues = [];
            forwardbccvalues = [];

            $(".ajax_forward_tousers :selected").each(function() {
                // alert(this.value);
                forwardtovalues.push(this.value);
            });


            $(".ajax_forward_ccusers :selected").each(function() {
                // alert(this.value);
                forwardccvalues.push(this.value);
            });

            $(".ajax_forward_bccusers :selected").each(function() {
                // alert(this.value);
                forwardbccvalues.push(this.value);
            });



            var body = $('#forwardbody_' + forwardeid).val();
            var subject = $('#forwardsubject_' + forwardeid).val();

            var file_data = $("#forwardimages_" + forwardeid).prop("files");
            console.log(file_data, 'filedata');
            var form_data = new FormData();
            var isFileNotAttached = 0;
            if (file_data.length > 0) {
                for (var i = 0; i < file_data.length; i++) {
                    form_data.append("file[]", file_data[i]);
                }
            } else {
                isFileNotAttached = 123;
            }

            if (forwardtovalues == null && ($('#forward_tousers').val().length > 0)) {

                console.log(to)
                var to = $('#forward_tousers').val();
                forwardtovalues = to;
            }
            if (forwardccvalues == null && ($('#forward_ccusers').val().length > 0)) {
                var cc = $('#forward_ccusers').val();
                forwardccvalues = cc;
            }
            if (forwardbccvalues == null && ($('#forward_bccusers').val().length > 0)) {
                var bcc = $('#forward_bccusers').val();
                forwardbccvalues = bcc;
            }

            form_data.append("subject", subject);
            form_data.append("body", body);
            form_data.append("forwardeid", forwardeid);
            form_data.append("bccvalues", JSON.stringify(forwardbccvalues));
            form_data.append("ccvalues", JSON.stringify(forwardccvalues));
            form_data.append("tovalues", JSON.stringify(forwardtovalues));
            form_data.append("isFileNotAttached", isFileNotAttached);
            $.ajax({
                url: '/projectemail/sendemail/',
                method: 'post',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    window.location = '/projectemail/inbox';
                    console.log(data);

                },
                error: function(e) {}
            });
        }


        function updateworklable(mid) {
            console.log(mid);
            console.log($('#worklabel').val());
            $.ajax({
                url: "/projectemail/updateworklable",
                dataType: "json",
                method: 'post',
                data: {
                    'mid': mid,
                    'lablename': $('#worklabel').val(),
                },
                success: function(data) {
                    console.log('hhhhhhhhhhhhhhhhhhhhhhh');

                    window.location = '/projectemail/inbox';

                }
            });


        }


        function showreplyDiv(mid) {
            reply = 1;
            console.log('reply', mid);
            var reply = $('#replay_' + mid).show();
        }


        function deleteComposemailDiv(mid) {
            console.log('This is Empty div', mid);
            $('#replay_' + mid).hide();
        }

        function deleteforwardmailDiv(mid) {
            $('#forward_' + mid).hide();

        }


        function showforwardDiv(mid) {
            var forward = $('#forward_' + mid).show();
        }




        function showtouserme(touser, emailid) {
            $('#showtouserme_' + touser + '_' + emailid).toggle();
        }

        function showccuserme(touser) {
            $('#showccuserme_' + touser).toggle();
        }

        function showbccuserme(touser) {
            $('#showbccuserme_' + touser).toggle();
        }

        function showtouserothers(touser, emailid) {
            $('#showtouserothers_' + touser + '_' + emailid).toggle();
        }


        function showparentmaildata(parentmailid, authuser) {
            if($("#showMore").text() == 'Load More...') {
                $("#showMore").text('Hide');
            } else {
                $("#showMore").text('Load More...');
            }


            if ($('#ajax_parentmails').html().replace(/\s/g, '')) {
                $('#ajax_parentmails').empty();
            } else {
                console.log(parentmailid, 'parentmail id');

                var resp_data;



                do {
                    resp_data = null;

                    console.log('comming', parentmailid);


                    $.ajax({
                        async: false,
                        url: '/projectemail/viewmail',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            'parentmailid': parentmailid
                        },
                        success: function(data) {

                            if (data[0] != null) {
                                var str = "";

                                str += ' <div>' +
                                    '<div class="mailview-header">' +
                                    '<div class="row">' +
                                    '<div class="col-sm-8">' +
                                    '<div class="text-ellipsis m-b-10">' +
                                    '<span class="mail-view-title">';
                                if (data[0].replies) {
                                    str += 'Re:' + data[0].subject + '';
                                } else if (data[0].forwardemails) {
                                    str += 'Fwd: ' + data[0].subject + '';
                                } else {
                                    str += '' + data[0].subject + '';
                                }
                                str += '</span>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-sm-4" style="display:flex;justify-content:space-between;">' +
                                    '<div class="mail-view-action">' +
                                    '<div class="btn-group">' +
                                    '<form action="/projectemail/deleteEmail" method="post">' +
                                    '<button type="submit" class="btn btn-white btn-sm" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash-o"></i></button>' +
                                    '<input type="hidden" name="mid" value="' + data[0].id + '">' +
                                    '</form>' +
                                    '<button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Reply" onclick="showreplyDiv(' + data[0].id + ')"> <i class="fa fa-reply"></i></button>' +

                                    '<button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Forward"  onclick="showforwardDiv(' + data[0].id + ');"> <i class="fa fa-share"></i></button>' +
                                    '<button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Print"> <i class="fa fa-print"></i></button>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="form-group form-focus">' +
                                    '<select class="select2-icon floating" id="worklabel" name="worklabel" onchange="updateworklable(' + data[0].id + ')">' +
                                    '<option selected>Select Worklabel Type</option>' +
                                    '<option value="W" data-icon="fa fa-circle text-success mail-label">Work</option>' +
                                    '<option value="P" data-icon="fa fa-circle text-warning mail-label">Personal</option>' +
                                    '</select>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="sender-info">' +
                                    '<div class="sender-img">' +
                                    '<img width="40" alt="" src="' + data[0].from_user.profileFilepath + '/' + data[0].from_user.profileFilename + '" class="rounded-circle">' +
                                    '</div>' +
                                    '<div class="receiver-details float-left">' +
                                    '<span class="sender-name">' + data[0].from_user.firstname + ' ' + data[0].from_user.lastname + ' (' + data[0].from_user.email + ')</span>' +
                                    '<span class="receiver-name">' +
                                    'to:';
                                if (data[0].tousers) {
                                    data[0].tousers.forEach((touser) => {
                                        if (touser.user.id == authuser) {
                                            str += ' me <a onclick="showtouserme(' + touser.user.id + ',' + data[0].id + ')"> <img src="/assets/img/down.png" style="width: 20px;"></a> </br>' +
                                                '<div id="showtouserme_' + touser.user.id + '_' + data[0].id + '" style="display: none;border:solid;">' +
                                                '<span>' +
                                                ' <p>' +
                                                'From:' + data[0].from_user.firstname + ' ' + data[0].from_user.lastname + ' (' + data[0].from_user.email + ')</br>' +
                                                'To :' + touser.user.firstname + '' + touser.user.lastname + '(' + touser.user.email + ')</br>' +
                                                'Subject : ' + data[0].subject + '</br>' +
                                                'Date: ' + data[0].send_date + '</br>' +
                                                '</p>' +
                                                '</span>' +
                                                '</div>';
                                        } else {

                                            str += ' <span><a onclick="showtouserothers(' + touser.user.id + ',' + data[0].id + ')"> <img src="/assets/img/down.png" style="width: 20px;"></a><?= $touser->user->firstname ?> </span><span><?= $touser->user->lastname ?></span>' +
                                                '<div id="showtouserothers_' + touser.user.id + '_' + data[0].id + '" style="display: none; border:solid;">' +
                                                '<span>' +
                                                '<p>' +
                                                'From:' + data[0].from_user.firstname + ' ' + data[0].from_user.lastname + ' (' + data[0].from_user.email + ')</br>' +
                                                'To :' + touser.user.firstname + '' + touser.user.lastname + '(' + touser.user.email + ')</br>' +
                                                'Subject : ' + data[0].subject + '</br>' +
                                                'Date: ' + data[0].send_date + '</br>' +
                                                '</p>' +
                                                '</span>' +
                                                '</div>';

                                        }
                                    });
                                }
                                if (data[0].ccusers) {
                                    str += 'cc:';
                                    data[0].ccusers.forEach((ccuser) => {
                                        if (ccuser.user.id == authuser) {
                                            str += ' me<a onclick="showccuserme(' + ccuser.user.id + ')"> <img src="/assets/img/down.png" style="width: 20px;"></a></br>' +
                                                '<div id="showccuserme_' + ccuser.user.id + '" style="display: none;border:solid;">' +
                                                '<span>' +
                                                '<p>' +
                                                'From:' + data[0].from_user.firstname + ' ' + data[0].from_user.lastname + ' (' + data[0].from_user.email + ')</br>' +
                                                'To :' + ccuser.user.firstname + '' + ccuser.user.lastname + '(' + ccuser.user.email + ')</br>' +
                                                'Subject : ' + data[0].subject + '</br>' +
                                                'Date: ' + data[0].send_date + '</br>' +
                                                '</p>' +
                                                '</span>' +
                                                '</div>';
                                        } else {
                                            str += '<span><' + ccuser.user.firstname + ' </span><span>' + ccuser.user.firstname + '</br></span><a>';
                                        }
                                    });
                                }

                                if (data[0].bccusers) {
                                    str += 'Bcc:';
                                    data[0].bccusers.forEach((bccuser) => {
                                        if (bccuser.user.id == authuser) {
                                            str += ' me<a onclick="showccuserme(' + bccuser.user.id + ')"> <img src="/assets/img/down.png" style="width: 20px;"></a></br>' +
                                                '<div id="showccuserme_' + ccuser.user.id + '" style="display: none;border:solid;">' +
                                                '<span>' +
                                                '<p>' +
                                                'From:' + data[0].from_user.firstname + ' ' + data[0].from_user.lastname + ' (' + data[0].from_user.email + ')</br>' +
                                                'To :' + bccuser.user.firstname + '' + bccuser.user.lastname + '(' + bccuser.user.email + ')</br>' +
                                                'Subject : ' + data[0].subject + '</br>' +
                                                'Date: ' + data[0].send_date + '</br>' +
                                                '</p>' +
                                                '</span>' +
                                                '</div>';
                                        } else {

                                            str += '<span><' + bccuser.user.firstname + ' </span><span>' + bccuser.user.firstname + '</br></span><a>';
                                        }
                                    });
                                }

                                str += '</span>' +
                                    '</div>' +
                                    '<div class="mail-sent-time">' +
                                    '<span class="mail-time">' + data[0].send_date + '</span>' +
                                    '</div>' +
                                    '<div class="clearfix"></div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="mailview-inner">' +
                                    '<p>' + nl2br(data[0].body) + '</p>' +
                                    '</div>';
                                if (data[0].emailfiles) {


                                    str += '<div class="mail-attachments">' +

                                        '<p><i class="fa fa-paperclip"></i> ' + data[0].emailfiles.length + ' Attachments -' +

                                        '</p>' +

                                        '<div class="row">';
                                    data[0].emailfiles.forEach((emailfile) => {
                                        var ext = emailfile.filename.split(".")[1];
                                        console.log(ext);

                                        str += '<ul class="attachments clearfix">' +
                                            ' <li>';
                                        if (ext == "word") {
                                            str += '<div class="attach-file"><i class="fa fa-file-word-o"></i></div>';
                                        } else if (ext == "pdf") {
                                            str += '<div class="attach-file"><i class="fa fa-file-pdf-o"></i></div>';
                                        } else {
                                            str += '<div class="attach-file"><i class="fa fa-image"></i></div>';
                                        }
                                        str += '<div class="attach-info"> <a href="#" class="attach-filename">' + emailfile.filename + '</a>' +
                                            '<div class="attach-fileize"> ' + emailfile.size + '</div>' +
                                            '<a href="/projectemail/downloadall?mid=' + data[0].id + '&fid=' + emailfile.id + '"> <i class="fa fa-download" aria-hidden="true"></i></a>' +
                                            '</div>' +
                                            '</li>' +
                                            '</ul>';

                                    });
                                    str += '</div>' +
                                        '</div>';
                                }
                                str += '</div>';

                                str += '<div class="row" id="replay_' + data[0].id + '" style="display: none;">' +
                                    '<div class="col-sm-12">' +
                                    '<div class="card">' +
                                    '<div class="card-body">' +
                                    '<div class="">' +
                                    '<div class="form-group form-focus select-focus m-b-30">' +
                                    '<select id="reply_tousers"  placeholder="To" class="select2-icon floating" name="toemail" multiple>';

                                data[1].forEach((singleuser) => {
                                    if (singleuser.id == data[0].from_user.id) {
                                        str += '<option selected value=' + data[0].from_user.id + '>' + data[0].from_user.email + '</option>';
                                    } else {
                                        str += '<option value=' + singleuser.id + '>' + singleuser.email + '</option>';
                                    }
                                });
                                str += '</select>' +
                                    '<label class="focus-label">To</label>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="row">' +
                                    '<div class="col-md-6">' +
                                    '<div class="form-group form-focus select-focus">' +
                                    '<select id="reply_ccusers" class="select2-icon floating" name="cc" multiple>';

                                if (data[0].ccusers.length > 0) {
                                    data[0].ccusers.forEach((ccuser) => {
                                        data[1].forEach((singleuser) => {
                                            if (singleuser.id == ccuser.user.id) {
                                                str += '<option selected value="' + ccuser.user.id + '">' + ccuser.user.email + ' </option>';
                                            } else {
                                                str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';
                                            }
                                        });
                                    });

                                } else {
                                    data[1].forEach((singleuser) => {
                                        str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';

                                    });
                                }
                                str += '</select>' +
                                    '<label class="focus-label">cc</label>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div class="form-group form-focus select-focus">' +
                                    '<select id="reply_bccusers" class="select2-icon floating" name="bcc" multiple>';
                                if (data[0].bccusers.length > 0) {
                                    data[0].bccusers.forEach((bccuser) => {

                                        data[1].forEach((singleuser) => {
                                            if (singleuser.id == bccuser.user.id) {
                                                str += '<option selected value="' + bccuser.user.id + '">' + bccuser.user.email + ' </option>';
                                            } else {
                                                str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';
                                            }
                                        });
                                    });

                                } else {
                                    data[1].forEach((singleuser) => {
                                        str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';

                                    });
                                }

                                str += '</select>' +
                                    '<label class="focus-label">Bcc</label>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<input name="subject" type="text" id="replysubject_' + data[0].id + '" placeholder="Subject" value="Re:' + data[0].subject + '" class="form-control">' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<textarea name="body" id="replybody_' + data[0].id + '" rows="4" class="form-control"></textarea>' +
                                    '</div>' +

                                    '<div class="form-group mb-0">' +
                                    '<div class="form-group">' +

                                    '<input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="images_' + data[0].id + '" name="attachment" type="file" multiple />' +

                                    '</div>' +

                                    '<div class="text-center">' +
                                    '<button type="submit" class="btn btn-primary" onclick="replyfunction(' + data[0].id + ')"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>' +

                                    '<button class="btn btn-success m-l-5" type="submit" formaction="/projectemail/senddraft"><span>Draft</span> <i class="fa fa-floppy-o m-l-5"></i></button>' +
                                    '<button class="btn btn-success m-l-5" onclick="deleteComposemailDiv(' + data[0].id + ')" type="button"><span>Delete</span> <i class="fa fa-trash-o m-l-5"></i></button>' +
                                    '</div>' +
                                    '</div>' +

                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +


                                    //forward div

                                    ' <div class="row" id="forward_' + data[0].id + '" style="display: none;">' +
                                    '<div class="col-sm-12">' +
                                    '<div class="card">' +
                                    '<div class="card-body">' +
                                    '<div class="">' +
                                    '<div class="form-group form-focus select-focus m-b-30">' +
                                    '<select  placeholder="To" class="select2-icon floating ajax_forward_tousers" name="toemail" multiple>';

                                data[1].forEach((singleuser) => {
                                    str += '<option value=' + singleuser.id + '>' + singleuser.email + '</option>';
                                });
                                str += '</select>' +
                                    '<label class="focus-label">To</label>' +
                                    '</div>' +
                                    '</div>' +


                                    '<div class="row">' +
                                    '<div class="col-md-6">' +
                                    '<div class="form-group form-focus select-focus">' +
                                    '<select id="ajax_forward_ccusers_testing" class="select2-icon floating" name="cc" multiple>';

                                if (data[0].ccusers.length > 0) {
                                    console.log(data[0].ccusers, 'if -ccuser');
                                    data[0].ccusers.forEach((ccuser) => {
                                        data[1].forEach((singleuser) => {
                                            if (singleuser.id == ccuser.user.id) {
                                                str += '<option selected value="' + ccuser.user.id + '">' + ccuser.user.email + ' </option>';
                                            } else {
                                                str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';
                                            }
                                            console.log(singleuser, 'allusers');
                                        });
                                    });
                                } else {

                                    data[1].forEach((singleuser) => {

                                        str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';
                                    });
                                }


                                str += '</select>' +
                                    '<label class="focus-label">cc</label>' +
                                    '</div>' +
                                    '</div>' +


                                    '<div class="col-md-6">' +
                                    '<div class="form-group form-focus select-focus">' +
                                    '<select id="ajax_forward_bccusers" class="select2-icon floating" name="bcc" multiple>';
                                if (data[0].bccusers.length > 0) {
                                    data[0].bccusers.forEach((bccuser) => {
                                        data[1].forEach((singleuser) => {
                                            if (singleuser.id == bccuser.user.id) {
                                                str += '<option selected value="' + bccuser.user.id + '">' + bccuser.user.email + ' </option>';
                                            } else {
                                                str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';
                                            }
                                        });
                                    });

                                } else {
                                    data[1].forEach((singleuser) => {
                                        str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';

                                    });
                                }
                                str += '</select>' +
                                    '<label class="focus-label">Bcc</label>' +
                                    '</div>' +
                                    '</div>' +


                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<input name="forwardsubject" type="text" id="forwardsubject_' + data[0].id + '" placeholder="Subject" value="Frd:' + data[0].subject + '" class="form-control">' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<textarea name="forwardbody" id="forwardbody_' + data[0].id + '" rows="4" class="form-control">' +
                                    '</textarea>' +
                                    '</div>' +
                                    '<div class="form-group mb-0">' +
                                    '<div class="form-group">' +
                                    '<input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="forwardimages_' + data[0].id + '" name="attachment" type="file" multiple />' +
                                    '</div>' +

                                    '<div class="text-center">' +
                                    '<button type="submit" onclick="ajaxfunctionforward(' + data[0].id + ')" class="btn btn-primary"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>' +
                                    '<button class="btn btn-success m-l-5" type="submit" formaction="/projectemail/senddraft"><span>Draft</span> <i class="fa fa-floppy-o m-l-5"></i></button>' +
                                    '<button class="btn btn-success m-l-5" type="button" onclick="deleteforwardmailDiv(' + data[0].id + ')"><span>Delete</span> <i class="fa fa-trash-o m-l-5"></i></button>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';


                                $('#ajax_parentmails').prepend(str);

                                function formatText(icon) {
                                    return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
                                    console.log("hh")
                                };
                                $('.select2-icon').select2({

                                    width: "100%",
                                    templateSelection: formatText,
                                    templateResult: formatText
                                });

                                if (data && data.length > 0) {
                                    resp_data = data[0].parentemail_id;
                                    parentmailid = data[0].parentemail_id;
                                    console.log(parentmailid, 'parent');
                                    console.log(data[0].parentemail_id, 'parent2');
                                } else {
                                    parentmailid = null;

                                }

                            }


                        },
                        error: function() {

                        }
                    });

                    console.log(resp_data, 'resp_data');
                }
                while (resp_data != null);
            }
        }






        //forwarded mails ajax


        function showforwardedmails(forwarded_id, authuser) {
            if ($('#ajax_parentmails').html()) {
                $('#ajax_parentmails').empty();
            } else {
                console.log(forwarded_id, 'forwarded id');

                var resp_data;

                do {
                    resp_data = null;

                    console.log('comming', forwarded_id);


                    $.ajax({
                        async: false,
                        url: '/projectemail/viewforwardmail',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            'forwardedid': forwarded_id
                        },
                        success: function(data) {

                            if (data[0] != null) {
                                var str = "";

                                str += ' <div>' +
                                    '<div class="mailview-header">' +
                                    '<div class="row">' +
                                    '<div class="col-sm-8">' +
                                    '<div class="text-ellipsis m-b-10">' +
                                    '<span class="mail-view-title">';
                                if (data[0].replies) {
                                    str += 'Re:' + data[0].subject + '';
                                } else if (data[0].forwardemails) {
                                    str += 'Fwd: ' + data[0].subject + '';
                                } else {
                                    str += '' + data[0].subject + '';
                                }
                                str += '</span>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-sm-4" style="display:flex;justify-content:space-between;">' +
                                    '<div class="mail-view-action">' +
                                    '<div class="btn-group">' +
                                    '<form action="/projectemail/deleteEmail" method="post">' +
                                    '<button type="submit" class="btn btn-white btn-sm" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash-o"></i></button>' +
                                    '<input type="hidden" name="mid" value="' + data[0].id + '">' +
                                    '</form>' +
                                    '<button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Reply" onclick="showreplyDiv(' + data[0].id + ')"> <i class="fa fa-reply"></i></button>' +

                                    '<button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Forward"  onclick="showforwardDiv(' + data[0].id + ');"> <i class="fa fa-share"></i></button>' +
                                    '<button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Print"> <i class="fa fa-print"></i></button>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="form-group form-focus">' +
                                    '<select class="select2-icon floating" id="worklabel" name="worklabel" onchange="updateworklable(' + data[0].id + ')">' +
                                    '<option selected>Select Worklabel Type</option>' +
                                    '<option value="W" data-icon="fa fa-circle text-success mail-label">Work</option>' +
                                    '<option value="P" data-icon="fa fa-circle text-warning mail-label">Personal</option>' +
                                    '</select>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="sender-info">' +
                                    '<div class="sender-img">' +
                                    '<img width="40" alt="" src="' + data[0].from_user.profileFilepath + '/' + data[0].from_user.profileFilename + '" class="rounded-circle">' +
                                    '</div>' +
                                    '<div class="receiver-details float-left">' +
                                    '<span class="sender-name">' + data[0].from_user.firstname + ' ' + data[0].from_user.lastname + ' (' + data[0].from_user.email + ')</span>' +
                                    '<span class="receiver-name">' +
                                    'to:';
                                if (data[0].tousers) {
                                    data[0].tousers.forEach((touser) => {
                                        if (touser.user.id == authuser) {
                                            str += ' me <a onclick="showtouserme(' + touser.user.id + ',' + data[0].id + ')"> <img src="/assets/img/down.png" style="width: 20px;"></a> </br>' +
                                                '<div id="showtouserme_' + touser.user.id + '_' + data[0].id + '" style="display: none;border:solid;">' +
                                                '<span>' +
                                                ' <p>' +
                                                'From:' + data[0].from_user.firstname + ' ' + data[0].from_user.lastname + ' (' + data[0].from_user.email + ')</br>' +
                                                'To :' + touser.user.firstname + '' + touser.user.lastname + '(' + touser.user.email + ')</br>' +
                                                'Subject : ' + data[0].subject + '</br>' +
                                                'Date: ' + data[0].send_date + '</br>' +
                                                '</p>' +
                                                '</span>' +
                                                '</div>';
                                        } else {

                                            str += ' <span><a onclick="showtouserothers(' + touser.user.id + ',' + data[0].id + ')"> <img src="/assets/img/down.png" style="width: 20px;"></a><?= $touser->user->firstname ?> </span><span><?= $touser->user->lastname ?></span>' +
                                                '<div id="showtouserothers_' + touser.user.id + '_' + data[0].id + '" style="display: none; border:solid;">' +
                                                '<span>' +
                                                '<p>' +
                                                'From:' + data[0].from_user.firstname + ' ' + data[0].from_user.lastname + ' (' + data[0].from_user.email + ')</br>' +
                                                'To :' + touser.user.firstname + '' + touser.user.lastname + '(' + touser.user.email + ')</br>' +
                                                'Subject : ' + data[0].subject + '</br>' +
                                                'Date: ' + data[0].send_date + '</br>' +
                                                '</p>' +
                                                '</span>' +
                                                '</div>';

                                        }
                                    });
                                }
                                if (data[0].ccusers) {
                                    str += 'cc:';
                                    data[0].ccusers.forEach((ccuser) => {
                                        if (ccuser.user.id == authuser) {
                                            str += ' me<a onclick="showccuserme(' + ccuser.user.id + ')"> <img src="/assets/img/down.png" style="width: 20px;"></a></br>' +
                                                '<div id="showccuserme_' + ccuser.user.id + '" style="display: none;border:solid;">' +
                                                '<span>' +
                                                '<p>' +
                                                'From:' + data[0].from_user.firstname + ' ' + data[0].from_user.lastname + ' (' + data[0].from_user.email + ')</br>' +
                                                'To :' + ccuser.user.firstname + '' + ccuser.user.lastname + '(' + ccuser.user.email + ')</br>' +
                                                'Subject : ' + data[0].subject + '</br>' +
                                                'Date: ' + data[0].send_date + '</br>' +
                                                '</p>' +
                                                '</span>' +
                                                '</div>';
                                        } else {
                                            str += '<span><' + ccuser.user.firstname + ' </span><span>' + ccuser.user.firstname + '</br></span><a>';
                                        }
                                    });
                                }

                                if (data[0].bccusers) {
                                    str += 'Bcc:';
                                    data[0].bccusers.forEach((bccuser) => {
                                        if (bccuser.user.id == authuser) {
                                            str += ' me<a onclick="showccuserme(' + bccuser.user.id + ')"> <img src="/assets/img/down.png" style="width: 20px;"></a></br>' +
                                                '<div id="showccuserme_' + ccuser.user.id + '" style="display: none;border:solid;">' +
                                                '<span>' +
                                                '<p>' +
                                                'From:' + data[0].from_user.firstname + ' ' + data[0].from_user.lastname + ' (' + data[0].from_user.email + ')</br>' +
                                                'To :' + bccuser.user.firstname + '' + bccuser.user.lastname + '(' + bccuser.user.email + ')</br>' +
                                                'Subject : ' + data[0].subject + '</br>' +
                                                'Date: ' + data[0].send_date + '</br>' +
                                                '</p>' +
                                                '</span>' +
                                                '</div>';
                                        } else {

                                            str += '<span><' + bccuser.user.firstname + ' </span><span>' + bccuser.user.firstname + '</br></span><a>';
                                        }
                                    });
                                }

                                str += '</span>' +
                                    '</div>' +
                                    '<div class="mail-sent-time">' +
                                    '<span class="mail-time">' + data[0].send_date + '</span>' +
                                    '</div>' +
                                    '<div class="clearfix"></div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<p>---------- Forwarded message ---------</br>' +
                                    'From:' + data[0].from_user.firstname + '  ' + data[0].from_user.lastname + ' (' + data[0].from_user.email + ') </br>' +
                                    'Subject:' + data[0].subject + ' </br>' +
                                    'Date:' + data[0].send_date + '</br>' +
                                    'To :';
                                if (data[0].tousers) {

                                    data[0].tousers.forEach((tousers) => {

                                        str += '<span><?= $touser->user->firstname ?> </span><span><?= $touser->user->lastname ?>(<?= $touser->user->email ?>)</span>';

                                    });
                                }
                                str += '</p>' +
                                    '<div class="mailview-inner">' +
                                    '<p>' + nl2br(data[0].body) + '</p>' +
                                    '</div>';
                                if (data[0].emailfiles) {


                                    str += '<div class="mail-attachments">' +

                                        '<p><i class="fa fa-paperclip"></i> ' + data[0].emailfiles.length + ' Attachments -' +

                                        '</p>' +

                                        '<div class="row">';
                                    data[0].emailfiles.forEach((emailfile) => {
                                        var ext = emailfile.filename.split(".")[1];
                                        console.log(ext);

                                        str += '<ul class="attachments clearfix">' +
                                            ' <li>';
                                        if (ext == "word") {
                                            str += '<div class="attach-file"><i class="fa fa-file-word-o"></i></div>';
                                        } else if (ext == "pdf") {
                                            str += '<div class="attach-file"><i class="fa fa-file-pdf-o"></i></div>';
                                        } else {
                                            str += '<div class="attach-file"><i class="fa fa-image"></i></div>';
                                        }
                                        str += '<div class="attach-info"> <a href="#" class="attach-filename">' + emailfile.filename + '</a>' +
                                            '<div class="attach-fileize"> ' + emailfile.size + '</div>' +
                                            '<a href="/projectemail/downloadall?mid=' + data[0].id + '&fid=' + emailfile.id + '"> <i class="fa fa-download" aria-hidden="true"></i></a>' +
                                            '</div>' +
                                            '</li>' +
                                            '</ul>';

                                    });
                                    str += '</div>' +
                                        '</div>';
                                }
                                str += '</div>';

                                str += '<div class="row" id="replay_' + data[0].id + '" style="display: none;">' +
                                    '<div class="col-sm-12">' +
                                    '<div class="card">' +
                                    '<div class="card-body">' +
                                    '<div class="">' +
                                    '<div class="form-group form-focus select-focus m-b-30">' +
                                    '<select id="reply_tousers"  placeholder="To" class="select2-icon floating" name="toemail" multiple>';

                                data[1].forEach((singleuser) => {
                                    if (singleuser.id == data[0].from_user.id) {
                                        str += '<option selected value=' + data[0].from_user.id + '>' + data[0].from_user.email + '</option>';
                                    } else {
                                        str += '<option value=' + singleuser.id + '>' + singleuser.email + '</option>';
                                    }
                                });
                                str += '</select>' +
                                    '<label class="focus-label">To</label>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="row">' +
                                    '<div class="col-md-6">' +
                                    '<div class="form-group form-focus select-focus">' +
                                    '<select id="reply_ccusers" class="select2-icon floating" name="cc" multiple>';

                                if (data[0].ccusers) {
                                    data[0].ccusers.forEach((ccuser) => {
                                        data[1].forEach((singleuser) => {
                                            if (singleuser.id == ccuser.user.id) {
                                                str += '<option selected value="' + ccuser.user.id + '">' + ccuser.user.email + ' </option>';
                                            } else {
                                                str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';
                                            }
                                        });
                                    });

                                } else {
                                    data[1].forEach((singleuser) => {
                                        str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';

                                    });
                                }
                                str += '</select>' +
                                    '<label class="focus-label">cc</label>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div class="form-group form-focus select-focus">' +
                                    '<select id="reply_bccusers" class="select2-icon floating" name="bcc" multiple>';
                                if (data[0].bccusers) {
                                    data[0].bccusers.forEach((bccuser) => {

                                        data[1].forEach((singleuser) => {
                                            if (singleuser.id == bccuser.user.id) {
                                                str += '<option selected value="' + bccuser.user.id + '">' + bccuser.user.email + ' </option>';
                                            } else {
                                                str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';
                                            }
                                        });
                                    });

                                } else {
                                    data[1].forEach((singleuser) => {
                                        str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';

                                    });
                                }

                                str += '</select>' +
                                    '<label class="focus-label">Bcc</label>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<input name="subject" type="text" id="replysubject_' + data[0].id + '" placeholder="Subject" value="Re:' + data[0].subject + '" class="form-control">' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<textarea name="body" id="replybody_' + data[0].id + '" rows="4" class="form-control"></textarea>' +
                                    '</div>' +

                                    '<div class="form-group mb-0">' +
                                    '<div class="form-group">' +

                                    '<input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="images_' + data[0].id + '" name="attachment" type="file" multiple />' +

                                    '</div>' +

                                    '<div class="text-center">' +
                                    '<button type="submit" class="btn btn-primary" onclick="replyfunction(' + data[0].id + ')"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>' +

                                    '<button class="btn btn-success m-l-5" type="submit" formaction="/projectemail/senddraft"><span>Draft</span> <i class="fa fa-floppy-o m-l-5"></i></button>' +
                                    '<button class="btn btn-success m-l-5" onclick="deleteComposemailDiv(' + data[0].id + ')" type="button"><span>Delete</span> <i class="fa fa-trash-o m-l-5"></i></button>' +
                                    '</div>' +
                                    '</div>' +

                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +

                                    //forward div

                                    ' <div class="row" id="forward_' + data[0].id + '" style="display: none;">' +
                                    '<div class="col-sm-12">' +
                                    '<div class="card">' +
                                    '<div class="card-body">' +
                                    '<div class="">' +
                                    '<div class="form-group form-focus select-focus m-b-30">' +
                                    '<select id="forward_tousers" placeholder="To" class="select2-icon floating" name="toemail" multiple>';

                                data[1].forEach((singleuser) => {
                                    str += '<option value=' + singleuser.id + '>' + singleuser.email + '</option>';
                                });
                                str += '</select>' +
                                    '<label class="focus-label">To</label>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="row">' +
                                    '<div class="col-md-6">' +
                                    '<div class="form-group form-focus select-focus">' +
                                    '<select id="forward_ccusers" class="select2-icon floating" name="cc" multiple>';

                                if (data[0].ccusers) {
                                    data[0].ccusers.forEach((ccuser) => {
                                        data[1].forEach((singleuser) => {
                                            if (singleuser.id == ccuser.user.id) {
                                                str += '<option selected value="' + ccuser.user.id + '">' + ccuser.user.email + ' </option>';
                                            } else {
                                                str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';
                                            }
                                            console.log(singleuser, 'allusers');
                                        });
                                    });


                                } else {
                                    data[1].forEach((singleuser) => {

                                        str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';
                                    });
                                }
                                str += '<label class="focus-label">cc</label>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                    '<div class="form-group form-focus select-focus">' +
                                    '<select id="forward_bccusers" class="select2-icon floating" name="bcc" multiple>';
                                if (data[0].bccusers) {
                                    data[0].bccusers.forEach((bccuser) => {
                                        data[1].forEach((singleuser) => {
                                            if (singleuser.id == bccuser.user.id) {
                                                str += '<option selected value="' + bccuser.user.id + '">' + bccuser.user.email + ' </option>';
                                            } else {
                                                str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';
                                            }
                                        });
                                    });

                                } else {
                                    data[1].forEach((singleuser) => {
                                        str += '<option value="' + singleuser.id + '">' + singleuser.email + '</option>';

                                    });
                                }
                                str += '</select>' +
                                    '<label class="focus-label">Bcc</label>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<input name="forwardsubject" type="text" id="forwardsubject_' + data[0].id + '" placeholder="Subject" value="Frd:' + data[0].subject + '" class="form-control">' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<textarea name="forwardbody" id="forwardbody_' + data[0].id + '" rows="4" class="form-control">' +
                                    '</textarea>' +
                                    '</div>' +
                                    '<div class="form-group mb-0">' +
                                    '<div class="form-group">' +
                                    '<input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="forwardimages_' + data[0].id + '" name="attachment" type="file" multiple />' +
                                    '</div>' +
                                    '<div class="text-center">' +
                                    '<button type="submit" onclick="forwardfunction(' + data[0].id + ')" class="btn btn-primary"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>' +
                                    '<button class="btn btn-success m-l-5" type="submit" formaction="/projectemail/senddraft"><span>Draft</span> <i class="fa fa-floppy-o m-l-5"></i></button>' +
                                    '<button class="btn btn-success m-l-5" type="button" onclick="deleteforwardmailDiv(' + data[0].id + ')"><span>Delete</span> <i class="fa fa-trash-o m-l-5"></i></button>' +
                                    '</div>' +
                                    '</div>' +

                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<hr></br>';


                                $('#ajax_parentmails').append(str);

                                function formatText(icon) {
                                    return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
                                    console.log("hh")
                                };
                                $('.select2-icon').select2({

                                    width: "100%",
                                    templateSelection: formatText,
                                    templateResult: formatText
                                });

                                if (data && data.length > 0) {
                                    resp_data = data[0].forwarded_id;
                                    forwarded_id = data[0].forwarded_id;
                                    console.log(forwarded_id, 'forwarded');
                                    console.log(data[0].forwarded_id, 'forwarded2');
                                } else {
                                    forwarded_id = null;

                                }
                            }

                        },
                        error: function() {

                        }
                    });

                    console.log(resp_data, 'resp_data');
                }
                while (resp_data != null);
            }
        }

        function nl2br(str, replaceMode, isXhtml) {

            var breakTag = (isXhtml) ? '<br />' : '<br>';
            var replaceStr = (replaceMode) ? '$1' + breakTag : '$1' + breakTag + '$2';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
        }

        function senddraftfunction(projectmailid) {
            var body = $('#replybody_' + projectmailid).val();
            var subject = $('#replysubject_' + projectmailid).val();
            console.log(subject, 'subject');
            var file_data = $("#images_" + projectmailid).prop("files");
            console.log(file_data, 'filedata');
            var form_data = new FormData();
            var isFileNotAttached = 0;
            if (file_data.length > 0) {
                for (var i = 0; i < file_data.length; i++) {
                    form_data.append("file[]", file_data[i]);
                }
            } else {
                isFileNotAttached = 123;
            }
            form_data.append("subject", subject);
            form_data.append("body", body);


            if (tovalues == null && ($('#reply_tousers').val().length > 0)) {
                var to = $('#reply_tousers').val();
                tovalues = to;
            }

            if (ccvalues == null && ($('#reply_ccusers').val().length > 0)) {
                var cc = $('#reply_ccusers').val();
                ccvalues = cc;
            }
            if (bccvalues == null && ($('#reply_bccusers').val().length > 0)) {
                var bcc = $('#reply_bccusers').val();
                bccvalues = bcc;
            }

            form_data.append("bccvalues", JSON.stringify(bccvalues));
            form_data.append("ccvalues", JSON.stringify(ccvalues));
            form_data.append("tovalues", JSON.stringify(tovalues));
            console.log(tovalues);
            form_data.append("isFileNotAttached", isFileNotAttached);
            $.ajax({
                url: '/projectemail/senddraft/',
                method: 'post',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    window.location = '/projectemail/inbox';

                    console.log(data, 'sucessfully');

                },
                error: function(e) {}
            });



        }
    </script>
