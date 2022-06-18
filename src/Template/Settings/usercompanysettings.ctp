<!-- /Header -->



<!-- Sidebar -->
<?= $this->element('settings_sidebar',[
    'companyId' => $authusersettings->company_id,
    'lastaddedrole' =>$lastaddedrole
]) ?>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Company Settings</h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <?php if ($authusersettings->company_id != null) : ?>
                    <form>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Company Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" value="<?= $authusersettings->usercompany->name ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Contact Person</label>
                                    <input class="form-control " value="<?= $authusersettings->user->firstname ?> <?= $authusersettings->user->lastname ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input class="form-control " value="<?= $authusersettings->usercompany->address ?>" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control select" name="state_bankbranch">
                                        <option selected value="ITALIA"><?= __('Italia') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Province</label>
                                    <select class="select2-icon floating" id="editprovince_<?= $authusersettings->usercompany->id ?>" name="province" onchange="filtercitiesedit(<?= $authusersettings->usercompany->id ?>)">
                                        <option value="NULL">Not Selected</option>
                                        <?php foreach ($cities as $city) : ?>
                                            <?php if ($authusersettings->usercompany->province_bankbranch == $city->province) : ?>
                                                <option selected value="<?= $city->province ?>"><?= $city->province ?></option>
                                            <?php else : ?>
                                                <option value="<?= $city->province ?>"><?= $city->province ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="select2-icon floating" name="city" id="editcompany_city_<?= $authusersettings->usercompany->id ?>">
                                        <?php foreach ($cities as $city) : ?>
                                            <?php if ($authusersettings->usercompany->city == $city->name) : ?>
                                                <option selected value="<?= $city->name ?>"><?= $city->name ?></option>
                                            <?php else : ?>
                                                <option value="NULL">Not Selected</option>
                                                <option value="<?= $city->name ?>"><?= $city->name ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="number" id="editcompany_postalcode_<?= $authusersettings->usercompany->id ?>" name="postalcode" value="<?= $authusersettings->usercompany->postal_code ?>" onkeyup="checkpostalcodeedit(<?= $authusersettings->usercompany->id ?>); return false;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" value="<?= $authusersettings->usercompany->email ?>" type="email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="form-control" value="<?= $authusersettings->usercompany->phone_number ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input class="form-control" value="<?= $authusersettings->usercompany->mobile_number ?>" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Fax</label>
                                    <input class="form-control" value="818-978-7102" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Website Url</label>
                                    <input class="form-control" value="https://www.<?= $authusersettings->usercompany->website ?>." type="text">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                <?php endif; ?>


                <!---Personal Settings------>

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Personal Settings</h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <?php if ($authusersettings->user_id != null) : ?>
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Company Name <span class="text-danger">*</span></label>
                                    <?php if ($authusersettings->usercompany != null) : ?>
                                        <input class="form-control" type="text" value="<?= $authusersettings->usercompany->name ?>">
                                    <?php else : ?>
                                        <input class="form-control" type="text">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Contact Person</label>
                                    <input class="form-control " value="<?= $authusersettings->user->firstname ?> <?= $authusersettings->user->lastname ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input class="form-control " value="<?= $authusersettings->user->address ?>" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control select">
                                        <option selected value="Italy">Italy</option>
                                        <option value="Italy">USA</option>
                                        <option value="Italy">Germani</option>
                                        <option value="Italy">India</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>City</label>
                                    <input class="form-control" value="<?= $authusersettings->user->city ?>" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>State/Province</label>
                                    <select class="form-control select">
                                        <option selected value="Milan">Milan</option>
                                        <option value="Vareze">Vareze</option>
                                        <option value="Rome">Rome</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input class="form-control" value="<?= $authusersettings->user->postal_code ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" value="<?= $authusersettings->user->email ?>" type="email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="form-control" value="<?= $authusersettings->user->phone_number ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input class="form-control" value="<?= $authusersettings->user->mobile_number ?>" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Fax</label>
                                    <input class="form-control" value="818-978-7102" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Website Url</label>
                                    <input class="form-control" value="https://www.<?= $authusersettings->user->website ?>." type="text">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                    <!--Security Settings---

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Security Settings</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <form method="post" action="/settings/updatesecuritysettings">
                        <div class="row">
                            <div class="form-group">
                                <label>Two Factor Authentication</label>
                                <select class="form-control select" name="two_factor_auth">

                                    <?php if ($authusersettings->two_factor_authentication == false) : ?>
                                        <option selected value="0">Disable</option>
                                        <option value="1">Enable</option>
                                    <?php else : ?>
                                        <option value="0">Disable</option>
                                        <option selected value="1">Enable</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->



<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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

    function filtercitiesedit(companyId) {
        $.ajax({
            url: '/cities/filtercities',
            method: 'post',
            dataType: 'json',
            data: {
                'province': $('#editprovince_' + companyId).val(),
                'companyId': companyId
            },
            success: function(data) {

                var htmlCode = "";
                $("#editcompany_city_" + companyId).empty();
                data['cities'].forEach((city) => {

                    if (data['company'].name == city.name) {

                        htmlCode += "<option selected value='" + city.name + "'>" + city.name + " " + "</option>";

                    } else {
                        htmlCode += "<option value='" + city.name + "'>" + city.name + " " + "</option>";

                    }
                });
                $("#editcompany_city_" + companyId).html(htmlCode);

            },
            error: function() {}
        });
    }

    function checkpostalcodeedit(companyId) {

        city = $('#editcompany_city_' + companyId).val();

        $.ajax({
            url: '/cities/checkpostalcode',
            method: 'post',
            dataType: 'json',
            data: {
                'city': city,
                'postalcode': $('#editcompany_postalcode_' + companyId).val()
            },
            success: function(data) {
                $('#editpostalcode_errormessage_' + companyId).empty();
                if (data['RESULT'] == "ERROR") {
                    $('#editpostalcode_errormessage_' + companyId).append(data['MESSAGE']);
                } else {
                    $('#editpostalcode_errormessage_' + companyId).empty();
                }
            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        })
    }
</script>
