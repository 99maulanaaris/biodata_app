<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserBiodata;
use App\Models\UserEducation;
use App\Models\UserTraining;
use App\Models\UserWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BiodataController extends Controller
{

    public function __construct()
    {
        return $this->middleware(['role:User']);
    }

    public function index()
    {
        $user = User::find(auth()->user()->id);
        return view('pages.profile.index',compact('user'));
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'name' => 'required',
            'no_telp' => [
                'required',
                Rule::unique('user_biodatas')->ignore($request->id_biodata),
            ],
            'no_ktp' => [
                'required',
                Rule::unique('user_biodatas')->ignore($request->id_biodata),
            ],
            'brithday' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'status' => 'required',
            'sallary' => 'required',
            'address_ktp' => 'required',
            'address' => 'required',
            'skill' => 'required',
            'last_education' => 'required',
            'name_of_institution' => 'required',
            'major' => 'required',
            'last_year_education' => 'required',
        ]);

        if($validasi->fails()){
            return back()->with('error',$validasi->errors()->first())->withInput();
        }

        try {
            DB::transaction(function() use($request){
                User::where('id',auth()->user()->id)->update([
                    'name' => $request->name,
                    'email' => $request->email
                ]);
                UserBiodata::updateOrCreate([
                    'id' => $request->id_biodata
                ],[
                    'users_id' => auth()->user()->id,
                    'contact_darurat' => $request->contact_darurat,
                    'position' => $request->position,
                    'no_telp' => $request->no_telp,
                    'no_ktp' => $request->no_ktp,
                    'brithday' => $request->brithday,
                    'gender' => $request->gender,
                    'religion' => $request->religion,
                    'blood' => $request->blood ?? "",
                    'status' => $request->status,
                    'address_ktp' => $request->address_ktp,
                    'address' => $request->address,
                    'skill' => $request->skill,
                    'sallary' => str_replace(',', '', $request->sallary),
                    'assignments' => $request->assignments == 'yes' ? true : false,
                ]);

                foreach ($request->name_of_institution as $key => $institution) {
                    if (!is_null($institution)) {
                        UserEducation::updateOrCreate([
                            'id' => $request->id_education[$key] ?? null
                        ],[
                            'users_id' => auth()->user()->id,
                            'name_of_institution' => $institution,
                            'last_education' => $request->last_education[$key],
                            'major' => $request->major[$key],
                            'last_year_education' => $request->last_year_education[$key],
                            'ipk' => $request->ipk[$key]
                        ]);
                    }
                }
                foreach ($request->name_course as $index => $course) {
                    if (!is_null($course)) {
                        UserTraining::updateOrCreate([
                            'id' => $request->id_training[$index] ?? null
                        ],[
                            'users_id' => auth()->user()->id,
                            'name_course' => $course ?? "",
                            'sertification' => strtolower($request->sertification[$index]) == 'ada' ? true : false,
                            'last_year' => $request->last_year_course[$index]
                        ]);
                    }

                }

                foreach ($request->company_name as $indexs => $company) {
                    if (!is_null($company)) {
                        UserWork::updateOrCreate([
                            'id' => $request->id_work[$indexs] ?? null
                        ],[
                            'users_id' => auth()->user()->id,
                            'company_name' => $company,
                            'last_position' => $request->last_position[$indexs],
                            'last_income' => str_replace(',','',$request->last_income[$indexs]),
                            'last_year' => $request->last_year_work[$indexs]
                        ]);
                    }
                }

            });
            return back()->with('success','Success Upload');
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage())->withInput();
        }
    }
}
