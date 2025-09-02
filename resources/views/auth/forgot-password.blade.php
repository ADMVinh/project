
@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
      <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
            role="tab" aria-controls="tab-item-login" aria-selected="true">Đặt lại mật khẩu</a>
        </li>
      </ul>
      <div class="tab-content pt-2" id="login_register_tab_content">
        <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
          <div class="login-form">
            <form method="POST" action="{{ route('password.email') }}" >
                @csrf
              <div class="form-floating mb-3">
                <input class="form-control form-control_gray" type="email" name="email" id="email" required>
                <label for="email">Địa chỉ email *</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div> 
                <button class="btn btn-primary w-100 text-uppercase" type="submit">Đặt lại ngay</button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection
