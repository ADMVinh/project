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
                    <h2>Chỉnh Sửa Đánh Giá</h2>
                    <p class="text-muted">Bạn có thể chỉnh sửa đánh giá trong vòng 24 giờ sau khi đăng</p>
                </div>

                <!-- Product Info Card -->
                <div class="product-review-card mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <img src="{{ asset('uploads/products') }}/{{ $review->product->image }}" 
                                 alt="{{ $review->product->name }}" 
                                 class="img-fluid rounded">
                        </div>
                        <div class="col-md-9">
                            <h5>{{ $review->product->name }}</h5>
                            <p class="mb-0">
                                <small class="text-muted">
                                    Đánh giá gốc: {{ $review->created_at->format('d/m/Y H:i') }}
                                </small>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Edit Form -->
                <div class="product-review-card">
                    <form method="POST" action="{{ route('user.review.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="review_id" value="{{ $review->id }}">

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Đánh giá của bạn <span class="text-danger">*</span>
                            </label>
                            <div class="rating-stars">
                                <input type="radio" id="star5" name="rating" value="5" 
                                       {{ $review->rating == 5 ? 'checked' : '' }} required>
                                <label for="star5" title="5 sao">★</label>
                                
                                <input type="radio" id="star4" name="rating" value="4"
                                       {{ $review->rating == 4 ? 'checked' : '' }}>
                                <label for="star4" title="4 sao">★</label>
                                
                                <input type="radio" id="star3" name="rating" value="3"
                                       {{ $review->rating == 3 ? 'checked' : '' }}>
                                <label for="star3" title="3 sao">★</label>
                                
                                <input type="radio" id="star2" name="rating" value="2"
                                       {{ $review->rating == 2 ? 'checked' : '' }}>
                                <label for="star2" title="2 sao">★</label>
                                
                                <input type="radio" id="star1" name="rating" value="1"
                                       {{ $review->rating == 1 ? 'checked' : '' }}>
                                <label for="star1" title="1 sao">★</label>
                            </div>
                            @error('rating')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Tiêu đề đánh giá</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $review->title) }}"
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
                                      placeholder="Chia sẻ chi tiết về trải nghiệm của bạn..."
                                      maxlength="1000"
                                      required>{{ old('comment', $review->comment) }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tối đa 1000 ký tự</small>
                        </div>

                        <!-- Warning -->
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i>
                            <strong>Lưu ý:</strong> Sau khi chỉnh sửa, đánh giá của bạn sẽ cần được kiểm duyệt lại trước khi hiển thị.
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save"></i> Lưu thay đổi
                            </button>
                            <a href="{{ route('user.my.reviews') }}" class="btn btn-outline-secondary btn-lg">
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
    
    // Character counter
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