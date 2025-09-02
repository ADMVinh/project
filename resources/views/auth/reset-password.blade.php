@extends('layouts.app')
@section('content')
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>

    <div>
        <label for="password">Mật khẩu mới *</label>
        <input type="password" name="password" id="password" required>
    </div>

    <div>
        <label for="password_confirmation">Nhập lại mật khẩn *</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
    </div>

    <button type="submit">Đặt lại mật khẩu</button>
</form>
@endsection