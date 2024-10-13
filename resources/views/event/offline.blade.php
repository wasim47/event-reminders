@extends('layouts.app')

@section('content')
<script>
    // Form submission handler
    function handleFormSubmit(e) {
        e.preventDefault();

        const event = {
            event_id: document.getElementById('event_id').value,
            name: document.getElementById('name').value,
            type: document.getElementById('type').value,
            status: document.getElementById('status').value,
            description: document.getElementById('description').value,
            event_time: document.getElementById('eventTime').value
        };

        // Check if online or offline
        if (navigator.onLine) {
            // Online, send data to the server
            syncWithServer(event);
        } else {
            // Offline, store data locally
            addEventOffline(event);
        }

        generateNewEventId();
    }

    function generateNewEventId() {
        const year = new Date().getFullYear();  // Get current year
        const randomNumber = String(Math.floor(Math.random() * 999) + 1).padStart(3, '0');  // Generate a random number between 1 and 999, and pad with 0 if necessary

        const eventId = `REM-${year}-${randomNumber}`;  // Combine year and random number into the ID
        document.getElementById('event_id').value = eventId;
    }

    window.onload = function() {
        generateNewEventId();
    };
</script>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="col-md-8 offset-2 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body form-bg">
                        <h4 class="card-title">Event Reminder Form</h4>
                        <p class="card-description">Fill in the details of the event</p>

                        <form id="eventForm" onsubmit="handleFormSubmit(event)">
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label">Name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Reminder Name" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="type" class="col-md-4 col-form-label">Type</label>
                                <div class="col-md-8">
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="Upcoming">Upcoming</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="event_id" class="col-md-4 col-form-label">Event Reminder ID</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control" id="event_id" name="event_id" placeholder="Event Reminder ID" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label">Description</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Event Description"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-md-4 col-form-label">Status</label>
                                <div class="col-md-8">
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="event_time" class="col-md-4 col-form-label">Reminder Time</label>
                                <div class="col-md-8">
                                    <input type="datetime-local" class="form-control" id="eventTime" name="event_time" value="{{ old('event_time', isset($event) ? $event->event_time->format('Y-m-d\TH:i') : '') }}" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit"  class="btn btn-primary">Save Event</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection