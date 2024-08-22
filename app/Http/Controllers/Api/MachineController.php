<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MachineRequest;
use App\Http\Resources\MachineResource;
use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $machines = MachineResource::collection(Machine::all());
        return ApiResponse::success($machines);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MachineRequest $request)
    {
        $machine = Machine::create($request->validated());
        return ApiResponse::success($machine);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $machine = new MachineResource(Machine::find($id));
        return ApiResponse::success($machine);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MachineRequest $request, string $id)
    {
        $machine = Machine::find($id);
        $machine->update($request->validated());
        return ApiResponse::success($machine);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $machine = Machine::find($id);
        $machine->delete();
        return ApiResponse::success($machine);
    }
}
