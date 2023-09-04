@props(['optionData','inputName','labelTitle','validation','value'])

<div class="border px-2 py-1 mb-3">
    <label for="{{$inputName}}">{{$labelTitle}}</label>
    <select @disabled(empty($optionData)) class="form-select mb-3" required name="{{$inputName}}" id="{{$inputName}}">
        <option selected readonly>Select {{$labelTitle}}</option>
        {{$slot}}
    </select>
    @isset($validation)
    <div class="invalid-feedback">
        {{$validation??"Required field"}}
    </div>
    @endisset
</div>
