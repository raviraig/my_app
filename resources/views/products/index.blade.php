@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Products</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Products</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div style="margin: 10px;" class="row">
    <div class="col-lg-10">
        @if(Auth::user()->role != 3)
        <a class="btn btn-success" href="/add_product">
            Add Products
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
                        <th>
                            Price
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            Image
                        </th>
                        @if(Auth::user()->role != 3)
                        <th>
                            &nbsp;
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                        <tr data-entry-id="{{ $product->id }}">
                            
                            <td>
                                {{ $product->id ?? '' }}
                            </td>
                            <td>
                                {{ $product->name ?? '' }}
                            </td>
                            <td>
                                {{ $product->description ?? '' }}
                            </td>
                            <td>
                                {{ $product->price ?? '' }}
                            </td>
                            <td>
                                {{ $categories[$product->category_id] ?? '' }}
                            </td>
                            <td>
                                 <img src="images/products/{{ $product->image ?? '' }}" width = 100; height= 100;>
                            </td>
                            @if(Auth::user()->role != 3)
                            <td>

                                    <a class="btn btn-xs btn-info" href="/edit_product/{{$product->id}}">
                                        Edit
                                    </a>

                                    <form action="/delete_product/{{$product->id}}" method="GET" onsubmit="return confirm('Is you want to delete this product ?');" style="display: inline-block;">
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
            {{ $products->links() }}
        </div>


    </div>
</div>




@endsection