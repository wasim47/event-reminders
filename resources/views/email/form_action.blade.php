@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="col-md-8 offset-2 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body form-bg">
                        <h4 class="card-title">Recipient Email Form</h4>
                        <p class="card-description">Fill in the details of the email</p>
                        <form class="forms-sample" method="POST" action="{{ isset($email) ? route('email.update', $email->id) : route('email.store') }}">
                            @csrf
                            @if(isset($email))
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
                                <label for="name" class="col-md-4 col-form-label">Email Address</label>
                                <div class="col-md-8">
                                    <input type="email" class="form-control" id="address" name="address" placeholder="Email address" value="{{ old('address', isset($email) ? $email->address : '') }}" required>
                                </div>
                            </div>

                            <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                            @if(isset($email))
                                <input type="hidden" name="updated_by" value="{{ auth()->id() }}">
                            @endif

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('email.index') }}" class="btn btn-dark">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
