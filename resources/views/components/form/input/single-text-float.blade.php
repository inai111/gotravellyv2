@props(['labelTitle' => 'title', 'inputName' => 'title', 'validation' => '', 'value' => ''])

<div class="mb-3">
    <div class="form-floating">
        <input placeholder="{{ $inputName }}" name="{{ $inputName }}" type="text" @class(['form-control', 'is-invalid' => $validation])
            id="{{ $inputName }}" value="{{ $value }}" required>
        <label for="{{ $inputName }}" class="form-label">{{ $labelTitle }}</label>
        <div class="invalid-feedback">
            {{ $validation ?? 'This field is required' }}
        </div>
    </div>
</div>
