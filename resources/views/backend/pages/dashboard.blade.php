@extends('backend.layout.template')

@section('title', 'Main Board')
@section('body-content')
    <!-- ########## START: MAIN PANEL ########## -->

    <div class="br-pagetitle">
        <i class="icon ion-ios-home-outline tx-70 lh-0"></i>
        <div>
            <h4>Dashboard</h4>
            <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">

        <div class="row row-sm mg-b-20">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-info rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Today's Visits
                            </p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">1,975,224</p>
                            <span class="tx-11 tx-roboto tx-white-8">24% higher yesterday</span>
                        </div>
                    </div>
                    <div id="ch1" class="ht-50 tr-y-1"></div>
                </div>
            </div><!-- col-3 -->
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                <div class="bg-purple rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-bag tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Today Sales
                            </p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">$329,291</p>
                            <span class="tx-11 tx-roboto tx-white-8">$390,212 before tax</span>
                        </div>
                    </div>
                    <div id="ch3" class="ht-50 tr-y-1"></div>
                </div>
            </div><!-- col-3 -->
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="bg-teal rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-monitor tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">% Unique
                                Visits</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">54.45%</p>
                            <span class="tx-11 tx-roboto tx-white-8">23% average duration</span>
                        </div>
                    </div>
                    <div id="ch2" class="ht-50 tr-y-1"></div>
                </div>
            </div><!-- col-3 -->
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="bg-primary rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-clock tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Time & Date
                            </p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1" id="brTime" class="br-time"></p>
                            <span class="tx-11 tx-roboto tx-white-8 br-date" id="brDate"></span>
                        </div>
                    </div>
                    <div id="ch4" class="ht-50 tr-y-1"></div>
                </div>
            </div><!-- col-3 -->
        </div><!-- row -->

        <div class="row row-sm mg-t-20">
            <div class="col-lg-8">
                <div class="card">
                    <div class="d-md-flex justify-content-between pd-25">
                        <div>
                            <h6 class="tx-13 tx-uppercase tx-white tx-spacing-1">How Engaged Our Users Daily</h6>
                            <p>Past 30 Days — Last Updated {{ date('d M, Y') }}</p>
                        </div>
                    </div><!-- d-flex -->
                    {!! $areaChart->container() !!}
                </div><!-- card -->

            </div><!-- col-8 -->
            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                <div class="card bd-gray-400">
                    <div class="d-md-flex justify-content-between pd-25">
                        <div>
                            <h6 class="tx-13 tx-uppercase tx-white tx-spacing-1">Top 3 Best Selling Products
                            </h6>
                        </div>
                    </div>
                    {!! $barChart->container() !!}
                </div><!-- card -->
            </div>
        </div>
    @endsection

    @push('chartScript')
        <script src="{{ $barChart->cdn() }}"></script>
        {{ $barChart->script() }}
        {{ $areaChart->script() }}
    @endpush
