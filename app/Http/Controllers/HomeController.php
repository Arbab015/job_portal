<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Designation;
use App\Models\JobPost;
use App\Models\JobType;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $latest_jobs = JobPost::whereDate('due_date', '>=', Carbon::today())->orderBy('id', 'desc')->take(3)->get();
        // dd($latest_jobs);
        return view('frontend.home', compact('latest_jobs',));
    }


    public function contactIndex()
    {
        return view('frontend.contact');
    }

    public function jobsDetail($slug)
    {
        $job = JobPost::where('slug', $slug)->firstOrFail();
        $no_of_applicants = $job->applicant()->count();
       
        $period = $job->created_at->diffForHumans();
        return view('frontend.jobs_detail', compact('job', 'period' , 'no_of_applicants'));
    }

    public function jobsViewAll(Request $request)
    {
        $load_limit = $request->input('load_limit');
        $limit = 3;
        $limit += $load_limit;
        $search_term = $request->input('search_term');
        $search_jobtype = $request->input('jobtype_id');
        $search_designation = $request->input('designation_id');
        $latest_jobs = [];
        if ($request->ajax()) {
            $jobs = JobPost::whereDate('due_date', '>=', Carbon::today())->orderBy('id', 'desc');
            if (!empty($search_jobtype)) {
                $jobs->where('job_type_id',  $search_jobtype);
            }
            if (!empty($search_designation)) {
                $jobs->where('designation_id',  $search_designation);
            }
            if (!empty($search_term)) {
                $jobs->where('title', 'like', '%' . $search_term . '%');
            }
            $total_jobs = $jobs->count();
            $latest_jobs = $jobs->with(['jobType', 'designation'])->take($limit)->get();
            $job_image = asset('img/job-search.webp');
            $has_more = $total_jobs > $limit;
            return response()->json([
                'jobs' => $latest_jobs,
                'has_more' => $has_more,
                'limit' => $limit,
                'job_image' => $job_image
            ]);
        }

        $jobtypes = JobType::pluck('title', 'id');
        $designations = Designation::pluck('name', 'id');
        return view('frontend.all_jobs', compact('jobtypes', 'designations', 'search_term'));
    }


    public function jobApply(Request $request)
    {

        try {
            $email = $request->input('email');
            $mobile_no = $request->input('mobile_no');

            $validated = $request->validate([
                'name'       => 'required|string|max:255',
                'email'      => 'required|email|max:255',
                'mobile_no'  => 'required|string|max:20',
                'experience' => 'required',
                'skills'     => 'required',
                'file'       => 'required|mimes:pdf,doc,docx|max:2048',
                'notes'       => 'nullable|text',
                'job_id'    => 'required|exists:job_posts,id'
            ]);

            if ($request->hasFile('file')) {
                $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('resumes', $fileName, 'public');
                $validated['file'] =  $filePath;
            }
            $applicant = Applicant::where('email', $email)->where('mobile_no', $mobile_no)->first();
            if (!$applicant) {
                $applicant = Applicant::create([
                    'name'       => $validated['name'],
                    'email'      => $validated['email'],
                    'mobile_no'  => $validated['mobile_no'],
                    'experience' => $validated['experience'],
                    'skills'     => $validated['skills'],
                    'file'       => $validated['file'],
                    'notes'       => $validated['notes'],
                ]);
            }


            DB::table('applicant_jobs')->insert([
                'applicant_id' => $applicant->id,
                'job_id' => $validated['job_id']
            ]);

            return redirect()->back()->with('success', 'Your application submitted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }


}
