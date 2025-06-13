<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Condition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\ConditionsDataTable;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ConditionsDataTable $dataTable)
    {
        return view('dashboard.conditions.index', [
            'conditions' => Condition::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.conditions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'si_unit' => ['nullable', 'string']
        ]);

        try {
            Condition::create($validated);

            return to_route('dashboard.conditions.index')->with('success', 'Condition Added Succesfully');
        } catch (\Throwable $th) {
            logger('Condition Add Failed: ' . $th->getMessage());

            return to_route('dashboard.conditions.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Condition $condition)
    {
        return view('dashboard.conditions.show', ['condition' => $condition]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Condition $condition)
    {
        return view('dashboard.conditions.edit', ['condition' => $condition]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Condition $condition)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'si_unit' => ['nullable', 'string']
        ]);

        try {
            $condition->update($validated);

            return to_route('dashboard.conditions.index')->with('success', 'Condition Updated Succesfully');
        } catch (\Throwable $th) {
            logger('Condition Update Failed: ' . $th->getMessage());

            return to_route('dashboard.conditions.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Condition $condition)
    {
        try {
            $condition->delete();

            return to_route('dashboard.conditions.index')->with('success', 'Condition Deleted Succesfully');
        } catch (\Throwable $th) {
            logger('Condition Delete Failed: ' . $th->getMessage());

            return to_route('dashboard.conditions.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }
}
