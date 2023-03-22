@extends('template')

@section('title', 'Login')

@section('content')
@if(session()->has('message'))
    <div class="alert {{ session()->get('alert') }}">
        {{ session()->get('message') }}
    </div>
@endif
<div class="row">
    <div class="col-6">
        <h2>Login form</h2>
        <form action="{{ route('login') }}" method="post" data-parsley-validate>
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
            </div>
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Login Now</button>
        </form>
    </div>

    <div class="col-6">
        <h2>Registration form</h2>
        <form action="{{ route('registration') }}" method="post" data-parsley-validate>
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Enter name" name="name" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" placeholder="Enter email" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="reg_password">Password:</label>
                <input type="password" class="form-control" id="reg_password" placeholder="Enter password" name="password" required>
            </div>

            <div class="form-group">
                <label for="conform_password">Confirm Password:</label>
                <input type="password" class="form-control" id="conform_password" placeholder="Re-enter password" name="conform_password" data-parsley-equalto="#reg_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register Now</button>
        </form>
    </div>


</div>
@endsection
