@extends('admin.layout.app')

@section('name')
message
@endsection

@php
$title='message';
@endphp

@section('main-part')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 justify-between">
        <h2> All Messages </h2>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Photo</th>
                        <th>Name $ email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th> Action</th>
                </thead>
                <tfoot>
                    <tr>
                        <th>SL.</th>
                        <th>Photo</th>
                        <th>Name $ email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($messages as $sl=> $message)

                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td>
                            <img src="{{ asset('user_photos/'.$message->user_photo) }}" alt="" style="width:100px">
                        </td>

                        <td>
                            {{ $message->user_name}} <br>
                            <small>{{ $message->user_email }}</small>
                        </td>

                        <td>{!! $message->subject !!}</td>
                        <td>
                            {!! $message->message !!}
                        </td>
                        <td>
                            <div class="d-flex">
                                <form method="post" action="{{ route('messages.destroy', $message->id ) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" class="btn text-danger delete"> <i class="fas fa-trash"> </i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
