@extends('frontend.layouts.app')

@section('content')
  <!-- Order Trcking Banner Section Start -->
  <div class="wishlist-banner">
    <div class="container">
      <div class="row">
        <div class="wishlist-banner-img">
          <h2><span>ORDER TRACKING</span></h2>
          <ul>
            <li><a href="#">Home</a></li>
            <li><i class="fas fa-arrows-alt-h"></i></li>
            <li><a href="#">Order Tracking</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Order Trcking Banner Section End -->


  <!-- Order Tracking Page Content Section Start -->
  <div class="ordertracking-page-content">
    <div class="container">
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <p>To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
          <form class="" action="{{ route('orders.track') }}" method="GET" enctype="multipart/form-data">
            <div class="form-group">
              <label for="orderId">Order Code</label>
              <input type="text" class="form-control mb-3" placeholder="{{ translate('Order Code')}}" name="order_code" required>
            </div>
            <div class="form-group order-btn">
              <button type="submit" class="btn btn-primary">Track</button>
            </div>
          </form>
        </div>
        <div class="col-md-3"></div>
      </div>
    </div>
  </div>
  <!-- Order Tracking Page Content Section End -->
  @isset($order)
  <div class="bg-white rounded shadow-sm mt-5">
      <div class="fs-15 fw-600 p-3 border-bottom">
          {{ translate('Order Summary')}}
      </div>
      <div class="p-3">
          <div class="row">
              <div class="col-lg-6">
                  <table class="table table-borderless">
                      <tr>
                          <td class="w-50 fw-600">{{ translate('Order Code')}}:</td>
                          <td>{{ $order->code }}</td>
                      </tr>
                      <tr>
                          <td class="w-50 fw-600">{{ translate('Customer')}}:</td>
                          <td>{{ json_decode($order->shipping_address)->name }}</td>
                      </tr>
                      <tr>
                          <td class="w-50 fw-600">{{ translate('Email')}}:</td>
                          @if ($order->user_id != null)
                              <td>{{ $order->user->email }}</td>
                          @endif
                      </tr>
                      <tr>
                          <td class="w-50 fw-600">{{ translate('Shipping address')}}:</td>
                          <td>{{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, {{ json_decode($order->shipping_address)->country }}</td>
                      </tr>
                  </table>
              </div>
              <div class="col-lg-6">
                  <table class="table table-borderless">
                      <tr>
                          <td class="w-50 fw-600">{{ translate('Order date')}}:</td>
                          <td>{{ date('d-m-Y H:i A', $order->date) }}</td>
                      </tr>
                      <tr>
                          <td class="w-50 fw-600">{{ translate('Total order amount')}}:</td>
                          <td>{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')) }}</td>
                      </tr>
                      <tr>
                          <td class="w-50 fw-600">{{ translate('Shipping method')}}:</td>
                          <td>{{ translate('Flat shipping rate')}}</td>
                      </tr>
                      <tr>
                          <td class="w-50 fw-600">{{ translate('Payment method')}}:</td>
                          <td>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                      </tr>
                  </table>
              </div>
          </div>
      </div>
  </div>


  @foreach ($order->orderDetails as $key => $orderDetail)
      @php
          $status = $orderDetail->delivery_status;
      @endphp
      <div class="bg-white rounded shadow-sm mt-4">
          <div class="p-4">
              <ul class="list-inline text-center aiz-steps">
                  <li class="list-inline-item @if($status == 'pending') active @else done @endif">
                      <div class="icon">
                          <i class="las la-file-invoice"></i>
                      </div>
                      <div class="title">{{ translate('Order placed')}}</div>
                  </li>
                  <li class="list-inline-item @if($status == 'confirmed') active @elseif($status == 'on_delivery' || $status == 'delivered') done @endif">
                      <div class="icon">
                          <i class="las la-newspaper"></i>
                      </div>
                      <div class="title">{{ translate('Confirmed')}}</div>
                  </li>
                  <li class="list-inline-item @if($status == 'on_delivery') active @elseif($status == 'delivered') done @endif">
                      <div class="icon">
                          <i class="las la-truck"></i>
                      </div>
                      <div class="title">{{ translate('On delivery')}}</div>
                  </li>
                  <li class="list-inline-item @if($status == 'delivered') done @endif">
                      <div class="icon">
                          <i class="las la-clipboard-check"></i>
                      </div>
                      <div class="title">{{ translate('Delivered')}}</div>
                  </li>
              </ul>
          </div>
          @if($orderDetail->product != null)
          <div class="p-3">
              <table class="table">
                  <thead>
                      <tr>
                          <th>{{ translate('Product Name')}}</th>
                          <th>{{ translate('Quantity')}}</th>
                          <th>{{ translate('Shipped By')}}</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                      <td>{{ $orderDetail->product->getTranslation('name') }} ({{ $orderDetail->variation }})</td>
                          <td>{{ $orderDetail->quantity }}</td>
                          <td>{{ $orderDetail->product->user->name }}</td>
                      </tr>
                  </tbody>
              </table>
          </div>
          @endif
      </div>
  @endforeach

@endisset

@endsection
