@extends('layouts.app')

@section('title')
Contact |
@endsection

@section('main-section')

@include('layouts.includes.banner')

<section class="section-sm">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">

                <div class="content mb-5">
                    <h2 id="we-would-love-to-hear-from-you">We would Love To Hear From You&hellip;.</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Velit massa vitae felis augue. In
                        venenatis scelerisque accumsan egestas mattis. Massa feugiat in sem pellentesque.</p>
                </div>

                <form method="POST" action="{{ route('contact_store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="subject">Reason For Contact</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Write here...">
                    </div>
                    <div class="form-group">
                        <label for="message">Your Message Here</label>
                        <textarea name="message" id="message" class="summernote form-control"
                            placeholder="your message..."></textarea>
                    </div>
                    <button type="submit" class=" btn btn-primary">Send Now</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
