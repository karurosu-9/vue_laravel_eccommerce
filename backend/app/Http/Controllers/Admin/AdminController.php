<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthAdminRequest;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * 本日、昨日、今月、今年の注文の取得
     */
    public function index()
    {
        $todayOrders = Order::whereDay('created_at', Carbon::today())->get();
        $yesterdayOrders = Order::whereDay('created_at', Carbon::yesterday())->get();
        $monthOrders = Order::whereDay('created_at', Carbon::now()->month)->get();
        $yearOrders = Order::whereDay('created_at', Carbon::now()->year)->get();

        return view('admin.dashboard')->with([
            'todayOrders' => $todayOrders,
            'yesterdayOrders' => $yesterdayOrders,
            'monthOrders' => $monthOrders,
            'yearOrders' => $yearOrders,
        ]);
    }

    /**
     * ログインフォーム
     */
    public function login()
    {
        if(!auth()->guard('admin')->check()) {
            return view('login');
        }

        // 既に管理者としてログイン済みであれば、dashboardに遷移
        return redirect()->route('admin.dashboard');
    }

    /**
     * ログイン処理
     */
    public function auth(AuthAdminRequest $request)
    {
        if($request->validated()) {
            // config/auth.phpで設定したguardの設定でチェックをかける
            if(auth()->guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                // ログイン成功時は、セッションIDを新しく作り直す
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }else {
                return redirect()->route('admin.login')->with([
                    'error' => 'メールアドレスとパスワードが一致しません。',
                ]);
            }
        }
    }

    /**
     * ログアウト処理
     */
    public function logout()
    {
        auth()->guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}
