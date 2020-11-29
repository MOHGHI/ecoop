@extends('frontend.layouts.app')

@section('content')
<div class="error-page">
    <div class="container">
      <div class="row">
        <div class="error-page-content">
          <img src="{{static_asset('assets/image/404.jpg')}}">
          <h2>Mr. Flower is sleeping !! Try reloading the page.</h2>
          <p>The page you are looking for does not exist!</p>
          <button class="btn btn-primary">Go Back</button>
        </div>
      </div>
    </div>
  </div>
@endsection
