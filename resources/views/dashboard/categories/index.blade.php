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

<x-alert  />


<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Image</th>
            <th>Created At</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Show</th>
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

            <td>
                <a href="{{route('dashboard.categories.show',$category->id) }}" class="btn btn-sm btn-outline-success">show</a>
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
