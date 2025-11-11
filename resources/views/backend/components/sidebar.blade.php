     <div class="sidebar pe-4 pb-3">
         <nav class="navbar bg-light navbar-light">
             <a href="{{ asset('dashboard') }}" class="navbar-brand mx-4 mb-3">
                 <h3 class="website_title ">JOB PORTAL</h3>
             </a>
             <div class="d-flex align-items-center ms-4 mb-4">
                 <div class="position-relative">
                     <img class="rounded-circle" src="{{ Auth::user()->profile_picture
            ? asset('storage/profile_pictures/' . Auth::user()->profile_picture)
            : asset('img/dummy_user.png') }}" style="width: 40px; height: 40px;">
                     <div
                         class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                     </div>
                 </div>
                 <div class="ms-3">
                     <h6 class="mb-0">
                         @Auth
                         {{ Auth::user()->name}}
                         @endauth
                     </h6>
                     <span> @Auth
                         {{ Auth::user()->roles->pluck('name')->implode(', ')}}
                         @endauth</span>
                 </div>
             </div>
             <div class="navbar-nav w-100">

                 <a href="{{ asset('dashboard') }}" class="nav-item nav-link "><i
                         class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                 @can('designations_listing')
                 <a href="{{ route('designations.index') }}" class="nav-item nav-link">
                     <i class="fa fa-th me-2"></i>Designations
                 </a>
                 @endcan
                 @can('jobtypes_listing')
                 <a href="{{ route('job_types.index') }}" class="nav-item nav-link">
                     <i class="fa-solid fa-layer-group"></i> Job Types
                 </a>
                 @endcan
                 @can('jobs_listing')
                 <a href="{{ route('jobs.index') }}" class="nav-item nav-link">
                     <i class="fa-solid fa-briefcase"></i> Jobs
                 </a>
                 @endcan
                 @can('Super Admin')
                 <a href="{{ route('roles.index') }}" class="nav-item nav-link">
                     <i class="fa-solid fa-person-circle-check"></i> Roles
                 </a>
                 @endcan
                 @can('Super Admin')
                 <a href="{{ route('users.index') }}" class="nav-item nav-link">
                     <i class="fa-solid fa-users"></i> Users
                 </a>
                 @endcan
                  @can('Super Admin')
                 <a href="{{ route('applicants.index') }}" class="nav-item nav-link">
                     <i class="fa-solid fa-users"></i> Applicants
                 </a>
                 @endcan
             </div>
     </div>
     </nav>
     </div>