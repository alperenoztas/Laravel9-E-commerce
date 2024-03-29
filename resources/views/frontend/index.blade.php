@extends('layouts.app')
@section('title', 'Homepage')
@section('content')

    <div id="myCarousel" class="carousel slide" data-bs-ride="false">

            <div class="carousel-inner">
                @foreach ($sliders as $key => $sliderItem )
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ asset("$sliderItem->image") }}" style="height:50%" class="d-block w-100" alt="">
                    <div class="carousel-caption d-none d-md-block">
                        <div class="custom-carousel-content">
                            <h1>
                                <span>{{ $sliderItem->title }} &amp; Sales
                            </h1>
                            <p>
                                {{ $sliderItem->description }}
                            </p>
                            <div>
                                <a href="#" class="btn btn-slider">
                                    Get Now
                                </a>
                            </div>
                        </div>
                    </div>
                  </div>
                @endforeach
            </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

@endsection

<style>
    #myCarousel .item {
    height: 25%;
}

#myCarousel .item img {
    height: 100%;
    width: 100%;
}
</style>
