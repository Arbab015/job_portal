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

        return view('frontend.index', compact('latest_jobs',));
    }

    public function aboutIndex()
    {
        return view('frontend.about');
    }
    public function shopIndex()
    {
        return view('frontend.shop');
    }

    public function shopSingleIndex()
    {
        return view('frontend.shop-single');
    }

    public function contactIndex()
    {
        return view('frontend.contact');
    }

    public function jobsDetail($slug)
    {
        $job = JobPost::where('slug', $slug)->firstOrFail();

        return view('frontend.jobs_detail', compact('job'));
    }

    public function jobsViewAll()
    {
        $jobtypes = JobType::pluck('title', 'id');
        $designations = Designation::pluck('name', 'id');
        return view('frontend.viewall', compact('jobtypes', 'designations'));
    }


    public function jobApply(Request $request)
    {
        try{
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'mobile_no'  => 'required|string|max:20',
            'experience' => 'required',
            'skills'     => 'required',
            'file'       => 'required|mimes:pdf,doc,docx|max:2048',
            'note'       => 'nullable|text',
            'job_id' => 'required|exists:job_posts,id',
        ]);

        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('resumes', $fileName, 'public');
            $validated['file'] = 'storage/' . $filePath;
        }

        Applicant::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'mobile_no'  => $validated['mobile_no'],
            'experience' => $validated['experience'],
            'skills'     => $validated['skills'],
            'file'       => $validated['file'],
            'note'       => $validated['note']?? null,
            'job_id' => $validated['job_id'],
        ]);
        return back()->with('success', 'Your application has been submitted successfully!');
    }
    catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
}
}
