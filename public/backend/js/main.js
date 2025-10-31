(function ($) {
    "use strict";

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
