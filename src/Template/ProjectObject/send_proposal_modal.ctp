<style>
    .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
</style>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" id="send-proposal-header" style="background: url(../../images/top-bar-background.png) no-repeat top left/100% 100%; color: white">
            <h4 align="left" class="modal-title" id="send-proposal-modalLabel"><?= __('Send Proposal') ?></h4>
            <button onclick="modalProjectClose(); return false; " type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
            <form method="post" id="send-proposal" enctype="multipart/form-data">
                <label for="priceMin"><?= __('Price Min') ?></label>
                <input name="priceMin" id="priceMin" type="text" class="form-control btn-mod-input" placeholder="<?= __('Your proposal bottom limit') ?>"/>
                <label for="priceMax"><?= __('Price Max') ?></label>
                <input name="priceMax" id="priceMax" type="text" class="form-control btn-mod-input" placeholder="<?= __('Your proposal top limit') ?>"/>

                <div class="text-center">
                    <button class="btn btn-secondary margin-t-1" onclick="modalProjectClose(); return false; "><?=__('Annulla') ?></button>
                    <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('Send proposal') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

    function modalProjectClose() {
        $('#send-proposal-modal').modal('hide');
    }

    function sendProposal() {
        console.log(<?= $projectId ?>);
        $.ajax({
            url: '/courseProposal/send-proposal',
            method: 'POST',
            dataType: 'json',
            data: {
                'projectId': <?= $projectId ?>,
                'priceMin': $('#priceMin').val(),
                'priceMax': $('#priceMax').val()
            },
            success: function(data) {
                //window.location.href = "/projectObject"
                console.log(data);
                $('#send-proposal-modal').modal('hide');
            },
            error: function(a, b, c) {
                console.log(a)
                console.log(b)
                console.log(c)
            }
        });
    }

    function getProposal() {
        $.ajax({
            url: '/courseProposal/get-proposal',
            method: 'POST',
            dataType: 'json',
            data: {
                'projectId': <?= $projectId ?>
            },
            success: function(data) {
                //window.location.href = "/projectObject"
                console.log(data)
                if(data[0] !== undefined) {
                    $('#priceMin').val(data[0]['priceMin']);
                    $('#priceMax').val(data[0]['priceMax']);
                }
            },
            error: function(a, b, c) {
                console.log(a)
                console.log(b)
                console.log(c)
            }
        });
    }

    $(document).ready(function(){
        getProposal();

        $('#send-proposal').on('submit', function(event) {
            event.preventDefault();
            sendProposal();
        })
    });

</script>
