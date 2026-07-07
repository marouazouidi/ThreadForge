<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlueprintRequest;
use App\Http\Resources\BlueprintResource;
use App\Models\Blueprint;
use Illuminate\Http\Request;

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

        return BlueprintResource::collection($blueprint);
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

        return response()->json(new BlueprintResource($blueprint), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blueprint $blueprint)
    {
        return new BlueprintResource($blueprint);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBlueprintRequest $request, Blueprint $blueprint)
    {

        $blueprint->update(
            $request->validated()
        );

        return new BlueprintResource($blueprint);
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
