@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Event Details</h4>
                    <p class="card-description">Details of the selected event</p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $event->name }}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>{{ $event->type }}</td>
                                </tr>
                                <tr>
                                    <th>Event ID</th>
                                    <td>{{ $event->event_id }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $event->description }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $event->status == 1 ? 'Active' : 'Inactive' }}</td>
                                </tr>
                                <tr>
                                    <th>Event Time</th>
                                    <td>{{ $event->event_time->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Created By</th>
                                    <td>{{ $event->creator->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Updated By</th>
                                    <td>{{ $event->updater->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Deleted By</th>
                                    <td>{{ $event->deleter->name ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('event.index') }}" class="btn btn-secondary">Back to Event List</a>
                        <div>
                            <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
