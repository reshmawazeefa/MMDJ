<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class SettingsController extends Controller
{
    /**
     * Display form change password
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password()
    {
        $customers = Customer::get();
        return view('admin.change_password');
    }

    /**
     * Update password
     *
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        $validator = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            Session::flash('message', 'Current password does not match!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('admin/change/password');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        Session::flash('message', 'Password changed successfully!');
        Session::flash('alert-class', 'alert-info');
        return redirect('admin/change/password');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $validator = $request->validate( ['name' => 'required', 'customer_code'
        => 'required|unique:customers,customer_code', 'phone' => 'required', 'address' => 'required', 'description' => 'required']);
        
        $Customer = Customer::create($validator);
        return redirect('admin/customers');
        /*$Customer= new Customer();
        $Customer->name= $request->name;
        $Customer->customer_code= $request->customer_code;
        $Customer->phone= $request->phone;
        $Customer->address= $request->address;
        $Customer->description= $request->description;
        $Customer->save();*/

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('admin.edit_customer', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = $request->validate( ['name' => 'required', 'customer_code'
        => 'required|unique:customers,customer_code,'.$customer->id, 'phone' => 'required', 'address' => 'required', 'description' => 'required']);

        Customer::where('id', $customer->id)->update($validator);

        return redirect('admin/customers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return 1;
    }
}
