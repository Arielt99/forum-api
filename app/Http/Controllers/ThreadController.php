<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Transformers\ThreadTransformer;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    /**
     * Display a list of all the threads.
     *
     * @return Response
     */
    public function index()
    {
        $channel = Thread::all();

        return fractal($channel, new ThreadTransformer())
        ->respond(200);
    }
}
