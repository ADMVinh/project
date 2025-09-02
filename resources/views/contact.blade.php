@extends('layouts.app')
@section('content')
<style>
    .text-danger2 {
    color: #dc3545 !important;
}
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">LIÊN HỆ CHÚNG TÔI</h2>
      </div>
    </section>

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us container">
      <div class="mw-930">
        <div class="contact-us__form">
            @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>                
            @endif
          <form name="contact-us-form" class="needs-validation" novalidate="" action="{{route('home.contact.store')}}" method="POST">
            @csrf
            <h3 class="mb-5">Liên hệ với chúng tôi</h3>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="name" placeholder="Họ tên *" value="{{old('name')}}" required="">
              <label for="contact_us_name">Họ tên *</label>
              @error('name')<span class="text-danger1">{{$message}}</span> @enderror
            </div>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="phone" placeholder="Số điện thoại *" value="{{old('phone')}}" required="">
              <label for="contact_us_name">Số điện thoại *</label>
               @error('phone')<span class="text-danger2">{{$message}}</span> @enderror
            </div>
            <div class="form-floating my-4">
              <input type="email" class="form-control" name="email" placeholder="Địa chỉ email *" value="{{old('email')}}" required="">
              <label for="contact_us_name">Địa chỉ email *</label>
               @error('email')<span class="text-danger3">{{$message}}</span> @enderror
            </div>
            <div class="my-4">
              <textarea class="form-control form-control_gray" name="comment" placeholder="Tin nhắn của bạn"  cols="30"
                rows="8" required="">{{old('comment')}}</textarea>
               @error('comment')<span class="text-danger4">{{$message}}</span> @enderror
            </div>
            <div class="my-4">
              <button type="submit" class="btn btn-primary">Gửi đi</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
@endsection
