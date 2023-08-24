<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Show Employee collections/listings
    public function index()
    {
        $employees = Employee::with('user')->get();

        // response
        return response()->json([
            'meta' => [
                'total' => $employees->count()
            ],
            'data' => EmployeeResource::collection($employees)
        ], 200);
    }

    // create employee resource
    public function store(StoreEmployeeRequest $request)
    {
        $employee = $request->user()->employees()->create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        // eager load
        $employee->load('user');

        // created response
        return response()->json([
            'meta' => [
                'id' => $employee->id,
            ],
            'data' => new EmployeeResource($employee),
        ], 201);
    }

    // update employee resource
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        // update
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        $employee = Employee::with('user')->find($employee->id);

        // update response
        return response()->json([
            'meta' => [
                'id' => $employee->id
            ],
            'data' => new EmployeeResource($employee)
        ], 200);
    }

    // delete employee resource
    public function destroy(Employee $employee)
    {
        // delete
        $employee->delete();

        // response
        return response()->json([], 204);
    }
}
