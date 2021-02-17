<?php

namespace App\Transformers;

use App\Models\Thread;
use League\Fractal\TransformerAbstract;

class ThreadTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user', 'channel'
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
    public function transform(Thread $thread)
    {
        return [
            'id' => (int) $thread->id,
            'title' => (string) $thread->title,
            'slug' => (string) $thread->slug,
            'body' => (string) $thread->body,
        ];
    }

    /**
     * Include user
     *
     * @param Thread $thread
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Thread $thread)
    {
        $user = $thread->user;

        return $this->item($user, new UserTransformer());
    }

    /**
     * Include channel
     *
     * @param Thread $thread
     * @return \League\Fractal\Resource\Item
     */
    public function includeChannel(Thread $thread)
    {
        $channel = $thread->channel;

        return $this->item($channel, new ChannelTransformer());
    }
}
