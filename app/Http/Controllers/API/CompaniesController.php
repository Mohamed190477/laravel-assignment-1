<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function signUp(Request $request){
//        dd($request->all());
        //validate the request
        $validatoin =$request->validate([
            'company_name' => 'required',
            'contact_person_name' => 'required',
            'contact_person_phone_number' => 'required',
            'email' => 'required|email|unique:companies,email'.$request->id,
            'company_address' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'password' => 'required',
        ],[
            'email.unique' => 'The email has already been taken.',
        ]);
        //if validation is false return error message
//        dd($validatoin->errors());
        if(!$validatoin){
            return response()->json($request->errors(), 400);
        }
        $company = new Company();
        $company->company_name = $request->company_name;
        $company->contact_person_name = $request->contact_person_name;
        $company->company_industry = $request->company_industry;
        $company->contact_person_phone_number = $request->contact_person_phone_number;
        $company->email = $request->email;
        $company->company_address = $request->company_address;
        $company->longitude = $request->longitude;
        $company->latitude = $request->latitude;
        $company->company_size = $request->company_size;
        $company->password = $request->password;
        //if the image is exeist i want to move it to the public folder and save this path in data base
        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $company->image = $name;
        }
        $company->save();
        $data=[
            'company_name' => $company->company_name,
            'contact_person_name' => $company->contact_person_name,
            'company_industry' => $company->company_industry,
            'contact_person_phone_number' => $company->contact_person_phone_number,
            'email' => $company->email,
            'company_address' => $company->company_address,
            'longitude' => $company->longitude,
            'latitude' => $company->latitude,
            'company_size' => $company->company_size,
            'password' => $company->password,
        ];

        if ($company->image) {
            $path = public_path('\images\\'.$company->image);
//            dd($path);
            if (!file_exists($path)) {
                return response()->json($data, 200);
            } else {
                $file = file_get_contents($path);
                $base64 = base64_encode($file);
                $data['image'] = $base64;
                //return response()->json($data, 200);
            }
        }
//            dd($image);
        return response()->json(
            [
                'data'=>$data,
//                'image'=>$image,
                'message' => 'تم انشاء الحساب بنجاح'
            ],
            200
        );
    }
    public function login(Request $request){
        // make login in table campnies
        $company = Company::where('email', $request->email)->first();
        if (!$company) {
            return response()->json(['message' => 'هذا الايميل غير موجود'], 404);
        }
        if ($company->password != $request->password) {
            return response()->json(['message' => 'كلمة المرور غير صحيحة'], 404);
        }
        $data=[
            'company_name' => $company->company_name,
            'contact_person_name' => $company->contact_person_name,
            'company_industry' => $company->company_industry,
            'contact_person_phone_number' => $company->contact_person_phone_number,
            'email' => $company->email,
            'company_address' => $company->company_address,
            'longitude' => $company->longitude,
            'latitude' => $company->latitude,
            'company_size' => $company->company_size,
            'password' => $company->password,
        ];
        if ($company->image) {
            $path = public_path('\images\\' . $company->image);

            if (!file_exists($path)) {
                return response()->json($data, 200);
            } else {
                $file = file_get_contents($path);
                $base64 = base64_encode($file);
                $data['image'] = $base64;
            }
        }
        return response()->json(
            [
                'data'=>$data,
                'message' => 'تم تسجيل الدخول بنجاح'
            ],
            200
        );


    }
}
