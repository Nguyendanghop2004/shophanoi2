@extends('admin.layouts.master')



@section('content')
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Cấp quyền người dùng: {{$admin->name}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                   <form action="{{url('admin/insert_permission',[$admin->id])}}" method="POST">
                    @csrf
                    @if(isset($name_roles))
                    Vai trò hiện tại: {{$name_roles}}
                    @endif
                    
                    @foreach ($permission as $per)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                            @foreach ($get_permission_viaroles as $get)
                                @if ($get->id == $per->id)
                                    checked
                                @endif
                            @endforeach                 
                            name="permission[]" id="{{$per->id}}" value="{{$per->name}}">
                            <label class="form-check-label" for="{{$per->id}}">{{$per->name}}</label>
                        </div>
                    @endforeach
                     @can('admin')
                    <br>
                    <input type="submit" name="insertroles" value="Cấp quyền" class="btn btn-danger">
                </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Thêm Quyền</h4>
            </div>
            <form action="{{ url('admin/insertPermission') }}"  method="POST">
                @csrf
                <div class="mb-3 mt-3">
                    <label for="name" class="form-label">Tên quyền</label>
                    <input type="text" class="form-control" value="{{ old('permission') }}" name="permission" placeholder="Tên quyền">
                </div>
                <div class="card-body">
                    <input type="submit" name="insertper" value="Thêm mới quyền" class="btn btn-danger">
                    @endcan
                </div>
            </form>
        </div>
    </div>
@endsection
