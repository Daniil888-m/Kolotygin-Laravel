@extends('layout')
@section('content')
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">{{ $contacts['name'] }}</h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">{{ $contacts['phone'] }}</h6>
            <p class="card-text">{{ $contacts['address'] }}</p>
            <a href="#" class="card-link">{{ $contacts['email'] }}</a>
            <a href="#" class="card-link">Another link</a>
        </div>
    </div>
@endsection
