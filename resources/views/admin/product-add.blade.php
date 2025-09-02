@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Thêm sản phẩm</h3>
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
                        <div class="text-tiny">Các sản phẩm</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Thêm sản phẩm</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.store')}}">
            @csrf
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Tên sản phẩm <span class="tf-color-1">*</span>
                    </div>
                    <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0" value="{{old('name')}}" aria-required="true" required="">
                    <div class="text-tiny">Không vượt quá 100 ký tự khi nhập tên sản phẩm.</div>
                </fieldset>
                @error('name') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0" value="{{old('slug')}}" aria-required="true" required="">
                    <div class="text-tiny">Không vượt quá 100 ký tự khi nhập tên sản phẩm.</div>
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
                                <option value="{{$category->id}}">{{$category->name}}</option>
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
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </fieldset>
                    @error('brand') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Mô tả ngắn<span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0" aria-required="true" required="">{{old('short_description')}}</textarea>
                    <div class="text-tiny">Không vượt quá 100 ký tự khi nhập tên sản phẩm.</div>
                </fieldset>
                @error('short_description') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                <fieldset class="description">
                    <div class="body-title mb-10">Mô tả <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true" required="">{{old('description')}}</textarea>
                        <div class="text-tiny">Không vượt quá 100 ký tự khi nhập tên sản phẩm.</div>
                </fieldset>
                @error('description') <sapn class="alert alert-danger text-center">{{$message}} @enderror 


            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Tải lên hình ảnh <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="../../../localhost_8000/images/upload/upload-1.png" class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Thả hình ảnh của bạn ở đây hoặc chọn<span class="tf-color">nhấp để duyệt</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                <fieldset>
                    <div class="body-title mb-10">Tải lên hình ảnh thư viện</div>
                    <div class="upload-image mb-16">
                        <!-- <div class="item">
        <img src="images/upload/upload-1.png" alt="">
    </div>                                                 -->
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Thả hình ảnh của bạn ở đây hoặc chọn <span class="tf-color">click to browse</span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*" multiple="">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('images') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                <div class="cols gap22">
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">Giá thông thường <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter regular price" name="regular_price" tabindex="0" value="{{old('regular_price')}}" aria-required="true" required="">
                    </fieldset>
                    @error('regular_price') <sapn class="alert alert-danger text-center">{{$message}} @enderror 
                    <fieldset class="name">
                        <div class="body-title mb-10">Giá bán <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter sale price" name="sale_price" tabindex="0" value="{{old('sale_price')}}" aria-required="true" required="">
                    </fieldset>
                    @error('sale_price') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                </div>


                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU" tabindex="0" value="{{old('SKU')}}" aria-required="true" required="">
                    </fieldset>
                    @error('SKU') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                    <fieldset class="name">
                        <div class="body-title mb-10">Số lượng <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity" tabindex="0" value="{{old('quantity')}}" aria-required="true" required="">
                    </fieldset>
                    @error('quantity') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Cổ phần</div>
                        <div class="select mb-10">
                            <select class="" name="stock_status">
                                <option value="instock">Còn hàng</option>
                                <option value="outofstock">Hết hàng</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('stock_status') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                    <fieldset class="name">
                        <div class="body-title mb-10">Nổi bật</div>
                        <div class="select mb-10">
                            <select class="" name="featured">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('featured') <sapn class="alert alert-danger text-center">{{$message}} @enderror 

                </div>
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Thêm sản phẩm</button>
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
               
                    if ($("#imgpreview img").length) {
                        $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    } else {
                        $("#imgpreview").append('<img src="'+URL.createObjectURL(file)+'" alt="Image Preview">');
                    }
                    $("#imgpreview").show();
                }
            });
            $("#gFile").on("change", function(e){
                const gphotos = this.files;
                $.each(gphotos, function(key, val) {
                    $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}" alt="Gallery Image"/></div>`);
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
