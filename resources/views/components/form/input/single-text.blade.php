@props(['labelTitle'=>'title', 'inputName'=>'title', 'validation'=>'', 'value'=>''])

<div class="mb-3">
    <label for="{{ $inputName }}" class="form-label">{{ $labelTitle }}</label>
    <input type="text" @class(['form-control', 'is-invalid' => $validation]) id="{{ $inputName }}" value="{{ $value }}" required>
    <div class="valid-feedback">
        {{ $validation ?? 'This field is required' }}
    </div>
</div>
