<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Address;
use App\Models\Order;

class UserController extends Controller
{
    // Hiển thị danh sách user
    public function index()
    {
        $users = User::paginate(10); // Hiển thị tất cả người dùng, có thể lọc theo `usertype` nếu cần
        return view('admin.users.index', compact('users'));
    }

    // Form tạo user mới
    public function create()
    {
        return view('admin.users.create');
    }

    // Lưu user mới
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'usertype' => 'required|in:user,admin', // Có thể thêm loại người dùng
        ]);

        // Tạo người dùng mới
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'usertype' => $request->usertype, // Thêm loại người dùng
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Thêm user thành công.');
    }

    // Form sửa user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Cập nhật user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'usertype' => 'required|in:user,admin', // Cập nhật loại người dùng
        ]);

        // Cập nhật thông tin người dùng
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'usertype' => $request->usertype, // Cập nhật loại người dùng
        ]);

        // Kiểm tra và cập nhật mật khẩu nếu có thay đổi
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6|confirmed']);
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật user thành công.');
    }

    // Xóa user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Bảo vệ không cho xóa người dùng admin chính
        if ($user->usertype == 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Không thể xóa người dùng admin.');
        }

        // Xóa người dùng
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Xóa user thành công.');
    }

    public function show($id)
    {
        // Lấy thông tin người dùng theo ID
        $user = User::findOrFail($id);

        // Lấy thông tin địa chỉ của người dùng (nếu có)
        $addresses = Address::where('user_id', $id)->get(); // Truy vấn địa chỉ của người dùng

        // Lấy thông tin đơn hàng của người dùng (nếu có)
        $orders = Order::where('customer_id', $id)->get();

        // Trả về view với thông tin người dùng, địa chỉ và đơn hàng
        return view('admin.users.show', compact('user', 'addresses', 'orders')); // Đảm bảo đã truyền các biến này
    }
}
