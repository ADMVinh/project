@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Quản Lý Đánh Giá</h3>
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
                    <div class="text-tiny">Đánh giá</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <!-- Filter Section -->
            <div class="flex items-center justify-between gap10 flex-wrap mb-20">
                <form method="GET" action="{{ route('admin.reviews') }}" class="form-search">
                    <div class="flex gap-3">
                        <input type="text" 
                               name="search" 
                               placeholder="Tìm kiếm..." 
                               value="{{ request('search') }}"
                               class="form-control">
                        
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                        </select>
                        
                        <select name="rating" class="form-select" onchange="this.form.submit()">
                            <option value="">Tất cả đánh giá</option>
                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 sao</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 sao</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 sao</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 sao</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 sao</option>
                        </select>

                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </form>
            </div>

            @if(Session::has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                @if($reviews->count() > 0)
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Người dùng</th>
                            <th>Sản phẩm</th>
                            <th>Đánh giá</th>
                            <th>Tiêu đề</th>
                            <th>Nhận xét</th>
                            <th>Trạng thái</th>
                            <th>Mua hàng</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-bold">{{ $review->user->name }}</div>
                                        <small class="text-muted">{{ $review->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('uploads/products/thumbnails') }}/{{ $review->product->image }}" 
                                         alt="{{ $review->product->name }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    <div>
                                        <div class="text-small">{{ Str::limit($review->product->name, 30) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fa fa-star text-warning"></i>
                                        @else
                                            <i class="fa fa-star-o text-muted"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2">{{ $review->rating }}/5</span>
                                </div>
                            </td>
                            <td>{{ Str::limit($review->title, 30) }}</td>
                            <td>{{ Str::limit($review->comment, 50) }}</td>
                            <td class="text-center">
                                @if($review->status == 'pending')
                                    <span class="badge bg-warning">Chờ duyệt</span>
                                @elseif($review->status == 'approved')
                                    <span class="badge bg-success">Đã duyệt</span>
                                @else
                                    <span class="badge bg-danger">Từ chối</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($review->verified_purchase)
                                    <span class="badge bg-info">Đã mua</span>
                                @else
                                    <span class="badge bg-secondary">Chưa mua</span>
                                @endif
                            </td>
                            <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{ route('admin.review.details', $review->id) }}" 
                                       class="item eye" 
                                       title="Xem chi tiết">
                                        <i class="icon-eye"></i>
                                    </a>
                                    
                                    @if($review->status == 'pending')
                                        <form method="POST" 
                                              action="{{ route('admin.review.status.update') }}" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Duyệt đánh giá này?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="review_id" value="{{ $review->id }}">
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" 
                                                    class="item text-success" 
                                                    title="Duyệt"
                                                    style="border: none; background: none; cursor: pointer;">
                                                <i class="icon-check"></i>
                                            </button>
                                        </form>
                                        
                                        <form method="POST" 
                                              action="{{ route('admin.review.status.update') }}" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Từ chối đánh giá này?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="review_id" value="{{ $review->id }}">
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" 
                                                    class="item text-danger" 
                                                    title="Từ chối"
                                                    style="border: none; background: none; cursor: pointer;">
                                                <i class="icon-x"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form method="POST" 
                                          action="{{ route('admin.review.delete', $review->id) }}" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="item text-danger" 
                                                title="Xóa"
                                                style="border: none; background: none; cursor: pointer;">
                                            <i class="icon-trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $reviews->links('pagination::bootstrap-5') }}
                </div>
                @else
                <div class="text-center py-5">
                    <p class="text-muted">Chưa có đánh giá nào</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection