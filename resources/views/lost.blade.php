@extends('layout')
@section('content')
    <div class="mx-5 d-flex justify-content-center">

        <div class="mt-8 overflow-hidden shadow" style="width: 40rem;">
            <div class="card text-center bg-light">
                <div class="card-header">

                    <h2>
                        <span class="badge badge-pill bg-danger">You have lost!</span>
                    </h2>
                    <div><span class="badge badge-pill bg-danger">The highlighted answer is the correct one. If you would like to try again go back to the homepage.</span>
                    </div>

                    <h4>
                        <span class="badge badge-pill bg-secondary">{{$round->count}}/20</span>
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('answer', ['id' => $round->game_id])}}">
                        @csrf
                        @foreach($options as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answer" value="{{$option->number}}"
                                       id="{{$option->number}}" disabled
                                       checked="{{$round->correct_answer_id === $option->id}}">
                                <label class="form-check-label" for="{{$option->number}}">
                                    {{$option->text}}
                                </label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-success float-end" disabled>Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection