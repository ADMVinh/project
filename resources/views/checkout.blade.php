@extends('layouts.app')
@section('content')
<style>
  .btn-checkout:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  .shipping-address-card {
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    background: #fff;
    margin-top: 20px;
  }

  .shipping-address-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 25px;
  }

  .shipping-address-header h5 {
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
    margin: 0;
  }

  .shipping-address-header i {
    font-size: 20px;
    margin-right: 10px;
  }

  .shipping-address-body {
    padding: 25px;
  }

  .address-info-row {
    display: flex;
    margin-bottom: 16px;
    align-items: flex-start;
  }

  .address-info-row:last-child {
    margin-bottom: 0;
  }

  .info-label {
    display: flex;
    align-items: center;
    min-width: 150px;
    font-weight: 600;
    color: #555;
    gap: 10px;
  }

  .info-label i {
    width: 20px;
    color: #667eea;
    font-size: 16px;
  }

  .info-value {
    flex: 1;
    color: #333;
    line-height: 1.5;
  }

  .address-divider {
    height: 1px;
    background: linear-gradient(to right, transparent, #e0e0e0, transparent);
    margin: 20px 0;
  }

  @media (max-width: 768px) {
    .address-info-row {
      flex-direction: column;
    }
    
    .info-label {
      margin-bottom: 5px;
      min-width: auto;
    }
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
                    <div class="shipping-address-card">
                        <div class="shipping-address-header">
                            <h5>
                                <i class="fas fa-map-marker-alt"></i>
                                Địa chỉ giao hàng
                            </h5>
                        </div>
                        <div class="shipping-address-body">
                            <div class="address-info-row">
                                <div class="info-label">
                                    <i class="fas fa-user"></i>
                                    <span>Người nhận:</span>
                                </div>
                                <div class="info-value">{{$address->name}}</div>
                            </div>
                            
                            <div class="address-info-row">
                                <div class="info-label">
                                    <i class="fas fa-phone"></i>
                                    <span>Số điện thoại:</span>
                                </div>
                                <div class="info-value">{{$address->phone}}</div>
                            </div>
                            
                            <div class="address-divider"></div>
                            
                            <div class="address-info-row">
                                <div class="info-label">
                                    <i class="fas fa-home"></i>
                                    <span>Địa chỉ:</span>
                                </div>
                                <div class="info-value">{{$address->address}}</div>
                            </div>
                            
                            <div class="address-info-row">
                                <div class="info-label">
                                    <i class="fas fa-road"></i>
                                    <span>Khu vực:</span>
                                </div>
                                <div class="info-value">{{$address->locality}}</div>
                            </div>
                            
                            <div class="address-info-row">
                                <div class="info-label">
                                    <i class="fas fa-landmark"></i>
                                    <span>Điểm mốc:</span>
                                </div>
                                <div class="info-value">{{$address->landmark}}</div>
                            </div>
                            
                            <div class="address-info-row">
                                <div class="info-label">
                                    <i class="fas fa-city"></i>
                                    <span>Thành phố:</span>
                                </div>
                                <div class="info-value">{{$address->city}}, {{$address->state}}</div>
                            </div>
                            
                            <div class="address-info-row">
                                <div class="info-label">
                                    <i class="fas fa-mail-bulk"></i>
                                    <span>Mã bưu chính:</span>
                                </div>
                                <div class="info-value">{{$address->zip}}</div>
                            </div>
                            
                            <div class="address-info-row">
                                <div class="info-label">
                                    <i class="fas fa-globe"></i>
                                    <span>Quốc gia:</span>
                                </div>
                                <div class="info-value">{{$address->country}}</div>
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
                        {{formatVND($item->subtotal())}}
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
                          <td class="text_right">{{formatVND(Cart::instance('cart')->subtotal())}}</td>
                        </tr>
                        <tr>
                          <th>Giảm giá {{Session::get('coupon')['code']}}</th>
                          <td class="text_right text-danger">-{{formatVND(Session::get('discounts')['discount'])}}</td>
                        </tr>
                        <tr>
                          <th>Tổng phụ sau giảm giá</th>
                          <td class="text_right">{{formatVND(Session::get('discounts')['subtotal'])}}</td>
                        </tr>
                        <tr>
                          <th>Vận chuyển</th>
                          <td class="text_right">Miễn phí</td>
                        </tr>
                        <tr>
                          <th>VAT</th>
                          <td class="text_right">{{formatVND(Session::get('discounts')['tax'])}}</td>
                        </tr>
                        <tr>
                          <th>Tổng cộng</th>
                          <td class="text_right fw-bold text-primary">{{formatVND(Session::get('discounts')['total'])}}</td>
                        </tr>
                      </tbody>
                  </table>
                  @else
                  <table class="checkout-totals">
                    <tbody>
                      <tr>
                        <th>TỔNG CỘNG</th>
                        <td class="text_right">{{formatVND(Cart::instance('cart')->subtotal())}}</td>
                      </tr>
                      <tr>
                        <th>VẬN CHUYỂN</th>
                        <td class="text_right">Miễn phí vận chuyển</td>
                      </tr>
                      <tr>
                        <th>VAT</th>
                        <td class="text_right">{{formatVND(Cart::instance('cart')->tax())}}</td>
                      </tr>
                      <tr>
                        <th>TỔNG</th>
                        <td class="text_right fw-bold text-primary">{{formatVND(Cart::instance('cart')->total())}}</td>
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