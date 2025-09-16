@extends('layouts.admin')

@section('title', 'Danh sách User')

@section('content')
<div class="container">
    <h4 class="card-title">Danh sách người dùng</h4>
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">+ Tạo tài khoản</a>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>  
                            <th>Hành động</th>
                        </tr>
                      </thead>
                      @forelse($users as $user)
                            <tr>
                                <td class= "py-1">{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->usertype) }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm">Xem</a> 
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa user này?')">Xóa</button>
                                    </form>
                                </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Chưa có user nào</td>
                                </tr>
                                @endforelse
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection
