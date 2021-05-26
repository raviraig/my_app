@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Users</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Users</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div style="margin: 10px;" class="row">
    <div class="col-lg-10">
        @if(Auth::user()->role != 3)
            <a class="btn btn-success" href="/add_user">
                Add User
            </a>
        @endif
    </div>
    <div class="col-lg-2">
        <a href="/export_user" id="export" class="btn btn-secondary btn-sm">Export</a>
    </div>

</div>

<div class="card">
    
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Id
                        </th>
                        <th>
                            First Name
                        </th>
                        <th>
                            Last Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Role
                        </th>
                        @if(Auth::user()->role != 3)
                        <th>
                            &nbsp;
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr data-entry-id="{{ $user->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $user->id ?? '' }}
                            </td>
                            <td>
                                {{ $user->first_name ?? '' }}
                            </td>
                            <td>
                                {{ $user->last_name ?? '' }}
                            </td>
                            <td>
                                {{ $user->email ?? '' }}
                            </td>
                            <td>
                                {{$roles[$user->role]->title ?? '' }}
                            </td>
                            @if(Auth::user()->role != 3)
                            <td>

                                    <a class="btn btn-xs btn-info" href="/edit_user/{{$user->id}}">
                                        Edit
                                    </a>

                                    <form action="/delete_user/{{$user->id}}" method="GET" onsubmit="return confirm('Is you want to delete this account ?');" style="display: inline-block;">
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
            {{ $users->links() }}
        </div>


    </div>
</div>

@endsection



