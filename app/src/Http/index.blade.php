@extends('_layouts.main')
@section('body')
<div class="container">
    <div class="row row-cols-3 g-4">
        <div class="col">
            <div class="card">
                <a href="/weather">
                <img src="@asset('public/pictures/weather.webp')" class="card-img-top" alt="Hollywood Sign on The Hill">
                </a>
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">
                        This is a longer card with supporting text below as a natural lead-in to
                        additional content. This content is a little bit longer.
                    </p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="@asset('public/pictures/php.webp')" class="card-img-top" alt="Palm Springs Road">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">
                        This is a longer card with supporting text below as a natural lead-in to
                        additional content. This content is a little bit longer.
                    </p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="@asset('public/pictures/messanger.webp')" class="card-img-top" alt="Palm Springs Road">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">
                        This is a longer card with supporting text below as a natural lead-in to
                        additional content. This content is a little bit longer.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection