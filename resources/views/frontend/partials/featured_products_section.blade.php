<div class="hot-deal featured-product">
    <div class="heading">
      <div class="row">
        <div class="col-md-9">
          <h2>FEATURED PRODUCT</h2>
        </div>
        <div class="col-md-3">
          <a class="carousel-control-prev" href="#carouselFeaturedProductControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselFeaturedProductControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
    <div id="carouselFeaturedProductControls" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="row">
            @foreach (filter_products(\App\Product::where('published', 1)->where('featured', '1'))->limit(6)->get() as $key => $product)
            <div class="col-md-4">
              <div class="media">
                <div class="icon">
                    <a href="{{ route('product', $product->slug) }}" class="d-block">
                        <img
                            class="lazyload"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                            alt="{{  $product->getTranslation('name')  }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                        >
                    </a>
                </div>
                  <div class="media-body">
                    <h3>{{  $product->getTranslation('name')  }}</h3>
                    <p> @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                        <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                    @endif
                    <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span></p>
                    {{ renderStarRating($product->rating) }}
                  </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>