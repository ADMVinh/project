@extends('layouts.app')
@section('content')
<style>
  .btn-checkout:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
</style>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Vận chuyển và Thanh toán</h2>
      <div class="checkout-steps">
        <a href="{{route('cart.index')}}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Giỏ hàng</span>
            <em>Quản lý danh sách mặt hàng của bạn</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Vận chuyển và Thanh toán</span>
            <em>Thanh toán danh sách mặt hàng của bạn</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Xác nhận</span>
            <em>Kiểm tra và gửi đơn hàng của bạn</em>
          </span>
        </a>
      </div>
      <form name="checkout-form" action="{{route('cart.place.an.order')}}" method="POST">
        @csrf
        <div class="checkout-form">
          <div class="billing-info__wrapper">
            <div class="row">
              <div class="col-6">
                <h4>CHI TIẾT VẬN CHUYỂN</h4>
              </div>
              <div class="col-6">
              </div>
            </div>
            @if($address)
             <div class="row">
                <div class="col-md-12">
                    <div class="my-account_address-list">
                        <div class="my-account_address-list-item">
                            <div class="my-account_address-item_detail">
                                <p>{{$address->name}}</p>
                                <p>{{$address->address}}</p>
                                <p>{{$address->landmark}}</p>
                                <p>{{$address->city}}, {{$address->state}}, {{$address->country}}</p>
                                <p>{{$address->zip}}, {{$address->locality}}</p>
                                <br />
                                <p>{{$address->phone}}</p>
                            </div>
                        </div>
                    </div>
                </div>
             </div> 
            @else
            <div class="row mt-5">
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="name" required="" value="{{old('name')}}">
                  <label for="name">Họ và Tên *</label>
                  @error('name') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="phone" required="" value="{{old('phone')}}">
                  <label for="phone">Số điện thoại *</label>
                  @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="zip" required="" value="{{old('zip')}}">
                  <label for="zip">Mã bưu chính *</label>
                  @error('zip') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating mt-3 mb-3">
                  <input type="text" class="form-control" name="state" required="" value="{{old('state')}}">
                  <label for="state">Tỉnh / Thành phố *</label>
                  @error('state') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="city" required="" value="{{old('city')}}">
                  <label for="city">Thị trấn / Thành phố *</label>
                  @error('city') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="address" required="" value="{{old('address')}}">
                  <label for="address">Số nhà, Tên tòa nhà *</label>
                  @error('address') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="locality" required="" value="{{old('locality')}}">
                  <label for="locality">Tên đường, Khu vực, Khu phố *</label>
                  @error('locality') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="country" required="" value="{{old('country')}}">
                  <label for="country">Quốc gia*</label>
                  @error('country') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="landmark" required="" value="{{old('landmark')}}">
                  <label for="landmark">Điểm mốc *</label>
                  @error('landmark') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
            </div>
            @endif
          </div>
          <div class="checkout__totals-wrapper">
            <div class="sticky-content">
              <div class="checkout__totals">
                <h3>Đơn hàng của bạn</h3>
                <table class="checkout-cart-items">
                  <thead>
                    <tr>
                      <th>SẢN PHẨM</th>
                      <th align="right">TỔNG CỘNG</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach(Cart::instance('cart') as $item)
                    <tr>
                      <td>
                        {{$item->name}} x {{$item->qty}}
                      </td>
                      <td align="right">
                        ${{$item->subtotal()}}
                      </td>
                    </tr>                   
                    @endforeach
                  </tbody>
                </table>
                @if(Session::has('discounts'))
                <table class="checkout-totals">
                    <tbody>
                        <tr>
                          <th>Tổng phụ</th>
                          <td class="text_right">${{Cart::instance('cart')->subtotal()}}</td>
                        </tr>
                        <tr>
                          <th>Giảm giá {{Session::get('coupon')['code']}}</th>
                          <td class="text_right">${{Session::get('discounts')['discount']}}</td>
                        </tr>
                        <tr>
                          <th>Tổng phụ sau giảm giá</th>
                          <td class="text_right">${{Session::get('discounts')['subtotal']}}</td>
                        </tr>
                        <tr>
                          <th>Vận chuyển</th>
                          <td class="text_right">Miễn phí</td>
                        </tr>
                        <tr>
                          <th>VAT</th>
                          <td class="text_right">${{Session::get('discounts')['tax']}}</td>
                        </tr>
                        <tr>
                          <th>Tổng cộng</th>
                          <td class="text_right">${{Session::get('discounts')['total']}}</td>
                        </tr>
                      </tbody>
                  </table>
                @else
                <table class="checkout-totals">
                  <tbody>
                    <tr>
                      <th>TỔNG CỘNG</th>
                      <td class="text_right">${{Cart::instance('cart')->subtotal()}}</td>
                    </tr>
                    <tr>
                      <th>VẬN CHUYỂN</th>
                      <td class="text_right">Miễn phí vận chuyển</td>
                    </tr>
                    <tr>
                      <th>VAT</th>
                      <td class="text_right">${{Cart::instance('cart')->tax()}}</td>
                    </tr>
                    <tr>
                      <th>TỔNG</th>
                      <td class="text_right">${{Cart::instance('cart')->total()}}</td>
                    </tr>
                  </tbody>
                </table>
                @endif
              </div>
              <div class="checkout__payment-methods">
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode1" value="card" disabled>
                  <label class="form-check-label" for="mode1">
                    Thẻ tín dụng hoặc thẻ ghi nợ                   
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode2" value="paypal" disabled>
                  <label class="form-check-label" for="mode2">
                    Paypal                   
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode3" value="cod">
                  <label class="form-check-label" for="mode3">
                    Thanh toán khi nhận hàng                   
                  </label>
                </div>
               
                <div class="policy-text">
                  Dữ liệu cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng, hỗ trợ trải nghiệm của bạn trên trang web này và cho các mục đích khác như đã mô tả trong <a href="terms.html" target="_blank">chính sách bảo mật</a>.
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-checkout" disabled>ĐẶT HÀNG</button>
            </div>
          </div>
        </div>
      </form>
    </section>
  </main>

@endsection

<script>
  document.addEventListener('DOMContentLoaded', function() {
      const codRadio = document.getElementById('mode3');
      const placeOrderButton = document.querySelector('.btn-checkout');
      placeOrderButton.disabled = !codRadio.checked;    
      const paymentMethods = document.querySelectorAll('input[name="mode"]');
      paymentMethods.forEach(radio => {
          radio.addEventListener('change', function() {              
              placeOrderButton.disabled = !codRadio.checked;              
              if (codRadio.checked) {
                  placeOrderButton.classList.remove('opacity-50', 'cursor-not-allowed');
              } else {
                  placeOrderButton.classList.add('opacity-50', 'cursor-not-allowed');
              }
          });
      });     
      document.querySelector('form[name="checkout-form"]').addEventListener('submit', function(e) {
          if (!codRadio.checked) {
              e.preventDefault();
              alert('Vui lòng chọn phương thức thanh toán khi nhận hàng để đặt đơn hàng của bạn.');
              return false;
          }
      });
  });
</script>
