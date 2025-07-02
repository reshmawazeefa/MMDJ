<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Company;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class CompanyinfoController extends Controller
{
    public function index()
    {
        // Get the existing company or create a new instance
        $company = Company::firstOrNew([]);
        return view('admin.create_company_info', compact('company'));
    }

    public function store(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'c_name'       => 'required|string|max:255',
            'c_address'    => 'required|string',
            'c_crncy_code' => 'required|string',
            'c_email'      => 'required|email|max:255',
            'c_phone'      => 'required',
            'c_logo'       => 'nullable|image|mimes:png|max:2048',
            'c_fav_icon'   => 'nullable|mimes:jpeg,png,jpg,gif,svg,ico|max:512'
        ], [
            'c_logo.mimes'       => 'Logo must be png file.',
            'c_logo.max'         => 'Logo must not exceed 2MB.',
            'c_fav_icon.mimes'   => 'Favicon must be a jpeg, png, jpg, gif, svg, or ico file.',
            'c_fav_icon.max'     => 'Favicon must not exceed 512KB.',
        ]);

        
    
        // Find existing or create new company record (assumes singleton setup)
        $company = Company::firstOrNew([]);
    

        if ($request->hasFile('c_logo')) {
            $logo = $request->file('c_logo');
            $logoName = 'logo-light.png'; // Fixed name
            $destinationPath = public_path('assets/images');
        
            // Make sure the folder exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
        
            // Move and overwrite the file
            $logo->move($destinationPath, $logoName);
        
            // Optional: save the relative path in DB if needed
            $company->c_logo = 'assets/images/' . $logoName;
        }
        
    

        if ($request->hasFile('c_fav_icon')) {
            $favicon = $request->file('c_fav_icon');
            $faviconName = 'favicon.ico'; // Fixed file name
            $destinationPath = public_path('assets/images');
        
            // Make sure the folder exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
        
            // Move and overwrite the file
            $favicon->move($destinationPath, $faviconName);
        
            // Optional: save the relative path in DB if needed
            $company->c_fav_icon = 'assets/images/' . $faviconName;
        }
        
    
        // Fill and save remaining data (excluding file inputs)
        $company->fill($request->only(['c_name', 'c_address', 'c_email', 'c_phone','c_phone1','c_crncy_code']));
        $company->save();
    
        return redirect()->back()->with('success', 'Company information saved successfully!');
    }
    

}
