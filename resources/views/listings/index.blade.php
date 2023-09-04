{{-- @extends('layout');

@section('content') --}}
<x-layout>
    @include('partials._hero')
    @include('partials._search')
    {{-- <h1>{{ $heading }}</h1> --}}

    @unless(count($listings) == 0)

    {{-- @if(count($listings) === 0)
        <p>No Listings</p>
    @endif --}}
    <x-card class="p-24 bg-black">
    @foreach($listings as $listing)
    <x-listing-card :listing="$listing"/>
    {{-- <h2>
        <a href='/listings/{{ $listing['id'] }}'>{{ $listing->title }}</a>
    </h2>
    <h2>
        {{ $listing->company }}
    </h2>
    <h2>
        {{ $listing->location }}
    </h2> --}}
    @endforeach
    </x-card>
    @else
        <p>No Listing Found</p>
    @endunless
    {{-- @endsection --}}
    <div class="mt-6">
      {{$listings->links()}}
    </div>
</x-layout>
