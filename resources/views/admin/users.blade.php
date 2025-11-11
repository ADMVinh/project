@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Quản lý người dùng</h3>
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
                    <div class="text-tiny">Người dùng</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET" action="{{route('admin.users')}}">
                        <fieldset class="name">
                            <input type="text" placeholder="Tìm kiếm theo tên, email, số điện thoại..." 
                                   class="" name="search" tabindex="2" value="{{request('search')}}" 
                                   aria-required="true">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.user.add')}}">
                    <i class="icon-plus"></i>Thêm người dùng mới
                </a>
            </div>

            <!-- Bộ lọc -->
            <div class="flex items-center justify-between gap10 flex-wrap mt-20">
                <form method="GET" action="{{route('admin.users')}}" class="flex gap10">
                    <select name="utype" class="form-select" onchange="this.form.submit()">
                        <option value="">Tất cả loại người dùng</option>
                        <option value="USER" {{request('utype') == 'USER' ? 'selected' : ''}}>Khách hàng</option>
                        <option value="ADM" {{request('utype') == 'ADM' ? 'selected' : ''}}>Quản trị viên</option>
                    </select>
                    <select name="verified" class="form-select" onchange="this.form.submit()">
                        <option value="">Tất cả trạng thái</option>
                        <option value="1" {{request('verified') == '1' ? 'selected' : ''}}>Đã xác thực</option>
                        <option value="0" {{request('verified') == '0' ? 'selected' : ''}}>Chưa xác thực</option>
                    </select>
                </form>
            </div>

            <div class="wg-table table-all-user mt-20">
                <div class="table-responsive">
                    @if(Session::has('status'))
                        <p class="alert alert-success">{{Session::get('status')}}</p>
                    @endif
                    @if(Session::has('error'))
                        <p class="alert alert-danger">{{Session::get('error')}}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Loại</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td class="pname">
                                    <div class="name">
                                        <a href="{{route('admin.user.details', $user->id)}}" class="body-title-2">
                                            {{$user->name}}
                                        </a>
                                    </div>
                                </td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->mobile}}</td>
                                <td>
                                    @if($user->utype === 'ADM')
                                        <span class="badge bg-danger">Quản trị viên</span>
                                    @else
                                        <span class="badge bg-primary">Khách hàng</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">Đã xác thực</span>
                                    @else
                                        <span class="badge bg-warning">Chưa xác thực</span>
                                    @endif
                                </td>
                                <td>{{$user->created_at->format('d/m/Y')}}</td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="{{route('admin.user.details', $user->id)}}" title="Chi tiết">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </a>
                                        <a href="{{route('admin.user.edit', $user->id)}}" title="Sửa">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{route('admin.user.delete', $user->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="item text-danger delete" title="Xóa">
                                                <i class="icon-trash-2"></i>
                                            </div>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{$users->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function(){
        $('.delete').on('click', function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Bạn có chắc chắn?",
                text: "Bạn muốn xóa người dùng này?",
                type: "warning",
                buttons: ["Không", "Có"],
                confirmButtonColor: "#dc3545"
            }).then(function(result){
                if(result){
                    form.submit();
                }
            });
        });
    });
</script>
@endpush