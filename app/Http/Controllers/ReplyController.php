<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Transformers\ReplyTransformer;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Display one reply.
     *
     * @param  $ThreadId, $ReplyId
     * @return Response
     */
    public function show($ThreadId, $ReplyId)
    {
        $reply = Reply::findOrFail($ReplyId)->where('thread_id', $ThreadId)->first();

        return fractal($reply, new ReplyTransformer())
        ->respond(200);
    }

    /**
     * create a reply.
     *
     * @param  Request $request, $ThreadId
     * @return Response
     */
    public function store(Request $request, $ThreadId)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:255'],
        ]);

        $reply = $request->user()->replies()->create([
            "body" => $request->body,
            "thread_id" => $ThreadId,
        ]);

        return fractal($reply, new ReplyTransformer())
        ->respond(201);
    }

    /**
     * delete a reply.
     *
     * @param Request $request, $ThreadId, $ReplyId
     * @return Response
     */
    public function destroy(Request $request, $ThreadId, $ReplyId)
    {
        $reply = Reply::findOrFail($ReplyId)->where('thread_id', $ThreadId)->first();

        if($request->user()->id != $reply->user_id){
            return response(['errors' => "not your reply"], 403);
        }

        $reply->delete();

        return fractal($reply, new ReplyTransformer())
        ->respond(200);
    }

    /**
     * update a reply.
     *
     * @param Request $request, $ThreadId, $ReplyId
     * @return Response
     */
    public function update(Request $request, $ThreadId, $ReplyId)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:255'],
        ]);

        $reply = Reply::findOrFail($ReplyId)->where('thread_id', $ThreadId)->first();

        if($request->user()->id != $reply->user_id){
            return response(['errors' => "not your reply"], 403);
        }

        $reply->update([
            "body" => $request->body,
        ]);
        
        return fractal($reply, new ReplyTransformer())
        ->respond(200);
    }
}
