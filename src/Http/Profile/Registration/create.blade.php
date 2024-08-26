@extends('_layouts.main')
@section('body')
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                    <form class="mx-1 mx-md-4" action="/register" method="post">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" name="username" id="form3Example1c"
                                                       class="form-control"
                                                       required/>
                                                <label class="form-label small opacity-50" for="form3Example1c">Your
                                                    Name</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" name="email" id="form3Example3c"
                                                       class="form-control"
                                                       required/>
                                                <label class="form-label small opacity-50" for="form3Example3c">Your
                                                    Email</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="password" id="form3Example4c"
                                                       class="form-control" required/>
                                                <label class="form-label small opacity-50"
                                                       for="form3Example4c">Password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="match-password" id="form3Example4cd"
                                                       class="form-control"
                                                       required/>
                                                <label class="form-label small opacity-50" for="form3Example4cd">Repeat
                                                    your
                                                    password</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fa fa-map-marker fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <select id="countryId" name="countryId" class="form-control">
                                                    <option value="">Select country</option>
                                                    @foreach($countryList as $country)
                                                        <option value="{{ $country['Code'] }}">{{ $country['Name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <label class="form-label small opacity-50" for="profile">Country</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fa fa-globe fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <select id="selectedTimezone" name="selectedTimezone"
                                                        class="form-control"></select>
                                                <label class="form-label small opacity-50" for="profile">Time
                                                    zone</label>
                                            </div>
                                        </div>

                                        <div class="form-check d-flex justify-content-center mb-5 mt-3">
                                            <input class="form-check-input me-2" type="checkbox" value=""
                                                   id="form2Example3c"/>
                                            <label class="form-check-label" for="form2Example3">
                                                I agree all statements in <a href="#!">Terms of service</a>
                                            </label>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Register</button>
                                        </div>

                                        <ul class="mt-3">
                                            @if (!empty($errors))
                                                @foreach ($errors as $error)
                                                    <li class="small text-danger">{{$error}}</li>
                                                @endforeach
                                            @endif
                                        </ul>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                         class="img-fluid" alt="Sample image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="visually-hidden" id="timezoneApiKey">{{$timezoneApiKey}}</div>
    </section>
    <script src="@asset('public/assets/js/getCountryAndTimezone.js')"></script>
    <script>
        let countrySelect = document.getElementById('countryId');
        let selectedTimezone = document.getElementById("selectedTimezone");
        let key = document.getElementById("timezoneApiKey").textContent;

        fillTimezone(countrySelect, selectedTimezone, key);
        getTimeZone(selectedTimezone);
    </script>
@endsection