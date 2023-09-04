@extends('layouts.html')
@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    create new State
                </div>
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <x-form.input.single-text-float input-name="name" label-title="Name"
                            validation="{{ $errors->first('name') }}" value="{{ old('name', '') }}" />
                        <x-form.button.default type="submit">Simpan</x-form.button.default>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
