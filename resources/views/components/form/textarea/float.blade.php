@props(['labelTitle'=>'title', 'inputName'=>'title', 'validation'=>'', 'value'=>''])

<div class="mb-3 form-floating">
    <textarea placeholder="{{$labelTitle}}" name="{{$inputName}}" id="{{$inputName}}"
     @class(['form-control', 'is-invalid' => $validation]) rows="10" required>
        {{$value}}
    </textarea>
    <label for="{{ $inputName }}" class="form-label">{{ $labelTitle }}</label>
    <div class="valid-feedback">
        {{ $validation ?? 'This field is required' }}
    </div>
</div>
