<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="project-activity-wrapper col-md-12" style=" background:whitesmoke;">
            <div class="form-group">
                <br/><br/>
                <a href="/project-object/comments/<?=$projectObject->id?>" class="btn btn-info " role="button" aria-pressed="true">Go Back</a>
                <br/><br/>
                <?php foreach ($comment as  $tags) : ?>

                    <?php if (strpos($tags->content, $text) == true) : ?>
                        <div class="form-control">
                            <a href=""><?= $tags->content ?> </a>
                        </div>
                        <br>
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
