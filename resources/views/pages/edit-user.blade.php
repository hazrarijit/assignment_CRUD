@extends('template')

@section('title', 'Edit User')

@section('content')
    @if(session()->has('message'))
        <div class="alert {{ session()->get('alert') }}">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">

        <div class="col-6">
            <h2>Edit user form</h2>
            <form action="{{ route('user.update', $user->id) }}" method="post" data-parsley-validate>
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" placeholder="Enter email" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label for="reg_password">Password:</label>
                    <input type="password" class="form-control" id="reg_password" placeholder="Enter password" name="password">
                    <small class="text-info">Alert!! If you change password you need to approve this user again.</small>
                </div>
                <button type="submit" class="btn btn-primary">Update Information</button>
            </form>
        </div>


    </div>
@endsection
