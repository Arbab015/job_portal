// open apply model
function openApplyModel(job_id) {
    document.getElementById("job_id").value = job_id;
    const modal = new bootstrap.Modal(
        document.getElementById("job_apply_modal")
    );
    modal.show();
}

// add skill batch wise
const skill_input = document.getElementById("skill_input");
const badges_container = document.getElementById("badges_container");
const hidden_input = document.getElementById("skills_hidden");
let skills_array = [];

skill_input.addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        const skill_value = skill_input.value.trim();
        if (skill_value && !skills_array.includes(skill_value)) {
            addSkillBadge(skill_value);
            skills_array.push(skill_value);
            updateHiddenInput();
            skill_input.value = "";
        }
    }
});

function addSkillBadge(skill) {
    const badge = document.createElement("span");
    badge.classList.add("badge", "bg-primary", "mb-2");
    badge.style.display = "inline-flex";
    badge.style.alignItems = "center";
    badge.textContent = skill;

    // Add a close button
    const close_button = document.createElement("i");
    close_button.classList.add("fa-solid", "fa-close", "ms-2");
    close_button.style.cursor = "pointer";
    close_button.setAttribute("data-skill", skill);

    badge.appendChild(close_button);
    badges_container.appendChild(badge);
}
function updateHiddenInput() {
    hidden_input.value = JSON.stringify(skills_array);
}

badges_container.addEventListener("click", function (event) {
    if (event.target.classList.contains("fa-close")) {
        const skill = event.target.getAttribute("data-skill");
        const badge = event.target.parentElement;
        badges_container.removeChild(badge);
        skills_array = skills_array.filter((s) => s !== skill);
        updateHiddenInput();
    }
});

$("#load_more").hide();
function searchJobs(load_more = null) {
    var job_type = $("#job_type").val();
    var designation = $("#designation").val();
    var search_term = $("#search_term").val();
    $.ajax({
        url: "/jobs-all",
        method: "GET",
        dataType: "json",
        data: {
            jobtype_id: job_type,
            designation_id: designation,
            search_term: search_term,
            load_limit: load_more,
        },
        success: function (response) {
            var html = "";
            html += `<span  id="limit_element" data-limit=${response.limit}> </span>`;
            if (response.jobs.length > 0) {
                $.each(response.jobs, function (index, job) {
                    html += `
                            <div class="col-12 col-md-4 mb-4">
                                <div class="card h-100">
                                    <a href="job/detail/${job.slug}">
                                        <img src="${response.job_image}" class="card-img-top" alt="Job Image">
                                    </a>
                                    <div class="card-body">
                                        <h5 class="text-center mt-3 mb-3 text-success">${job.title}</h5>
                                        <hr>
                                        <p class="text-center mb-1 Poppins"><b>Type:</b> ${job.job_type.title}</p>
                                        <p class="text-center mb-1 Poppins"><b>Designation:</b> ${job.designation.name}</p>
                                        <p class="text-center mb-3 Poppins"><b>Due Date:</b> ${job.due_date}</p>
                                        <p class="text-center ">
                                            <a onclick="openApplyModel('${job.id}')" class="btn btn-success">Apply now</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        `;
                });
            } else {
                html = `
                        <div class="col-12 p-5">
                            <div class="text-center">
                                <i class="fa-solid fa-magnifying-glass mb-3" style="font-size: 80px"></i>
                                <p>No jobs found. Try different filters.</p>
                            </div>
                        </div>
                    `;
            }
            $("#job_listing").html(html);
            $("#before_search").hide();
            if (response.has_more) {
                $("#load_more").show();
                $("#button_text").show();
                $("#spinner").addClass("d-none");
            } else {
                $("#load_more").hide();
            }
        },
        error: function (xhr) {
            $("#before_search").show();
        },
    });
}
$("#job_type, #designation").on("change", function () {
    searchJobs();
});

$("#search_btn").on("click", function (e) {
    e.preventDefault();
    searchJobs();
});

$("#load_more_btn").on("click", function (e) {
    e.preventDefault();
    var spinner = document.getElementById("spinner");
    var button_text = document.getElementById("button_text");
    spinner.classList.remove("d-none");
    button_text.style.display = "none";
    var limit_element = document.getElementById('limit_element');
    var load_more = limit_element.getAttribute('data-limit');
    searchJobs(load_more);
});
