<?php

namespace App\Http\Controllers;

use App\Enums\RawContentStatus;
use App\Http\Requests\StoreRawContentRequest;
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
            $rawContents,
            'message' => 'Raw contents retrieved successfully'
            ], 200
            );
    }

    public function store(StoreRawContentRequest $request){

        $rawContent =$request->user()
            ->rawContents()
            ->create([
                ...$request->validated(),
                'status' => RawContentStatus::Pending,
            ]);

        return response()->json([
            $rawContent,
            'message' => 'Raw content created successfully'
            ], 201
            );
    }

    public function show(RawContent $rawContent){
        
        return response()->json([
            $rawContent,
            'message' => 'Raw content retrieved successfully'
            ], 200
            );
    }
}
