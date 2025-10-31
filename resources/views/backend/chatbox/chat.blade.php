@extends('layouts.master')

@section('content')
<div class="content_area">
    <div class="card">
        <div class="card-header mb-3">Chat Box</div>
        <div class="col-lg-3 w-30 bg-light">
            @include('chatbox.sidebar')
        </div>
    </div>
</div>
@endsection