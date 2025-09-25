@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Product</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.products') }}">
                            <div class="text-tiny">Products</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit product</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.update', $product->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0"
                            value="{{ $product->name }}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('name')
                        <div class="text-danger mb-3">{{ $message }}</div>
                        
                    @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0"
                            value="{{ $product->slug }}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('slug')
                        <div class="text-danger mb-3">{{ $message }}</div>
                        
                    @enderror

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="" name="category_id">
                                    <option value="">Choose category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('category_id')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror
                        <fieldset class="brand">
                            <div class="body-title mb-10">Brand <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="" name="brand_id">
                                    <option>Choose Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>
                                            {{ $brand->name }}
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('brand_id')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description" value="{{ old('short_description', $product->short_description) }}" placeholder="Short Description" tabindex="0"
                            aria-required="true" required="">{{ old('short_description', $product->short_description) }}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('short_description')
                        <div class="text-danger mb-3">{{ $message }}</div>
                    @enderror

                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                        </div>
                        <textarea class="mb-10" name="description" value="{{ old('description', $product->description) }}" placeholder="Description" tabindex="0" aria-required="true"
                            required="">{{ old('description', $product->description) }}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('description')
                        <div class="text-danger mb-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                        <div class="upload-image" style="display: flex;">
                            <div id="imgpreview" class="item" style="display: {{ $product->image ? 'block' : 'none' }}">
                                <img src="{{ $product->image ? asset('uploads/products/thumbnails/' . $product->image) : asset('images/upload/upload-1.png') }}" class="effect8" alt="">
                            </div>
                            <input type="hidden" name="old_image" value="{{ $product->image }}">

                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click
                                            to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <div class="text-danger mb-3">{{ $message }}</div>
                    @enderror

                     <fieldset>
                        <div class="body-title mb-10">Upload Gallery Images</div>
                        <div class="upload-image mb-16">
                            <div id="galUpload">
                                @if ($product->images)
                                    @foreach (explode(',', $product->images) as $img)
                                        @if(trim($img))
                                            <div class="item gitems">
                                                <img src="{{ asset('uploads/products/thumbnails/' . trim($img)) }}" alt="Gallery Image">
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            <div class="item up-load mt-10">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or select <span class="tf-color">click
                                            to browse</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('images')
                        <div class="text-danger mb-3">{{ $message }}</div>
                    @enderror
                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter regular price" name="regular_price"
                                tabindex="0" value="{{$product->regular_price}}" aria-required="true" required="">
                        </fieldset>
                        @error('regular_price')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Sale Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter sale price" name="sale_price"
                                tabindex="0" value="{{ $product->sale_price }}" aria-required="true" required="">
                        </fieldset>
                        @error('sale_price')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU" tabindex="0"
                                value="{{ $product->SKU }}" aria-required="true" required="">
                        </fieldset>
                        @error('SKU')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity"
                                tabindex="0" value="{{ $product->quantity }}" aria-required="true" required="">
                        </fieldset>
                        @error('quantity')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select name="stock_status">
                                    <option value="instock" @selected(old('stock_status', $product->stock_status) === 'instock')>InStock</option>
                                    <option value="outofstock" @selected(old('stock_status', $product->stock_status) === 'outofstock')>Out of Stock</option>
                                </select>
                            </div>
                        </fieldset>
                            @error('stock_status')
                                <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="0" @selected(old('featured', $product->featured) == 0)>No</option>
                                    <option value="1" @selected(old('featured', $product->featured) == 1)>Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('featured')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Update product</button>
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
            // preview single main image
            $("#myFile").on("change", function(e){
                const [file] = this.files || [];
                if (file && file.type && file.type.startsWith('image/')) {
                    $("#imgpreview img").attr("src", URL.createObjectURL(file));
                    $("#imgpreview").show();
                } else {
                    $("#imgpreview").hide();
                }
            });

            // preview multiple gallery images
            $("#gFile").on("change", function(e){
                const files = Array.from(this.files || []);
                const $gal = $("#galUpload");
                $gal.empty();
                files.forEach(function(file){
                    if (!file.type || !file.type.startsWith('image/')) return;
                    const url = URL.createObjectURL(file);
                    $gal.prepend('<div class="item gitems"><img src="'+url+'" alt="'+(file.name || '')+'"></div>');
                });
            });

            // auto-generate slug from name
            $("input[name='name']").on("change", function(){
               $("input[name='slug']").val(stringToslug($(this).val()));
            });
        });

        function stringToslug(Text){
            return String(Text || '')
                .toLowerCase()
                .replace(/\s+/g,'-')        // spaces to hyphens
                .replace(/[^\w-]+/g,'')     // remove invalid chars but keep hyphens
                .replace(/--+/g,'-')        // collapse multiple hyphens
                .replace(/^-+|-+$/g,'');    // trim leading/trailing hyphens
        }
    </script>
    
@endpush
