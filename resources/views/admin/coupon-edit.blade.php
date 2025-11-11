@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Thông tin mã giảm giá</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Bảng điều khiển</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{route('admin.coupons')}}">
                        <div class="text-tiny">Mã giảm giá</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Chỉnh sửa mã giảm giá</div>
                </li>
            </ul>
        </div>
        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST" action="{{route('admin.coupon.update')}}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{$coupon->id}}" />
                <fieldset class="name">
                    <div class="body-title">Mã giảm giá <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Coupon Code" name="code" tabindex="0" value="{{$coupon->code}}" aria-required="true" required="">
                </fieldset>
                @error('code') <span class="alert alert-danger text-danger">{{$message}}</span> @enderror
                <fieldset class="category">
                    <div class="body-title">Loại mã giảm giá</div>
                    <div class="select flex-grow">
                        <select class="" name="type">
                            <option value="">Chọn</option>
                            <option value="fixed" {{ $coupon->type=='fixed' ? 'selected':'' }}>Cố định</option>
                            <option value="percent" {{ $coupon->type=='percent' ? 'selected':'' }}>Phần trăm</option>
                        </select>
                    </div>
                </fieldset>
                @error('type') <span class="alert alert-danger text-danger">{{$message}}</span> @enderror
                <fieldset class="name">
                    <div class="body-title">Giá trị <span class="tf-color-1">*</span></div>
                    <input class="flex-grow format-vnd" type="text" placeholder="Nhập giá trị" name="value_display" id="value_display" tabindex="0" value="{{ $coupon->type == 'fixed' ? number_format($coupon->value, 0, ',', '.') : $coupon->value }}" aria-required="true" required="">
                    <input type="hidden" name="value" id="value" value="{{ $coupon->value }}">
                    <div class="text-tiny" id="value_hint">
                        {{ $coupon->type == 'fixed' ? 'Ví dụ: 50.000 (giảm 50k)' : 'Ví dụ: 10 (giảm 10%)' }}
                    </div>
                </fieldset>
                @error('value') <span class="alert alert-danger text-danger">{{$message}}</span> @enderror
                
                <fieldset class="name">
                    <div class="body-title">Giá trị giỏ hàng tối thiểu (VND) <span class="tf-color-1">*</span></div>
                    <input class="flex-grow format-vnd" type="text" placeholder="Nhập giá trị giỏ hàng" name="cart_value_display" id="cart_value_display" tabindex="0" value="{{ number_format($coupon->cart_value, 0, ',', '.') }}" aria-required="true" required="">
                    <input type="hidden" name="cart_value" id="cart_value" value="{{ $coupon->cart_value }}">
                    <div class="text-tiny">Ví dụ: 500.000 (giỏ hàng tối thiểu 500k mới áp dụng mã)</div>
                </fieldset>
                @error('cart_value') <span class="alert alert-danger text-danger">{{$message}}</span> @enderror
                <fieldset class="name">
                    <div class="body-title">Ngày hết hạn <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="date" placeholder="Expiry Date" name="expiry_date" tabindex="0" value="{{$coupon->expiry_date}}" aria-required="true"
                        required="">
                </fieldset>
                @error('expiry_date') <span class="alert alert-danger text-danger">{{$message}}</span> @enderror

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(function(){
            // Xử lý khi thay đổi loại mã giảm giá
            $("select[name='type']").on("change", function() {
                let type = $(this).val();
                let valueInput = $("#value_display");
                let valueHint = $("#value_hint");
                let currentValue = valueInput.val().replace(/\./g, ''); // Lấy giá trị hiện tại, xóa dấu chấm
                
                if (type === 'fixed') {
                    // Nếu chuyển sang Fixed, format VND
                    valueInput.attr('placeholder', 'Nhập số tiền (VND)');
                    valueHint.text('Ví dụ: 50.000 (giảm 50k)');
                    if (!isNaN(currentValue) && currentValue !== '') {
                        valueInput.val(formatNumber(currentValue));
                    }
                } else if (type === 'percent') {
                    // Nếu chuyển sang Percent, xóa format
                    valueInput.attr('placeholder', 'Nhập phần trăm (%)');
                    valueHint.text('Ví dụ: 10 (giảm 10%)');
                    // Xóa format VND nếu có
                    valueInput.val(currentValue);
                }
            });

            // Format VND cho giá trị (chỉ khi type = fixed)
            $("#value_display").on("input", function() {
                let type = $("select[name='type']").val();
                let value = $(this).val().replace(/\./g, ''); // Xóa dấu chấm cũ
                
                if (!isNaN(value) && value !== '') {
                    if (type === 'fixed') {
                        // Format VND nếu là fixed
                        $(this).val(formatNumber(value));
                        $("#value").val(value);
                    } else if (type === 'percent') {
                        // Không format nếu là percent, chỉ giới hạn 0-100
                        if (parseInt(value) > 100) {
                            value = '100';
                        }
                        $(this).val(value);
                        $("#value").val(value);
                    } else {
                        // Chưa chọn type, format VND mặc định
                        $(this).val(formatNumber(value));
                        $("#value").val(value);
                    }
                }
            });

            // Format VND cho giá trị giỏ hàng
            $("#cart_value_display").on("input", function() {
                let value = $(this).val().replace(/\./g, ''); // Xóa dấu chấm cũ
                if (!isNaN(value) && value !== '') {
                    // Format hiển thị
                    $(this).val(formatNumber(value));
                    // Lưu giá trị thật vào hidden input
                    $("#cart_value").val(value);
                }
            });

            // Khi submit form
            $("form").on("submit", function() {
                let type = $("select[name='type']").val();
                
                // Xử lý giá trị
                let valueDisplay = $("#value_display").val().replace(/\./g, '');
                $("#value").val(valueDisplay);
                
                // Xử lý giá trị giỏ hàng
                let cartValueDisplay = $("#cart_value_display").val().replace(/\./g, '');
                $("#cart_value").val(cartValueDisplay);
                
                // Validation
                if (!type) {
                    alert('Vui lòng chọn loại mã giảm giá!');
                    return false;
                }
                
                if (type === 'percent' && parseInt(valueDisplay) > 100) {
                    alert('Giá trị phần trăm không được vượt quá 100%!');
                    return false;
                }
            });
        });

        // Hàm format số thành dạng 1.000.000
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
@endpush
@endsection