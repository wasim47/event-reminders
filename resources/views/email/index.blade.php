@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-3"><h3 class="card-title">Recipient Email List</h3></div>
                        <div class="col-sm-3 offset-6">
                            <a href="{{ route('email.create') }}" class="btn btn-primary">Add New Email</a>
                            <a href="{{ route('sendmail') }}" onclick="return confirm('Are you sure you want to send email to all recipient?');" class="btn btn-danger">Send Email Now</a>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-4">   
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif                 
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> Recipient Email </th>
                                    <th> Created at </th>
                                    <th> Created By </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emailList as $email)
                                <tr>
                                    <td> {{ $email->address }} </td>
                                    <td> {{ \Carbon\Carbon::parse($email->created_at)->format('M d, Y H:i') }} </td>
                                    <td> {{ optional($email->creator)->name ?? 'N/A' }} </td>
                                    <td>
                                        <a href="{{ route('email.edit', $email->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('email.destroy', $email->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this email?');">
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
@endsection
