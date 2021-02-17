<?php

namespace App\Transformers;

use App\Models\Channel;
use League\Fractal\TransformerAbstract;

class ChannelTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
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
    public function transform(Channel $channel)
    {

        return [
            'id' => (int) $channel->id,
            'title' => (string) $channel->title,
            'slug' => (string) $channel->slug,
            'description' => (string) $channel->description,
        ];
    }
}
