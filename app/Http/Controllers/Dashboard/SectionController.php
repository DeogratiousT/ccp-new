<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\SectionsDataTable;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.sections.index', [
            'sections' => Section::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'rabbitmq_exchange' => ['required', 'string']
        ]);

        try {
            Section::create($validated);

            return to_route('dashboard.sections.index')->with('success', 'Section Added Succesfully');
        } catch (\Throwable $th) {
            logger('Section Add Failed: ' . $th->getMessage());

            return to_route('dashboard.sections.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        return view('dashboard.sections.show', ['section' => $section]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        return view('dashboard.sections.edit', [
            'section' => $section
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'rabbitmq_exchange' => ['required', 'string']
        ]);

        try {
            $section->update($validated);

            return to_route('dashboard.sections.index')->with('success', 'Section Updated Succesfully');
        } catch (\Throwable $th) {
            logger('Section Update Failed: ' . $th->getMessage());

            return to_route('dashboard.sections.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        try {
            $section->delete();

            return to_route('dashboard.sections.index')->with('success', 'Section Deleted Succesfully');
        } catch (\Throwable $th) {
            logger('Section Delete Failed: ' . $th->getMessage());

            return to_route('dashboard.sections.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }
}
