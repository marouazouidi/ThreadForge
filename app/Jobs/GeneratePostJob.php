<?php

namespace App\Jobs;

use App\Actions\GeneratePostAction;
use App\Enums\PostStatus;
use App\Enums\RawContentStatus;
use App\Models\Post;
use App\Models\RawContent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GeneratePostJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public RawContent $rawContent)
    {}

    /**
     * Execute the job.
     */
    public function handle(GeneratePostAction $action): void
    {
        try {
            $rawContent = $this->rawContent;
            $blueprint = $rawContent->blueprint;

            Log::info('GeneratePostJob started', [
                'raw_content_id' => $this->rawContent->id,
                'blueprint_id' => $blueprint->id,
            ]);

            $result = $action->execute($rawContent, $blueprint);

            Post::create([
                'raw_content_id' => $rawContent->id,
                'hook_propose' => $result['hook_propose'] ?? '',
                'body_points' => $result['body_points'] ?? [],
                'technical_readability_score' => $result['technicalreadabilityscore'] ?? 0,
                'suggested_hashtag' => isset($result['suggested_hashtags'])
                    ? json_encode($result['suggested_hashtags'])
                    : '[]',
                'tone_compliance_justification' => $result['tonecompliancejustification'] ?? '',
                'payload_brut' => $result,
                'status' => PostStatus::Draft,
            ]);

            $rawContent->update([
                'status' => RawContentStatus::Processed,
            ]);

            Log::info('GeneratePostJob completed', [
                'raw_content_id' => $this->rawContent->id,
            ]);
        } catch (\Exception $e) {
            $this->rawContent->update([
                'status' => RawContentStatus::Failed,
            ]);

            Log::error('GeneratePostJob failed', [
                'raw_content_id' => $this->rawContent->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
