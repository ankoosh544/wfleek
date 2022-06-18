<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\City $city
 */
?>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="container">
        <h2>Upload Cities Data</h2>
        <form action="/cities/add" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Upload a File</label>
                <input class="form-control" type="file" id="commune_cities" name="file" required />
            </div>
            <button type="submit" class="btn btn-info"><?= __('Submit') ?></button>
        </form>
    </div>
</div>
