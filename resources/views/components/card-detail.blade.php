@props([
    'title'=>'untitled',
    'image'=>"https://media.istockphoto.com/id/500798563/id/foto/city-skyline-at-sunset-jakarta-indonesia.jpg?s=612x612&w=0&k=20&c=dICfiBlbElOeu0UceZMoFpBJ7xJF5bKyriTRZmGXHO4=",
    'description'=>"
        apa ya, pokoknya buat tes aja deh

        apa ya, pokoknya buat tes aja deh

        apa ya, pokoknya buat tes aja deh

        apa ya, pokoknya buat tes aja deh

        apa ya, pokoknya buat tes aja deh

        apa ya, pokoknya buat tes aja deh

        apa ya, pokoknya buat tes aja deh

        apa ya, pokoknya buat tes aja deh

        apa ya, pokoknya buat tes aja deh

        apa ya, pokoknya buat tes aja deh
    ",
    ])

<div class="card">
    <div class="card-header">
        {{$title}}
    </div>
    <div class="card-body" style="height:500px">
        <div class="row h-100">
            <div class="col-4 my-auto">
                <img src="{{$image}}"
                    class="card-img-top" alt="{{ $title }}">
            </div>
            <div class="col-8">
                <p style="text-align:justify">
                    {{$description}}
                </p>
            </div>
        </div>
    </div>
</div>