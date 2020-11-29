@extends('frontend.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:price:currency" content="{{ \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

@section('content')
      <!-- Product Details Page Start -->
  <div class="product-page">
    <div class="container">
      <div class="wrapper row">
        <div class="preview col-md-7">
          <div class="row">
            @php
            $photos = explode(',',$detailedProduct->photos);
            $active = 'active';
        @endphp
            <div class="col-md-2">
              <ul class="preview-thumbnail nav nav-tabs">
                @foreach ($photos as $key => $photo)
                <li class="{{$active}}"><a data-target="#pic-{{$key}}" data-toggle="tab"><img class="lazyload" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                    data-src="{{ uploaded_asset($photo) }}"
                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"/></a></li>
                    @php $active=''@endphp
                @endforeach
              </ul>
            </div>
            <div class="col-md-10">
              <div class="preview-pic tab-content">
                @php $active='active'@endphp
                @foreach ($photos as $key => $photo)
                <div class="tab-pane {{$active}}" id="pic-{{$key}}"><img 
                    class="lazyload"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ uploaded_asset($photo) }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';" />
                    </div>
                @php $active=''@endphp
                @endforeach
                
              </div>
            </div>
          </div>
          
          
          
          
        </div>
        <div class="details col-md-5">
          <h3 class="product-title">{{ $detailedProduct->getTranslation('name') }}</h3>
          <p class="product-price">
            @if(home_price($detailedProduct->id) != home_discounted_price($detailedProduct->id))
                <span>
                    {{ home_price($detailedProduct->id) }}
                    @if($detailedProduct->unit != null)
                        /{{ $detailedProduct->getTranslation('unit') }}
                    @endif
                </span> 
                {{ home_discounted_price($detailedProduct->id) }}
                @if($detailedProduct->unit != null)
                    /{{ $detailedProduct->getTranslation('unit') }}
                @endif
            @else
                {{ home_discounted_price($detailedProduct->id) }}
                @if($detailedProduct->unit != null)
                    /{{ $detailedProduct->getTranslation('unit') }}
                @endif
            @endif
            </p>
          <h3 class="product-avai">Availability: 
            @php
            $qty = 0;
            if($detailedProduct->variant_product){
                foreach ($detailedProduct->stocks as $key => $stock) {
                    $qty += $stock->qty;
                }
            }
            else{
                $qty = $detailedProduct->current_stock;
            }
        @endphp
        @if ($qty > 0)
        <span>{{ translate('In stock')}}</span>
        @else
            <span>{{ translate('Out of stock')}}</span>
        @endif
            
        </h3>
          <div class="product-description">
            <?php echo $detailedProduct->getTranslation('description'); ?>
          </div>
          <form id="option-choice-form">
            @csrf
            <input type="hidden" name="id" value="{{ $detailedProduct->id }}">
            <div class="color-section">
                <h5>Colors/Organic:</h5>
                @if (count(json_decode($detailedProduct->colors)) > 0)
                    <div class="aiz-radio-inline">
                        @foreach (json_decode($detailedProduct->colors) as $key => $color)
                        <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ \App\Color::where('code', $color)->first()->name }}">
                            <input
                                type="radio"
                                name="color"
                                value="{{ $color }}"
                                @if($key == 0) checked @endif
                            >
                            <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                <span class="size-30px d-inline-block rounded" style="background: {{ $color }};"></span>
                            </span>
                        </label>
                        @endforeach
                    </div>
                @endif
            </div>
            @if ($detailedProduct->choice_options != null)
                @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)

                <div class="row no-gutters">
                    <div class="col-2">
                        <div class="opacity-50 mt-2 ">{{ \App\Attribute::find($choice->attribute_id)->getTranslation('name') }}:</div>
                    </div>
                    <div class="col-10">
                        <div class="aiz-radio-inline">
                            @foreach ($choice->values as $key => $value)
                            <label class="aiz-megabox pl-0 mr-2">
                                <input
                                    type="radio"
                                    name="attribute_id_{{ $choice->attribute_id }}"
                                    value="{{ $value }}"
                                    @if($key == 0) checked @endif
                                >
                                <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                    {{ $value }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                @endforeach
            @endif

                                
            <!-- Quantity + Add to cart -->
            <div class="row no-gutters">
                <div class="col-2">
                    <div class="opacity-50 mt-2">{{ translate('Quantity')}}:</div>
                </div>
                <div class="col-10">
                    <div class="product-quantity d-flex align-items-center">
                        <div class="row no-gutters align-items-center aiz-plus-minus mr-3" style="width: 130px;">
                            <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="minus" data-field="quantity" disabled="">
                                <i class="las la-minus"></i>
                            </button>
                            <input type="text" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="1" min="1" max="10" readonly>
                            <button class="btn  col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="plus" data-field="quantity">
                                <i class="las la-plus"></i>
                            </button>
                        </div>
                        <div class="avialable-amount opacity-60">(<span id="available-quantity">{{ $qty }}</span> {{ translate('available')}})</div>
                    </div>
                </div>
            </div>
            <div class="action">
            @if ($qty > 0)
            <button type="button" class="btn btn-primary mr-2 add-to-cart fw-600" onclick="addToCart()">
                <i class="las la-shopping-bag"></i>
                <span class="d-none d-md-inline-block"> {{ translate('Add to cart')}}</span>
            </button>            
            @else
                <button type="button" class="btn btn-secondary fw-600" disabled>
                    <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock')}}
                </button>
            @endif
        </div>
    </form>
          <div class="addwislist">
              <!-- Add to wishlist button -->
            <button onclick="addToWishList({{ $detailedProduct->id }})">
                <i class="fas fa-heart"></i> {{ translate('Add to wishlist')}}
            </button> 
            <!-- Add to compare button -->
            <button onclick="addToCompare({{ $detailedProduct->id }})">
                <i class="fas fa-arrows-alt-h"></i> {{ translate('Add to compare')}}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Product Details Page End -->

    <!-- Cart Page Product Section Start -->
    <div class="wishlist-page-product">
        <div class="container">
          <div class="heading">
            <h2>Cross Sell Products</h2>
          </div>
          <div id="carouselCrossSellControls" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselCrossSellControls" data-slide-to="0" class="active"></li>
              <li data-target="#carouselCrossSellControls" data-slide-to="1"></li>
              <li data-target="#carouselCrossSellControls" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="row">
                    @foreach (filter_products(\App\Product::where('subcategory_id', $detailedProduct->subcategory_id)->where('id', '!=', $detailedProduct->id))->limit(4)->get() as $key => $related_product)
                  <div class="col-md-3">
                    <div class="img-box">
                      <a href="{{ route('product', $related_product->slug) }}" class="d-block">
                        <img
                            class="d-block w-100 lazyload"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($related_product->thumbnail_img) }}"
                            alt="{{ $related_product->getTranslation('name') }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                        >
                    </a>
                    </div>
                    <h3>Banana</h3>
                    <p>
                        @if(home_base_price($related_product->id) != home_discounted_base_price($related_product->id))
                                                    <span>{{ home_base_price($related_product->id) }}</span>
                                                @endif
                                                {{ home_discounted_base_price($related_product->id) }}
                    </p>
                    {{ renderStarRating($related_product->rating) }}
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Cart Page Product Section End -->
@endsection

