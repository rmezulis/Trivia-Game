@extends('layout')
@section('content')
    <div class="mx-5 d-flex justify-content-center">

        <div class="mt-8 overflow-hidden shadow" style="width: 40rem;">

            <div class="card bg-light">
                <div class="card-header text-center">
                    <h4>
                        <span class="badge badge-pill bg-secondary">{{$round->count}}/20</span>
                    </h4>
                    <h3>
                        {{$round->correctAnswer->number}} is...
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('answer', ['id' => $round->game_id])}}">
                        @csrf
                        @foreach($options as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answer" value="{{$option->number}}"
                                       id="{{$option->number}}">
                                <label class="form-check-label" for="{{$option->number}}">
                                    ...{{$option->text}}
                                </label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-success float-end">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection