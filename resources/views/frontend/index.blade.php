@extends('frontend.layouts.app')

@section('content')
    {{-- Categories , Sliders . Today's deal --}}
    
      <!-- Banner Section Start -->
  <div class="banner-section">
    <div class="container">
      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
        @php 
            $slider_images = json_decode(get_setting('home_slider_images'), true);  
            $active = true;
        @endphp
        @foreach ($slider_images as $key => $value)
          <div class="carousel-item {{$active ? 'active' : ''}}">
            <img class="d-block w-100 lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
            data-src="{{ uploaded_asset($slider_images[$key]) }}" alt="{{ env('APP_NAME')}} promo">
          </div>
          @php $active = false @endphp
        @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </div>
  <!-- Banner Section End -->


  <!-- Marquee Section Start -->
  <div class="marquee-section">
    <div class="container">
      <marquee>Welcome to Mero Dokan a E-commerce for farmers | Something that's scrolling 24x27 Here | Notice, Information or anything that is quite important.</marquee>
    </div>
  </div>
  <!-- Marquee Section End -->

    <!-- Content Section Start-->
    <div class="content-section">
        <div class="container">
          <div class="row">
            
            <div class="col-md-3">
              <!-- Hot Deals Section Start -->
              <div class="hot-deal">
                <div class="heading">
                  <div class="row">
                    <div class="col-md-9">
                      <h2>HOT DEALS</h2>
                    </div>
                    <div class="col-md-3">
                      <a class="carousel-control-prev" href="#carouselHotDealControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselHotDealControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                  </div>
                </div>
                <div id="carouselHotDealControls" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                      @php $active = true @endphp
                    @foreach (filter_products(\App\Product::where('published', 1)->where('todays_deal', '1'))->get() as $key => $product)
                    @if ($product != null)
                    <div class="carousel-item {{$active ? 'active' : ''}}">
                      <div class="img-box">
                        <a href="{{ route('product', $product->slug) }}">
                        <img class="lazyload d-block w-100"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                            alt="{{ $product->getTranslation('name') }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                        >
                        </a>
                      </div>
                      <h3>
                        <h3>{{  $product->getTranslation('name')  }}</h3>
                      <p><span class="d-block text-primary fw-600">{{ home_discounted_base_price($product->id) }}</span>
                        @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                            <del class="d-block opacity-70">{{ home_base_price($product->id) }}</del>
                        @endif</p>
                        {{ renderStarRating($product->rating) }}
                    </div>
                    @endif
                    @php $active = false @endphp
                    @endforeach
                  </div>
                </div>
              </div>
              <!-- Hot Deals Section Start -->
    
    
    
              <!-- Special Deals Section Start -->
              <div class="hot-deal special-deal">
                <div class="heading">
                  <div class="row">
                    <div class="col-md-9">
                      <h2>SPECIAL DEALS</h2>
                    </div>
                    <div class="col-md-3">
                      <a class="carousel-control-prev" href="#carouselHotDealControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselHotDealControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                  </div>
                </div>
                <div id="carouselHotDealControls" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    @php
                    $flash_deal = \App\FlashDeal::where('status', 1)->where('featured', 1)->first();
                @endphp
                @if($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date)
                @php $active = true @endphp
                @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                        @php
                            $product = \App\Product::find($flash_deal_product->product_id);
                        @endphp
                        @if ($product != null && $product->published != 0)
                    <div class="carousel-item {{$active ? 'active' : ''}}">
                      <div class="img-box">
                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                            <img
                                class="lazyload d-block w-100"
                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                alt="{{  $product->getTranslation('name')  }}"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                            >
                        </a>
                      </div>
                      <h3>{{  $product->getTranslation('name')  }}</h3>
                      <p>
                          @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                        <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                        @endif
                    <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span></p>
                    {{ renderStarRating($product->rating) }}
                    </div>
                    @endif
                    @php $active = false @endphp
                    @endforeach
                    @endif
                  </div>
                </div>
              </div>
              <!-- Special Deals Section Start -->
    
    
              <!-- News Letter Section Start -->
              <div class="hot-deal news-letter">
                <div class="heading">
                  <h2>NEWSLETTERS</h2>
                </div>
                <form>
                  <div class="form-group">
                    <label for="inputAddress">Sign Up for Our Newsletter</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Enter Email Addres">
                  </div>
                  <button type="submit" class="btn btn-danger">SUBSCRIB</button>
                </form>
              </div>
              <!-- News Letter Section End -->
    
    
    
              <!-- Left ADD Section Start -->
              <div class="left-add">
                <img src="{{ static_asset('assets/image/vegimg.jpg')}}">
              </div>
              <!-- Left ADD Section End -->
    
            </div>
    
            <div class="col-md-9">
              <!-- New Product Section Start -->
              <div class="hot-deal new-product">
                <div class="heading">
                  <div class="row">
                    <div class="col-md-9">
                      <h2>NEW PRODUCTS</h2>
                    </div>
                    <div class="col-md-3">
                      <a class="carousel-control-prev" href="#carouselNewProductControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselNewProductControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                  </div>
                </div>
                <div id="carouselNewProductControls" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <div class="row">
                        @foreach (filter_products(\App\Product::where('published', 1)->where('featured', '0'))->limit(4)->get() as $key => $product)
                        <div class="col-md-3 box-content-div">
                          <div class="box-content">
                            <div class="img-box">
                                <a href="{{ route('product', $product->slug) }}">
                              <img class="d-block w-100 lazyload" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                              data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                              alt="{{  $product->getTranslation('name')  }}"
                              onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </a>
                            </div>
                            <h3>{{  $product->getTranslation('name')  }}</h3>
                            <p>@if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                            @endif
                            <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span></p>
                            {{ renderStarRating($product->rating) }}
                          </div>
                        </div>
                        @endforeach
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
              <!-- New Product Section End -->
    
    
    
              <!-- Fresh Section Start -->
              <div class="fresh-section">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6">
                        <img src="{{static_asset('assets/image/add.jpg')}}">
                      </div>
                      <div class="col-md-6">
                        <div class="fresh-section-content">
                          <h3>2020</h3>
                          <h4>FRESH FARM</h4>
                          <a href="#">BUY NOW</a>
                          <p>*on selected item only</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6">
                        <img src="{{static_asset('assets/image/add.jpg')}}">
                      </div>
                      <div class="col-md-6">
                        <div class="fresh-section-content">
                          <h3>2020</h3>
                          <h4>FRESH FARM</h4>
                          <a href="#">BUY NOW</a>
                          <p>*on selected item only</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Fresh Section End -->

              {{-- Category wise Products --}}
            <div id="section_home_categories">

            </div>
            <!-- Category wise Products End -->
    
    
              <!-- Fresh Organic Section Start -->
              <div class="fresh-organic-section">
                <div class="container">
                  <div class="row">
                    <div class="col-md-6">
                      <img src="{{static_asset('assets/image/freshorganicimg.jpg')}}">
                    </div>
                    <div class="col-md-6">
                      <h2>FRESH & ORGANIC</h2>
                      <h3>HAND PICKED BY FRAME</h3>
                      <button class="btn btn-danger">SHOP NOW</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Freh Organic Section End -->

                {{-- Featured Section --}}
                <div id="section_featured">

                </div>
    
            </div>
    
          </div>
        </div>
      </div>
      <!-- Content Section End -->


    {{-- Classified Product --}}
    @if(\App\BusinessSetting::where('type', 'classified_product')->first()->value == 1)
        @php
            $customer_products = \App\CustomerProduct::where('status', '1')->where('published', '1')->take(10)->get();
        @endphp
           @if (count($customer_products) > 0)
               <section class="mb-4">
                   <div class="container">
                       <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                            <div class="d-flex mb-3 align-items-baseline border-bottom">
                                <h3 class="h5 fw-700 mb-0">
                                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Classified Ads') }}</span>
                                </h3>
                                <a href="{{ route('customer.products') }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a>
                            </div>
                           <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                               @foreach ($customer_products as $key => $customer_product)
                                   <div class="carousel-box">
                                        <div class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                            <div class="position-relative">
                                                <a href="{{ route('customer.product', $customer_product->slug) }}" class="d-block">
                                                    <img
                                                        class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($customer_product->thumbnail_img) }}"
                                                        alt="{{ $customer_product->getTranslation('name') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    >
                                                </a>
                                                <div class="absolute-top-left pt-2 pl-2">
                                                    @if($customer_product->conditon == 'new')
                                                       <span class="badge badge-inline badge-success">{{translate('new')}}</span>
                                                    @elseif($customer_product->conditon == 'used')
                                                       <span class="badge badge-inline badge-danger">{{translate('Used')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="p-md-3 p-2 text-left">
                                                <div class="fs-15 mb-1">
                                                    <span class="fw-700 text-primary">{{ single_price($customer_product->unit_price) }}</span>
                                                </div>
                                                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                                                    <a href="{{ route('customer.product', $customer_product->slug) }}" class="d-block text-reset">{{ $customer_product->getTranslation('name') }}</a>
                                                </h3>
                                            </div>
                                       </div>
                                   </div>
                               @endforeach
                           </div>
                       </div>
                   </div>
               </section>
           @endif
       @endif

    {{-- Banner Section 2 --}}
    <div class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                @if (get_setting('home_banner2_images') != null)
                    @php $banner_2_imags = json_decode(get_setting('home_banner2_images')); @endphp
                    @foreach ($banner_2_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3 mb-lg-0">
                                <a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}" target="_blank" class="d-block text-reset">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_2_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $.post('{{ route('home.section.featured') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_featured').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_selling') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });

            @if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
            $.post('{{ route('home.section.best_sellers') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_sellers').html(data);
                AIZ.plugins.slickCarousel();
            });
            @endif
        });
    </script>
@endsection
