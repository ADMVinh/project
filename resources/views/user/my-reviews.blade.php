@extends('layouts.app')
@section('content')

<style>
.review-status-badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.my-review-card {
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    transition: all 0.3s;
}

.my-review-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.rating-display {
    color: #ffc107;
    font-size: 1.2rem;
}

.review-actions {
    display: flex;
    gap: 10px;
}

.sidebar-account {
    position: sticky;
    top: 100px;
}
</style>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    
    <section class="my-account container">
        <h2 class="page-title">Đánh Giá Của Tôi</h2>
        
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sidebar-account">
                    <ul class="account-nav list-unstyled">
                        <li>
                            <a href="{{ route('user.index') }}" class="menu-link">
                                <i class="fa fa-dashboard"></i> Tổng quan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.orders') }}" class="menu-link">
                                <i class="fa fa-shopping-bag"></i> Đơn hàng
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.my.reviews') }}" class="menu-link menu-link_active">
                                <i class="fa fa-star"></i> Đánh giá của tôi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('wishlist.index') }}" class="menu-link">
                                <i class="fa fa-heart"></i> Danh sách yêu thích
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                                @csrf
                            </form>
                            <a href="{{ route('logout') }}" 
                               class="menu-link"
                               onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                                <i class="fa fa-sign-out"></i> Đăng xuất
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                @if(Session::has('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle"></i> {{ Session::get('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle"></i> {{ Session::get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Summary Stats -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm">
                            <div class="card-body">
                                <h3 class="text-primary mb-0">{{ $reviews->total() }}</h3>
                                <small class="text-muted">Tổng đánh giá</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm">
                            <div class="card-body">
                                <h3 class="text-success mb-0">
                                    {{ $reviews->where('status', 'approved')->count() }}
                                </h3>
                                <small class="text-muted">Đã duyệt</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm">
                            <div class="card-body">
                                <h3 class="text-warning mb-0">
                                    {{ $reviews->where('status', 'pending')->count() }}
                                </h3>
                                <small class="text-muted">Chờ duyệt</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews List -->
                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                    <div class="my-review-card">
                        <div class="row">
                            <!-- Product Image -->
                            <div class="col-md-2">
                                <img src="{{ asset('uploads/products/thumbnails') }}/{{ $review->product->image }}" 
                                     alt="{{ $review->product->name }}" 
                                     class="img-fluid rounded"
                                     style="width: 100%; height: auto; object-fit: cover;">
                            </div>

                            <!-- Review Content -->
                            <div class="col-md-10">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">
                                            <a href="{{ route('shop.products.details', $review->product->slug) }}" 
                                               class="text-dark text-decoration-none">
                                                {{ $review->product->name }}
                                            </a>
                                        </h6>
                                        <div class="rating-display mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <div>
                                        @if($review->status == 'approved')
                                            <span class="review-status-badge bg-success text-white">
                                                <i class="fa fa-check"></i> Đã duyệt
                                            </span>
                                        @elseif($review->status == 'pending')
                                            <span class="review-status-badge bg-warning text-dark">
                                                <i class="fa fa-clock-o"></i> Chờ duyệt
                                            </span>
                                        @else
                                            <span class="review-status-badge bg-danger text-white">
                                                <i class="fa fa-times"></i> Từ chối
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if($review->title)
                                    <h6 class="fw-bold mb-2">{{ $review->title }}</h6>
                                @endif

                                <p class="mb-3">{{ Str::limit($review->comment, 200) }}</p>

                                <!-- Review Details -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">
                                            <i class="fa fa-calendar"></i> 
                                            {{ $review->created_at->format('d/m/Y H:i') }}
                                        </small>
                                        @if($review->verified_purchase)
                                            <small class="text-success ms-2">
                                                <i class="fa fa-check-circle"></i> Đã mua hàng
                                            </small>
                                        @endif
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="review-actions">
                                        @if($review->canEdit(Auth::id()))
                                            <a href="{{ route('user.review.edit', $review->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-edit"></i> Chỉnh sửa
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('shop.products.details', $review->product->slug) }}#review-{{ $review->id }}" 
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="fa fa-eye"></i> Xem
                                        </a>
                                    </div>
                                </div>

                                <!-- Admin Replies -->
                                @if($review->replies->count() > 0)
                                    <div class="mt-3 p-3 bg-light rounded">
                                        <h6 class="mb-2">
                                            <i class="fa fa-reply"></i> Phản hồi từ Admin
                                        </h6>
                                        @foreach($review->replies as $reply)
                                            <div class="mb-2">
                                                <div class="d-flex align-items-center mb-1">
                                                    <strong>{{ $reply->user->name }}</strong>
                                                    <span class="badge bg-primary ms-2">Admin</span>
                                                    <small class="text-muted ms-2">
                                                        {{ $reply->created_at->format('d/m/Y H:i') }}
                                                    </small>
                                                </div>
                                                <p class="mb-0">{{ $reply->comment }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $reviews->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-star-o" style="font-size: 5rem; color: #ddd;"></i>
                        <h4 class="mt-3 text-muted">Bạn chưa có đánh giá nào</h4>
                        <p class="text-muted mb-4">
                            Hãy mua sắm và đánh giá sản phẩm để chia sẻ trải nghiệm của bạn
                        </p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">
                            <i class="fa fa-shopping-bag"></i> Khám phá sản phẩm
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <div class="mb-5 pb-5"></div>
</main>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Smooth scroll to review
    $('a[href*="#review-"]').on('click', function(e) {
        var target = $(this.hash);
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });
});
</script>
@endpush