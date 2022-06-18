<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event[]|\Cake\Collection\CollectionInterface $events
 */
?>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Events</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Events</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_event"><i class="fa fa-plus"></i> Add Event</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <!-- Calendar -->
                                <div id="calendar"></div>
                                <!-- /Calendar -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add Event Modal -->
    <div id="add_event" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/events/addevent">
                        <div class="form-group">
                            <label>Event Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="name" type="text" required>
                        </div>
                        <div class="form-group">
                            <label>Event Start Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="eventstartdate" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Event End Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="eventenddate" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <select class="select form-control" name="category">
                                <option>Danger</option>
                                <option>Success</option>
                                <option>Purple</option>
                                <option>Primary</option>
                                <option>Pink</option>
                                <option>Info</option>
                                <option>Inverse</option>
                                <option>Orange</option>
                                <option>Brown</option>
                                <option>Teal</option>
                                <option>Warning</option>
                            </select>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Event Modal -->

    <!-- Event Modal -->
    <div class="modal custom-modal fade" id="event-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-success submit-btn save-event">Create event</button>
                    <button type="button" class="btn btn-danger submit-btn delete-event" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Event Modal -->

    <!-- Add Category Modal-->
    <div class="modal custom-modal fade" id="add-category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Event</h4>
                </div>
                <div class="modal-body p-20">
                    <!--  <form method="post" action="/events/addevent"> -->
                    <div class="form-group">
                        <label class="col-form-label">Category Name</label>
                        <input class="form-control" placeholder="Enter name" name="name" id="eventname" type="text" name="category-name">
                    </div>

                    <div class="form-group">
                        <label>Event Date <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control" id="dateclick" name="startdate" type="text">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Choose Category Color</label>
                            <select class="form-control" data-placeholder="Choose a color..." name="category-color" id="category">
                                <option value="success">Success</option>
                                <option value="danger">Danger</option>
                                <option value="info">Info</option>
                                <option value="pink">Pink</option>
                                <option value="primary">Primary</option>
                                <option value="warning">Warning</option>
                                <option value="orange">Orange</option>
                                <option value="brown">Brown</option>
                                <option value="teal">Teal</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button onclick="addevent()" class="btn btn-danger save-category" data-dismiss="modal">Save</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- /Add Category Modal-->

</div>
<!-- /Page Wrapper -->
<!-- Calendar CSS -->

<!-- Calendar JS -->

<script>

    document.addEventListener('DOMContentLoaded', function() {

        $.ajax({
            url: '/events/getevents/',
            /*    method: 'post', */
            dataType: 'json',
            /*  cache: false,
             contentType: false,
             processData: false,
             data: form_data, */
            success: function(data) {
                console.log(data, 'data');
                let eventArr = [];
                data.forEach((item) => {
                    const itemObj = {};
                    itemObj.title = item.event_name;
                    itemObj.start = item.event_startdate;
                    itemObj.end = item.event_enddate;
                    eventArr.push(itemObj);
                });
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    dateClick: function(info) {
                        // alert('clicked ' + info.dateStr);
                        $('#dateclick').val(info.dateStr);
                        $('#add-category').modal('show');


                    },
                    events: eventArr,
                });
                calendar.render();
            },
            error: function(e) {
                console.log(e);
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                });
                calendar.render();
            }
        });




        /*    var date = new Date();
           var d = date.getDate();
           var m = date.getMonth();
           var y = date.getFullYear();
           $('#calendar').fullCalendar({
               header: {
                   left: 'prev, next today',
                   center: 'title',
                   right: 'month, basicWeek, basicDay'
               },
               //events: "Calendar.asmx/EventList",
               //defaultView: 'dayView',
               events: [{
                       title: 'Event Name 4',
                       start: new Date($.now() + 148000000),
                       className: 'bg-purple'
                   },
                   {
                       title: 'Test Event 1',
                       start: today,
                       end: today,
                       className: 'bg-success'
                   },
                   {
                       title: 'Test Event 2',
                       start: new Date($.now() + 168000000),
                       className: 'bg-info'
                   },
                   {
                       title: 'Test Event 3',
                       start: new Date($.now() + 338000000),
                       className: 'bg-primary'
                   }],
               eventRender: function(event, element) {
                   element.qtip({
                       content: event.title + '<br />' + event.start,
                       style: {
                           background: 'black',
                           color: '#FFFFFF'
                       },
                       position: {
                           corner: {
                               target: 'center',
                               tooltip: 'bottomMiddle'
                           }
                       }
                   });
               }
           }); */
    });


    function addevent() {

        var name = $('#eventname').val();
        var date = $('#dateclick').val();
        var category = $('#category').val();

        console.log('function', name, date, category);


        $.ajax({
            url: '/events/addsingleevent',
            method: 'post',
            dataType: 'json',
            data: {
                'name': name,
                'date': date,
                'category': category
            },
            success: function(data) {
                window.location = '/events/index';

            },
            error: function(e) {

            }
        });



    }
</script>
