@extends('layouts.html')

@section('content')
    <div class="row justify-content-center my-3">
        <div class="col-5 p-5 border">
            <h1 class="mb-3">Login</h1>
            <form action="/login" method="post" class="needs-validation" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="text" name="email" value="{{ old('email', '') }}" class="form-control @error('email') is-invalid @enderror"
                        required>
                    <div class="invalid-feedback">{{ $errors->first('email')??"Please fill the required form" }}</div>
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    <div class="invalid-feedback">{{ $errors->first('password')??"Please fill the required form"}}</div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
