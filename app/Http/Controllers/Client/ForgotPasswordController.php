<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CodeRequest;
use App\Http\Requests\Client\UpdatePasswordRequest;
use App\Mail\ForgotPassword;
use App\Models\PasswordResets;
use App\Models\User;
use Cache;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Mail;

class ForgotPasswordController extends Controller
{
    public function sendResetCode(Request $request)
    {
        // dd(1);
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email không tồn tại trong hệ thống.',
        ]);
        $token = \Str::random(40);
        $reset_code = \Str::random(6);
        $expiresAt = Carbon::now()->addMinutes(1);
        $data =  User::where('email', $request->email)->first();
        if (!$data->status) {
            $dataToken = [
                'email' => $request->email,
                'token' => $token,
                'reset_code' => $reset_code,
                'expires_at' => $expiresAt,
            ];
            if (PasswordResets::query()->create($dataToken)) {
                Mail::to($request->email)->send(new ForgotPassword($data, $reset_code));
                return redirect()->route('account.resetPassword', $token)->with('success', 'kiểm tra email');
            }
            return redirect()->back()->with('error', 'Lỗi');
        } else {
            return redirect()->back()->with('error', 'tài khoản của bạn đã bị khóa');
        }
    }
    public function resetPassword($token)
    {
        $resetRequest = DB::table('password_resets')->where('token', $token)->first();
        return view('client.user.code-password', compact('resetRequest'));
    }
    public function checkCode(CodeRequest $request)
    {
        $reset = DB::table('password_resets')->where([
            'reset_code' => $request->reset_code,
            'token' => $request->token,
            'email' => $request->email,
        ])->first();

        if (!$reset) {
            return redirect()->back()->with('error', 'Mã code sai');
        }
        if (Carbon::now()->greaterThan($reset->expires_at)) {
            return redirect()->back()->with('error', 'Mã code đã hết hạn');;
        }
        return redirect()->route('account.changePassword', $request->token)->with('success', 'Thành công');
    }
    public function resetCode($token, Request $request)
    {
        $key = 'last_send_action_' . $request->ip();
        $cooldown = 60; // 10 giây

        $lastActionTime = Cache::get($key);

        if ($lastActionTime && now()->diffInSeconds($lastActionTime) < $cooldown) {
            $remainingTime = $cooldown - now()->diffInSeconds($lastActionTime);
            return redirect()->back()->with('error', "Vui lòng đợi 60 giây trước khi thử lại.", );
        }
        // Cập nhật thời gian gửi lần cuối
        Cache::put($key, now(), $cooldown);
        // Xử lý logic gửi
        $expiresAt = Carbon::now()->addMinutes(1);
        $data =  PasswordResets::where('token', $token)->first();
        $reset_code = \Str::random(6);
        $token = \Str::random(40);

        $dataRest = [
            'email' =>  $data->email,
            'token' =>  $token,
            'reset_code' => $reset_code,
            'expires_at' => $expiresAt,

        ];
        if (PasswordResets::query()->create($dataRest)) {
            Mail::to($data->email)->send(new ForgotPassword($data, $reset_code));
            return redirect()->route('account.resetPassword', $token)->with('success', 'vui lòng kiểm tra email');
        }
    }
    public function indexChangePassword($token)
    {
        try {

            $dataemail = DB::table('password_resets')->where('token', $token)->first();


            if (!$dataemail) {
                throw new \Exception('Token không hợp lệ hoặc đã hết hạn.');
            }
            $data = User::where('email', $dataemail->email)->first();


            if (!$data) {
                throw new \Exception('Người dùng không tồn tại.');
            }

            return view('client.user.reset-change-password', compact('data'));
        } catch (\Exception $e) {
            return redirect()->route('error')->with('error', $e->getMessage());
        }
    }

    public function changePassword(string $id, UpdatePasswordRequest $request)
    {
        $dataUser = User::query()->latest('id')->findOrFail($id);
        $dataUser->password = Hash::make($request->password);
        $dataUser->save();
        return redirect()->route('accountUser.login')->with('success', 'thay đổi mật khẩu thành công');
    }
}
