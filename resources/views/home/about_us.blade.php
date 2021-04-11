@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row h-100 align-items-center py-5">
            <div class="col-lg-6">
                <h1 class="display-4">Kolokas.com</h1>
                <p class="lead text-muted font-italic">{{__('aboutus.par1')}}</p>
                <p class="lead text-muted">{!! __('aboutus.par2') !!}</p>
                <p class="lead text-muted">{!! __('aboutus.par3') !!}</p>
                <p class="lead text-muted font-italic">{!! __('aboutus.par4') !!}</p>
            </div>
            <div class="col-lg-6 d-none d-lg-block"><img src="{{ asset('images/about_us_1.jpg') }}" alt=""
                                                         class="img-fluid"></div>
        </div>
    </div>

    <div class="container py-5">
        <h2 class="display-4 font-weight-light text-center fit-width">{{__('aboutus.thisisus')}}</h2>

        <div class="row text-center">
            <!-- Team item-->
            <div class="col-xl-3 col-sm-6 mb-5">
            </div>
            <!-- End-->

            <!-- Team item-->
            <div class="col-xl-3 col-sm-6 mb-5">
                <div class="bg-white rounded shadow-sm py-5 px-4"><img
                        src="{{ asset('images/bugra.jpeg') }}" alt=""
                        width="130" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">{{$bugra->name}}</h5>
                    <span class="small text-uppercase text-muted">CEO - Founder - Developer</span><br>
                    <span>MSc Robotics</span>
                    <ul class="social mb-0 list-inline mt-3">
                        <li class="list-inline-item"><a href="https://www.facebook.com/Bici89/" class="social-link"><i
                                    class="fa fa-facebook-f"></i></a></li>
                        <li class="list-inline-item"><a href="https://twitter.com/BugraBgErgin" class="social-link"><i
                                    class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.instagram.com/bicibg/" class="social-link"><i
                                    class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.linkedin.com/in/bugraergin/"
                                                        class="social-link"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- End-->

            <!-- Team item-->
            <div class="col-xl-3 col-sm-6 mb-5">
                <div class="bg-white rounded shadow-sm py-5 px-4"><img
                        src="{{ asset('images/burak.jpeg') }}" alt=""
                        width="130" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">Burak Ergin</h5><span
                        class="small text-uppercase text-muted">Product Manager - Marketing</span><br>
                    <span>MSc Applied Acoustics</span>
                    <ul class="social mb-0 list-inline mt-3">
                        <li class="list-inline-item"><a href="https://www.facebook.com/burak.ergin4"
                                                        class="social-link"><i class="fa fa-facebook-f"></i></a></li>
                        <li class="list-inline-item"><a href="https://twitter.com/burakk_ergin" class="social-link"><i
                                    class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.instagram.com/burakergin/"
                                                        class="social-link"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.linkedin.com/in/burakerginuk/"
                                                        class="social-link"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- End-->

            <!-- Team item-->
            <div class="col-xl-3 col-sm-6 mb-5">
            </div>
            <!-- End-->

        </div>
    </div>

@endsection
