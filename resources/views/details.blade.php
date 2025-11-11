@extends('layouts.app')
@section('content')
<style>
  .filled-heart{
    color: red;
  }
  
  .review-card {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    transition: box-shadow 0.3s;
  }

  .review-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }

  .review-stars {
    color: #ffc107;
    font-size: 1.2rem;
  }

  .review-reply {
    background-color: #f8f9fa;
    border-left: 3px solid #0d6efd;
    padding: 15px;
    margin-top: 15px;
    border-radius: 5px;
  }

  .rating-summary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
  }

  .rating-breakdown {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }

  .rating-bar {
    flex-grow: 1;
    height: 8px;
    background-color: #e0e0e0;
    border-radius: 4px;
    margin: 0 10px;
    overflow: hidden;
  }

  .rating-bar-fill {
    height: 100%;
    background-color: #ffc107;
    transition: width 0.3s;
  }

  .verified-purchase {
    color: #28a745;
    font-weight: 600;
  }
  
  .avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #6c757d;
  }
</style>

<main class="pt-90">
    <div class="mb-md-1 pb-md-3"></div>
    <section class="product-single container">
      <div class="row">
        <div class="col-lg-7">
          <div class="product-single__media" data-media-type="vertical-thumbnail">
            <div class="product-single__image">
              <div class="swiper-container">
                <div class="swiper-wrapper">

                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{asset('uploads/products')}}/{{$product->image}}" width="674" height="674" alt="" />
                    <a data-fancybox="gallery" href="{{asset('uploads/products')}}/{{$product->image}}" data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_zoom" />
                      </svg>
                    </a>
                  </div>

                  @foreach(explode(',', $product->images) as $gimg)
                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{asset('uploads/products')}}/{{$gimg}}" width="674" height="674" alt="" />
                    <a data-fancybox="gallery" href="{{asset('uploads/products')}}/{{$gimg}}" data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_zoom" />
                      </svg>
                    </a>
                  </div>
                  @endforeach
                </div>
                <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                    xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_prev_sm" />
                  </svg></div>
                <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11"
                    xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_next_sm" />
                  </svg></div>
              </div>
            </div>
            <div class="product-single__thumbnail">
              <div class="swiper-container">
                <div class="swiper-wrapper">
                  <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto" src="{{asset('uploads/products/thumbnails')}}/{{$product->image}}" width="104" height="104" alt="" /></div>
                  @foreach(explode(',', $product->images) as $gimg)
                  <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto" src="{{asset('uploads/products/thumbnails')}}/{{$gimg}}" width="104" height="104" alt="" /></div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="d-flex justify-content-between mb-4 pb-md-2">
            <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
              <a href="{{route('home.index')}}" class="menu-link menu-link_us-s text-uppercase fw-medium">Trang chủ</a>
              <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
              <a href="{{route('shop.index')}}" class="menu-link menu-link_us-s text-uppercase fw-medium">Cửa hàng</a>
            </div>

            <div class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
              <a href="#" class="text-uppercase fw-medium"><svg width="10" height="10" viewBox="0 0 25 25"
                  xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_prev_md" />
                </svg><span class="menu-link menu-link_us-s">Prev</span></a>
              <a href="#" class="text-uppercase fw-medium"><span class="menu-link menu-link_us-s">Tiếp</span><svg
                  width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_md" />
                </svg></a>
            </div>
          </div>
          <h1 class="product-single__name">{{$product->name}}</h1>
          <div class="product-single__rating">
            <div class="reviews-group d-flex">
              @php
                $avgRating = $product->averageRating() ?? 0;
              @endphp
              @for($i = 1; $i <= 5; $i++)
                <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg" 
                     style="fill: {{ $i <= round($avgRating) ? '#ffc107' : '#ddd' }}">
                  <use href="#icon_star" />
                </svg>
              @endfor
            </div>
            <span class="reviews-note text-lowercase text-secondary ms-1">
              {{ $product->totalReviews() }} đánh giá
              @if($avgRating > 0)
                ({{ number_format($avgRating, 1) }}/5)
              @endif
            </span>
          </div>
          <div class="product-single__price">
            <span class="current-price">
                    @if($product->sale_price)
                    <s>{{formatVND($product->regular_price)}}</s> {{formatVND($product->sale_price)}}
                    @else
                      {{formatVND($product->regular_price)}}
                    @endif
            </span>
          </div>
          <div class="product-single__short-desc">
            <p>{{$product->short_description}}</p>
          </div>
          @if(Cart::instance('cart')->content()->where('id',$product->id)->count()>0)
            <a href="{{route('cart.index')}}" class="btn btn-warning mb-3">Đi đến giỏ hàng</a>
          @else
          <form name="addtocart-form" method="post" action="{{route('cart.add')}}">
            @csrf
            <div class="product-single__addtocart">
              <div class="qty-control position-relative">
                <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
                <div class="qty-control__reduce">-</div>
                <div class="qty-control__increase">+</div>
              </div>
              <input type="hidden" name="id" value="{{$product -> id}}" />
              <input type="hidden" name="name" value="{{$product -> name}}" />
              <input type="hidden" name="price" value="{{$product -> sale_price == '' ? $product->regular_price : $product->sale_price}}" />
              <button type="submit" class="btn btn-primary btn-addtocart" data-aside="cartDrawer">Thêm vào giỏ hàng</button>
            </div>
          </form>
          @endif
          <div class="product-single__addtolinks">
            @if(Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
            <form method="POST" action="{{ route('wishlist.item.remove', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}" id="frm-remove-item">
              @csrf
              @method('DELETE')
            <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist filled-heart" onclick="document.getElementById('frm-remove-item').submit();"><svg width="16" height="16" viewBox="0 0 20 20"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_heart" />
              </svg><span>Xóa khỏi yêu thích</span></a>
            </form>
            @else
            <form method="POST" action="{{route('wishlist.add')}}" id="wishlist-form">
              @csrf
              <input type="hidden" name="id" value="{{$product->id}}" />
              <input type="hidden" name="name" value="{{$product->name}}" />
              <input type="hidden" name="price" value="{{$product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
              <input type="hidden" name="quantity" value="1" />
              <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist" onclick="document.getElementById('wishlist-form').submit()"><svg width="16" height="16" viewBox="0 0 20 20"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_heart" />
              </svg><span>Thêm vào yêu thích</span></a>
            </form>
            @endif

            <share-button class="share-button">
              <button class="menu-link menu-link_us-s to-share border-0 bg-transparent d-flex align-items-center">
                <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_sharing" />
                </svg>
                <span>Chia sẻ</span>
              </button>
            </share-button>
          </div>
          <div class="product-single__meta-info">
            <div class="meta-item">
              <label>SKU:</label>
              <span>{{$product->SKU}}</span>
            </div>
            <div class="meta-item">
              <label>Danh mục:</label>
              <span>{{$product->category->name}}</span>
            </div>
            <div class="meta-item">
              <label>Thương hiệu:</label>
              <span>{{$product->brand->name}}</span>
            </div>
          </div>
        </div>
      </div>
      
      <div class="product-single__details-tab">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
              href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Mô tả</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab"
              href="#tab-additional-info" role="tab" aria-controls="tab-additional-info"
              aria-selected="false">Thông tin bổ sung</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab" href="#tab-reviews"
              role="tab" aria-controls="tab-reviews" aria-selected="false">
              Đánh giá ({{ $product->totalReviews() }})
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
            aria-labelledby="tab-description-tab">
            <div class="product-single__description">
                {{$product->description}}
            </div>
          </div>
          
          <div class="tab-pane fade" id="tab-additional-info" role="tabpanel" aria-labelledby="tab-additional-info-tab">
            <div class="product-single__addtional-info">
              <div class="item">
                <label class="h6">Trạng thái kho</label>
                <span>{{ $product->stock_status == 'instock' ? 'Còn hàng' : 'Hết hàng' }}</span>
              </div>
              <div class="item">
                <label class="h6">Số lượng</label>
                <span>{{ $product->quantity }}</span>
              </div>
              <div class="item">
                <label class="h6">SKU</label>
                <span>{{ $product->SKU }}</span>
              </div>
            </div>
          </div>
          
          <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
            <!-- Reviews Section -->
            <section class="product-single__reviews mt-4">
              <div class="row">
                <!-- Left Column - Rating Summary -->
                <div class="col-lg-4 mb-4">
                  <div class="rating-summary">
                    <div class="mb-3">
                      <h1 class="display-3 mb-0">{{ number_format($product->averageRating() ?? 0, 1) }}</h1>
                      <div class="review-stars mb-2">
                        @for($i = 1; $i <= 5; $i++)
                          @if($i <= round($product->averageRating() ?? 0))
                            ★
                          @else
                            ☆
                          @endif
                        @endfor
                      </div>
                      <p class="mb-0">{{ $product->totalReviews() }} đánh giá</p>
                    </div>
                  </div>

                  <!-- Rating Breakdown -->
                  <div class="mt-4">
                    <h6 class="mb-3">Phân bố đánh giá</h6>
                    @php
                      $distribution = $product->ratingDistribution();
                      $total = $product->totalReviews();
                    @endphp
                    @for($i = 5; $i >= 1; $i--)
                      @php
                        $count = $distribution[$i] ?? 0;
                        $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                      @endphp
                      <div class="rating-breakdown">
                        <span class="me-2">{{ $i }} ★</span>
                        <div class="rating-bar">
                          <div class="rating-bar-fill" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="ms-2 text-muted">{{ $count }}</span>
                      </div>
                    @endfor
                  </div>
                </div>

                <!-- Right Column - Reviews List -->
                <div class="col-lg-8">
                  @if($product->approvedReviews->count() > 0)
                    @foreach($product->approvedReviews as $review)
                    <div class="review-card" id="review-{{ $review->id }}">
                      <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                          <div class="me-3">
                            <div class="avatar-circle">
                              <i class="fa fa-user"></i>
                            </div>
                          </div>
                          <div>
                            <h6 class="mb-1">{{ $review->user->name }}</h6>
                            <div class="review-stars mb-1">
                              @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                  ★
                                @else
                                  ☆
                                @endif
                              @endfor
                            </div>
                            @if($review->verified_purchase)
                              <small class="verified-purchase">
                                <i class="fa fa-check-circle"></i> Đã mua hàng
                              </small>
                            @endif
                          </div>
                        </div>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                      </div>

                      @if($review->title)
                        <h6 class="fw-bold mb-2">{{ $review->title }}</h6>
                      @endif

                      <p class="mb-3">{{ $review->comment }}</p>

                      <!-- Admin Replies -->
                      @if($review->replies->count() > 0)
                        @foreach($review->replies as $reply)
                        <div class="review-reply">
                          <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-user-circle text-primary me-2" style="font-size: 1.5rem;"></i>
                            <div>
                              <strong>{{ $reply->user->name }}</strong>
                              @if($reply->user->utype == 'ADM')
                                <span class="badge bg-primary ms-2">Admin</span>
                              @endif
                              <br>
                              <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                            </div>
                          </div>
                          <p class="mb-0">{{ $reply->comment }}</p>
                        </div>
                        @endforeach
                      @endif
                    </div>
                    @endforeach
                  @else
                    <div class="text-center py-5">
                      <i class="fa fa-comment-o" style="font-size: 4rem; color: #ddd;"></i>
                      <h5 class="mt-3 text-muted">Chưa có đánh giá nào</h5>
                      <p class="text-muted">Hãy là người đầu tiên đánh giá sản phẩm này</p>
                    </div>
                  @endif
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </section>
    
    <section class="products-carousel container">
      <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Sản phẩm <strong>Liên quan</strong></h2>

      <div id="related_products" class="position-relative">
        <div class="swiper-container js-swiper-slider" data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>
          <div class="swiper-wrapper">
            @foreach ($rproducts as $rproduct)
            <div class="swiper-slide product-card">
              <div class="pc__img-wrapper">
                <a href="{{route('shop.products.details',['product_slug'=>$rproduct->slug])}}">
                  <img loading="lazy" src="{{asset('uploads/products')}}/{{$rproduct->image}}" width="330" height="400" alt="{{$rproduct->name}}" class="pc__img">
                  @php
                    $images = explode(",",$rproduct->images);
                  @endphp
                  @if(count($images) > 0 && !empty($images[0]))
                    <img loading="lazy" src="{{asset('uploads/products')}}/{{$images[0]}}" width="330" height="400" alt="{{$rproduct->name}}" class="pc__img pc__img-second">
                  @endif
                </a>
                @if(Cart::instance('cart')->content()->where('id',$rproduct->id)->count()>0)
                <a href="{{route('cart.index')}}" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn btn-warning mb-3">Đi đến giỏ hàng</a>
                @else
                <form name="addtocart-form" method="post" action="{{route('cart.add')}}">
                @csrf
                <input type="hidden" name="id" value="{{$rproduct -> id}}" />
                <input type="hidden" name="quantity" value="1" />
                <input type="hidden" name="name" value="{{$rproduct -> name}}" />
                <input type="hidden" name="price" value="{{$rproduct -> sale_price == '' ? $rproduct->regular_price : $rproduct->sale_price}}" />
                <button type="submit" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium" data-aside="cartDrawer" title="Add To Cart">Thêm giỏ hàng</button>
                </form>
                @endif
              </div>

              <div class="pc__info position-relative">
                <p class="pc__category">{{$rproduct->category->name}}</p>
                <h6 class="pc__title"><a href="{{route('shop.products.details',['product_slug'=>$rproduct->slug])}}">{{$rproduct->name}}</a></h6>
                <div class="product-card__price d-flex">
                  <span class="money price">
                    @if($rproduct->sale_price)
                    <s>{{formatVND($rproduct->regular_price)}}</s> {{formatVND($rproduct->sale_price)}}
                    @else
                      {{formatVND($rproduct->regular_price)}}
                    @endif
                  </span>
                </div>

                <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                  title="Add To Wishlist">
                  <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_heart" />
                  </svg>
                </button>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <div class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
          <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_prev_md" />
          </svg>
        </div>
        <div class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
          <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg>
        </div>

        <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
      </div>
    </section>
  </main>

@endsection