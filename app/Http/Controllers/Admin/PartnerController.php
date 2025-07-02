<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Validator;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::get();
        return view('admin.partners', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_partner');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $last = Partner::orderBy('id','desc')->first();
        $array = array();
        if($last)
        {
            $code = $last->partner_code;
            $array = explode('PA',$code);
        }
        if(count($array) > 1)
            $num = $array[1]+1;            
        else
            $num = 1;
        /*if(strlen($num) < 7)
            $num = str_pad($num, 7, '0', STR_PAD_LEFT);*/
        if($request->ajax())
        {
            $validator = Validator::make(
                $request->all(), [
                'name' => 'max:255',
                'phone' => 'numeric|unique:partners,phone|digits:10', 
                'email' => 'nullable|unique:partners,email|max:100', 
                'designation' => 'max:255',
                'alt_phone' => 'nullable|numeric|digits:10']);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }
            else
            {                
                $Partner= new Partner();
                $Partner->name= $request->name;
                //$Partner->partner_code= $request->partner_code;
                $Partner->partner_code= 'PA'.$num;
                $Partner->phone= $request->phone;
                $Partner->email= $request->email;
                $Partner->address= $request->address;
                $Partner->description= $request->description;
                $Partner->partner_type= $request->partner_type;
                $Partner->designation= $request->designation;
                $Partner->alt_phone= $request->alt_phone;
                $Partner->save();
                return response()->json(['success'=>'Added new records.']);
            }
        }
        else
        {
            $validator = $request->validate( ['name' => 'required|max:255',
                'phone' => 'required|numeric|unique:partners,phone|digits:10', 
                'email' => 'nullable|unique:partners,email|max:100',
                'partner_type' => 'required', 
                'designation' => 'max:255',
                'alt_phone' => 'nullable|numeric|digits:10'
            ]);
            $Partner= new Partner();
            $Partner->name= $request->name;
            //$Partner->partner_code= $request->partner_code;
            $Partner->partner_code= 'PA'.$num;
            $Partner->phone= $request->phone;
            $Partner->alt_phone= $request->alt_phone;
            $Partner->email= $request->email;
            $Partner->address= $request->address;
            $Partner->description= $request->description;
            $Partner->partner_type= $request->partner_type;
            $Partner->designation= $request->designation;
            $Partner->alt_phone= $request->alt_phone;
            $Partner->save();
            return redirect('admin/partners')->with('success','Partner added successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        return view('admin.edit_partner', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $validator = $request->validate( ['name' => 'required|max:255', 
                'partner_code' => 'required|unique:partners,partner_code,'.$partner->id, 
                'phone' => 'required|numeric|unique:partners,phone,'.$partner->id.'|digits:10', 
                'email' => 'nullable|unique:partners,email,'.$partner->id.'|max:100',
                'partner_type' => 'required', 
                'designation' => 'max:255',
                'alt_phone' => 'nullable|numeric|digits:10'
            ]);

        $Partner = Partner::where('id', $partner->id)->first();
        $Partner->name= $request->name;
        //$Partner->partner_code= $request->partner_code;
        $Partner->phone= $request->phone;
        $Partner->alt_phone= $request->alt_phone;
        $Partner->email= $request->email;
        $Partner->address= $request->address;
        $Partner->description= $request->description;
        $Partner->partner_type= $request->partner_type;
        $Partner->designation= $request->designation;
        $Partner->alt_phone= $request->alt_phone;
        $Partner->save();

        return redirect('admin/partners')->with('success','Partner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();
        return true;
    }
}
