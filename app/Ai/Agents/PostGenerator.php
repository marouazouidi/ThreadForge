<?php

namespace App\Ai\Agents;

use App\Ai\Tools\GetCampaignRules;
use App\Ai\Tools\GetPostHistory;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

#[Provider('groq')]
class PostGenerator implements Agent, Conversational, HasStructuredOutput, HasTools
{
    use Promptable;

    /**
     * The in-memory conversation messages.
     *
     * @var Message[]
     */
    private array $messageList = [];

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are an expert LinkedIn Ghostwriter. Return ONLY structured data.';
    }

    /**
     * Add a message to the in-memory conversation history.
     */
    public function addMessage(Message $message): void
    {
        $this->messageList[] = $message;
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return $this->messageList;
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new GetCampaignRules,
            new GetPostHistory,
        ];
    }

    /**
     * Get the agent's structured output schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'schema_version' => $schema
                ->integer()
                ->min(1)
                ->required(),
            'hook_propose' => $schema
                ->string()
                ->required(),

            'body_points' => $schema
                ->array()
                ->items($schema->string())
                ->required(),

            'technicalreadabilityscore' => $schema
                ->integer()
                ->min(0)
                ->max(100)
                ->required(),

            'suggested_hashtags' => $schema
                ->array()
                ->items($schema->string())
                ->required(),

            'tonecompliancejustification' => $schema
                ->string()
                ->required(),
            ];
    }
}
