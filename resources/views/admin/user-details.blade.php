@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Chi tiết người dùng</h3>
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
                    <div class="text-tiny">Chi tiết</div>
                </li>
            </ul>
        </div>

        @if(Session::has('status'))
            <div class="alert alert-success">{{Session::get('status')}}</div>
        @endif

        <div class="wg-box">
            <div class="flex items-center justify-between">
                <h5>Thông tin người dùng #{{$user->id}}</h5>
                <div class="flex gap10">
                    @if($user->email_verified_at)
                        <form action="{{route('admin.user.unverify.email', $user->id)}}" method="POST">
                            @csrf
                            <button type="submit" class="tf-button style-2">
                                <i class="icon-x-circle"></i> Hủy xác thực email
                            </button>
                        </form>
                    @else
                        <form action="{{route('admin.user.verify.email', $user->id)}}" method="POST">
                            @csrf
                            <button type="submit" class="tf-button style-1">
                                <i class="icon-check-circle"></i> Xác thực email
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{route('admin.user.edit', $user->id)}}" class="tf-button">
                        <i class="icon-edit"></i> Chỉnh sửa
                    </a>
                </div>
            </div>

            <div class="divider"></div>

            <div class="row">
                <div class="col-md-6">
                    <div class="wg-box">
                        <h6 class="mb-20">Thông tin cơ bản</h6>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width: 180px;">ID:</th>
                                    <td>{{$user->id}}</td>
                                </tr>
                                <tr>
                                    <th>Họ và tên:</th>
                                    <td><strong>{{$user->name}}</strong></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>
                                        {{$user->email}}
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success ms-2">
                                                <i class="icon-check"></i> Đã xác thực
                                            </span>
                                        @else
                                            <span class="badge bg-warning ms-2">
                                                <i class="icon-alert-circle"></i> Chưa xác thực
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Số điện thoại:</th>
                                    <td>{{$user->mobile}}</td>
                                </tr>
                                <tr>
                                    <th>Loại người dùng:</th>
                                    <td>
                                        @if($user->utype === 'ADM')
                                            <span class="badge bg-danger">Quản trị viên</span>
                                        @else
                                            <span class="badge bg-primary">Khách hàng</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="wg-box">
                        <h6 class="mb-20">Thông tin hệ thống</h6>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width: 180px;">Ngày tạo:</th>
                                    <td>{{$user->created_at->format('d/m/Y H:i:s')}}</td>
                                </tr>
                                <tr>
                                    <th>Cập nhật lần cuối:</th>
                                    <td>{{$user->updated_at->format('d/m/Y H:i:s')}}</td>
                                </tr>
                                @if($user->email_verified_at)
                                <tr>
                                    <th>Xác thực email lúc:</th>
                                    <td>{{$user->email_verified_at->format('d/m/Y H:i:s')}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Tổng đơn hàng:</th>
                                    <td><strong>0</strong></td>
                                </tr>
                                <tr>
                                    <th>Tổng chi tiêu:</th>
                                    <td><strong>0đ</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="flex items-center justify-between gap10">
                <a href="{{route('admin.users')}}" class="tf-button style-3">
                    <i class="icon-arrow-left"></i> Quay lại
                </a>
                
                @if($user->id !== auth()->id())
                <form action="{{route('admin.user.delete', $user->id)}}" method="POST" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="tf-button style-1 btn-danger delete-btn">
                        <i class="icon-trash-2"></i> Xóa người dùng
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function(){
        $('.delete-btn').on('click', function(e){
            e.preventDefault();
            swal({
                title: "Bạn có chắc chắn?",
                text: "Bạn muốn xóa người dùng này? Hành động này không thể hoàn tác!",
                type: "warning",
                buttons: ["Hủy", "Xóa"],
                confirmButtonColor: "#dc3545"
            }).then(function(result){
                if(result){
                    $('#delete-form').submit();
                }
            });
        });
    });
</script>
@endpush