  <!-- Top Section Start-->
  <div class="top-section">
    <div class="row">
      <div class="col-md-5 top-left">
        <p>{{get_setting('site_motto')}}</p>
      </div>
      <div class="col-md-7 top-right">
        <ul>
          <li><span>{{date('Y M d')}}</span></li>
          @auth
            <li>
                <a href="{{ route('dashboard') }}" class="top-bar-item">{{translate('My Account')}}</a>
            </li>
            <li>
                <a href="{{ route('logout') }}" class="top-bar-item">{{translate('Logout')}}</a>
            </li>
            @else
            <li>
                <a href="{{ route('user.login') }}" class="top-bar-item">{{translate('Login')}}</a>
            </li>
            <li>
                <a href="{{ route('user.registration') }}" class="top-bar-item">{{translate('Registration')}}</a>
            </li>
            @endauth
          <li>
            <a href="{{ route('wishlists.index') }}">
                {{translate('Wishlist')}}
            </a>
            </li>
          <li>
              <a href="{{ route('cart') }}">
                {{translate('My Cart')}}
              </a>
          </li>
          <li><a href="{{ route('orders.track') }}" class="top-bar-item">{{translate('Track Order')}}</a></li>
        </ul>
        </ul>
      </div>
    </div>
  </div>
  <!-- Top Section End -->
  

  <!-- Logo Section Start -->
  <div class="logo-section">
    <div class="container">
      <div class="row">
        <div class="col-md-3 logo">
          <a href="{{ route('home') }}">
            @php
                $header_logo = get_setting('header_logo');
            @endphp
            @if($header_logo != null)
                <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100" height="40">
            @else
                <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100" height="40">
            @endif
        </a>
        </div>
        <div class="col-md-6">
          <form class="search-box">
            <div class="input-group">
              <input type="search" class="form-control" placeholder="Search Here..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-danger" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-3">
          <div class="media">
            <div class="icon">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </div>
              <div class="media-body">
                <p>TOTAL</p>
                @if(Session::has('cart'))
                  @if(count($cart = Session::get('cart')) > 0)
                    @php
                        $total = 0;
                    @endphp
                    @foreach($cart as $key => $cartItem)
                    @php
                      $total = $total + $cartItem['price']*$cartItem['quantity'];
                    @endphp
                    @endforeach
                    <h5>NRs. {{$total}}</h5>
                  @endif
                @else
                <h5>NRs. 00:00</h5>
                @endif
              </div>
            <ul>
            @if(get_setting('show_language_switcher') == 'on')
              @php
                  if(Session::has('locale')){
                      $locale = Session::get('locale', Config::get('app.locale'));
                  }
                  else{
                      $locale = 'en';
                  }
              @endphp
              @foreach (\App\Language::all() as $key => $language)
              <li>
                <a href="javascript:void(0)" data-flag="{{ $language->code }}" class="@if($locale == $language) active @endif">
                  <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="lazyload" alt="{{ $language->name }}"></a>
              </li>
              @endforeach
            @endif
          </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Logo Section End -->



  <!-- Menu Section Start -->
  <div class="menu-section">
    <div class="container">
      <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#"><i class="fa fa-list" aria-hidden="true"></i> CATEGORIES</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            @foreach (\App\Category::all()->take(11) as $key => $category)
            <li class="nav-item">
              <a class="nav-link" href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
            </li>
            @endforeach
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <!-- Menu Section End -->
