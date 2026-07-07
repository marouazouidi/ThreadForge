<?php

namespace App\Http\Controllers;

use App\Enums\RawContentStatus;
use App\Http\Requests\StoreRawContentRequest;
use App\Http\Resources\RawContentResource;
use App\Jobs\GeneratePostJob;
use App\Models\RawContent;
use Illuminate\Http\Request;

class RawContentController extends Controller
{
    public function index(Request $request){

        // $rawContents = RawContent::where(
        //     'user_id', $request->user()->id)
        //     ->get();

        $rawContents = $request->user()
            ->rawContents()
            ->get();

        return response()->json([
            RawContentResource::collection($rawContents),
            'message' => 'Raw contents retrieved successfully'
            ], 200
            );
    }

    public function store(StoreRawContentRequest $request){

        $rawContent = RawContent::create([
                ...$request->validated(),
                'user_id' => $request->user()->id,
                'status' => RawContentStatus::Pending,
            ]);

        GeneratePostJob::dispatch($rawContent);

        return response()->json([
            new RawContentResource($rawContent),
            'message' => 'Raw content submitted successfully. Generation started.',
            ], 202);
    }

    public function show(RawContent $rawContent){
        
        return response()->json([
            new RawContentResource($rawContent),
            'message' => 'Raw content retrieved successfully'
            ], 200
            );
    }
}
