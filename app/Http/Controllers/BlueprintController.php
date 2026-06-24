<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlueprintRequest;
use App\Models\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlueprintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        $blueprint = $request->user()
            ->blueprints()
            ->get();

        return response()->json($blueprint);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlueprintRequest $request)
    {
        // $blueprint = Blueprint::create([
        //     ...$request->validated(),
        //     'user_id' => Auth::id(),
        // ]);

        $blueprint = $request->user()
                ->blueprints()
                ->create(
                    $request->validated()
                );

        return response()->json($blueprint, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blueprint $blueprint)
    {
        return response()->json($blueprint);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBlueprintRequest $request, Blueprint $blueprint)
    {

        $blueprint->update(
            $request->validated()
        );

        return response()->json($blueprint);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blueprint $blueprint)
    {
        $blueprint->delete();
        return response()->json([
            'message' => 'Blueprint deleted successfully'
        ]);
    }
}
