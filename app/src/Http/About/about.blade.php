@extends('_layouts.main')
@section('body')
    <div class="container">
        <div class="row gx-5 p-4">
            <div class="col-md-6 mb-4">
                <div class="bg-image hover-overlay ripple shadow-2-strong rounded-5" data-mdb-ripple-color="light">
                    <img src="@asset('public/pictures/sender.webp')" class="img-fluid"/>
                    <a href="#!">
                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                    </a>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <span class="badge bg-danger px-2 py-1 shadow-1-strong mb-3">News of the day</span>
                <h4><strong>Facilis consequatur eligendi</strong></h4>
                <p class="text-muted">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis consequatur
                    eligendi quisquam doloremque vero ex debitis veritatis placeat unde animi laborum
                    sapiente illo possimus, commodi dignissimos obcaecati illum maiores corporis.
                </p>
                <button type="button" class="btn btn-primary">Read more</button>
            </div>
        </div>
    </div>
@endsection