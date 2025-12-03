$("#select_all").on("click", function () {
    $(".checkbox").prop("checked", this.checked);
});
// bulk delete
$("#bulk_delete_btn").click(function () {
    let ids = [];
    let data_type = $(".checkbox").attr("data_type");
    let url = "";
    if (data_type == "user") {
        url += "/users/bulk-delete";
    }
    if (data_type == "designation") {
        url += "/designation/bulk-delete";
    }
    if (data_type == "jobtype") {
        url += "/jobtype/bulk-delete";
    }
    if (data_type == "jobpost") {
        url += "/jobpost/bulk-delete";
    }
    if (data_type == "role") {
        url += "/role/bulk-delete";
    }
    if (data_type == "compressed_file") {
        url += "/compressed_files/bulk-delete";
    }
    $(".checkbox:checked").each(function () {
        ids.push($(this).val());
    });

    if (ids.length === 0) {
        Swal.fire("No users selected!", "", "warning");
        return;
    }
    Swal.fire({
        title: "Are You Sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    ids: ids,
                },
                success: function () {
                    $(".table").DataTable().ajax.reload();
                    Swal.fire("Deleted!", "", "success");
                },
            });
        }
    });
});

$(document).ready(function () {
    const modal = new bootstrap.Modal(
        document.getElementById("compression_modal")
    );
    const form = $("#file_form");

    $("#add_btn").on("click", function () {
        $("#method_field").html("");
        $("#model_label").text("Add File");
        modal.show();
    });

    // edit button functionality
    $(document).on("click", ".edit-btn", function () {
        const id = $(this).data("id");
        form.attr("action", "/compressed_file/edit/" + id);
        $("#method_field").html(
            '<input type="hidden" name="_method" value="PUT">'
        );
        $("#model_label").text("Edit File");
        modal.show();
    });

    form.on("submit", function (e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass("was-validated");
    });
});

// sweetalert on delete in yajra datatables
function confirmDelete(event) {
    event.preventDefault();
    var form = event.target.closest("form");
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// sweetalert to confirm acceptance of an application
function confirmAccept(event) {
    event.preventDefault();
    var form = event.target.closest("form");
    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Approve!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// sweetalert to confirm rejection of an application
function confirmReject(event) {
    event.preventDefault();
    var form = event.target.closest("form");
    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Reject!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
(function ($) {
    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($("#spinner").length > 0) {
                $("#spinner").removeClass("show");
            }
        }, 1);
    };
    spinner();

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $(".back-to-top").fadeIn("slow");
        } else {
            $(".back-to-top").fadeOut("slow");
        }
    });
    $(".back-to-top").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
        return false;
    });

    // Sidebar Toggler
    $(".sidebar-toggler").click(function () {
        $(".sidebar, .content").toggleClass("open");
        return false;
    });

    // Progress Bar
    $(".pg-bar").waypoint(
        function () {
            $(".progress .progress-bar").each(function () {
                $(this).css("width", $(this).attr("aria-valuenow") + "%");
            });
        },
        { offset: "80%" }
    );

    // Calender
    $("#calender").datetimepicker({
        inline: true,
        format: "L",
    });

    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        items: 1,
        dots: true,
        loop: true,
        nav: false,
    });

    // jobs
    var job_data = document.getElementById("job_data");
    var jobsperyear = job_data.getAttribute("data-item");
    var jobs_data = JSON.parse(jobsperyear);

    // job types
    var job_type_data = document.getElementById("job_type_data");
    var jobtypesperyear = job_type_data.getAttribute("data-item");
    var job_type_data = JSON.parse(jobtypesperyear);

    // designations
    var designation_data = document.getElementById("designation_data");
    var designations_per_year = designation_data.getAttribute("data-item");
    var designations_data = JSON.parse(designations_per_year);

    // Worldwide Sales Chart
    var ctx1 = $("#worldwide-sales").get(0).getContext("2d");
    var myChart1 = new Chart(ctx1, {
        type: "bar",
        data: {
            labels: ["2025", "2026", "2027", "2028", "2029", "2030"],
            datasets: [
                {
                    label: "Jobs",
                    data: jobs_data,
                    backgroundColor: "rgba(0, 156, 255, .7)",
                },
                {
                    label: "Job Types",
                    data: job_type_data,
                    backgroundColor: "rgba(0, 156, 255, .5)",
                },
                {
                    label: "Designations",
                    data: designations_data,
                    backgroundColor: "rgba(0, 34, 255, 0.3)",
                },
            ],
        },
        options: {
            responsive: true,
        },
    });

    // Salse & Revenue Chart
    var ctx2 = $("#salse-revenue").get(0).getContext("2d");
    var myChart2 = new Chart(ctx2, {
        type: "line",
        data: {
            labels: ["2025", "2026", "2027", "2028", "2029", "2030"],
            datasets: [
                {
                    label: "Jobs",
                    data: jobs_data,
                    backgroundColor: "rgba(0, 156, 255, .5)",
                    fill: true,
                },
                {
                    label: "Job Types",
                    data: job_type_data,
                    backgroundColor: "rgba(0, 156, 255, .3)",
                    fill: true,
                },
                {
                    label: "Designations",
                    data: designations_data,
                    backgroundColor: "rgba(0, 34, 255, 0.3)",
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
        },
    });
})(jQuery);
