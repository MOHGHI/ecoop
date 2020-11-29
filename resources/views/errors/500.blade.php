@extends('frontend.layouts.app')

@section('content')
<!-- 500 Page Start -->
<div class="error-page">
    <div class="container">
      <div class="row">
        <div class="error-page-content">
          <img src="{{static_asset('assets/image/404.jpg')}}">
          <h2>{{ translate("Something went wrong!") }}</h2>
          <p>{{ translate("Sorry for the inconvenience, but we're working on it.") }} <br> {{ translate("Error code") }}: 500</p>
          <button class="btn btn-primary">Go Back</button>
        </div>
      </div>
    </div>
  </div>
  <!-- 500 Page End -->
@endsection
