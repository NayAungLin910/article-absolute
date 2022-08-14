<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleChageController extends Controller
{
    public function roleManage()
    {
        $search_user = "";
        return view('admin.role-manage', compact('search_user'));
    }
    public function postRoleManage(Request $request)
    {
        $search_user = User::where('email', $request->search)->first();
        if ($search_user && $search_user->role !== "admin" && $search_user->id !== Auth::user()->id) {
            return view('admin.role-manage', compact('search_user'));
        } else {
            $search_user = "";
            return view('admin.role-manage', compact('search_user'));
        }
    }
    public function chageRole(Request $request, $id)
    {
        $find_user = User::where("id", $id)->first();
        if ($find_user) {
            if ($find_user->role == "moderator") {
                User::where("id", $find_user->id)->update([
                    "role" => "user",
                ]);
                return redirect()->back()->with("success", "Role changed to user!");
            }
            if ($find_user->role == "user") {
                User::where("id", $find_user->id)->update([
                    "role" => "moderator",
                ]);
                return redirect()->back()->with("success", "Role changed to moderator!");
            }
        } else {
            return redirect()->back()->with("error", "User not found!");
        }
    }
}
