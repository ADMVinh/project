@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Chi Tiết Đánh Giá #{{ $review->id }}</h3>
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
                    <a href="{{route('admin.reviews')}}">
                        <div class="text-tiny">Đánh giá</div>
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
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="wg-box">
            <div class="row">
                <!-- Left Column - Review Details -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Thông Tin Đánh Giá</h5>
                        </div>
                        <div class="card-body">
                            <!-- Product Info -->
                            <div class="mb-4 pb-4 border-bottom">
                                <h6 class="mb-3">Sản phẩm</h6>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('uploads/products/thumbnails') }}/{{ $review->product->image }}" 
                                         alt="{{ $review->product->name }}" 
                                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                                    <div>
                                        <div class="fw-bold">{{ $review->product->name }}</div>
                                        <small class="text-muted">SKU: {{ $review->product->SKU }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="mb-4 pb-4 border-bottom">
                                <h6 class="mb-3">Người đánh giá</h6>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $review->user->name }}</div>
                                        <small class="text-muted">{{ $review->user->email }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="mb-4 pb-4 border-bottom">
                                <h6 class="mb-3">Đánh giá</h6>
                                <div class="d-flex align-items-center gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fa fa-star text-warning" style="font-size: 24px;"></i>
                                        @else
                                            <i class="fa fa-star-o text-muted" style="font-size: 24px;"></i>
                                        @endif
                                    @endfor
                                    <span class="fs-5 fw-bold ms-2">{{ $review->rating }}/5</span>
                                </div>
                            </div>

                            <!-- Review Content -->
                            <div class="mb-4">
                                @if($review->title)
                                <h6 class="mb-2">{{ $review->title }}</h6>
                                @endif
                                <p class="mb-3">{{ $review->comment }}</p>
                                
                                <div class="d-flex gap-2 flex-wrap">
                                    @if($review->verified_purchase)
                                        <span class="badge bg-info">
                                            <i class="fa fa-check-circle"></i> Đã mua hàng
                                        </span>
                                    @endif
                                    
                                    @if($review->status == 'pending')
                                        <span class="badge bg-warning">Chờ duyệt</span>
                                    @elseif($review->status == 'approved')
                                        <span class="badge bg-success">Đã duyệt</span>
                                    @else
                                        <span class="badge bg-danger">Từ chối</span>
                                    @endif
                                </div>
                            </div>

                            <div class="text-muted small">
                                Đăng ngày: {{ $review->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>

                    <!-- Replies Section -->
                    @if($review->replies->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Câu trả lời ({{ $review->replies->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @foreach($review->replies as $reply)
                            <div class="mb-3 p-3 border rounded {{ !$loop->last ? 'mb-3' : '' }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa fa-user-circle text-primary" style="font-size: 24px;"></i>
                                        <div>
                                            <div class="fw-bold">{{ $reply->user->name }}</div>
                                            <small class="text-muted">{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div>
                                    @if($reply->user->utype == 'ADM')
                                        <span class="badge bg-primary">Admin</span>
                                    @endif
                                </div>
                                <p class="mb-0">{{ $reply->comment }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Reply Form -->
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Trả lời đánh giá</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.review.reply') }}">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $review->id }}">
                                
                                <div class="mb-3">
                                    <label class="form-label">Nội dung trả lời <span class="text-danger">*</span></label>
                                    <textarea name="comment" 
                                              class="form-control @error('comment') is-invalid @enderror" 
                                              rows="4" 
                                              placeholder="Nhập câu trả lời của bạn..."
                                              required>{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-reply"></i> Gửi câu trả lời
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Actions -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Hành động</h5>
                        </div>
                        <div class="card-body">
                            <!-- Status Update -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cập nhật trạng thái</label>
                                <form method="POST" action="{{ route('admin.review.status.update') }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="review_id" value="{{ $review->id }}">
                                    
                                    <select name="status" class="form-select mb-2">
                                        <option value="pending" {{ $review->status == 'pending' ? 'selected' : '' }}>
                                            Chờ duyệt
                                        </option>
                                        <option value="approved" {{ $review->status == 'approved' ? 'selected' : '' }}>
                                            Duyệt
                                        </option>
                                        <option value="rejected" {{ $review->status == 'rejected' ? 'selected' : '' }}>
                                            Từ chối
                                        </option>
                                    </select>
                                    
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fa fa-check"></i> Cập nhật
                                    </button>
                                </form>
                            </div>

                            <hr>

                            <!-- Quick Actions -->
                            <div class="d-grid gap-2">
                                @if($review->status == 'pending')
                                    <form method="POST" action="{{ route('admin.review.status.update') }}" onsubmit="return confirm('Duyệt đánh giá này?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="review_id" value="{{ $review->id }}">
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fa fa-check"></i> Duyệt ngay
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('admin.review.status.update') }}" onsubmit="return confirm('Từ chối đánh giá này?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="review_id" value="{{ $review->id }}">
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-warning w-100">
                                            <i class="fa fa-times"></i> Từ chối
                                        </button>
                                    </form>
                                @endif
                                
                                <form method="POST" 
                                      action="{{ route('admin.review.delete', $review->id) }}" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fa fa-trash"></i> Xóa đánh giá
                                    </button>
                                </form>

                                <a href="{{ route('admin.reviews') }}" class="btn btn-secondary w-100">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Thông tin thêm</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <small class="text-muted">ID đánh giá:</small>
                                <div class="fw-bold">{{ $review->id }}</div>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Ngày tạo:</small>
                                <div>{{ $review->created_at->format('d/m/Y H:i:s') }}</div>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Cập nhật cuối:</small>
                                <div>{{ $review->updated_at->format('d/m/Y H:i:s') }}</div>
                            </div>
                            @if($review->orderItem)
                            <div class="mb-2">
                                <small class="text-muted">Đơn hàng:</small>
                                <div>
                                    <a href="{{ route('admin.order.details', $review->orderItem->order_id) }}">
                                        #{{ $review->orderItem->order_id }}
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #6c757d;
}
</style>
@endsection