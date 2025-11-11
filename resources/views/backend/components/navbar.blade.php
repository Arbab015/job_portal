<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <a href="dashboard.blade.php" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <form class="d-none d-md-flex ms-4">
        <input class="form-control border-0" type="search" placeholder="Search">
    </form>
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-envelope me-lg-2"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="#" class="dropdown-item">
                    <div class="d-flex align-items-center">
                        <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt=""
                            style="width: 40px; height: 40px;">
                        <div class="ms-2">
                            <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                            <small>15 minutes ago</small>
                        </div>
                    </div>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item">
                    <div class="d-flex align-items-center">
                        <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt=""
                            style="width: 40px; height: 40px;">
                        <div class="ms-2">
                            <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                            <small>15 minutes ago</small>
                        </div>
                    </div>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item">
                    <div class="d-flex align-items-center">
                        <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt=""
                            style="width: 40px; height: 40px;">
                        <div class="ms-2">
                            <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                            <small>15 minutes ago</small>
                        </div>
                    </div>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item text-center">See all message</a>
            </div>
        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-bell me-lg-2"></i>
                @if($unread_notifications > 0)
                <span class="position-absolute translate-middle badge rounded-pill bg-danger">
                    {{ $unread_notifications }}
                </span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-white border rounded rounded-bottom m-0 pt-0">
                <div class="d-flex align-items-center justify-content-between mb-4  notification_header p-3 " style="min-width: 220px;">
                    <div class=""> Notifications </div>
                    <div class="buttons">
                        <span class="cursor-pointer text-info small ps-3 read-btn" title="Read All">
                            @if($unread_notifications>0)
                            <i class="fa-solid fa-envelope"></i>
                            @else
                            <i class="fa-regular fa-envelope-open"></i>

                            @endif
                        </span>
                        <span class="cursor-pointer text-danger delete-btn" type="button" title="Delete All"> <i class="ps-1 fa-solid fa-trash-can"></i> </span>
                    </div>
                </div>
                @if(empty($notification_arrays))
                <div class="block p-5 text-center" style="min-height: 150px;">
                    <i class="fa-2x fa-solid fa-bell"></i>
                    <p> No Notifications</p>
                </div>
                @endif
                @if(isset($notification_arrays))
                <div class="notifications overflow-y-scroll" style="max-height: 290px;">
                    @foreach ($notification_arrays as $key => $notification)
                    <div @class([ 'dropdown-item' , 'd-flex' , 'justify-content-between' , 'p-3' , 'mb-1' , 'notification_item' , 'unread-dropdown-item'=> ! $notification['read_at']]) data-id="{{ $notification['id'] }}">
                        <div class="fw-normal mb-0">
                            <div>{{ $notification['data'] }}</div>
                            <small>{{ $notification['created_at'] }}</small>
                        </div>
                        <div class="buttons">
                            <span class="cursor-pointer text-info small ps-3 read-btn" title="Read">
                                @if($notification['read_at'])
                                <i class="fa-regular fa-envelope-open"></i>
                                @else
                                <i class="fa-solid fa-envelope"></i>
                                @endif
                            </span>
                            <span class="cursor-pointer text-danger small delete-btn" title="Delete">
                                <i class="ps-1 fa-solid fa-trash-can"></i>
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2"
                    src="{{ Auth::user()->profile_picture
            ? asset('storage/profile_pictures/' . Auth::user()->profile_picture)
            : asset('img/dummy_user.png') }}"
                    style="width: 40px; height: 40px;">
                <span class="d-none d-lg-inline-flex">
                    @auth
                    {{ Auth::user()->name }}
                    @endauth
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="{{ route('user.profile') }}" class="dropdown-item">My Profile</a>
                <a href="#" class="dropdown-item">Settings</a>
                <a href="{{ route('logout') }}" class="dropdown-item">logout</a>
            </div>
        </div>
    </div>
</nav>

<!-- toast sms -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toast_message" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fa-2x fa-solid fa-bell rounded me-2"></i>

            <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            You have read Notification
        </div>
    </div>
</div>


@push('scripts')
<script>
        // for read notification and read all notification
        $('.read-btn').on('click', function(e) {
            e.preventDefault();
            let notification_item = $(this).closest('.notification_item');
            let id = notification_item.data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: id ? 'notification/read/' + id : 'notification/read/',
                method: 'POST',
                success: function(response) {
                    console.log('notification read')
                    let message = id ? 'You have read notification' : 'You have read all notifications';
                    $('.toast-body').text(message);
                    const toastEl = document.getElementById('toast_message');
                    const toast = new bootstrap.Toast(toastEl);
                    toast.show();
                    setInterval(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    console.error('An error occurred:', xhr.responseText);
                }
            });
        });

        // for delete notification and delete all notifications
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            let notification_item = $(this).closest('.notification_item');
            let id = notification_item.data('id');
            Swal.fire({
                    title: id ? 'Delete this notification?' : 'Delete all notifications?',
                    text: id ? "This notification will be permanently removed." : "All notifications will be deleted.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: id ? 'notification/delete/' + id : 'notification/delete/',
                            method: 'POST',
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: id ? 'Notification deleted' : 'All notifications deleted',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setInterval(function() {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr) {
                                console.error('An error occurred:', xhr.responseText);
                            }
                        });
                    }
                });

        });
  
</script>
@endpush

@push('styles')
<style>
    .notification_header {
        background-color: rgb(202 221 248) !important;
    }

    .unread-dropdown-item {
        background-color: #f3f6f9 !important;
    }

    .unread-dropdown-item:hover {
        background-color: #b2c0d0 !important;
    }
</style>
@endpush
