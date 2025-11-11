<?php

namespace App\Http\Controllers;

use App\Mail\AcceptanceMail;
use App\Mail\RejectionMail;
use App\Models\Applicant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return DataTables::of(Applicant::orderBy('id', 'desc'))
                    ->editColumn('skills', function ($row) {
                        $skill = '';
                        if (!empty($row->skills)) {
                            $skills_array = json_decode($row->skills, true);
                            foreach ($skills_array as $value) {
                                $skill .= '<span class="badge bg-info ms-1">' . htmlspecialchars($value) . '</span>';
                            }
                            return $skill;
                        }
                    })
                    ->addColumn('job', function ($applicant) {
                        $job = '';
                        $jobs = $applicant->jobPost->pluck('title')->toArray();
                        if (!empty($applicant->jobPost)) {
                            foreach ($jobs as $value) {
                                $job .= '<span class="badge bg-secondary ms-1">' . htmlspecialchars($value) . '</span>';
                            }
                            return $job;
                        }
                    })
                    ->editColumn('status', function ($row) {
                        $status = ($row->status === 'accepted')? '<span class="badge bg-success">' . $row->status . '</span>' :  '<span class="badge bg-warning">' . $row->status . '</span>';
                        return $status;
                    })
                    ->addColumn('file', function ($row) {
                        $download_icon = '<a href="' . route('file.download', $row->id) . '"><i class="fa-solid fa-arrow-down ps-2" role= "button" title="Download File">
                        </i>
                        </a>';
                        return $download_icon;
                    })
                    ->addColumn('actions', function ($row) {
                        $approve =  '<form action="' . route('status.accept', $row->id) . '"  method="POST" style="display:inline;">'
                            . csrf_field()
                            . '<i class="fa-solid fa-check text-success" role= "button" title="Accept" onclick="confirmAccept(event)">
                        </i>'
                            . '</form>';

                        $reject =  '<form action="' . route('status.reject', $row->id) . '"  method="POST" style="display:inline;">'
                            . csrf_field()
                            . '<i class="fa-solid fa-close text-danger" role= "button" title="Reject" onclick="confirmReject(event)">
                        </i>'
                            . '</form>';

                        return $approve . ' ' . $reject;
                    })
                    ->rawColumns(['actions', 'file', 'status', 'skills', 'job'])
                    ->make(true);
            }
            return view('backend.applicants.index');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }


    public function download(Request $request, $id)
    {
        try {
            $applicant = Applicant::findOrFail($id);
            $filePath = $applicant->file;

            if (Storage::disk('public')->exists($filePath)) {
                return Storage::disk('public')->download($filePath);
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function statusAccept(Request $request, $id)
    {
        try {
            $applicant = Applicant::findOrFail($id);
            $applicant->update([
                'status' => 'accepted',
            ]);

            Mail::to($applicant->email)->send(
                new AcceptanceMail($applicant->name)
            );
            return redirect()->back()->with('success', 'Application accepted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }



    public function statusReject($id)
    {
        try {
            $applicant = Applicant::findOrFail($id);
            $applicant->update([
                'status' => 'rejected',
            ]);
            Mail::to($applicant->email)->send(
                new RejectionMail($applicant->name)
            );
            $applicant->delete();
            return redirect()->back()->with('success', 'Application rejected successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
