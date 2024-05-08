@extends('_layouts.main')
@section('body')
    <div class="row">
        <div class="col-md-6">
            <form action="" method="post">
                <div class="form-control m-2 shadow p-3">
                    <div class="d-flex justify-content-between p-1">
                        <select name="subject" id="" class="form-select">
                            @foreach($subjects as $subject)
                                <option value="{{$subject}}">{{$subject}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-control m-2 shadow p-3">
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
                <button type="submit" class="btn btn-primary m-2">Submit</button>
            </form>
        </div>
        <div class="col-md-6">
            @isset($article)
                {!! $article !!}
            @endisset
        </div>
    </div>
@endsection