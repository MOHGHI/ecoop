  <!-- Footer Section Start -->
  <div class="footer-section">
    <div class="container">
      <div class="row">  
        <div class="col-md-3 first-footer">
          <a href="{{ route('home') }}" class="d-block">
            @if(get_setting('footer_logo') != null)
                <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset(get_setting('footer_logo')) }}" alt="{{ env('APP_NAME') }}" height="44">
            @else
                <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" height="44">
            @endif
        </a>
          <p class="fdes">{!! get_setting('about_us_description') !!}</p>
          <p><i class="fa fa-map-marker-alt" aria-hidden="true"></i> {{ get_setting('contact_address') }}</p>
          <p><i class="fas fa-mobile-alt" aria-hidden="true"></i> {{ get_setting('contact_phone') }}</p>
          <p><i class="fas fa-envelope" aria-hidden="true"></i> {{ get_setting('contact_email')  }}</p>
        </div>
        <div class="col-md-3 second-footer">
          <h3>INFORMATION</h3>
          <p><a href="#">Our Story</a></p>
          <p><a href="#">Privacy & Policy</a></p>
          <p><a href="#">Terms & Conditions</a></p>
          <p><a href="#">Shipping & Delivery</a></p>
          <p><a href="#">Careers</a></p>
          <p><a href="#">FAQs</a></p>
        </div>
        <div class="col-md-3 second-footer third-footer">
          <h3>OUR SOCIAL</h3>
          <div class="row">
            <div class="col-md-6">
              @if ( get_setting('facebook_link') !=  null )
              <li class="list-inline-item">
                  <p><a href="{{ get_setting('facebook_link') }}" target="_blank" ><i class="fab fa-facebook-f" aria-hidden="true"></i> Facebook</a></p>
              </li>
              @endif
              @if ( get_setting('twitter_link') !=  null )
              <li class="list-inline-item">
                  <p><a href="{{ get_setting('twitter_link') }}" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i> Twitter</a></p>
              </li>
              @endif
              @if ( get_setting('instagram_link') !=  null )
              <li class="list-inline-item">
                  <p><a href="{{ get_setting('instagram_link') }}"><i class="fab fa-instagram" aria-hidden="true"></i> Instagram</a></p>
              </li>
              @endif
              @if ( get_setting('youtube_link') !=  null )
              <li class="list-inline-item">
                  <p><a href="{{ get_setting('youtube_link') }}" target="_blank" ><i class="fab fa-youtube" aria-hidden="true"></i> YouTube</a></p>
              </li>
              @endif
              @if ( get_setting('linkedin_link') !=  null )
              <li class="list-inline-item">
                  <a href="{{ get_setting('linkedin_link') }}" target="_blank" class="linkedin"><i class="lab la-linkedin-in"></i></a>
              </li>
              @endif
              
            </div>
          </div>
        </div>
        <div class="col-md-3 second-footer fourth-footer">
          <h3>OPENING TIME</h3>
          <P><i class="fas fa-clock" aria-hidden="true"></i> Mon - Fri: 08:30 am - 09:30 pm</P>
          <P><i class="fas fa-clock" aria-hidden="true"></i> Sat - Sun: 09:00 am - 10:00 pm</P>
          <h3>PAYMENT OPTION</h3>
          <ul>
            @if ( get_setting('payment_method_images') !=  null )
                @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                    <li >
                        <img src="{{ uploaded_asset($value) }}" height="30">
                    </li>
                @endforeach
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer Section End -->


  <!-- Footer Bottom Section Start -->
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <ul>
          <li><a href="#">Sitemap</a></li>
          <li><a href="#">Search</a></li>
          <li><a href="#">Search</a></li>
          <li><a href="#">Advance</a></li>
          <li><a href="#">Search</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
        <p>&#169; 2020 <a href="#">vikrantvisuals.com</a> | All Rights Reserved.</p>
      </div>
    </div>
  </div>
  <!-- Footer Bottom Section End -->


  <!-- Bottom Section Start -->
  <div class="bottom-section">
    <div class="row">
      <div class="col-md-6 bottom-left">

      </div>
      <div class="col-md-6 bottom-right">

      </div>
    </div>
  </div>
  <!-- Bottom Section End -->
