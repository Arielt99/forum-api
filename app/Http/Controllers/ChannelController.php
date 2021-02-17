<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Transformers\ChannelTransformer;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * Display a list of all the channels.
     *
     * @return Response
     */
    public function index()
    {
        $channel = Channel::all();

        return fractal($channel, new ChannelTransformer())
        ->respond(200);
    }
}
