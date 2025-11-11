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
                    <div class="text-tiny">Mã giảm giá mới</div>
                </li>
            </ul>
        </div>
        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST" action="{{route('admin.coupon.store')}}">
                @csrf
                <fieldset class="name">
                    <div class="body-title">Mã giảm giá <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Coupon Code" name="code" tabindex="0" value="{{old('code')}}" aria-required="true" required="">
                </fieldset>
                @error('code') <span class="alert alert-danger text-danger">{{$message}}</span> @enderror
                <fieldset class="category">
                    <div class="body-title">Loại mã giảm giá</div>
                    <div class="select flex-grow">
                        <select class="" name="type">
                            <option value="">Chọn</option>
                            <option value="fixed">Cố định</option>
                            <option value="percent">Phần trăm</option>
                        </select>
                    </div>
                </fieldset>
                @error('type') <span class="alert alert-danger text-danger">{{$message}}</span> @enderror
                <fieldset class="name">
                    <div class="body-title">Giá trị <span class="tf-color-1">*</span></div>
                    <input class="flex-grow format-vnd" type="text" placeholder="Nhập giá trị" name="value_display" id="value_display" tabindex="0" value="{{old('value')}}" aria-required="true" required="">
                    <input type="hidden" name="value" id="value">
                    <div class="text-tiny" id="value_hint">Nhập số tiền (VND) hoặc phần trăm (%)</div>
                </fieldset>
                @error('value') <span class="alert alert-danger text-danger">{{$message}}</span> @enderror
                
                <fieldset class="name">
                    <div class="body-title">Giá trị giỏ hàng tối thiểu (VND) <span class="tf-color-1">*</span></div>
                    <input class="flex-grow format-vnd" type="text" placeholder="Nhập giá trị giỏ hàng" name="cart_value_display" id="cart_value_display" tabindex="0" value="{{old('cart_value')}}" aria-required="true" required="">
                    <input type="hidden" name="cart_value" id="cart_value">
                    <div class="text-tiny">Ví dụ: 500.000 (giỏ hàng tối thiểu 500k mới áp dụng mã)</div>
                </fieldset>
                @error('cart_value') <span class="alert alert-danger text-danger">{{$message}}</span> @enderror
                <fieldset class="name">
                    <div class="body-title">Ngày hết hạn <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="date" placeholder="Expiry Date" name="expiry_date" tabindex="0" value="{{old('expiry_date')}}" aria-required="true"
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
                
                if (type === 'fixed') {
                    // Nếu là Fixed, format VND
                    valueInput.attr('placeholder', 'Nhập số tiền (VND)');
                    valueHint.text('Ví dụ: 50.000 (giảm 50k)');
                } else if (type === 'percent') {
                    // Nếu là Percent, không format
                    valueInput.attr('placeholder', 'Nhập phần trăm (%)');
                    valueHint.text('Ví dụ: 10 (giảm 10%)');
                    // Clear format nếu có
                    let currentValue = valueInput.val().replace(/\./g, '');
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