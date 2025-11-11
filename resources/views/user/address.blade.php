@extends('layouts.app')
@section('content')
<style>
    .address-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        background: #fff;
        margin-top: 20px;
    }

    .address-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .address-card-header h5 {
        font-size: 18px;
        font-weight: 600;
        display: flex;
        align-items: center;
        margin: 0;
    }

    .address-card-header i.fa-map-marker-alt {
        font-size: 20px;
        margin-right: 10px;
    }

    .address-card-header .btn-edit {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 8px 20px;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .address-card-header .btn-edit:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .address-card-body {
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

    .verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #d4edda;
        color: #155724;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .unverified-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fff3cd;
        color: #856404;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .verified-badge i,
    .unverified-badge i {
        font-size: 14px;
    }

    .empty-address {
        text-align: center;
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 12px;
        margin-top: 20px;
    }

    .empty-address i {
        font-size: 64px;
        color: #ccc;
        margin-bottom: 20px;
    }

    .empty-address h5 {
        color: #666;
        margin-bottom: 10px;
    }

    .empty-address p {
        color: #999;
        margin-bottom: 0;
    }

    .form-section {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 30px;
        margin-top: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .form-section-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #667eea;
    }

    .form-section-header i {
        font-size: 24px;
        color: #667eea;
        margin-right: 12px;
    }

    .form-section-header h5 {
        margin: 0;
        color: #333;
        font-weight: 600;
    }

    .user-info-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-left: 4px solid #667eea;
    }

    .user-info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .user-info-row:last-child {
        margin-bottom: 0;
    }

    .user-info-label {
        font-weight: 500;
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-info-value {
        font-weight: 600;
        color: #333;
    }

    @media (max-width: 768px) {
        .address-info-row {
            flex-direction: column;
        }
        
        .info-label {
            margin-bottom: 5px;
            min-width: auto;
        }

        .address-card-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .address-card-header h5 {
            justify-content: center;
            flex-wrap: wrap;
        }

        .user-info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
    }
</style>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Địa Chỉ Của Tôi</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__address">
                    <!-- Thông tin user -->
                    <div class="user-info-card">
                        <div class="user-info-row">
                            <div class="user-info-label">
                                <i class="fas fa-user-circle"></i>
                                <span>Tên tài khoản:</span>
                            </div>
                            <div class="user-info-value">{{ Auth::user()->name }}</div>
                        </div>
                        <div class="user-info-row">
                            <div class="user-info-label">
                                <i class="fas fa-envelope"></i>
                                <span>Email:</span>
                            </div>
                            <div class="user-info-value">
                                {{ Auth::user()->email }}
                                @if(Auth::user()->email_verified_at)
                                    <span class="verified-badge ms-2">
                                        <i class="fas fa-check-circle"></i>
                                        Đã xác thực
                                    </span>
                                @else
                                    <span class="unverified-badge ms-2">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Chưa xác thực
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($address)
                        <div class="address-card">
                            <div class="address-card-header">
                                <h5>
                                    <i class="fas fa-map-marker-alt"></i>
                                    Địa Chỉ Giao Hàng
                                </h5>
                                <a href="{{ route('user.edit.address', $address->id) }}" class="btn-edit">
                                    <i class="fas fa-edit me-1"></i> Chỉnh sửa
                                </a>
                            </div>
                            <div class="address-card-body">
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
                    @else
                        <div class="form-section">
                            <div class="form-section-header">
                                <i class="fas fa-plus-circle"></i>
                                <h5>Thêm Địa Chỉ Mới</h5>
                            </div>
                            <form action="{{ route('user.add.address') }}" method="POST"> 
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="name" required="" value="{{old('name')}}">
                                            <label for="name">Họ Tên *</label>
                                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="phone" required="" value="{{old('phone')}}">
                                            <label for="phone">Số Điện Thoại *</label>
                                            @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="zip" required="" value="{{old('zip')}}">
                                            <label for="zip">Mã Bưu Chính *</label>
                                            @error('zip') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="state" required="" value="{{old('state')}}">
                                            <label for="state">Tỉnh / Thành Phố *</label>
                                            @error('state') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="city" required="" value="{{old('city')}}">
                                            <label for="city">Thị Trấn / Thành Phố *</label>
                                            @error('city') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="address" required="" value="{{old('address')}}">
                                            <label for="address">Số Nhà, Tên Tòa Nhà *</label>
                                            @error('address') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="locality" required="" value="{{old('locality')}}">
                                            <label for="locality">Tên Đường, Khu Vực, Khu Dân Cư *</label>
                                            @error('locality') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" id="country" name="country" required value="{{old('country')}}">
                                            <label for="country">Quốc Gia *</label>
                                            @error('country') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" name="landmark" required="" value="{{old('landmark')}}">
                                            <label for="landmark">Điểm Đặc Biệt *</label>
                                            @error('landmark') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-end mt-3">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="fas fa-save me-2"></i>
                                            Lưu Địa Chỉ
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection