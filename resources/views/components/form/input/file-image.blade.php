@props(['labelTitle' => 'title', 'inputName' => 'title', 'validation' => '', 'value' => ''])

<div>
    <div class="row mb-3">
        <div class="col-5">
            <div class="dropzone" style="border:2px dashed rgba(170, 170, 170, 0.767)">
            </div>
        </div>
        <div class="col-7">
            <label for="{{ $inputName }}">{{ $labelTitle }}</label>
            <input type="hidden" id="{{ $inputName }}" name="{{$inputName}}" value="{{ $value }}" required>
            <p style="font-size:12px;text-align: justify;">
                Lorem ipsum dolor sit amet consectetur
                adipisicing elit. Sunt tempore quasi
                temporibus, eum quidem autem earum labore aut
                eaque maiores dolorum ipsum qui ullam
                laborum perferendis ut vel vero explicabo?
            </p>
            <div class="valid-feedback">
                {{ $validation ?? 'This field is required' }}
            </div>
        </div>
    </div>
</div>
