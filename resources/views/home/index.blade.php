@extends('layouts.html')
@section('content')
    <div>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">

                <form class="w-100" role="search">
                    <div>
                        <div class="w-75 mx-auto d-flex align-items-end gap-2">
                            <div class="d-flex flex-fill">
                                <input class="form-control me-2" name="filter[name]" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </div>
                            <button type="button" style="font-size:12px" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"
                                class="btn text-success border-0 pb-0 btn-sm d-flex align-items-center gap-2">
                                Filters
                            </button>
                        </div>
                        <div class="collapse my-2" id="collapseExample">
                            <div class="row">
                                <div class="col-3">
                                    <select class="form-select" name="filter[stateId]" aria-label="Default select example">
                                        <option selected>Pilih by Provinsi</option>
                                        @foreach ($states as $state)
                                            <option value="{{$state['id']}}">{{$state['attributes']['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </nav>
    </div>
    <div>
        <div class="row gx-2">
            @foreach ($dataCities as $city)
                @php
                    $name = $city['attributes']['name'];
                    $desc = 'asdasd';
                @endphp
                <div class="col-4 mb-2">
                    <x-card-cities :$name :$desc />
                </div>
            @endforeach
        </div>
        <div>
            {{ $cities->links() }}
        </div>
    </div>
@endsection
