<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Reading;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\ReadingsDataTable;
use App\Actions\Generate\UniqueStringGenerator;

class ReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ReadingsDataTable $dataTable)
    {
        return $dataTable->render('dashboard.readings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.readings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'probe_id' => ['required', 'integer'],
            'value' => ['required', 'string'],
            'time_stamp' => ['required', 'string']
        ]);

        try {
            Reading::create($validated);

            return to_route('dashboard.readings.index')->with('success', 'Reading Added Successfully');
        } catch (\Throwable $th) {
            logger('Reading Add Failed: ' . $th->getMessage());

            return to_route('dashboard.readings.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Reading $reading)
    {
        return view('dashboard.readings.show', ['reading' => $reading]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reading $reading)
    {
        return view('dashboard.readings.edit', ['reading' => $reading]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reading $reading)
    {
        $validated = $request->validate([
            'probe_id' => ['required', 'integer'],
            'value' => ['required', 'string'],
            'time_stamp' => ['required', 'string']
        ]);

        try {
            $reading->update($validated);

            return to_route('dashboard.readings.index')->with('success', 'Reading Updated Successfully');
        } catch (\Throwable $th) {
            logger('Reading Update Failed: ' . $th->getMessage());

            return to_route('dashboard.readings.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reading $reading)
    {
        try {
            $reading->delete();

            return to_route('dashboard.readings.index')->with('success', 'Reading Deleted Succesfully');
        } catch (\Throwable $th) {
            logger('Reading Delete Failed: ' . $th->getMessage());

            return to_route('dashboard.readings.index')->with('error', 'Something Went Wrong, Please Try Again Later');
        }
    }
}
