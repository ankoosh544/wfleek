<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Item View</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Item View</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit</h4>
                    </div>
                    <div class="card-body">
                        <form action="/invoiceitems/updateitem?id=<?= $item->id ?>" method="POST">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Item Name</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="itemname" value="<?= $item->name ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Item Description</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <textarea type="text" class="form-control" name="itemdescription" aria-describedby="basic-addon2"> <?= $item->description ?> </textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Item Price</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="text" class="form-control" name="itemprice" value="<?= $item->price ?>" id="price_<?=$item->id?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label class="col-form-label col-lg-2">Quantity</label>
                                <div class="col-lg-10">
                                    <div class="input-group">

                                        <input type="text" class="form-control" name="itemqty" id="qty_<?=$item->id?>" value="<?= $item->quantity ?>" onkeyup="counttotalamount(<?=$item->id?>)">
                                    </div>
                                </div>
                            </div>
                            <?php $total = $item->quantity * $item->price; ?>
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-lg-2">Total</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?= $total ?>" id="amount_<?=$item->id?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="/invoiceitems/delete?id=<?= $item->id ?>" class="btn btn-danger">Delete</a>
                                <button type="submit" class="btn btn-primary ">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<!-- /Main Wrapper -->
<script>
    function counttotalamount(id) {
        var amount = $('#price_' + id).val();
        var qty = $('#qty_' + id).val();
        var finalamt = amount * qty;
        $('#amount_' + id).val(finalamt);
        totalamount += finalamt;
        $('#total_amount').val(totalamount);
    }
</script>
