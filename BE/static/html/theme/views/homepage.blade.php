@extends('.layouts.app')
@section('content')


    <!-- BANNER -->
    <div class="banner-area pt-60 pb-65">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="single-banner mb-30">
                        <a href="product-details.html"><img src="@img_path(banner/banner-1.webp)" alt="" width="371" height="216"></a>
                        <div class="banner-content">
                            <h3>Watches</h3>
                            <h4>Starting at <span>$99.00</span></h4>
                            <a href="product-details.html"><i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="single-banner mb-30">
                        <a href="product-details.html"><img src="@img_path(banner/banner-2.webp)" alt="" width="371" height="216"></a>
                        <div class="banner-content">
                            <h3>Plo Bag</h3>
                            <h4>Starting at <span>$79.00</span></h4>
                            <a href="product-details.html"><i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="single-banner mb-30">
                        <a href="product-details.html"><img src="@img_path(banner/banner-3.webp)" alt="" width="371" height="216"></a>
                        <div class="banner-content">
                            <h3>Sunglass</h3>
                            <h4>Starting at <span>$79.00</span></h4>
                            <a href="product-details.html"><i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END BANNER -->

    <!-- PRODUCTS-->
    <div class="product-area pb-60">
        <div class="container">
            <div class="tab-filter-wrap mb-60">
                <div class="product-tab-list-2 nav">
                    <a class="active" href="#product-1" data-bs-toggle="tab" >
                        <h4>New Arrivals  </h4>
                    </a>
                </div>
                <div class="filter-active">
                    <a href="#"><i class="fa fa-plus"></i> filter</a>
                </div>
            </div>
            <div class="product-filter-wrapper">
                <div class="row">
                    <!-- Product Filter -->
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-30">
                        <div class="product-filter">
                            <h5>Sort by</h5>
                            <ul class="sort-by">
                                <li><a href="#">Default</a></li>
                                <li><a href="#">Popularity</a></li>
                                <li><a href="#">Average rating</a></li>
                                <li><a href="#">Newness</a></li>
                                <li><a href="#">Price: Low to High</a></li>
                                <li><a href="#">Price: High to Low</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Product Filter -->
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-30">
                        <div class="product-filter">
                            <h5>color filters</h5>
                            <ul class="color-filter">
                                <li><input type="checkbox" value=""> <a href="#">Black</a></li>
                                <li><input type="checkbox" value=""> <a href="#">Brown</a></li>
                                <li><input type="checkbox" value=""> <a href="#">Orange</a></li>
                                <li><input type="checkbox" value=""> <a href="#">red</a></li>
                                <li><input type="checkbox" value=""> <a href="#">Yellow</a></li>
                                <li><input type="checkbox" value=""> <a href="#">purple</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Product Filter -->
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-30">
                        <div class="product-filter">
                            <h5>Filter by price</h5>
                            <div class="price-filter mt-25">
                                <div class="price-slider-amount">
                                    <input type="text" id="amount" name="price"  placeholder="Add Your Price" />
                                </div>
                                <div id="slider-range"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content jump">
                <div class="tab-pane active" id="product-1">
                    <div class="row">
                        @foreach($products as $product)
                            @include('components.product', [ "product" => $product ])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PRODUCTS-->

    <!-- BLOG -->
    <div class="blog-area pb-55">
        <div class="container">
            <div class="section-title text-center mb-55">
                <h2>OUR BLOG</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog-wrap mb-30 scroll-zoom">
                        <div class="blog-img">
                            <a href="blog-details.html"><img src="@img_path(blog/blog-1.webp)" alt="" width="371" height="271"></a>
                            <span class="purple">Lifestyle</span>
                        </div>
                        <div class="blog-content-wrap">
                            <div class="blog-content text-center">
                                <h3><a href="blog-details.html">Lorem ipsum dolor sit <br> amet consec.</a></h3>
                                <span>By Shop <a href="#">Admin</a></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog-wrap mb-30 scroll-zoom">
                        <div class="blog-img">
                            <a href="blog-details.html"><img src="@img_path(blog/blog-2.webp)" alt="" width="371" height="271"></a>
                            <span class="pink">Lifestyle</span>
                        </div>
                        <div class="blog-content-wrap">
                            <div class="blog-content text-center">
                                <h3><a href="blog-details.html">Lorem ipsum dolor sit <br> amet consec.</a></h3>
                                <span>By Shop <a href="#">Admin</a></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog-wrap mb-30 scroll-zoom">
                        <div class="blog-img">
                            <a href="blog-details.html"><img src="@img_path(blog/blog-3.webp)" alt="" width="371" height="271"></a>
                            <span class="purple">Lifestyle</span>
                        </div>
                        <div class="blog-content-wrap">
                            <div class="blog-content text-center">
                                <h3><a href="blog-details.html">Lorem ipsum dolor sit <br> amet consec.</a></h3>
                                <span>By Shop <a href="#">Admin</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END BLOG -->
@endsection