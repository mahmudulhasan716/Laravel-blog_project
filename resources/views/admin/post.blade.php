@extends('admin.layout.app')

@section('name')
Post
@endsection

@php
$title='Post';
@endphp

@section('main-part')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 justify-between">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#PostAddModal"> Add
            posts</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th> Action</th>
                </thead>
                <tfoot>
                    <tr>
                        <th>SL.</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th> Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($posts as $sl=> $post)

                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category_name}}</td>
                        <td>{!! $post->description !!}</td>
                        <td>
                            <img src="{{ asset('post_thumbnil/'.$post->thumbail) }}" alt="" style="width:100px">
                        </td>
                        <td> @if ($post->status==1)
                            Active
                            @else
                            Inactive
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <a class="btn text-primary" data-toggle="modal"
                                    data-target="{{ '#Modal'.$post->id.'post'}}">
                                    <i class="fas fa-edit"> </i></a>
                                <form method="POST" action="{{ route('post.destroy', $post->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" class="btn text-danger delete"> <i class="fas fa-trash"> </i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>


                    <!-- Dropdown Post Update -->

                    <div class="modal fade" id="{{ 'Modal'.$post->id.'post'}}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Post</h5>
                                </div>
                                <form method="POST" action="{{ route('post.update', $post->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" value="put" />
                                    <div class="modal-body">
                                        <input type="text" placeholder="Post Title " name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ $post->title }}">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <div class="form-group mt-2">
                                            <select name="category_id" class="form-control">
                                                @foreach ($category as $Categories)
                                                <option value="{{ $Categories->id }}" @if ($Categories->id==
                                                    $post->category_id)
                                                    selected @endif > {{$Categories->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="">
                                            <input type="file" placeholder="Post Thumbnil " name="thumbail"
                                                class="form-control">

                                            <input type="hidden" name="old_thumbail" value="{{ $post->thumbail }}"
                                                class="form-control">
                                        </div>

                                        <textarea class="summernote" name="description" rows="3"
                                            class="form-control my-2 @error('description') is-invalid @enderror">{{ $post->description }}</textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <div>
                                            <select class="form-control" name="status">
                                                <option value="1" @if ($post->status==1) selected @endif> Active
                                                </option>
                                                <option value="0" @if ($post->status==0) selected @endif> inactive
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <a type="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                        <button type="submit" class="btn btn-primary">Update Category</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Dropdown Post Model -->

<div class="modal fade" id="PostAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Post</h5>
            </div>
            <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="text" placeholder="Post Title " name="title"
                        class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <div class="form-group mt-2">
                        <select name="category_id" class="form-control">
                            <option selected disabled> Seclect Category</option>
                            @foreach ($category as $Categories)
                            <option value="{{ $Categories->id }}"> {{$Categories->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <input type="file" placeholder="Post Thumbnil " name="thumbail" class="form-control">
                    </div>

                    <textarea class="summernote" name="description" rows="3"
                        class="form-control my-2 @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <div>
                        <select class="form-control" name="status">
                            <option selected disabled> Status</option>
                            <option value="1"> Active</option>
                            <option value="2"> inactive</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
