<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Nationality;
use App\Models\Position;
use App\Models\Religion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(){
        $employees = Employee::join('departments','departments.id','=','department_id')
        ->orderBy('employees.id', 'ASC') 
        ->select(
            'employees.id as id',
            'employees.name as employee_name',
            'departments.name as department_name',
            
        )->get();
//   dd($employees);
       return response()->json($employees);
    }

    public function show($id)
{
    $employee = Employee::with(['department', 'religion', 'position', 'nationality'])
    ->select(
        'employees.id as id',
        'employees.name as employee_name',
        'employees.signature as employee_signature',
        'department_id',       
        'religion_id',       
        'position_id',      
        'nationality_id'     
    )
    ->find($id);

    // dd($employee);
    if (!$employee) {
        return response()->json(['message' => 'Employee not found'], 404);
    }

    return response()->json($employee);
}

public function create()
{
    $departments = Department::all();
    $nationalities = Nationality::all();
    $religions = Religion::all();
    $positions = Position::all();
  


    return response()->json([
        'departments' => $departments,
        'nationalities' => $nationalities,
        'religions' => $religions,
        'positions' => $positions,
    ]);
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'department_id' => 'required|exists:departments,id',
        'nationality_id' => 'required|exists:nationalities,id',
        'religion_id' => 'required|exists:religions,id',
        'position_id' => 'required|exists:positions,id',
        'signature' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // التحقق من أن الصورة مرفوعة بشكل صحيح
    ]);

    if ($request->hasFile('signature')) {
        $file = $request->file('signature');
        $fileName = time().'_'.$file->getClientOriginalName();
        $filePath = $file->storeAs('signatures', $fileName, 'public');
    }

    $employee = Employee::create([
        'name' => $request->name,
        'department_id' => $request->department_id,
        'nationality_id' => $request->nationality_id,
        'religion_id' => $request->religion_id,
        'position_id' => $request->position_id,
        'signature' => $filePath,
    ]);

    return response()->json($employee, 201);
}

public function edit($id)
{
    $employee = Employee::with(['department', 'religion', 'position', 'nationality'])
    ->select(
        'employees.id as id',
        'employees.name as employee_name',
        'employees.signature as employee_signature',
        'department_id as department_name',       
        'religion_id as religion_name',       
        'position_id as position_name',      
        'nationality_id as nationality_name'     
    )
    ->find($id);

    if (!$employee) {
        return response()->json(['message' => 'Employee not found'], 404);
    }

    $departments = Department::all();
    $nationalities = Nationality::all();
    $religions = Religion::all();
    $positions = Position::all();

    return response()->json([
        'employee' => $employee,
        'departments' => $departments,
        'nationalities' => $nationalities,
        'religions' => $religions,
        'positions' => $positions
    ]);
}

public function update(Request $request, $id)
{
    $employee = Employee::find($id);
    
    if (!$employee) {
        return response()->json(['message' => 'Employee not found'], 404);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'department_id' => 'required|exists:departments,id',
        'nationality_id' => 'required|exists:nationalities,id',
        'religion_id' => 'required|exists:religions,id',
        'position_id' => 'required|exists:positions,id',
        'signature' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // التحقق من أن الصورة مرفوعة بشكل صحيح
    ]);

    if ($request->hasFile('signature')) {
        $file = $request->file('signature');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('signatures', $fileName, 'public'); // Save to the public disk

        $employee->signature = $filePath;
    }

    $employee->update($request->except('signature'));

    return response()->json($employee);
}
    public function destroy($id)
    {
    $employee = Employee::find($id);


    $employee->delete();

    return response()->json(['message' => 'Employee deleted successfully']);
}

    
}
