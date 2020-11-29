@php $home_categories = json_decode(get_setting('home_categories')); @endphp
@foreach ($home_categories as $key => $value)
    @php $category = \App\Category::find($value); @endphp
        <div class="hot-deal fresh-vegitable">
            <div class="heading">
            <div class="row">
                <div class="col-md-9">
                <h2>{{ $category->getTranslation('name') }}</h2>
                </div>
                <div class="col-md-3">
                <a class="carousel-control-prev" href="#carouselFreshVegitableControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselFreshVegitableControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                </div>
            </div>
            </div>
            <div id="carouselFreshVegitableControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <div class="row">
                    @foreach (get_cached_products($category->id, 4) as $key => $product)
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
                            <a href="{{ route('product', $product->slug) }}"><h3>{{  $product->getTranslation('name')  }}</h3></a>
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
@endforeach