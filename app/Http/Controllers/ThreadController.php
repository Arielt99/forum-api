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
        $thread = Thread::all();

        return fractal($thread, new ThreadTransformer())
        ->includeChannel()
        ->respond(200);
    }

    /**
     * Display one of the task of the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function show($id)
    {
        $thread = Thread::findOrFail($id);

        return fractal($thread, new ThreadTransformer())
        ->includeChannel()
        ->respond(200);
    }

    /**
     * create a thread.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'unique:threads','max:255'],
            'body' => ['required', 'string', 'max:255'],
            'channel_id' => ['required', 'int', 'max:255'],

        ]);

        $thread = $request->user()->threads()->create([
            "title" => $request->title,
            "body" => $request->body,
            "channel_id" => $request->channel_id
            ]);

        $response = [
            'message' => "Task created successfully."
        ];

        return fractal($thread, new ThreadTransformer())
        ->includeChannel()
        ->respond(201);
    }

    /**
     * delete a thread.
     *
     * @param Request $request, $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $thread = Thread::findOrFail($id);

        if($request->user()->id != $thread->user_id){
            return response(['errors' => "not your threads"], 403);
        }

        $thread->delete();

        return fractal($thread, new ThreadTransformer())
        ->includeChannel()
        ->respond(200);
    }

    
}
