@extends('layouts.app')
@section('content')
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
                    <div class="row">
                        @if($address)
                        <div class="col-6 text-right">
                            <a href="{{ route('user.edit.address', $address->id) }}" class="btn btn-sm btn-info">Sửa</a>
                        </div>
                        @endif
                    </div>
                    <div class="my-account__address-list row">
                        <h5>Địa Chỉ Giao Hàng</h5>

                        @if($address)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="my-account__address-item__title">
                                        <h5>{{$address->name}} <i class="fa fa-check-circle text-success"></i></h5>
                                        
                                      </div>
                                    <div class="my-account_address-list">
                                        <div class="my-account_address-list-item">
                                            <div class="my-account_address-item_detail">
                
                                                <p>{{$address->address}}</p>
                                                <p>{{$address->landmark}}</p>
                                                <p>{{$address->city}}, {{$address->state}}, {{$address->country}}</p>
                                                <p>{{$address->zip}},{{$address->locality}}</p>
                                                <br />
                                                <p>{{$address->phone}}</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            @else
                            <form action="{{ route('user.add.address') }}" method="POST"> 
                            @csrf
                            <div class="row mt-5">
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
                                <div class="form-floating mt-3 mb-3">
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
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                <input type="text" class="form-control" name="landmark" required="" value="{{old('landmark')}}">
                                <label for="landmark">Điểm Đặc Biệt *</label>
                                @error('landmark') <span class="text-danger">{{$message}}</span> @enderror
                                </div>

                            </div>
                            <div class="col-md-12 text-right"> <button type="submit" class="btn btn-primary">Lưu Địa Chỉ</button> </div>
                            </div>
                            </form>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
