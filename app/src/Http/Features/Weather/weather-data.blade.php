@php use function Symfony\Component\String\u; @endphp
@extends('_layouts.main')
@section('body')
    @php(require "translations/translations.php")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form action="/weather" method="post">
                    <div class="form-control my-1 shadow p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="text-center p-1">City</h3>
                                <div class="input-group">
                                    <input type="text" name="city" class="form-control" placeholder="Input your city"
                                           id="input-city" value="{{$city}}" required>
                                    <select name="select-city" class="visually-hidden form-select"
                                            id="select-city">
                                        <option value="">Choose your city</option>
                                    </select>
                                    <div class="input-group-append">
                                        <a class="btn btn-primary" id="find-city-btn">Find</a>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="latitude" id="latitude" value="{{$latitude}}">
                            <input type="hidden" name="longitude" id="longitude" value="{{$longitude}}">
                            <div class="col-md-6">
                                <h3 class="text-center p-1">Forecast length</h3>
                                <select name="forecast-length" id="forecast-length" class="form-select m-2">
                                    <option value="1" selected>1 day</option>
                                    <option value="3">3 days</option>
                                    <option value="7">7 days</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="form-control my-1 p-1 shadow">
                        <h3 class="text-center p-1">Values</h3>
                        <div class="row d-flex justify-content-around">
                            <div class="col-md-5 border rounded m-2 p-2">
                                <h5 class="text-center p-2">Daily</h5>
                                @foreach($dailyWeatherParametersList as $dailyWeatherParameter)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="daily-values[{{$dailyWeatherParameter}}]"
                                               value="{{$dailyWeatherParameter}}"
                                               id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            @if(isset($translator))
                                                {{$translator->trans($dailyWeatherParameter)}}
                                            @else
                                                {{$dailyWeatherParameter}}
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-5 border rounded m-2 p-2">
                                <h5 class="text-center p-2">Current</h5>
                                @foreach($currentWeatherParametersList as $currentWeatherParameter)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="daily-values[{{$currentWeatherParameter}}]"
                                               value="{{$currentWeatherParameter}}"
                                               id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            @if(isset($translator))
                                                {{$translator->trans($currentWeatherParameter)}}
                                            @else
                                                {{$currentWeatherParameter}}
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-control my-1 shadow">
                        <div class="d-flex justify-content-between p-1">
                            <div>
                                <span class="p-1 fw-bold">Message type</span>
                                <label class="form-label">
                                    <select id="cars" class="form-select" name="message-type" required>
                                        @foreach($messageTypes as $messageType)
                                            <option value="{{$messageType}}">
                                                {{$messageType}}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <div>
                                <span class="p-1 fw-bold">Time execute</span>
                                <label class="form-label">
                                    <input type="time" class="form-control" name="time-execute" required>
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="container">
                    @isset($weatherData)
                        {!! $weatherData !!}
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <div class="visually-hidden" id="opencagedataKey">{{$opencagedataKey}}</div>
    <script src="@asset('public/assets/js/weatherData.js')"></script>
    <script>
        let inputCity = document.getElementById('input-city');
        let selectCity = document.getElementById('select-city');
        let opencagedataKey = document.getElementById('opencagedataKey').textContent

        bindFindCityBtn(inputCity, selectCity, opencagedataKey);
    </script>
@endsection