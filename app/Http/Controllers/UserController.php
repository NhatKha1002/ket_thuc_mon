<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class UserController extends Controller
{
    // Phương thức để hiển thị danh sách user
    public function show_users()
    {
        $customers = DB::table('tbl_customers')->get();
        return view('admin.all_user', compact('customers'));
    }

    // Phương thức để xóa user
    public function destroy($id)
    {
        $customer = DB::table('tbl_customers')->where('customer_id', $id)->first();
        if ($customer) {
            DB::table('tbl_customers')->where('customer_id', $id)->delete();
            return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công');
        }
        return redirect()->route('users.index')->with('error', 'không tìm thấy người dùng này');
    }
}
