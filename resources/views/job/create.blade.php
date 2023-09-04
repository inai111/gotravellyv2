@extends('layouts.html')

@section('vite') @vite(['resources/js/bundling/create-job.js'])

@section('css-file')
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div>
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-6">
                        <form action="{{ route('job') }}" method="post">
                            <x-form.input.single-text-float input-name="title" label-title="Title"
                                validation="{{ $errors->first('title') }}" value="{{ old('title', '') }}" />
                            <x-form.input.single-text-float input-name="location" label-title="Location"
                                validation="{{ $errors->first('location') }}" value="{{ old('location', '') }}" />
                            <x-form.textarea.float input-name="description" label-title="Description"
                                validation="{{ $errors->first('description') }}" value="{{ old('description', '') }}" />
                            <x-form.input.file-image input-name="logo" label-title="Logo"
                                validation="{{ $errors->first('logo') }}" value="{{ old('logo', '') }}" />
                            <x-form.input.single-text input-name="logo" label-title="Logo"
                                validation="{{ $errors->first('logo') }}" value="{{ old('logo', '') }}"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-lg" id="cropping" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cropping image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="cropper-container mx-auto" style="max-height:500px;max-width:500px">
                        <img src="" alt="picture" style="max-width:100%;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="crop" type="button">Crop</button>
                    <button id="cropReset" type="button">Reset</button>
                </div>
            </div>
        </div>
    </div>
@endsection
