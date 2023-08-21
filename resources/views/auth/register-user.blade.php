@extends('layouts.html')

@section('content')
    <div class="row justify-content-center my-3">
        <div class="col-5 p-5 border">
            <h1 class="mb-3">Register</h1>
            <form action="/register" method="post" class="needs-validation" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ old('name', '') }}" class="form-control @error('name') is-invalid @enderror"
                        required>
                    <div class="invalid-feedback">{{ $errors->first('name')??"Please fill the required form" }}</div>
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email', '') }}" class="form-control @error('email') is-invalid @enderror"
                        required>
                    <div class="invalid-feedback">{{ $errors->first('email')??"Please fill the required form" }}</div>
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    <div class="invalid-feedback">{{ $errors->first('password')??"Please fill the required form"}}</div>
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                    <div class="invalid-feedback">{{ $errors->first('password_confirmation')??"Please fill the required form"}}</div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                <a href="/login">ke halaman Login</a>
            </form>
        </div>
    </div>
@endsection
