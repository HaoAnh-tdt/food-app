<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ApiAuthController extends Controller
{
    // POST /api/login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email', // nếu bạn dùng username, đổi field
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email hoặc mật khẩu không chính xác'
            ], 401);
        }

        // sinh token plaintext rồi lưu hash vào DB
        $plainToken = bin2hex(random_bytes(40)); // ~80 chars
        $tokenHash = hash('sha256', $plainToken);

        $user->api_token = $tokenHash;
        $user->save();

        return response()->json([
            'success' => true,
            'token' => $plainToken,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name ?? null,
            ],
        ]);
    }

    // POST /api/logout (protected)
    public function logout(Request $request)
    {
        $user = $request->user(); // middleware sẽ set user
        if ($user) {
            $user->api_token = null;
            $user->api_token_created_at = null;
            $user->save();
        }
        return response()->json(['success' => true, 'message' => 'Đăng xuất thành công']);
    }
}
