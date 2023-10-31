@extends('layouts.app')

@section('title')
Question |
@endsection

@section('main-section')

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class=" col-lg-9   mb-5 mb-lg-0">
                <article>

                    <h1 class="h2">{{ $question->question }}</h1>
                    <ul class="card-meta list-inline mt-4">
                        <li class="list-inline-item">
                            <a href="#" class="card-meta-author">
                                <img src="{{ asset('user_photos/'.$question->user_photo) }}">
                                <span>{{ $question->user_name }}</span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <i class="ti-calendar"></i>{{ date('D M Y', strtotime($question->created_at)) }}
                        </li>
                        <li class="list-inline-item text-primary">
                            <i class="ti-bookmark"></i>{{ $question->category_name }}
                        </li>
                    </ul>

                </article>

            </div>

            <div class="col-lg-9 col-md-12">
                <div class="mb-5 border-top mt-4 pt-5">
                    <h3 class="mb-4">Answers</h3>

                    @if ($answers->count() > 0)

                    @foreach ($answers as $answer)

                    <div class="card card-body mt-4">
                        <div class="media d-block d-sm-flex">
                            <a class="d-inline-block mr-2 mb-3 mb-md-0" href="#">
                                <img src="{{ asset('user_photos/'.$answer->user_photo) }}" class="mr-3 avater" alt="">
                            </a>
                            <div class="media-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span>
                                        <a href="#!" class="h4 d-inline-block mb-3">{{ $answer->user_name }}</a>
                                        <small class="text-black-800 ml-2 font-weight-600">{{ date('D M Y',
                                            strtotime($answer->created_at)) }}</small>
                                    </span>
                                    @if ($answer->user_id==auth()->user()->id)
                                    <form method="post" action="{{ route('answer_delete',$answer->id) }}">
                                        @csrf
                                        @method('DELETE');
                                        <button class="text-danger border-0 bg-white"> <i class="fas fa-trash"></i>
                                    </form>
                                    </button>

                                    @endif
                                </div>

                                <p>{!! $answer->question_answer !!}</p>
                                <hr class="my-3">
                                <div class="">
                                    @php

                                    $likes= DB::table('question_answer_likes')
                                    ->where('answer_id', $answer->id)
                                    ->get();

                                    $liker_user= DB::table('question_answer_likes')
                                    ->where('answer_id', $answer->id)
                                    ->where('user_id', auth()->user()->id)
                                    ->first();

                                    @endphp

                                    @if ($liker_user)
                                    <a href="{{ route('answer_unlike',$answer->id ) }}">
                                        <i class="fa fa-heart text-danger"></i>
                                    </a>

                                    @else
                                    <a href="{{ route('answer_like',$answer->id ) }}">
                                        <i class="far fa-heart text-dark"></i>
                                    </a>

                                    @endif
                                    <span class="ml-1">{{ $likes->count(); }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach

                    @else

                    <p> No Comment Found </p>

                    @endif


                </div>

                <div>
                    <h3 class="mb-4 pt-4">Leave an answer</h3>

                    <form action={{ route('questions_answer_store', $question->id) }} method="POST">
                        @csrf

                        <div class="form-group">
                            <textarea class="form-control shadow-none" name="answer" rows="7" required></textarea>
                        </div>

                        <button class="btn btn-primary" type="submit">Submit Answer</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
