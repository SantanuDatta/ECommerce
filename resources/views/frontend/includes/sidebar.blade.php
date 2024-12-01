    {{-- <div class="sidebar-widget widget-category-2 mb-30">
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
    </div> --}}

    <!-- Fillter By Price -->
    <div class="sidebar-widget price_range range mb-30">
        <h5 class="section-title style-1 mb-30">Fill by price</h5>
        <form action="{{ route('shop') }}" method="GET">
            <div class="form-group mb-20" id="slider">
                <label class="fw-900 form-label" for="price-range">Price Range:</label>
                <input class="form-control" id="price-range" name="filter[regular_price]" data-min="{{ $minPrice }}"
                    data-max="{{ $maxPrice }}" data-step="1" data-from="{{ $minPrice }}"
                    data-to="{{ $maxPrice }}" data-prefix="BDT " type="text">

                <div class="d-flex justify-content-between" id="price-range-values">
                    <span id="price-min">From: {{ $minPrice }} BDT</span>
                    <span id="price-max">To: {{ $maxPrice }} BDT</span>
                </div>
            </div>

            <div class="form-group">
                <label for="catgory">Catgory</label>
                <select class="form-control" id="" name="filter[category_id]">
                    <option value="" hidden>Please Select Category</option>
                    @foreach (App\Models\Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get() as $pCat)
                        <option value="{{ $pCat->id }}" disabled>{{ $pCat->name }}</option>
                        @foreach (App\Models\Category::orderBy('name', 'asc')->where('is_parent', $pCat->id)->where('status', 0)->get() as $cCat)
                            <option value="{{ $cCat->id }}">{{ $cCat->name }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            {{-- <div class="list-group">
                <div class="list-group-item mb-10 mt-10">
                    <label class="fw-900">Color</label>
                    <div class="custome-checkbox">
                        <input class="form-check-input" id="exampleCheckbox1" name="checkbox" type="checkbox"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox1"><span>Red (56)</span></label>
                        <br />
                        <input class="form-check-input" id="exampleCheckbox2" name="checkbox" type="checkbox"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox2"><span>Green (78)</span></label>
                        <br />
                        <input class="form-check-input" id="exampleCheckbox3" name="checkbox" type="checkbox"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox3"><span>Blue (54)</span></label>
                    </div>
                    <label class="fw-900 mt-15">Item Condition</label>
                    <div class="custome-checkbox">
                        <input class="form-check-input" id="exampleCheckbox11" name="checkbox" type="checkbox"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox11"><span>New (1506)</span></label>
                        <br />
                        <input class="form-check-input" id="exampleCheckbox21" name="checkbox" type="checkbox"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox21"><span>Refurbished (27)</span></label>
                        <br />
                        <input class="form-check-input" id="exampleCheckbox31" name="checkbox" type="checkbox"
                            value="" />
                        <label class="form-check-label" for="exampleCheckbox31"><span>Used (45)</span></label>
                    </div>
                </div>
            </div> --}}
            <button class="btn btn-sm btn-default" type="submit">Fillter</button>
            <a class="btn btn-sm btn-dark" type="submit" href="{{ route('shop') }}">Reset</a>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
        <script>
            $(document).ready(function() {
                var slider = $('#price-range');
                slider.ionRangeSlider({
                    type: 'double',
                    skin: 'round',
                    min: {{ $minPrice }},
                    max: {{ $maxPrice }},
                    onFinish: function(data) {
                        $('#price-min').text('From: ' + slider.data('prefix') + data.from);
                        $('#price-max').text('To: ' + slider.data('prefix') + data.to);
                        slider.trigger('change');
                    }
                });
            });
        </script>
    @endpush
