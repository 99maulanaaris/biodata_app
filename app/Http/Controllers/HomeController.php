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
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home.index');
    }

    public function dataUser(Request $request)
    {
        return view('pages.user.index');
    }

    public function editUser($id)
    {
        $user = User::find($id);
        return view('pages.user.edit',compact('user'));
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
                User::where('id',$request->user_id)->update([
                    'name' => $request->name,
                    'email' => $request->email
                ]);
                UserBiodata::updateOrCreate([
                    'id' => $request->id_biodata
                ],[
                    'users_id' => $request->user_id,
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
                            'users_id' => $request->user_id,
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
                            'users_id' => $request->user_id,
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
                            'users_id' => $request->user_id,
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

    public function dataTable(Request $request)
    {
        $user = User::role('User')->with(['biodata','work','training','education'])->filter($request)->get();

        return DataTables::of($user)->addIndexColumn()
                            ->addColumn('name',function($user){
                                return $user->name;
                            })
                            ->addColumn('ttl',function($user){
                                return $user->biodata->brithday ?? '';
                            })
                            ->addColumn('position',function($user){
                                return $user->biodata->position ?? '';
                            })
                            ->addColumn('action',function($user){
                                return '<div class="d-flex justify-content-center align-items-center gap-3">
                                    <a href="'.route('user.edit',[$user->id]).'" class="btn btn-outline-secondary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <div class="btn btn-outline-danger btn-delete" data-id="'.$user->id.'">
                                        <i class="bi bi-trash"></i>
                                    </div>
                                </div>';
                            })
                            ->rawColumns(['action'])
                            ->smart(true)
                            ->make(true);

    }

    public function destroy($id)
    {
        try {
            $data = User::find($id);
            if(!$data)
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);

            DB::transaction(function () use ($data) {
                UserBiodata::where('users_id',$data->id)->delete();
                UserWork::where('users_id',$data->id)->delete();
                UserTraining::where('users_id',$data->id)->delete();
                UserEducation::where('users_id',$data->id)->delete();
                $data->delete();
            });

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}
