@extends('_layouts.main')
@section('body')
    <div class="container">
        @foreach($session->getFlashBag()->all() as $type => $messages)
            @foreach ($messages as $message)
                <div class="alert alert-{{$type}} alert-dismissible fade show" role="alert">
                    <div class="text-center">{{$message}}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endforeach
        <div class="row row-cols-3 g-4">
            <div class="col">
                <div class="card">
                    <a href="/weather">
                        <img src="@asset('public/pictures/weather.webp')" class="card-img-top"
                             alt="Hollywood Sign on The Hill">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Weather</h5>
                        <p class="card-text">
                            Configure and receive the weather forecast through a messenger that is convenient for you.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <a href="/study">
                        <img src="@asset('public/pictures/php.webp')" class="card-img-top" alt="Palm Springs Road">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">PHP study</h5>
                        <p class="card-text">
                            Get interesting PHP articles to support your knowledge.
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