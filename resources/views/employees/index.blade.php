<!DOCTYPE html>
<html>
<head>
    <title>Employees</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Employees</h1>
        <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add Employee</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="employee-table">
                <!-- Employees will be loaded here via JavaScript -->
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchEmployees();

            function fetchEmployees() {
                $.ajax({
                    url: '/api/employees',
                    method: 'GET',
                    headers: {
                        'x-api-key': "{{ env('X_API_KEY') }}"
                    },
                    success: function(data) {
                        let rows = '';
                        data.forEach(employee => {
                            rows += `
                                <tr>
                                    <td>${employee.id}</td>
                                    <td>${employee.name}</td>
                                    <td>${employee.email}</td>
                                    <td>
                                        <a href="/employees/${employee.id}/edit" class="btn btn-warning">Edit</a>
                                        <button class="btn btn-danger delete-btn" data-id="${employee.id}">Delete</button>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#employee-table').html(rows);
                    },
                    error:function()
                    {
                        alert("Something went wrong, Please try again");
                    }
                });
            }

            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');
                if (confirm('Are you sure you want to delete this employee?')) {
                    $.ajax({
                        url: `/api/employees/${id}`,
                        method: 'DELETE',
                        success: function() {
                            fetchEmployees();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
