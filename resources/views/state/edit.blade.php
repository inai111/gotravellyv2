@extends('layouts.html')
@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    edit State
                </div>
                <div class="card-body">
                    <form method="POST">
                        @method("PUT")
                        @csrf
                        <x-form.input.single-text-float input-name="name" label-title="Name"
                            validation="{{ $errors->first('name') }}" value="{{ old('name', $state['name']) }}" />
                        <x-form.button.default type="submit">Update</x-form.button.default>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
