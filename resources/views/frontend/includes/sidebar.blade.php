    <div class="sidebar-widget widget-category-2 mb-30">
        <h5 class="section-title style-1 mb-30">Category</h5>
        <ul>
            @foreach (App\Models\Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get() as $pCat)
                <li>
                    <a href=""> <img src="{{ asset('frontend/assets/imgs/theme/icons/category-1.svg') }}"
                            alt="" />{{ $pCat->name }}</a><span class="count">
                        @php
                            $numOfPItems = DB::table('products')
                                ->orderBy('id', 'asc')
                                ->where('category_id', $pCat->id)
                                ->get();
                        @endphp
                        {{ $numOfPItems->count() }}
                    </span>
                </li>
                @foreach (App\Models\Category::orderBy('name', 'asc')->where('is_parent', $pCat->id)->where('status', 0)->get() as $cCat)
                    <li>
                        &#8990<a href="{{ route('category.product', $cCat->slug) }}"><span></span><img
                                src="{{ asset('frontend/assets/imgs/theme/icons/category-1.svg') }}"
                                alt="" />{{ $cCat->name }}</a><span class="count">
                            @php
                                $numOfCItems = DB::table('products')
                                    ->orderBy('id', 'asc')
                                    ->where('category_id', $cCat->id)
                                    ->get();
                            @endphp
                            {{ $numOfCItems->count() }}
                        </span>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>

    <!-- Fillter By Price -->
    <div class="sidebar-widget price_range range mb-30">
        <h5 class="section-title style-1 mb-30">Fill by price</h5>
        <form action="{{ route('shop') }}" method="GET">
            @csrf
            <div class="price-filter">
                <div class="price-filter-inner">
                    <div id="slider" class="mb-20">
                        <label class="fw-900" for="price-range">Price Range:</label>
                        <input type="range" class="form-range" id="price-range" name="price_range" min="0"
                            max="{{ $maxRegularPrice }}" value="{{ $minPrice }},{{ $maxPrice }}"
                            style="border:0px;">
                        <div id="price-range-values" class="d-flex justify-content-between">
                            <span id="price-min">From: {{ $minPrice }} BDT</span>
                            <span id="price-max">To: {{ $maxPrice }} BDT</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-group">
                <div class="list-group-item mb-10 mt-10">
                    <label class="fw-900">Color</label>
                    <div class="custome-checkbox">
                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox1"><span>Red (56)</span></label>
                        <br />
                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox2"><span>Green (78)</span></label>
                        <br />
                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox3"><span>Blue (54)</span></label>
                    </div>
                    <label class="fw-900 mt-15">Item Condition</label>
                    <div class="custome-checkbox">
                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox11"><span>New (1506)</span></label>
                        <br />
                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox21"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox21"><span>Refurbished (27)</span></label>
                        <br />
                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox31"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox31"><span>Used (45)</span></label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-default"><i class="fi-rs-filter mr-5"></i> Fillter</button>
        </form>
    </div>
    <!-- Product sidebar Widget -->
    <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
        <h5 class="section-title style-1 mb-30">New products</h5>
        @foreach ($lastProducts as $lastPro)
            <div class="single-post clearfix">
                <div class="image">
                    <img src="{{ asset('frontend/assets/imgs/shop/thumbnail-3.jpg') }}" alt="#" />
                </div>
                <div class="content pt-10">
                    <h5><a href="shop-product-detail.html">{{ $lastPro->name }}</a></h5>
                    <p class="price mb-0 mt-5">
                        @if (!is_null($lastPro->offer_price))
                            @php
                                $totalSave = $lastPro->regular_price * ($lastPro->offer_price / 100);
                            @endphp
                            <span>{{ $lastPro->regular_price - $totalSave }} {{ __('BDT') }}</span>
                        @else
                            <span>{{ $lastPro->regular_price }} {{ __('BDT') }}</span>
                        @endif
                    </p>
                    <div class="product-rate">
                        <div class="product-rating" style="width: 90%"></div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="banner-img wow fadeIn mb-lg-0 animated d-lg-block d-none">
        <img src="{{ asset('frontend/assets/imgs/banner/banner-11.png') }}" alt="" />
        <div class="banner-text">
            <span>Oganic</span>
            <h4>
                Save 17% <br />
                on <span class="text-brand">Oganic</span><br />
                Juice
            </h4>
        </div>
    </div>

    @push('extraScripts')
        <script>
            const priceRange = document.getElementById('price-range');
            const priceMin = document.getElementById('price-min');

            priceRange.addEventListener('input', () => {
                const [min, max] = priceRange.value.split(',');
                priceMin.textContent = `From: ${min} BDT`;
                priceMax.textContent = `To: ${max} BDT`;
                priceRange.max = "{{ $maxRegularPrice }}" - min;
            });
        </script>
    @endpush
