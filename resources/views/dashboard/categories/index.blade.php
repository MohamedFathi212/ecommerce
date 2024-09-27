@extends('layouts.dashboard')

@section('title','Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
</div>


@if(session()->has('success'))
    <div class="alert alert-success">
        {{session('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger">
        {{session('error') }}
    </div>
@endif

@if(session()->has('info'))
    <div class="alert alert-info">
        {{session('info') }}
    </div>
@endif



<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Image</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $category)
        <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->name}}</td>
            <td>{{$category->parent_id}}</td>
            <td><img src="{{asset('storage/'.$category->image) }}" alt="" height="80"></td>
            <td>{{$category->created_at}}</td>
            <td>
                <a href="{{route('dashboard.categories.edit',$category->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td>
            <form action="{{route('dashboard.categories.destroy',$category->id) }}" method="post">
            @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">No Categories defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
