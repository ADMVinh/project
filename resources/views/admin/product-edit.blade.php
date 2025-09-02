@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Chỉnh sửa sản phẩm</h3>
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
                    <a href="{{route('admin.products')}}">
                        <div class="text-tiny">Sản phẩm</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Chỉnh sửa sản phẩm</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.update')}}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{$product->id}}" />
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Tên sản phẩm <span class="tf-color-1">*</span>
                    </div>
                    <input class="mb-10" type="text" placeholder="Nhập tên sản phẩm" name="name" tabindex="0" value="{{ $product->name }}" aria-required="true" required="">
                    <div class="text-tiny">Không quá 100 ký tự khi nhập tên sản phẩm.</div>
                </fieldset>
                @error('name') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Nhập slug sản phẩm" name="slug" tabindex="0" value="{{$product->slug}}" aria-required="true" required="">
                    <div class="text-tiny">Không quá 100 ký tự khi nhập slug sản phẩm.</div>
                </fieldset>
                @error('slug') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Danh mục <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="category_id">
                                <option>Chọn danh mục</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('category') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                    <fieldset class="brand">
                        <div class="body-title mb-10">Thương hiệu <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="brand_id">
                                <option>Chọn thương hiệu</option>
                                @foreach($brands as $brand)
                                <option value="{{$brand->id}}" {{$product->brand_id == $brand->id ? 'selected' : ''}}>{{$brand->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </fieldset>
                    @error('brand') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Mô tả ngắn <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_description" placeholder="Mô tả ngắn" tabindex="0" aria-required="true" required>{{ $product->short_description }}</textarea>
    
                    <div class="text-tiny">Không quá 100 ký tự khi nhập mô tả ngắn sản phẩm.</div>
                </fieldset>
                @error('short_description') <sapn class="alert alert-danger text-center">{{$message}} @enderror 
                <fieldset class="description">
                    <div class="body-title mb-10">Mô tả chi tiết <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="mb-10" name="description" placeholder="Mô tả chi tiết" tabindex="0" aria-required="true" required>{{ $product->description }}</textarea>
                        <div class="text-tiny">Không quá 100 ký tự khi nhập mô tả chi tiết sản phẩm.</div>
                </fieldset>
                @error('description') <sapn class="alert alert-danger text-center">{{$message}} @enderror 


            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Tải lên hình ảnh <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        @if($product->image)
                        <div class="item" id="imgpreview">
                            <img src="{{asset('uploads/products/')}}/{{$product->image}}" class="effect8" alt="{{$product->name}}">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Thả hình ảnh của bạn vào đây hoặc chọn <span class="tf-color">click để duyệt</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                <fieldset>
                    <div class="body-title mb-10">Tải lên hình ảnh trong bộ sưu tập</div>
                    <div class="upload-image mb-16">
                    @if($product->images)
                        @foreach(explode(',',$product->images) as $img)
                        <div class="item gitems">
                            <img src="{{ asset('uploads/products')}}/{{trim($img)}}" alt="">
                        </div>
                        @endforeach
                    @endif
                            <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Thả hình ảnh của bạn vào đây hoặc chọn <span class="tf-color">click để duyệt</span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*" multiple="">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('images') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Giá gốc <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Nhập giá gốc" name="regular_price" tabindex="0" value="{{ $product->regular_price }}" aria-required="true" required="">
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Giá bán <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Nhập giá bán" name="sale_price" tabindex="0" value="{{$product->sale_price}}" aria-required="true" required="">
                    </fieldset>
                    @error('sale_price') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                </div>


                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Nhập SKU" name="SKU" tabindex="0" value="{{$product->SKU}}" aria-required="true" required="">
                    </fieldset>
                    @error('SKU') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                    <fieldset class="name">
                        <div class="body-title mb-10">Số lượng <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Nhập số lượng" name="quantity" tabindex="0" value="{{$product->quantity}}" aria-required="true" required="">
                    </fieldset>
                    @error('quantity') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Tình trạng hàng</div>
                        <div class="select mb-10">
                            <select class="" name="stock_status">
                                <option value="instock"{{$product->stock_status == "instock" ? "select":""}}>Có hàng</option>
                                <option value="outofstock"{{$product->stock_status == "outofstock" ? "select":""}}>Hết hàng</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('stock_status') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                    <fieldset class="name">
                        <div class="body-title mb-10">Nổi bật</div>
                        <div class="select mb-10">
                            <select class="" name="featured">
                                <option value="0"{{$product->featured ==  "0" ? "select":""}}>Không</option>
                                <option value="1"{{$product->featured ==  "1" ? "select":""}}>Có</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('featured') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                </div>
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Cập nhật sản phẩm</button>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
</div>
@endsection


@push('scripts')
    <script>
        $(function(){
            $("#myFile").on("change", function(e){
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });

            $("#gFile").on("change", function(e){
                const gphotos = this.files;
                $.each(gphotos,function(key,val)
            {
                $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}"/></div>`)
            });
                
                
            });
             
            $("input[name='name']").on("change", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }
    </script>
@endpush
