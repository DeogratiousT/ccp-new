<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Probe;
use Illuminate\Http\Request;
use App\DataTables\ProbesDataTable;
use App\Http\Controllers\Controller;
use App\Actions\Generate\UniqueStringGenerator;

class ProbeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProbesDataTable $dataTable)
    {
        return $dataTable->render('dashboard.probes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.probes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_id' => ['required', 'integer'],
            'max_threshold' => ['required', 'string'],
            'min_threshold' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);

        // Generate UUID
        $generator = new UniqueStringGenerator();
        $validated['uuid'] = 'CCP/' . $generator->generate(4, false);

        try {
            Probe::create($validated);

            return to_route('dashboard.probes.index')->with('success', 'Probe Added Successfully');
        } catch (\Throwable $th) {
            logger('Probe Add Failed: ' . $th->getMessage());

            return to_route('dashboard.probes.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Probe $probe)
    {
        return view('dashboard.probes.show', ['probe' => $probe]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Probe $probe)
    {
        return view('dashboard.probes.edit', ['probe' => $probe]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Probe $probe)
    {
        $validated = $request->validate([
            'section_id' => ['required', 'integer'],
            'max_threshold' => ['required', 'string'],
            'min_threshold' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);

        try {
            $probe->update($validated);

            return to_route('dashboard.probes.index')->with('success', 'Probe Updated Successfully');
        } catch (\Throwable $th) {
            logger('Probe Update Failed: ' . $th->getMessage());

            return to_route('dashboard.probes.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Probe $probe)
    {
        try {
            $probe->delete();

            return to_route('dashboard.probes.index')->with('success', 'Probe Deleted Succesfully');
        } catch (\Throwable $th) {
            logger('Probe Delete Failed: ' . $th->getMessage());

            return to_route('dashboard.probes.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }
}
