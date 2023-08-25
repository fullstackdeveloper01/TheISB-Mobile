<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('backend.includes.head')
    @include('backend.includes.styles')
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" /> 
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" /> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>

<body>
    @include('backend.includes.sidebar')
    <div class="vironeer-page-content">
        @include('backend.includes.header')
        <div class="container @yield('container')">
            <div class="vironeer-page-body px-1 px-sm-2 px-xxl-0">
                <div class="py-4 g-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-lg">
                            @include('backend.includes.breadcrumb')
                        </div>
                        <div class="col-12 col-lg-auto">
                            @hasSection('back')
                                <a href="@yield('back')" class="btn btn-secondary me-2"><i
                                        class="fas fa-arrow-left me-2"></i>{{ __('Back') }}</a>
                            @endif
                            @hasSection('language')
                                <div class="dropdown d-inline me-2">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-globe me-2"></i>{{ $active }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        @foreach ($adminLanguages as $adminLanguage)
                                            <li><a class="dropdown-item @if ($adminLanguage->name == $active) active @endif"
                                                    href="?lang={{ $adminLanguage->code }}">{{ $adminLanguage->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @hasSection('link')
                                <a href="@yield('link')" class="btn btn-primary me-2"><i
                                        class="fa fa-plus"></i></a>
                            @endif
                            @hasSection('modal')
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                    data-bs-target="#viewModal">
                                    @yield('modal')
                                </button>
                            @endif
                            @hasSection('add_modal')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            @endif
                            @if (request()->routeIs('admin.advertisements.index'))
                                <a href="{{ route('admin.advertisements.edit', $headAd->id) }}"
                                    class="btn btn-blue"><i class="fa fa-code me-2"></i>{{ __('Head Code') }}</a>
                            @endif
                            @if (request()->routeIs('admin.transactions.edit'))
                                @if ($transaction->status != 3)
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#cancelTransaction"><i
                                            class="far fa-times-circle me-2"></i>{{ __('Cancel Transaction') }}</button>
                                @endif
                            @endif
                            @if (request()->routeIs('admin.transfers.users.edit') || request()->routeIs('admin.transfers.guests.edit'))
                                @if ($transfer->status && !isExpiry($transfer->expiry_at))
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#cancelTransfer"><i
                                            class="far fa-times-circle me-2"></i>{{ __('Cancel Transfer') }}</button>
                                @endif
                            @endif
                            @if (request()->routeIs('admin.notifications.index'))
                                <a class="vironeer-link-confirm btn btn-outline-success me-2"
                                    href="{{ route('admin.notifications.readall') }}">{{ __('Make All as Read') }}</a>
                                <form class="d-inline"
                                    action="{{ route('admin.notifications.deleteallread') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="vironeer-able-to-delete btn btn-outline-danger">
                                        {{ __('Delete All Read') }}</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row g-3 g-xl-3">
                    <div class="col">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @include('backend.includes.footer')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.min.js') }}"></script>

    <script type="text/javascript">
        "use strict";
        const BASE_URL = "{{ url('/admin') }}";
        const PRIMARY_COLOR = "{{ $settings['website_primary_color'] }}";
        const SECONDARY_COLOR = "{{ $settings['website_secondary_color'] }}";
    </script>  
    <script type="text/javascript">
  
        $(document).ready(function () {
          
    /*------------------------------------------
    --------------------------------------------
    CSRF Token Setup
    --------------------------------------------
    --------------------------------------------*/
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
    /*------------------------------------------
    --------------------------------------------
    FullCalender JS Code
    --------------------------------------------
    --------------------------------------------*/
    var calendar = $('#calendar').fullCalendar({
                    editable: true,
                    events: BASE_URL + "/timeTable",
                    displayEventTime: false,
                    editable: true,
                    eventRender: function (event, element, view) {
                        if (event.allDay === 'true') {
                            event.allDay = true;
                        } else {
                            event.allDay = false;
                        }
                    },
                    selectable: true,
                    selectHelper: true,
                    select: function (start, end, allDay) {
                        $('#timeTableModal').modal('show');
                        var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                        $('#start').val(start);
                        $('.selected_date').text(start);
                        $('#end').val(end);
                        $('#allDay').val(allDay);
                        //$("#student_class").empty();
                        $('#student_class').select2('destroy');
                        setTimeout($("#student_class").select2(), 200);                        
                        
                       // console.log(allDay);
                        /*
                        var title = prompt('Time Table Title:');
                        if (title) {
                            var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                            var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                            $.ajax({
                                url: BASE_URL + "/timeTableAjax",
                                data: {
                                    title: title,
                                    start: start,
                                    end: end,
                                    type: 'add'
                                },
                                type: "POST",
                                success: function (data) {
                                    displayMessage("Time Table Created Successfully");
  
                                    calendar.fullCalendar('renderEvent',
                                        {
                                            id: data.id,
                                            title: title,
                                            start: start,
                                            end: end,
                                            allDay: allDay
                                        },true);
  
                                    calendar.fullCalendar('unselect');
                                }
                            });
                        }*/
                    },
                    eventDrop: function (event, delta) {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                        console.log('event', event)
                        $.ajax({
                            url: BASE_URL + '/timeTableAjax',
                            data: {
                                title: event.title,
                                student_class: event.student_class,
                                description: event.description,
                                start: start,
                                end: end,
                                id: event.id,
                                type: 'update'
                            },
                            type: "POST",
                            success: function (response) {
                                displayMessage("Time Table Updated Successfully");
                            }
                        });
                    },
                    eventClick: function (event) {
                        var deleteMsg = confirm("Do you really want to delete?");
                        if (deleteMsg) {
                            $.ajax({
                                type: "POST",
                                url: BASE_URL + '/timeTableAjax',
                                data: {
                                        id: event.id,
                                        type: 'delete'
                                },
                                success: function (response) {
                                    calendar.fullCalendar('removeEvents', event.id);
                                    displayMessage("Time Table Deleted Successfully");
                                }
                            });
                        }
                    }
 
                });
 
    });
      
    /*------------------------------------------
        --------------------------------------------
        Toastr Success Code
        --------------------------------------------
        --------------------------------------------*/
    function saveTimeTableData(){
        var calendar = $('#calendar').fullCalendar();
        var title = $('#title').val();
        var student_class = $('#student_class').val();
        var description = $('#description').val();
        var start = $('#start').val();
        var end = $('#end').val();
        var allDay = $('#allDay').val(); 
        var campus = jQuery('#campus').val();
        var shift = jQuery('#shift').val();
        var class_id = jQuery('#class_id').val();
        var section = jQuery('#section').val();
        var student_id = jQuery('#student_id').val();

        var student_class_id = '';
        var student_class_text = $('#student_class option:selected')
                .toArray().map(item => item.text).join();
console.log(student_class_text);
        $.ajax({
            url: BASE_URL + "/timeTableAjax",
            data: {
                title: title,
                student_class: student_class_text,
                description: description,
                start: start,
                end: end,
                campus: campus,
                shift: shift,
                class_id: class_id,
                section: section,
                student_id: student_id,
                type: 'add'
            },
            type: "POST",
            success: function (data) {
                displayMessage("Time Table Created Successfully");

                calendar.fullCalendar('renderEvent',
                    {

                        id: data.id,
                        title: 'Title:'+title+', '+student_class_text,
                        start: start,
                        end: end,
                        allDay: allDay
                    },true);

                calendar.fullCalendar('unselect');
                $("#timeTableModal").modal("toggle");
            }
        });
    }

        /*------------------------------------------
        --------------------------------------------
        Toastr Success Code
        --------------------------------------------
        --------------------------------------------*/
        function displayMessage(message) {
            toastr.success(message, 'Time Table');
        } 
        

        $('#timeTableModal').on('hidden.bs.modal', function (e) {
          $(this)
            .find("input,textarea,select")
               .val('')
               .end()
            .find("input[type=checkbox], input[type=radio]")
               .prop("checked", "")
               .end();
        })
    </script>
    @stack('scripts')
</body>

</html>
