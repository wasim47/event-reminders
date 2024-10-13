@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-2"><h3 class="card-title">Event List</h3></div>
                        <div class="col-sm-4 offset-6">
                            <a href="{{ route('event.create') }}" class="btn btn-primary">Add New Event</a>                            
                            <a href="{{ route('export') }}" class="btn btn-info">Export in CSV</a>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#messageModal">Import</button>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-4">    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif              
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> Event ID </th>
                                    <th> Name </th>
                                    <th> Type </th>
                                    <th> Status </th>
                                    <th> Event Time </th>
                                    <th> Created By </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventList as $event)
                                <tr>
                                    <td> {{ $event->event_id }} </td>
                                    <td> {{ $event->name }} </td>
                                    <td> {{ $event->type }} </td>
                                    <td> {{ $event->status == 1 ? 'Active' : 'Inactive' }} </td>
                                    <td> {{ \Carbon\Carbon::parse($event->event_time)->format('M d, Y H:i') }} </td>
                                    <td> {{ optional($event->creator)->name ?? 'N/A' }} </td>
                                    <td>
                                        <a href="{{ route('event.show', $event->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('event.destroy', $event->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Event Bulk Import</h5>
                <button type="button" class="close btn btn-danger btn-sm offset-7" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalMessage" class="alert" role="alert">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('samplefiledownload') }}" class="btn btn-warning">Download Sample File</a>
                        </div>
                        <div class="col-sm-6">
                        <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="importfile">Upload File:</label>
                                <input type="file" name="importfile" id="importfile" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4">Import</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection
