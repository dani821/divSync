<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        $perPage = $request->per_page ?? config('app.per_page');

        return Comment::with('post')
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentRequest $request
     * @return mixed
     * @throws Throwable
     */
    public function store(CommentRequest $request)
    {

        $post = Post::find($request->post_id);
        if(empty($post))
        {
            return response()->json([
                'status' => 1,
                'msg' => 'Post not found.'
            ]);
        }

        Comment::create([
            'text' => $request->text,
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'status' => 1,
            'msg' => 'Comment Created Successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show( int $id ): JsonResponse
    {
        $response = [];

        $comment = Comment::with('post')
            ->where([
                'id' => $id,
                'user_id' => Auth::id()
            ])->first();

        if(empty($comment))
        {
            return response()->json([
                'status' => 0,
                'msg' => 'Comment not found.'
            ]);
        }

        return response()->json([
            'status' => 1,
            'data' => $comment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return mixed
     */
    public function edit( int $id )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CommentRequest $request, int $id): JsonResponse
    {
        $comment = Comment::where([
            'id' => $id,
            'user_id' => Auth::id()
        ])->first();

        if(empty($comment))
        {
            return response()->json([
                'status' => 0,
                'msg' => 'Comment not found.'
            ]);
        }

        $comment->update([
            'text' => $request->text,
        ]);

        return response()->json([
            'status' => 1,
            'msg' => 'Comment Updated Successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy( int $id ): JsonResponse
    {
        $comment = Comment::where([
            'id' => $id,
            'user_id' => Auth::id()
        ])->first();

        if(empty($comment))
        {
            return response()->json([
                'status' => 0,
                'msg' => 'Comment not found.'
            ]);
        }

        $comment->delete();

        return response()->json([
            'status' => 1,
            'msg' => 'Comment Deleted Successfully.'
        ]);
    }
}
