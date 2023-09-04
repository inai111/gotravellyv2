@extends('layouts.html')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">
            <a href="/continent/{{ $continent['id'] }}">{{ $continent['attributes']['name'] }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ $country['attributes']['name'] }}</li>
    </x-breadcrumb>
    <div class="mb-3">
        <div class="row">
            <div class="col-md-8 mb-3">
                <x-card-detail title="{{ $country['attributes']['name'] }}" />
            </div>
            <div class="col-md-3 mb-3">
                <x-card-other-resource>
                    <x-slot:header>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="overflow-hidden">
                                States in this countries
                            </div>
                            <div>
                                <a class="btn btn-sm btn-outline-success"
                                    href="{{route('country.create.state',['country'=>$country['id']])}}">
                                    <i class="fa-solid fa-plus"></i>
                                    State
                                </a>
                            </div>
                        </div>
                    </x-slot>
                    @foreach ($states as $state)
                        <li class="d-flex align-items-center justify-content-between list-group-item">
                            <div>
                                <a href="/states/{{ $state['id'] }}" class="" aria-current="true">
                                    {{ $state['attributes']['name'] }}
                                </a>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" 
                                            href="{{route('state.edit',['state'=>$state['id']])}}">
                                            <i class="fa-solid fa-pen"></i>
                                            Edit
                                        </a></li>
                                    <li>
                                        <form method="POST" action="{{route('state.delete',['state'=>$state['id']])}}">
                                            @csrf
                                            @method('DELETE')
                                            {{-- <input type="hidden" name="state" value="{{$state['id']}}"> --}}
                                            <button type="submit" class="dropdown-item" href="#">
                                            <i class="fa-solid fa-trash-can"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        {{-- <a href="/states/{{ $state['id'] }}" class="list-group-item list-group-item-action"
                            aria-current="true">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    {{ $state['attributes']['name'] }}
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">
                                                <i class="fa-solid fa-pen"></i>
                                            </a></li>
                                        <li><a class="dropdown-item" href="#">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </a> --}}
                    @endforeach
                </x-card-other-resource>
                {{-- <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body overflow-scroll" style="height:500px">
                        <ul class="list-group">
                            @foreach ($cities as $cit)
                                <a href="/cities/{{ $cit['id'] }}"
                                    class="list-group-item list-group-item-action @if ($city['id'] == $cit['id']) active @endif"
                                    aria-current="true">
                                    {{ $cit['attributes']['name'] }}
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
