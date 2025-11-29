@extends('layout')
@section('content')
    <div class="warning list-group">
        @if ($errors->any())
            <br>
            <br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                @endforeach

            </ul>
        @endif
    </div>
    <form action="/auth/registr" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Your name</label>
            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
        </div>

        <button type="submit" style="background-color: rgb(25, 135, 84)" class="btn btn-primary">Sign in</button>
    </form>
@endsection
