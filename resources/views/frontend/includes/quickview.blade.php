    <!-- Quick view -->
    <div class="modal fade custom-modal" id="quickViewModal-{{ $prDetails->id }}" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                            <div class="detail-gallery">
                                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                <!-- MAIN SLIDES -->
                                <div class="product-image-slider">
                                    @foreach ($prDetails->images as $image)
                                        <figure class="border-radius-10">
                                            <img src="{{ asset('backend/img/products/' . $image->image ) }}" alt="product image" />
                                        </figure>
                                    @endforeach
                                </div>
                                <!-- THUMBNAILS -->
                                <div class="slider-nav-thumbnails">
                                    @foreach ($prDetails->images as $image)
                                        <div><img src="{{ asset('backend/img/products/' . $image->image ) }}" alt="product image" /></div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- End Gallery -->
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info pr-30 pl-30">
                                @if ($prDetails->is_featured == 1 && $prDetails->offer_price)
                                    <span class="stock-status in-stock">Hot & Sale</span>
                                @elseif ($prDetails->is_featured == 1)
                                    <span class="stock-status in-stock">Hot</span>
                                @elseif ($prDetails->is_featured == 0)
                                    @if (!is_null($prDetails->offer_price))
                                        <span class="stock-status out-stock">Sale</span>
                                    @endif
                                @endif
                                <h3 class="title-detail"><a href="shop-product-right.html" class="text-heading">{{ $prDetails->name }}</a></h3>
                                <div class="product-detail-rating">
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                    </div>
                                </div>
                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">
                                        @if (!is_null($prDetails->offer_price))
                                            @php
                                                $totalSave = ($prDetails->regular_price *($prDetails->offer_price /100) );
                                            @endphp
                                            <span class="current-price text-brand">{{ $prDetails->regular_price - $totalSave }} BDT</span> 
                                            <span>
                                                @if (!is_null($prDetails->offer_price))
                                                    <span class="save-price font-md color3 ml-15"">{{ $prDetails->offer_price }} % Off</span>
                                                @endif
                                                <span class="old-price font-md ml-15">{{ $prDetails->regular_price }} BDT</span>
                                            </span>
                                        @else
                                            <span class="current-price text-brand">{{ $prDetails->regular_price }} BDT</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="detail-extralink mb-30">
                                    <div class="detail-qty border radius">
                                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                        <span class="qty-val">1</span>
                                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                    <div class="product-extra-link2">
                                        <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                                <div class="font-xs">
                                    <ul>
                                        <li class="mb-5">Brand: <span class="text-brand">{{ $prDetails->brand->name ?? 'N/A' }}</span></li>
                                        <li class="mb-5">MFG:<span class="text-brand">{{ $prDetails->mfg_date ?? 'N/A' }}</span></li>
                                        <li class="mb-5">EXP:<span class="text-brand">{{ $prDetails->exp_date ?? 'N/A' }}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Detail Info -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
