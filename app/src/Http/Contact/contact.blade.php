@extends('_layouts.main')
@section('body')
    <div class="row justify-content-center">
        <div class="col-md-5 border border-1 rounded p-4 shadow">
            <form method="post" action="/contact">
                <!-- Name input -->
                <div class="form-outline mb-4">
                    <input type="text" id="form4Example1" class="form-control" name="name"/>
                    <label class="form-label" for="form4Example1">Name</label>
                </div>

                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="email" id="form4Example2" class="form-control" name="email"/>
                    <label class="form-label" for="form4Example2">Email address</label>
                </div>

                <!-- Message input -->
                <div class="form-outline mb-4">
                    <textarea class="form-control" id="form4Example3" rows="4" name="message"></textarea>
                    <label class="form-label" for="form4Example3">Message</label>
                </div>

                <ul class="mt-3">
                    @foreach($session->getFlashBag()->all() as $type => $messages)
                        @foreach ($messages as $message)
                            <li class="small text-{{$type}}">{{$message}}</li>
                        @endforeach
                    @endforeach
                </ul>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4">
                    Send
                </button>
            </form>
        </div>
    </div>
@endsection