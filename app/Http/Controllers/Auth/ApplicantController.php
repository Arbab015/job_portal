<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return DataTables::of(Applicant::orderBy('id', 'desc'))
                    ->addColumn('actions', function () {
                        $approve =  '<a href="">
                        <i class="fa-solid fa-check" role= "button" title="Approve">
                        </i>
                        </a>';

                        $reject =  '<a href="">
                        <i class="fa-solid fa-close" role= "button" title="Reject">
                        </i>
                        </a>';

                        return $approve . ' ' . $reject;
                        
                    })
                     ->rawColumns(['actions'])
                ->make(true);
                }
                    return view('backend.applicants.index');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
