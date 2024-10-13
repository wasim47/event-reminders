@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="col-md-8 offset-2 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body form-bg">
                        <h4 class="card-title">Event Reminder Form</h4>
                        <p class="card-description">Fill in the details of the event</p>
                        <form class="forms-sample" method="POST" action="{{ isset($event) ? route('event.update', $event->id) : route('event.store') }}">
                            @csrf
                            @if(isset($event))
                                @method('PUT') 
                            @endif

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label">Name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Reminder Name" value="{{ old('name', isset($event) ? $event->name : '') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="type" class="col-md-4 col-form-label">Type</label>
                                <div class="col-md-8">
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="Upcoming" {{ (old('type', isset($event) ? $event->type : '') == 'Upcoming') ? 'selected' : '' }}>Upcoming</option>
                                        <option value="Completed" {{ (old('type', isset($event) ? $event->type : '') == 'Completed') ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="event_id" class="col-md-4 col-form-label">Event Reminder ID</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control" id="event_id" name="event_id" placeholder="Event Reminder ID" value="{{ old('event_id', isset($event) ? $event->event_id : $eventID) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label">Description</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Event Description">{{ old('description', isset($event) ? $event->description : '') }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-md-4 col-form-label">Status</label>
                                <div class="col-md-8">
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="1" {{ ( old('status', isset($event) ? $event->status : '') == 1) ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ ( old('status', isset($event) ? $event->status : '') == 0) ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="event_time" class="col-md-4 col-form-label">Reminder Time</label>
                                <div class="col-md-8">
                                    <input type="datetime-local" class="form-control" id="event_time" name="event_time" value="{{ old('event_time', isset($event) ? $event->event_time->format('Y-m-d\TH:i') : '') }}" required>
                                </div>
                            </div>

                            <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                            @if(isset($event))
                                <input type="hidden" name="updated_by" value="{{ auth()->id() }}">
                            @endif

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('event.index') }}" class="btn btn-dark">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
