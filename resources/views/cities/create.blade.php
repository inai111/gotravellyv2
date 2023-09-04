@extends('layouts.html')
@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    create new city
                </div>
                <div class="card-body">
                    <form method="POST">
                        @method('POST')
                        @csrf
                        <x-form.input.single-text-float input-name="name" label-title="Name"
                            validation="{{ $errors->first('name') }}" value="{{ old('name', '') }}" />
                        <x-form.input.single-text-float input-name="lat" label-title="Latitude"
                            validation="{{ $errors->first('lat') }}" value="{{ old('lat', '') }}" />
                        <x-form.input.single-text-float input-name="lng" label-title="Longtitude"
                            validation="{{ $errors->first('lng') }}" value="{{ old('lng', '') }}" />
                        {{-- @foreach ($optionData as $option)
                                <option value="{{$option['id']}}" 
                                    @selected($value==$option['id'])>
                                    {{$option['name']}}
                                </option>
                            @endforeach --}}
                        {{-- <x-form.select.default validation="{{ $errors->first('continent') }}" input-name="continent"
                            label-title="Continent" value="{{ old('continent', '') }}">
                        </x-form.select.default>
                        <x-form.select.default validation="{{ $errors->first('country') }}" input-name="country"
                            label-title="Country" value="{{ old('country', '') }}">
                        </x-form.select.default>
                        <x-form.select.default validation="{{ $errors->first('state') }}" input-name="state"
                            label-title="State" value="{{ old('state', '') }}">
                        </x-form.select.default> --}}
                        <x-form.button.default type="submit">Simpan</x-form.button.default>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
