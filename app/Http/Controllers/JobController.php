<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobType;
use App\Models\Designation;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class JobController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(JobPost::orderBy('id', 'desc'))
                ->addColumn('serial_no', function () {
                    static $count = 0;
                    $count++;
                    return $count;
                })
                ->addColumn('job_type', function ($jobPost) {
                    return $jobPost->jobType ? $jobPost->jobType->title : '';
                })
                ->addColumn('designation', function ($jobPost) {
                    return $jobPost->designation ? $jobPost->designation->name : '';
                })
                ->addColumn('actions', function ($JobPost) {

                    $edit =  '<a href="' . route('jobs.edit', $JobPost->slug) . '">
                        <i class="fa-solid fa-pen-to-square text-primary " role= "button" title="Edit">
                        </i>
                        </a>';

                    $delete =  '<form action="' . route('jobs.destroy', $JobPost->slug) . '" method="POST" style="display:inline;">'
                        . csrf_field()
                        . method_field('DELETE')
                        . '<i class="fa-solid fa-trash-can text-danger" role="button" title="Delete" onclick="confirmDelete(event)">
                                </i>'
                        . '</form>';
                    return $edit . ' ' . $delete;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('jobs.index');
    }

    public function create()
    {
        $jobtypes = JobType::pluck('title', 'id');
        $designations = Designation::pluck('name', 'id');

        return view('jobs.create', compact('jobtypes', 'designations'));
    }

    public function store(Request $request)
    {
        try {

            $validated_data =  $request->validate([
                'title' => 'required|string|max:50',
                'slug' => 'required|string|max:50|unique:job_posts',
                'description' => 'required',
                'job_type_id' => 'required|string',
                'designation_id' => 'required|string',
            ]);
            JobPost::create($validated_data);
            return redirect()->route('jobs.index')->with('success', 'Job added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit($slug)
    {
        $jobtypes = JobType::pluck('title', 'ID');
        $designations = Designation::pluck('name', 'ID');
        $job_post = JobPost::where('slug', $slug)->firstOrFail();
        return view('jobs.edit', compact('jobtypes', 'designations', 'job_post'));
    }

    public function update(Request $request, $slug)
    {
        try {
            $validated_data = $request->validate([
                'title' => 'required|string|max:50',
                'description' => 'required',
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

            $job_post->delete();
            return redirect()->route('jobs.index')->with('success', 'Job deleted successfully. ');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
