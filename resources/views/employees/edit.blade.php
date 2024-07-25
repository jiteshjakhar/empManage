<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Employee</h1>
        <form id="edit-employee-form">
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
                    <!-- Experience fields will be populated here via JavaScript -->
                </div>
                <button type="button" id="add-experience" class="btn btn-secondary">Add Experience</button>
            </div>
            <div class="form-group">
                <label>Educations</label>
                <div id="educations">
                    <!-- Education fields will be populated here via JavaScript -->
                </div>
                <button type="button" id="add-education" class="btn btn-secondary">Add Education</button>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function() {
            let experienceCount = 0;
            let educationCount = 0;
            const employeeId = '{{ $id }}';

            function fetchEmployee() {
                $.ajax({
                    url: `/api/employees/${employeeId}`,
                    method: 'GET',
                    headers: {
                        'x-api-key': "{{ env('X_API_KEY') }}"
                    },
                    success: function(data) {
                        $('#name').val(data.name);
                        $('#date_of_birth').val(data.date_of_birth);
                        $('#contact_number').val(data.contact_number);
                        $('#email').val(data.email);
                        $('#street').val(data.street);
                        $('#city').val(data.city);
                        $('#state').val(data.state);
                        $('#zip_code').val(data.zip_code);
                        $('#expected_ctc').val(data.expected_ctc);

                        data.experiences.forEach((experience, index) => {
                            let experienceHtml = `
                                <div class="experience">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" class="form-control" name="experiences[${index}][company_name]" value="${experience.company_name}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_title">Job Title</label>
                                        <input type="text" class="form-control" name="experiences[${index}][job_title]" value="${experience.job_title}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="duration">Duration (months)</label>
                                        <input type="number" class="form-control" name="experiences[${index}][duration]" value="${experience.duration}" required>
                                    </div>
                                </div>
                            `;
                            $('#experiences').append(experienceHtml);
                            experienceCount = index + 1;
                        });

                        data.educations.forEach((education, index) => {
                            let educationHtml = `
                                <div class="education">
                                    <div class="form-group">
                                        <label for="degree">Degree</label>
                                        <input type="text" class="form-control" name="educations[${index}][degree]" value="${education.degree}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="institution">Institution</label>
                                        <input type="text" class="form-control" name="educations[${index}][institution]" value="${education.institution}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="year_of_passing">Year of Passing</label>
                                        <input type="number" class="form-control" name="educations[${index}][year_of_passing]" value="${education.year_of_passing}" required>
                                    </div>
                                </div>
                            `;
                            $('#educations').append(educationHtml);
                            educationCount = index + 1;
                        });
                    },
                    error: function(response) {
                        alert('Error fetching employee data.');
                    }
                });
            }

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

            $('#edit-employee-form').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: `/api/employees/${employeeId}`,
                    method: 'PUT',
                    headers: {
                        'x-api-key': "{{ env('X_API_KEY') }}"
                    },
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Employee updated successfully.');
                        window.location.href = '/employees';
                    },
                    error: function(response) {
                        alert('Error updating employee.');
                    }
                });
            });

            fetchEmployee();
        });
    </script>
</body>
</html>
