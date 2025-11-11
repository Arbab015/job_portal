<!-- Apply Model -->
<div class="modal fade" id="job_apply_modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="{{ route('job.apply')}}" enctype="multipart/form-data" class="needs-validation" novalidate id="job_apply_form">
                @csrf
                <input type="hidden" name="job_id" id="job_id">

                <div class="modal-header">
                    <h5 class="modal-title " id="myModalLabel">Job Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group  col-6 py-2">
                            <label for="name" class="col fw-bolder required">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" required placeholder="Enter your name">
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>
                        </div>
                        <div class="form-group col-6 py-2">
                            <label for="email" class="col fw-bolder required">Email </label>
                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" required placeholder="Enter your email">
                                <div class="invalid-feedback">Please enter your email. </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-6 py-2">
                            <label for="mobile_no" class="col fw-bolder required">Mobile Number</label>
                            <div class="col-sm-10">
                                <input type="text" name="mobile_no" class="form-control" required placeholder="Enter your Mobile number">
                                <div class="invalid-feedback">Please enter your Mobile number.</div>
                            </div>
                        </div>
                        <div class="form-group  col-6 py-2">
                            <label for="experience" class="col fw-bolder required">Total Experience</label>
                            <div class="col-sm-10">
                                <input type="text" name="experience" class="form-control" required placeholder="Experience">
                                <div class="invalid-feedback">Please enter your experience.</div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group  col-6 py-2">
                            <label for="skills" class="col fw-bolder required ">Skills</label>
                            <div class="col-sm-10">
                                <input type="text" id="skill_input" class="form-control" placeholder="Add your skill and press enter">
                                <div class="invalid-feedback">Please add at least one skill.</div>
                                <div class="badges-container" id="badges_container">
                                </div>
                                <input type="hidden" name="skills" id="skills_hidden">

                            </div>
                        </div>

                        <div class="form-group  col-6 py-2">
                            <label for="file" class="col fw-bolder required">Resume</label>
                            <div class="col-sm-10">
                                <input type="file" name="file" class="form-control" required>
                                <div class="invalid-feedback">Please add your CV file.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group py-2">
                        <label for="notes" class="col fw-bolder ">Note: (optional)</label>
                        <div class="col-sm-11">
                            <textarea id="note" class="form-control" name="notes" rows="2" cols="40" placeholder="Write something more about yourself."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>