@section('modal')
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="title" value="{{ $detailedProduct->name }}" placeholder="{{ translate('Product Name') }}" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="message" required placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600" data-dismiss="modal">{{ translate('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary fw-600">{{ translate('Send')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login')}}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <input type="text" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone')}}" name="email" id="email">
                                @else
                                    <input type="email" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                @endif
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <span class="opacity-60">{{  translate('Use country code before number') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg" placeholder="{{ translate('Password')}}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-60>{{  translate('Remember Me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}" class="text-reset opacity-60 fs-14">{{ translate('Forgot password?')}}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary btn-block fw-600">{{  translate('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <p class="text-muted mb-0">{{ translate('Dont have an account?')}}</p>
                            <a href="{{ route('user.registration') }}">{{ translate('Register Now')}}</a>
                        </div>
                        @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60">{{ translate('Or Login With')}}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getVariantPrice();
    	});

        function CopyToClipboard(containerid) {
            if (document.selection) {
                var range = document.body.createTextRange();
                range.moveToElementText(document.getElementById(containerid));
                range.select().createTextRange();
                document.execCommand("Copy");

            } else if (window.getSelection) {
                var range = document.createRange();
                document.getElementById(containerid).style.display = "block";
                range.selectNode(document.getElementById(containerid));
                window.getSelection().addRange(range);
                document.execCommand("Copy");
                document.getElementById(containerid).style.display = "none";

            }
            AIZ.plugins.notify('success', 'Copied');
        }

        function show_chat_modal(){
            @if (Auth::check())
                $('#chat_modal').modal('show');
            @else
                $('#login_modal').modal('show');
            @endif
        }

    </script>
@endsection
