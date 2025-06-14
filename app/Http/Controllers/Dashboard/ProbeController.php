<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Probe;
use Illuminate\Http\Request;
use App\DataTables\ProbesDataTable;
use App\Http\Controllers\Controller;
use App\Actions\Generate\UniqueStringGenerator;
use App\Models\Condition;
use App\Models\Section;

class ProbeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Section $section)
    {
        return view('dashboard.probes.index', [
            'section' => $section,
            'probes' => Probe::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Section $section)
    {
        return view('dashboard.probes.create', [
            'section' => $section,
            'conditions' => Condition::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Section $section)
    {
        $validated = $request->validate([
            'uuid' => ['required', 'string'],
            'section_id' => ['required', 'integer'],
            'condition_id' => ['required', 'integer'],
            'max_threshold' => ['required', 'string'],
            'min_threshold' => ['required', 'string'],
            'description' => ['nullable', 'string']
        ]);

        try {
            Probe::create($validated);

            return redirect()->route('dashboard.sections.probes.index', $section)->with('success', 'Probe Added Successfully');
        } catch (\Throwable $th) {
            logger('Probe Add Failed: ' . $th->getMessage());

            return redirect()->route('dashboard.sections.probes.index', $section)->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Section $section, Probe $probe)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section, Probe $probe)
    {
        return view('dashboard.probes.edit', [
            'section' => $section,
            'probe' => $probe,
            'conditions' => Condition::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section, Probe $probe)
    {
        $validated = $request->validate([
            'uuid' => ['required', 'string'],
            'section_id' => ['required', 'integer'],
            'condition_id' => ['required', 'integer'],
            'max_threshold' => ['required', 'string'],
            'min_threshold' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);

        try {
            $probe->update($validated);

            return redirect()->route('dashboard.sections.probes.index', $section)->with('success', 'Probe Updated Successfully');
        } catch (\Throwable $th) {
            logger('Probe Update Failed: ' . $th->getMessage());

            return redirect()->route('dashboard.sections.probes.index', $section)->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section, Probe $probe)
    {
        try {
            $probe->delete();

            return redirect()->route('dashboard.sections.probes.index', $section)->with('success', 'Probe Deleted Succesfully');
        } catch (\Throwable $th) {
            logger('Probe Delete Failed: ' . $th->getMessage());

            return redirect()->route('dashboard.sections.probes.index', $section)->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }
}
