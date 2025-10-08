@extends('layouts.master')
@section('content')

<div class="designation_area">
    <h2 class="mb-3"> Designations</h2>

    <div class="card lh-lg">
        <div class="card-header">
            {{ $designation->id ? 'Update Designation' : 'Add Designation' }}
        </div>

        <form method="POST" action="{{ $designation->id 
          ? route('designations.update', $designation->id) 
          : route('designations.store') }}">
            @csrf
            @if($designation->id)
            @method('PUT')
            @endif

            <div class="form-group">
                <label>Designation Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $designation->name) }}"
                    placeholder="Enter designation name">
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                {{ $designation->id ? 'Update' : 'Save' }}
            </button>
        </form>


    </div>

</div>
@endsection