@extends('layouts.app')
@section('content')
<main class="pt-90">
    <section class="container">
        <h2>Sửa Địa Chỉ</h2>
        <form action="{{ route('user.edit.address', $address->id) }}" method="POST">
            @csrf
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="name" required value="{{ old('name', $address->name) }}">
                        <label for="name">Họ Tên *</label>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="phone" required value="{{ old('phone', $address->phone) }}">
                        <label for="phone">Số Điện Thoại *</label>
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="zip" required value="{{ old('zip', $address->zip) }}">
                        <label for="zip">Mã Bưu Chính *</label>
                        @error('zip') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mt-3 mb-3">
                        <input type="text" class="form-control" name="state" required value="{{ old('state', $address->state) }}">
                        <label for="state">Tỉnh / Thành Phố *</label>
                        @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="city" required value="{{ old('city', $address->city) }}">
                        <label for="city">Thị Trấn / Thành Phố *</label>
                        @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="address" required value="{{ old('address', $address->address) }}">
                        <label for="address">Số Nhà, Tên Tòa Nhà *</label>
                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="locality" required value="{{ old('locality', $address->locality) }}">
                        <label for="locality">Tên Đường, Khu Vực, Khu Dân Cư *</label>
                        @error('locality') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="country" required value="{{ old('country', $address->country) }}">
                        <label for="country">Quốc Gia *</label>
                        @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" name="landmark" required value="{{ old('landmark', $address->landmark) }}">
                        <label for="landmark">Điểm Đặc Biệt *</label>
                        @error('landmark') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group text-right mt-3">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection
