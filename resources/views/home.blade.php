@extends('layout')
@section('content')
    <div class="mx-5 d-flex justify-content-center">

        <div class="mt-8 overflow-hidden shadow" style="width: 40rem;">

            <div class="card text-center bg-light">
                <div class="card-body">
                    <form action="{{route('startGame')}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg btn-block">Play game</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection