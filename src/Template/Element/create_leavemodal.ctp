 <!-- Add Leave Modal -->
 <div id="add_leave" class="modal custom-modal fade" role="dialog">
     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Add Leave</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form method="post" action="/leaves/addleave">
                     <div class="form-group form-focus select-focus">
                         <label class="focus-label">Leave Type <span class="text-danger">*</span></label>
                         <select class="select2-icon floating" id="addleavetype" name="leavetype" onchange="changeLeaveTypeadd(); return false;" required>
                             <option>Select Leave Type</option>
                             <option value="C">Casual Leave 12 Days</option>
                             <option value="M">Medical Leave</option>
                             <option value="L">Loss of Pay</option>
                         </select>
                     </div>

                     <div class="form-group" id="addmedicalno" style="display: none;">
                         <label for="medicalno"><?= __('Enter Medical Number') ?><span class="text-danger">*</span></label>
                         <input class="form-control" type="text" id="medicalnonumber" name="medicalno">
                     </div>


                     <div class="form-group">
                         <label>From <span class="text-danger">*</span></label>
                         <div class="cal-icon" id="addfromdateerrormsg">
                             <input name="fromdate" id="add_fromdate" class="datetimepicker form-control" type="text" required>
                         </div>
                     </div>
                     <div class="form-group">
                         <label>To <span class="text-danger">*</span></label>
                         <div class="cal-icon" id="addtodateerrormsg">
                             <input name="todate" id="add_todate" class="datetimepicker form-control" type="text" required>
                         </div>
                     </div>
                     <div class="form-group">
                         <label>Number of days <span class="text-danger">*</span></label>
                         <input class="form-control ndays" type="text">
                     </div>
                     <div class="form-group">
                         <label>Remaining Leaves <span class="text-danger">*</span></label>
                         <input class="form-control" readonly value="12" type="text">
                     </div>
                     <div class="form-group">
                         <label>Leave Reason <span class="text-danger">*</span></label>
                         <textarea name="leavereason" rows="4" class="form-control summernote" required></textarea>
                     </div>
                     <div class="submit-section">
                         <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /Add Leave Modal -->

 <script type="text/javascript">
     $(function() {

         $(document).ready(function() {

             $("#add_fromdate").datetimepicker().on('dp.change', function() {
                 $('#fromdate_errormsg').remove();
                 var splittedDate = $('#add_fromdate').val().split("/");

                 var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                 var fromdate = moment(dateToString).format("YYYY-MM-DD");
                 var todaydate = moment().format("YYYY-MM-DD");

                 if (fromdate < todaydate) {
                     $('#addfromdateerrormsg').append('<p id="fromdate_errormsg" style="color:red;"class="message">Fromdate Should be Equal or Greater than Current Date</p>');
                 }
                 myfunc();


             });

             $("#add_todate").datetimepicker().on('dp.change', function() {
                 $('#todate_errormsg').remove();
                 var splittedDate = $('#add_todate').val().split("/");
                 var splittedfromdate = $('#add_fromdate').val().split("/");

                 var fromdatedateToString = splittedfromdate[2] + "-" + splittedfromdate[1] + "-" + splittedfromdate[0];
                 var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];



                 var fromdate = moment(fromdatedateToString).format("YYYY-MM-DD");
                 var todate = moment(dateToString).format("YYYY-MM-DD");

                 if (todate <=  fromdate) {

                     $('#addtodateerrormsg').append('<p id="todate_errormsg" style="color:red;"class="message">Expiry Date Greather than From Date</p>');

                 }
                 myfunc();


             });


             $("#add_fromdate").datetimepicker({
                 dateFormat: "dd/mm/yy"
             }).val();

             $("#add_todate").datetimepicker().on('dp.change', function() {
                 console.log("sucess")
                 myfunc();


             });



         });
         var totaldays = 0;

         function myfunc() {
             var start = $("#add_fromdate").datetimepicker("viewDate");
             var end = $("#add_todate").datetimepicker("viewDate");
             days = (end - start) / (1000 * 60 * 60 * 24);
             totaldays = Math.round(days);
             $(".ndays").html(totaldays);
         }
     });
 </script>
