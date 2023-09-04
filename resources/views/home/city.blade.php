@extends('layouts.html')

@section('content')
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/continent/{{$continent['id']}}">{{ $continent['attributes']['name'] }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/country/{{$country['id']}}">{{ $country['attributes']['name'] }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/state/{{$state['id']}}">{{ $state['attributes']['name'] }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $city['attributes']['name'] }}</li>
            </ol>
        </nav>
    </div>
    <div class="mb-3">
        <div class="row">
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-header">
                        {{ $city['attributes']['name'] }}
                    </div>
                    <div class="card-body" style="height:500px">
                        <div class="row h-100">
                            <div class="col-4 my-auto">
                                <img src="https://media.istockphoto.com/id/500798563/id/foto/city-skyline-at-sunset-jakarta-indonesia.jpg?s=612x612&w=0&k=20&c=dICfiBlbElOeu0UceZMoFpBJ7xJF5bKyriTRZmGXHO4="
                                    class="card-img-top" alt="{{ $city['attributes']['name'] }}">
                            </div>
                            <div class="col-8">
                                <p style="text-align:justify">
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
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-header">
                        Other cities in same state
                    </div>
                    <div class="card-body overflow-scroll" style="height:500px">
                        <ul class="list-group">
                            @foreach ($cities as $cit)
                                <a href="/cities/{{$cit['id']}}" class="list-group-item list-group-item-action @if($city['id']==$cit['id']) active @endif" aria-current="true">
                                    {{ $cit['attributes']['name'] }}
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
