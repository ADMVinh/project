@extends('layouts.app')
@section('content')

<style>
.rating-stars {
    display: flex;
    gap: 10px;
    font-size: 2rem;
}

.rating-stars input[type="radio"] {
    display: none;
}

.rating-stars label {
    cursor: pointer;
    color: #ddd;
    transition: color 0.2s;
}

.rating-stars label:hover,
.rating-stars label:hover ~ label,
.rating-stars input[type="radio"]:checked ~ label {
    color: #ffc107;
}

.rating-stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.product-review-card {
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}
</style>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    
    <section class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="page-title mb-4">
                    <h2>Đánh Giá Sản Phẩm</h2>
                    <p class="text-muted">Chia sẻ trải nghiệm của bạn về sản phẩm này</p>
                </div>

                <!-- Product Info Card -->
                <div class="product-review-card mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <img src="{{ asset('uploads/products') }}/{{ $orderItem->product->image }}" 
                                 alt="{{ $orderItem->product->name }}" 
                                 class="img-fluid rounded">
                        </div>
                        <div class="col-md-9">
                            <h5>{{ $orderItem->product->name }}</h5>
                            <p class="text-muted mb-2">
                                <small>Đơn hàng #{{ $orderItem->order->id }}</small>
                            </p>
                            <p class="mb-0">
                                <span class="badge bg-success">Đã giao</span>
                                <small class="text-muted ms-2">
                                    {{ $orderItem->order->delivered_date ? \Carbon\Carbon::parse($orderItem->order->delivered_date)->format('d/m/Y') : '' }}
                                </small>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Review Form -->
                <div class="product-review-card">
                    <form method="POST" action="{{ route('user.review.store') }}">
                        @csrf
                        <input type="hidden" name="order_item_id" value="{{ $orderItem->id }}">
                        <input type="hidden" name="product_id" value="{{ $orderItem->product->id }}">

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Đánh giá của bạn <span class="text-danger">*</span>
                            </label>
                            <div class="rating-stars">
                                <input type="radio" id="star5" name="rating" value="5" required>
                                <label for="star5" title="5 sao">★</label>
                                
                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4" title="4 sao">★</label>
                                
                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3" title="3 sao">★</label>
                                
                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2" title="2 sao">★</label>
                                
                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1" title="1 sao">★</label>
                            </div>
                            @error('rating')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">Nhấp vào số sao để đánh giá</small>
                        </div>

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Tiêu đề đánh giá</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Tóm tắt ngắn gọn về đánh giá của bạn"
                                   maxlength="255">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">
                                Nhận xét của bạn <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                      id="comment" 
                                      name="comment" 
                                      rows="6" 
                                      placeholder="Chia sẻ chi tiết về trải nghiệm của bạn với sản phẩm này..."
                                      maxlength="1000"
                                      required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tối đa 1000 ký tự</small>
                        </div>

                        <!-- Guidelines -->
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="fa fa-info-circle"></i> Hướng dẫn viết đánh giá
                            </h6>
                            <ul class="mb-0 ps-3">
                                <li>Hãy chia sẻ trải nghiệm thật của bạn về sản phẩm</li>
                                <li>Đánh giá chi tiết về chất lượng, kích cỡ, màu sắc...</li>
                                <li>Tránh sử dụng ngôn từ không phù hợp</li>
                                <li>Đánh giá sẽ được kiểm duyệt trước khi hiển thị</li>
                            </ul>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-paper-plane"></i> Gửi đánh giá
                            </button>
                            <a href="{{ route('user.orders') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fa fa-times"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="mb-5 pb-5"></div>
</main>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle star rating hover effect
    $('.rating-stars label').hover(
        function() {
            $(this).addClass('hover');
            $(this).nextAll('label').addClass('hover');
        },
        function() {
            $('.rating-stars label').removeClass('hover');
        }
    );
    
    // Character counter for comment
    $('#comment').on('input', function() {
        var length = $(this).val().length;
        var maxLength = $(this).attr('maxlength');
        if (length > maxLength - 100) {
            $(this).next('.text-muted').html('Còn lại: ' + (maxLength - length) + ' ký tự');
        }
    });
});
</script>
@endpush