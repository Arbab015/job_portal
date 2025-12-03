<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobType;
use App\Models\Designation;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            return DataTables::of(JobPost::orderBy('id', 'desc'))
                ->addColumn('checkbox', function ($user) {
                    return '<input type="checkbox" class="checkbox" data_type="jobpost" title="Select Record" value="' . $user->id . '">';
                })
                ->addColumn('job_type', function ($jobPost) {
                    return $jobPost->jobType ? $jobPost->jobType->title : '';
                })
                ->addColumn('designation', function ($jobPost) {
                    return $jobPost->designation ? $jobPost->designation->name : '';
                })
                ->addColumn('actions', function ($JobPost) use ($user) {
                    $edit =  "";
                    $delete = "";
                    if ($user->can('edit_job')) {
                        $edit =  '<a href="' . route('jobs.edit', $JobPost->slug) . '">
                        <i class="fa-solid fa-pen-to-square text-primary " role= "button" title="Edit">
                        </i>
                        </a>';
                    }
                    if ($user->can('delete_job')) {
                        $delete =  '<form action="' . route('jobs.destroy', $JobPost->slug) . '" method="POST" style="display:inline;">'
                            . csrf_field()
                            . method_field('DELETE')
                            . '<i class="fa-solid fa-trash-can text-danger" role="button" title="Delete" onclick="confirmDelete(event)">
                                </i>'
                            . '</form>';
                    }

                    return $edit . ' ' . $delete;
                })
                ->addIndexColumn()
                ->rawColumns(['actions', 'checkbox'])
                ->make(true);
        }
        $can_edit = $user->can('edit_job');
        $can_delete = $user->can('delete_job');
        $show_actions =  $can_edit ||  $can_delete;
        return view('backend.jobs.index', compact('show_actions'));
    }

    public function create()
    {
        $jobtypes = JobType::pluck('title', 'id');
        $designations = Designation::pluck('name', 'id');

        return view('backend.jobs.create', compact('jobtypes', 'designations'));
    }

    public function store(Request $request)
    {
        try {
            if ($request->hasFile('upload')) {

                $file = $request->file('upload');
                $filename = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('media'), $filename);

                $url = asset('media/' . $filename);

                return response()->json([
                    "uploaded" => 1,
                    "fileName" => $filename,
                    "url" => $url
                ]);
            }
            $validated_data =  $request->validate([
                'title' => 'required|string|max:50',
                'slug' => 'required|string|max:50|unique:job_posts',
                'description' => 'required',
                'job_type_id' => 'required|string',
                'address' => 'required|string',
                'designation_id' => 'required|string',
                'due_date' => 'required|date',
            ]);


            JobPost::create($validated_data);
            return redirect()->route('jobs.index')->with('success', 'Job added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit($slug)
    {
        $jobtypes = JobType::pluck('title');
        $designations = Designation::pluck('name');
        $job_post = JobPost::where('slug', $slug)->firstOrFail();
        return view('backend.jobs.edit', compact('jobtypes', 'designations', 'job_post'));
    }

    public function update(Request $request, $slug)
    {
        try {
            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('media'), $filename);
                $url = asset('media/' . $filename);
                return response()->json([
                    "uploaded" => 1,
                    "fileName" => $filename,
                    "url" => $url
                ]);
            }
            $validated_data = $request->validate([
                'title' => 'required|string|max:50',
                'description' => 'required',
                'address' => 'required|string',
                'job_type_id' => 'required|string|exists:job_types,id',
                'designation_id' => 'required|string|exists:designations,id'
            ]);
            $job_post = JobPost::where('slug', $slug)->firstOrFail();
            $job_post->fill($validated_data);
            if ($job_post->isDirty()) {
                $job_post->save();
                return redirect()->route('jobs.index')->with('success', 'Job  Updated Successfully.');
            }
            return redirect()->back()->with('error', 'No changes detected.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy($slug)
    {
        try {
            $job_post = JobPost::where('slug', $slug)->firstOrFail();
            // Get all applicants for this job
            $applicants = $job_post->applicants;
            foreach ($applicants as $applicant) {
                $applicant->delete();
            }
            $job_post->applicants()->detach();
            // Delete job post
            $job_post->delete();
            return redirect()->route('jobs.index')->with('success', 'Job and related applicants deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $jobIds = $request->ids;
            // Get all applicants who applied to these jobs
            $applicants = Applicant::whereHas('jobPost', function ($q) use ($jobIds) {
                $q->whereIn('job_id', $jobIds);
            })->get();
            logger($applicants);
            foreach ($applicants as $applicant) {
                if ($applicant->jobPost()->count() <= 1) {
                    $applicant->delete();
                }
            }
            DB::table('applicant_jobs')->whereIn('job_id', $jobIds)->delete();
            // Now delete the job posts
            JobPost::whereIn('id', $jobIds)->delete();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
