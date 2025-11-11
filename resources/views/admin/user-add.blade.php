@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Thông tin người dùng</h3>
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
                    <a href="{{route('admin.users')}}">
                        <div class="text-tiny">Người dùng</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">{{isset($user) ? 'Chỉnh sửa' : 'Thêm mới'}}</div>
                </li>
            </ul>
        </div>
        
        <div class="wg-box">
            <form class="form-new-product form-style-1" 
                  action="{{isset($user) ? route('admin.user.update') : route('admin.user.store')}}" 
                  method="POST">
                @csrf
                @if(isset($user))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$user->id}}">
                @endif

                <fieldset class="name">
                    <div class="body-title">Họ và tên <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Nhập họ và tên" 
                           name="name" tabindex="0" value="{{old('name', $user->name ?? '')}}" 
                           aria-required="true" required="">
                </fieldset>
                @error('name') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Email <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="email" placeholder="Nhập email" 
                           name="email" tabindex="0" value="{{old('email', $user->email ?? '')}}" 
                           aria-required="true" required="">
                </fieldset>
                @error('email') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Số điện thoại <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Nhập số điện thoại" 
                           name="mobile" tabindex="0" value="{{old('mobile', $user->mobile ?? '')}}" 
                           aria-required="true" required="">
                </fieldset>
                @error('mobile') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="category">
                    <div class="body-title">Loại người dùng <span class="tf-color-1">*</span></div>
                    <div class="select flex-grow">
                        <select name="utype" required="">
                            <option value="">Chọn loại người dùng</option>
                            <option value="USER" {{old('utype', $user->utype ?? '') == 'USER' ? 'selected' : ''}}>
                                Khách hàng
                            </option>
                            <option value="ADM" {{old('utype', $user->utype ?? '') == 'ADM' ? 'selected' : ''}}>
                                Quản trị viên
                            </option>
                        </select>
                    </div>
                </fieldset>
                @error('utype') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">
                        Mật khẩu 
                        @if(!isset($user))
                            <span class="tf-color-1">*</span>
                        @else
                            <span class="text-tiny">(Để trống nếu không đổi)</span>
                        @endif
                    </div>
                    <input class="flex-grow" type="password" placeholder="Nhập mật khẩu" 
                           name="password" tabindex="0" {{!isset($user) ? 'required' : ''}}>
                </fieldset>
                @error('password') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">
                        Xác nhận mật khẩu
                        @if(!isset($user))
                            <span class="tf-color-1">*</span>
                        @endif
                    </div>
                    <input class="flex-grow" type="password" placeholder="Xác nhận mật khẩu" 
                           name="password_confirmation" tabindex="0" {{!isset($user) ? 'required' : ''}}>
                </fieldset>

                <fieldset>
                    <div class="body-title mb-10">Trạng thái email</div>
                    <div class="radio-buttons">
                        <div class="item">
                            <input type="checkbox" name="email_verified" id="email_verified" 
                                   {{old('email_verified', isset($user) && $user->email_verified_at) ? 'checked' : ''}}>
                            <label for="email_verified">
                                <span class="body-title-2">Email đã được xác thực</span>
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">
                        {{isset($user) ? 'Cập nhật' : 'Thêm mới'}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection