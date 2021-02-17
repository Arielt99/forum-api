<?php

namespace App\Transformers;

use App\Models\Reply;
use League\Fractal\TransformerAbstract;

class ReplyTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'thread'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Reply $reply)
    {
        return [
            'id' => (int) $reply->id,
            'created_at' => (string) $reply->created_at,
            'updated_at' => (string) $reply->updated_at,
            'body' => (string) $reply->body,
        ];
    }

    /**
     * Reply $reply
     *
     * @param Thread $thread
     * @return \League\Fractal\Resource\Item
     */
    public function includeThread(Reply $reply)
    {
        $thread = $reply->thread;

        return $this->item($thread, new ThreadTransformer());
    }
}
