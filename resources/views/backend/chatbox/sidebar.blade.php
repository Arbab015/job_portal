<div class="border rounded p-3">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text py-3" id="basic-addon1">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
        </div>
        <input type="text" class="form-control" placeholder="Username or Email" aria-describedby="basic-addon1">
    </div>

    <div class="border rounded p-2 overflow-y-auto bg-white" style="max-height: 455px;">
        @foreach($username as $user_name)
        <div class="w-100 p-1 d-flex align-items-center">
            <a href="#" class="btn-light rounded w-100 p-2 cursor-pointer">
                <img class="rounded-circle me-2"
                    src="{{ asset('img/dummy_user.png') }}"
                    style="width: 30px; height: 30px;">
                <span class="text-dark">{{ $user_name }}</span>
            </a>
        </div>
        @endforeach
    </div>
</div>