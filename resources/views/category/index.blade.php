@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Categories</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Categories</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div style="margin: 10px;" class="row">
    <div class="col-lg-10">
        @if(Auth::user()->role != 3)
            <a class="btn btn-success" href="/add_category">
                Add Category
            </a>
        @endif
    </div>

</div>

<div class="card">
    
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        
                        <th>
                            Id
                        </th>
                        <th>
                            Name
                        </th>
                        <th width="60%">
                            Description
                        </th>
                        @if(Auth::user()->role != 3)
                        <th>
                            &nbsp;
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $key => $category)
                        <tr data-entry-id="{{ $category->id }}">
                            
                            <td>
                                {{ $category->id ?? '' }}
                            </td>
                            <td>
                                {{ $category->name ?? '' }}
                            </td>
                            <td>
                                {{ $category->description ?? '' }}
                            </td>
                            @if(Auth::user()->role != 3)
                            <td>

                                    <a class="btn btn-xs btn-info" href="/edit_category/{{$category->id}}">
                                        Edit
                                    </a>

                                    <form action="/delete_category/{{$category->id}}" method="GET" onsubmit="return confirm('Is you want to delete this category ?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>

                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $categories->links() }}
        </div>


    </div>
</div>




@endsection