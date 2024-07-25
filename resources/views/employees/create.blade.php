<!DOCTYPE html>
<html>
<head>
    <title>Create Employee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Create Employee</h1>
        <form id="create-employee-form">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="street">Street</label>
                <input type="text" class="form-control" id="street" name="street" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" class="form-control" id="state" name="state" required>
            </div>
            <div class="form-group">
                <label for="zip_code">Zip Code</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code" required>
            </div>
            <div class="form-group">
                <label for="expected_ctc">Expected CTC</label>
                <input type="number" class="form-control" id="expected_ctc" name="expected_ctc" required>
            </div>
            <div class="form-group">
                <label>Experiences</label>
                <div id="experiences">
                    <div class="experience">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" name="experiences[0][company_name]" required>
                        </div>
                        <div class="form-group">
                            <label for="job_title">Job Title</label>
                            <input type="text" class="form-control" name="experiences[0][job_title]" required>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration (months)</label>
                            <input type="number" class="form-control" name="experiences[0][duration]" required>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-experience" class="btn btn-secondary">Add Experience</button>
            </div>
            <div class="form-group">
                <label>Educations</label>
                <div id="educations">
                    <div class="education">
                        <div class="form-group">
                            <label for="degree">Degree</label>
                            <input type="text" class="form-control" name="educations[0][degree]" required>
                        </div>
                        <div class="form-group">
                            <label for="institution">Institution</label>
                            <input type="text" class="form-control" name="educations[0][institution]" required>
                        </div>
                        <div class="form-group">
                            <label for="year_of_passing">Year of Passing</label>
                            <input type="number" class="form-control" name="educations[0][year_of_passing]" required>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-education" class="btn btn-secondary">Add Education</button>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function() {
            let experienceCount = 1;
            let educationCount = 1;

            $('#add-experience').click(function() {
                let experienceHtml = `
                    <div class="experience">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" name="experiences[${experienceCount}][company_name]" required>
                        </div>
                        <div class="form-group">
                            <label for="job_title">Job Title</label>
                            <input type="text" class="form-control" name="experiences[${experienceCount}][job_title]" required>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration (months)</label>
                            <input type="number" class="form-control" name="experiences[${experienceCount}][duration]" required>
                        </div>
                    </div>
                `;
                $('#experiences').append(experienceHtml);
                experienceCount++;
            });

            $('#add-education').click(function() {
                let educationHtml = `
                    <div class="education">
                        <div class="form-group">
                            <label for="degree">Degree</label>
                            <input type="text" class="form-control" name="educations[${educationCount}][degree]" required>
                        </div>
                        <div class="form-group">
                            <label for="institution">Institution</label>
                            <input type="text" class="form-control" name="educations[${educationCount}][institution]" required>
                        </div>
                        <div class="form-group">
                            <label for="year_of_passing">Year of Passing</label>
                            <input type="number" class="form-control" name="educations[${educationCount}][year_of_passing]" required>
                        </div>
                    </div>
                `;
                $('#educations').append(educationHtml);
                educationCount++;
            });

            $('#create-employee-form').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/api/employees',
                    method: 'POST',
                    headers: {
                        'x-api-key': "{{ env('X_API_KEY') }}"
                    },
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Employee created successfully.');
                        window.location.href = '/employees';
                    },
                    error: function(response) {
                        alert('Error creating employee.');
                    }
                });
            });
        });
    </script>
</body>
</html>
