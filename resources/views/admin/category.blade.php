@extends('admin.layout.app')

@section('title')
Categories
@endsection

@php
$title='Category';
@endphp

@section('main-part')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 justify-between">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Add
            Category</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th> Action</th>
                </thead>
                <tfoot>
                    <tr>
                        <th>SL.</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th> Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($categories as $sl=> $category)

                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <div class="d-flex">
                                <a class="btn text-primary" data-toggle="modal"
                                    data-target="{{ '#Modal'.$category->id.'Category'}}">
                                    <i class="fas fa-edit"> </i></a>
                                <form method="POST" action="{{ route('category.destroy',$category->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" class="btn text-danger delete"> <i class="fas fa-trash"> </i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Dropdown Category Update -->

                    <div class="modal fade" id="{{ 'Modal'.$category->id.'Category'}}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                                </div>
                                <form method="POST" action="{{ route('category.update', $category->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="put" />
                                    <div class="modal-body">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $category->name }}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <textarea name="description" rows="3"
                                            class="form-control my-2 @error('description') is-invalid @enderror">{{ $category->description }}</textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror


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


<!-- Dropdown Category Information -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            </div>
            <form method="POST" action="{{ route('category.store') }}">
                @csrf
                <div class="modal-body">
                    <input type="text" placeholder="Category Name" name="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <textarea name="description" rows="3"
                        class="form-control my-2 @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror


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
