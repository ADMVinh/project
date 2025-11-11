@extends('layouts.app')

@section('content')
    <style>
        .pt-90 {
            padding-top: 90px !important;
        }

        .pr-6px {
            padding-right: 6px;
            text-transform: uppercase;
        }

        .my-account .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 40px;
            border-bottom: 1px solid;
            padding-bottom: 13px;
        }

        .my-account .wg-box {
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            padding: 24px;
            flex-direction: column;
            gap: 24px;
            border-radius: 12px;
            background: var(--White);
            box-shadow: 0px 4px 24px 2px rgba(20, 25, 38, 0.05);
        }

        .bg-success {
            background-color: #40c710 !important;
        }

        .bg-danger {
            background-color: #f44032 !important;
        }

        .bg-warning {
            background-color: #f5d700 !important;
            color: #000;
        }

        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;

        }

        .table-transaction th,
        .table-transaction td {
            padding: 0.625rem 1.5rem .25rem !important;
            color: #000 !important;
        }

        .table> :not(caption)>tr>th {
            padding: 0.625rem 1.5rem .25rem !important;
            background-color: #6a6e51 !important;
        }

        .table-bordered>:not(caption)>*>* {
            border-width: inherit;
            line-height: 32px;
            font-size: 14px;
            border: 1px solid #e1e1e1;
            vertical-align: middle;
        }

        .table-striped .image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            flex-shrink: 0;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-striped td:nth-child(1) {
            min-width: 250px;
            padding-bottom: 7px;
        }

        .pname {
            display: flex;
            gap: 13px;
        }

        .table-bordered> :not(caption)>tr>th,
        .table-bordered> :not(caption)>tr>td {
            border-width: 1px 1px;
            border-color: #6a6e51;
        }
    </style>
    <main class="pt-90" style="padding-top: 0px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Chi Tiết Đơn Hàng</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account-nav')
                </div>

                <div class="col-lg-10">
                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 flex-wrap">
                            <div class="row">
                                <div class="col-6">
                                    <h5>Chi Tiết Đơn Hàng</h5>
                                </div>
                                <div class="col-6 text-right" style="margin-top: -10px;">
                                    <a class="btn btn-sm btn-danger" href="{{ route('user.orders') }}">Quay Lại</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-transaction">
                                    <tr>
                                        <th>Mã Đơn Hàng</th>
                                        <td>{{ $order->id }}</td>
                                        <th>Số Điện Thoại</th>
                                        <td>{{ $order->phone }}</td>
                                        <th>Mã Bưu Điện</th>
                                        <td>{{ $order->zip }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày Đặt Hàng</th>
                                        <td>{{ $order->created_at }}</td>
                                        <th>Ngày Giao Hàng</th>
                                        <td>{{ $order->delivered_date }}</td>
                                        <th>Ngày Hủy</th>
                                        <td>{{ $order->canceled_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng Thái Đơn Hàng</th>
                                        <td colspan="5">
                                            @if ($order->status == 'delivered')
                                                <span class="badge bg-success">Đã Giao</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="badge bg-danger">Đã Hủy</span>
                                            @else
                                                <span class="badge bg-warning">Đã Đặt</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="wg-box">
                            <div class="flex items-center justify-between gap10 flex-wrap">
                                <div class="wg-filter flex-grow">
                                    <h5>Danh Sách Sản Phẩm</h5>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tên Sản Phẩm</th>
                                            <th class="text-center">Giá</th>
                                            <th class="text-center">Số Lượng</th>
                                            <th class="text-center">SKU</th>
                                            <th class="text-center">Danh Mục</th>
                                            <th class="text-center">Thương Hiệu</th>
                                            <th class="text-center">Tùy Chọn</th>
                                            <th class="text-center">Trạng Thái Hoàn Hàng</th>
                                            <th class="text-center">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItems as $item)
                                            <tr>
                                                <td class="pname">
                                                    <div class="image">
                                                        <img src="{{ asset('uploads/products/thumbnails') }}/{{ $item->product->image }}"
                                                             alt="{{ $item->product->name }}" class="image">
                                                    </div>
                                                    <div class="name">
                                                        <a href="{{ route('shop.products.details', ['product_slug' => $item->product->slug]) }}"
                                                           target="_blank" class="body-title-2">
                                                           {{ $item->product->name }}
                                                        </a>
                                                
                                                        <!-- Thêm vào phần hiển thị từng sản phẩm trong đơn hàng -->
                                                        <div class="d-flex align-items-center gap-3 mt-2">
                                                            @if($order->status == 'delivered')
                                                                @php
                                                                    $hasReview = \App\Models\Review::where('order_item_id', $item->id)
                                                                        ->where('user_id', Auth::id())
                                                                        ->exists();
                                                                @endphp
                                                                
                                                                @if(!$hasReview)
                                                                    <a href="{{ route('user.review.product', $item->id) }}" 
                                                                       class="btn btn-sm btn-primary">
                                                                        <i class="fa fa-star"></i> Đánh giá
                                                                    </a>
                                                                @else
                                                                    <span class="badge bg-success">
                                                                        <i class="fa fa-check"></i> Đã đánh giá
                                                                    </span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td class="text-center">{{formatVND( $item->price) }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-center">{{ $item->product->SKU }}</td>
                                                <td class="text-center">{{ $item->product->category->name }}</td>
                                                <td class="text-center">{{ $item->product->brand->name }}</td>
                                                <td class="text-center">{{ $item->options }}</td>
                                                <td class="text-center">{{ $item->rstatus == 0 ? 'Không' : 'Có' }}</td>
                                                <td class="text-center">
                                                    <div class="list-icon-function view-icon">
                                                        <div class="item eye">
                                                            <i class="icon-eye"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="divider"></div>
                            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                                {{ $orderItems->links('pagination::bootstrap-5') }}
                            </div>
                        </div>

                        <div class="wg-box mt-5">
                            <h5>Địa Chỉ Giao Hàng</h5>
                            <div class="my-account__address-item col-md-6">
                                <div class="my-account__address-item__detail">
                                    <p>{{ $order->name }}</p>
                                    <p>{{ $order->address }}</p>
                                    <p>{{ $order->locality }}</p>
                                    <p>{{ $order->city }}, {{ $order->country }}</p>
                                    <p>{{ $order->landmark }}</p>
                                    <p>{{ $order->zip }}</p>
                                    <br>
                                    <p>Số Điện Thoại: {{ $order->phone }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="wg-box mt-5">
                            <h5>Giao Dịch</h5>
                            <table class="table table-striped table-bordered table-transaction">
                                <tbody>
                                    <tr>
                                        <th>Tạm Tính</th>
                                        <td>{{formatVND( $order->subtotal) }}</td>
                                        <th>Thuế</th>
                                        <td>{{formatVND( $order->tax) }}</td>
                                        <th>Giảm Giá</th>
                                        <td>{{formatVND( $order->discount) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tổng Cộng</th>
                                        <td>{{formatVND( $order->total) }}</td>
                                        <th>Hình Thức Thanh Toán</th>
                                        <td>{{ $transaction ? $transaction->mode : 'Không Có' }}</td>
                                        <th>Trạng Thái</th>
                                        <td>
                                            @if ($transaction && $transaction->status == 'approved')
                                                <span class="badge bg-success">Đã Duyệt</span>
                                            @elseif($transaction && $transaction->status == 'declined')
                                                <span class="badge bg-danger">Bị Từ Chối</span>
                                            @elseif($transaction && $transaction->status == 'refunded')
                                                <span class="badge bg-secondary">Đã Hoàn Lại</span>
                                            @else
                                                <span class="badge bg-warning">Đang Chờ</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @if($order->status == 'ordered')
                        <div class="mg-box mt-5 text-right">
                            <form action="{{route('user.order.cancel')}}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="order_id" value="{{$order->id}}" />
                                <button type="button" class="btn btn-danger cancel-order">Hủy Đơn Hàng</button>
                            </form>
                        </div>
                        @endif
                    </div>

                </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function(){
            $('.cancel-order').on('click', function(e){
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: "Bạn có chắc không?",
                    text: "Bạn muốn hủy đơn hàng này?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Không'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush