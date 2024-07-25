<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Experience;
use App\Models\Education;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['experiences', 'educations'])->get();
        return response()->json($employees);
    }

    public function show(Employee $employee)
    {
        $employee->load(['experiences', 'educations']);
        return response()->json($employee);
    }

    public function store(Request $request)
    {
        // Validate the input fields
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'contact_number' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:employees',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'expected_ctc' => 'required|numeric',
            'experiences.*.company_name' => 'required|string|max:255',
            'experiences.*.job_title' => 'required|string|max:255',
            'experiences.*.duration' => 'required|integer',
            'educations.*.degree' => 'required|string|max:255',
            'educations.*.institution' => 'required|string|max:255',
            'educations.*.year_of_passing' => 'required|integer|min:1900|max:'.date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Create the employee
        $employee = Employee::create([
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'street' => $request->street,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'expected_ctc' => $request->expected_ctc,
            'status' => 'Pending',
        ]);

        // Create experiences
        foreach ($request->experiences as $experienceData) {
            Experience::create([
                'employee_id' => $employee->id,
                'company_name' => $experienceData['company_name'],
                'job_title' => $experienceData['job_title'],
                'duration' => $experienceData['duration'],
            ]);
        }

        // Create educations
        foreach ($request->educations as $educationData) {
            Education::create([
                'employee_id' => $employee->id,
                'degree' => $educationData['degree'],
                'institution' => $educationData['institution'],
                'year_of_passing' => $educationData['year_of_passing'],
            ]);
        }

        return response()->json(['success' => 'Employee registered successfully.', 'employee' => $employee], 201);
    }

    public function update(Request $request, Employee $employee)
    {
        // Validate the input fields
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'contact_number' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:employees,email,'.$employee->id,
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'expected_ctc' => 'required|numeric',
            'experiences.*.company_name' => 'required|string|max:255',
            'experiences.*.job_title' => 'required|string|max:255',
            'experiences.*.duration' => 'required|integer',
            'educations.*.degree' => 'required|string|max:255',
            'educations.*.institution' => 'required|string|max:255',
            'educations.*.year_of_passing' => 'required|integer|min:1900|max:'.date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Update the employee
        $employee->update([
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'street' => $request->street,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'expected_ctc' => $request->expected_ctc,
        ]);

        // Update experiences
        $employee->experiences()->delete();
        foreach ($request->experiences as $experienceData) {
            Experience::create([
                'employee_id' => $employee->id,
                'company_name' => $experienceData['company_name'],
                'job_title' => $experienceData['job_title'],
                'duration' => $experienceData['duration'],
            ]);
        }

        // Update educations
        $employee->educations()->delete();
        foreach ($request->educations as $educationData) {
            Education::create([
                'employee_id' => $employee->id,
                'degree' => $educationData['degree'],
                'institution' => $educationData['institution'],
                'year_of_passing' => $educationData['year_of_passing'],
            ]);
        }

        return response()->json(['success' => 'Employee updated successfully.', 'employee' => $employee], 200);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(['success' => 'Employee deleted successfully.'], 200);
    }

    public function updateStatus(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Approved,Rejected',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $employee->status = $request->status;
        $employee->save();

        return response()->json(['success' => 'Employee status updated successfully.'], 200);
    }


    public function viewIndex()
    {
        return view('employees.index');
    }

    public function viewCreate()
    {
        return view('employees.create');
    }

    public function viewEdit($id)
    {
        return view('employees.edit', compact('id'));
    }

}
