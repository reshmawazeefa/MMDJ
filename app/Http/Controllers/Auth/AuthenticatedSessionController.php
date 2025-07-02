<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $branch = DB::table('branches')
        ->select('id', 'BranchCode','BranchName','Address')
        ->groupBy('id', 'BranchCode')
        ->get();
        return view('auth.login', ['branch' => $branch]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
   public function store(LoginRequest $request)
{

    $request->authenticate();
    $request->session()->regenerate();

    $branchCode = $request->input('branch', '11111');
    $branchName = $request->input('branchname', 'Default Branch');
    $branchAddress = $request->input('branchaddress', 'No Address');

    $request->session()->put('branch_code', $branchCode);
    $request->session()->put('branch_name', $branchName);
    $request->session()->put('branch_address', $branchAddress);

    return redirect()->intended(RouteServiceProvider::HOME);
}

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
