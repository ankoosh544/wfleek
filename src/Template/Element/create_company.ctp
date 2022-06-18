 <!-- Create Company -->
 <div id="add_company" class="modal custom-modal fade" role="dialog">
     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Add Company</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">

                 <form method="post" action="/usercompanies/add" enctype="multipart/form-data">

                     <div class="row">
                         <div class="col-sm-6">
                             <div class="form-group ">
                                 <label>Company Name<span class="text-danger">*</span></label>
                                 <input class="form-control" type="text" name="company_name">
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <label>BusinessName<span class="text-danger">*</span></label>
                                 <input class="form-control" type="text" name="businessname">
                             </div>
                         </div>
                     </div>
                     </br>

                     <div class="companyaddress_info">
                         <label>Company Address</label>

                         <div class="form-group">
                             <label> Address<span class="text-danger">*</span></label>
                             <input class="form-control" type="text" name="company_address">
                         </div>

                         <div class="row">
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label>Country</label>
                                     <select class="select2-icon floating" id="country" name="country">
                                         <option selected value="Italy">Italy</option>
                                     </select>
                                 </div>
                             </div>
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label>Province</label>
                                     <select class="select2-icon floating" id="province" name="province" onchange="filtercities(this)">
                                         <?php foreach ($cities as $city) : ?>
                                             <option value="<?= $city->province ?>"><?= $city->province ?></option>
                                         <?php endforeach; ?>
                                     </select>
                                 </div>
                             </div>
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label>City</label>
                                     <select class="select2-icon floating" id="company_city" name="city">
                                         <?php foreach ($defalutcities as $city) : ?>
                                             <option value="<?= $city->name ?>"><?= $city->name ?></option>
                                         <?php endforeach; ?>

                                     </select>
                                 </div>
                             </div>
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label>Postal Code</label>
                                     <input class="form-control" type="number" id="company_postalcode" name="postalcode" onkeyup="checkpostalcode(); return false;">
                                     <span style="color: red;" id="postalcode_errormessage"></span>
                                 </div>
                             </div>

                         </div>

                     </div>

                     <div class="row">
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <label>FISCAL-Code<span class="text-danger">*</span></label>
                                 <input class="form-control" name="fiscal_code" id="fiscal_code" required>
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <label>VAT-Code<span class="text-danger">*</span></label>
                                 <input class="form-control" name="vatcode" id="vatcode" required>
                             </div>
                         </div>
                     </div>

                     <div class="bankinfo">
                         <label>Bank Information</label>
                         <div class="row">
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label>Bank Name</label>
                                     <input class="form-control" type="text" name="bank_name">
                                 </div>
                             </div>
                             <div class="col-sm-6">
                                 <div class="form-group col">
                                     <label>IBAN</label>
                                     <input class="form-control" type="text" name="iban">
                                 </div>
                             </div>
                         </div>
                         </br>

                         <div class="row">
                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label><?= __('Stato Banka') ?><span class="text-danger">*</span></label>
                                     <select class="form-control select" name="country">
                                         <option selected value="ITALIA"><?= __('Italia') ?></option>
                                     </select>
                                 </div>
                             </div>
                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label><?= __('Province') ?><span class="text-danger">*</span></label>
                                     <select class="select2-icon floating" id="bankprovince" name="bankprovince" onchange="filterbankcities()">
                                         <option selected value="null">Not Seleted</option>
                                         <?php foreach ($cities as $city) : ?>
                                             <option value="<?= $city->province ?>"><?= $city->province ?></option>
                                         <?php endforeach; ?>
                                     </select>
                                 </div>
                             </div>
                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label>City of Bank</label>
                                     <select class="select2-icon floating" name="city_bankbranch" id="bank_city">
                                     </select>
                                 </div>
                             </div>

                         </div>
                     </div>
                     <div class="row">
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label>Email<span class="text-danger">*</span></label>
                                 <input class="form-control" type="email" name="email">
                             </div>
                         </div>
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label>Phone Number<span class="text-danger">*</span></label>
                                 <input class="form-control" type="number" name="phonenumber">
                             </div>
                         </div>
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label>Mobile Number</label>
                                 <input class="form-control" type="text" name="mobilenumber">
                             </div>
                         </div>
                     </div>


                     <div class="form-group">
                         <label>Website Link<span class="text-danger">*</span></label>
                         <input class="form-control" type="text" name="weblink">
                     </div>



                     <div class="form-group">
                         <label>Company Description<span class="text-danger">*</span></label>
                         <textarea class="form-control summernote" type="text" name="company_description"></textarea>
                     </div>

                     <div class="form-group">
                         <label>Company Logo<span class="text-danger">*</span></label>
                         <input class="form-control" type="file" name="file">
                     </div>

                     <div class="submit-section">
                         <button class="btn btn-primary submit-btn">Submit</button>
                     </div>
                 </form>



             </div>

         </div>
     </div>
 </div>
 <!------/Create company----------------------------->
