@extends('layouts.master')
@section('title', 'Calendar')
@section('main-container')
    @include('layouts.badge')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Calendar</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Calendar</a></li>
                                <li class="breadcrumb-item active">Events & Holidays</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.badge')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Events & Holidays Calendar</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('school-admin.event.create') }}" class="btn btn-success btn-sm">
                                    <i class="ri-add-line align-middle me-1"></i> Add Event
                                </a>
                                <a href="{{ route('school-admin.holiday.create') }}" class="btn btn-primary btn-sm">
                                    <i class="ri-add-line align-middle me-1"></i> Add Holiday
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event/Holiday Details Modal -->
    <div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="eventDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" id="eventDetailsLink" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- <a href="#"  class="btn btn-primary">View Details</a> --}}
                </div>
            </div>
        </div>
    </div>

    @push('stylesheet')
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" type="text/css" />
        <style>
            #calendar {
                max-width: 100%;
                margin: 0 auto;
            }

            .fc-event {
                cursor: pointer;
            }

            .event-details p {
                margin-bottom: 0.5rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    events: function(fetchInfo, successCallback, failureCallback) {
                        fetch('{{ route('school-admin.calendar.events') }}?start=' + fetchInfo.startStr +
                                '&end=' + fetchInfo.endStr)
                            .then(response => response.json())
                            .then(data => {
                                successCallback(data);
                            })
                            .catch(error => {
                                failureCallback(error);
                            });
                    },
                    eventClick: function(info) {
                        const event = info.event;
                        const extendedProps = event.extendedProps;

                        let content = '<div class="event-details">';
                        content += '<h6 class="mb-3">' + event.title + '</h6>';

                        if (extendedProps.type === 'event') {
                            content +=
                                '<p class="mb-2"><strong>Type:</strong> <span class="badge bg-success">Event</span></p>';
                            if (extendedProps.description) {
                                content += '<p class="mb-2"><strong>Description:</strong> ' + (extendedProps
                                    .description || 'N/A') + '</p>';
                            }
                            if (extendedProps.location) {
                                content += '<p class="mb-2"><strong>Location:</strong> ' + extendedProps
                                    .location + '</p>';
                            }
                            if (extendedProps.start_time) {
                                content += '<p class="mb-2"><strong>Start Time:</strong> ' + extendedProps
                                    .start_time + '</p>';
                            }
                            if (extendedProps.end_time) {
                                content += '<p class="mb-2"><strong>End Time:</strong> ' + extendedProps
                                    .end_time + '</p>';
                            }
                            content += '<p class="mb-2"><strong>Start Date:</strong> ' + event.start
                                .toLocaleDateString() + '</p>';
                            if (event.end) {
                                content += '<p class="mb-2"><strong>End Date:</strong> ' + event.end
                                    .toLocaleDateString() + '</p>';
                            }
                        } else if (extendedProps.type === 'holiday') {
                            content +=
                                '<p class="mb-2"><strong>Type:</strong> <span class="badge bg-danger">Holiday</span></p>';
                            if (extendedProps.description) {
                                content += '<p class="mb-2"><strong>Description:</strong> ' + (extendedProps
                                    .description || 'N/A') + '</p>';
                            }
                            content += '<p class="mb-2"><strong>Date:</strong> ' + event.start
                                .toLocaleDateString() + '</p>';
                        }

                        content += '</div>';

                        document.getElementById('eventDetailsContent').innerHTML = content;
                        document.getElementById('eventDetailsLink').href = extendedProps.url;

                        const modal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
                        modal.show();
                    },
                    eventDisplay: 'block',
                    height: 'auto',
                    dayMaxEvents: true,
                    moreLinkClick: 'popover'
                });

                calendar.render();
            });
        </script>
    @endpush

@endsection
