@props(['color'=>'primary','type'=>'button'])
<button {{$attributes->merge([
    'class'=>"btn shadow btn-{$color}",
    'type'=>$type
])}}>
{{$slot}}
</button>