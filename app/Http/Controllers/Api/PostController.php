<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class PostController extends Controller
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

        return Post::with('comments')
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
     * @param PostRequest $request
     * @return mixed
     * @throws Throwable
     */
    public function store(PostRequest $request)
    {

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'status' => 1,
            'msg' => 'Post Created Successfully.'
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

        $post = Post::with('comments')
            ->find($id);

        if(empty($post))
        {
            return response()->json([
                'status' => 0,
                'msg' => 'Post not found.'
            ]);
        }

        return response()->json([
            'status' => 1,
            'data' => $post
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
     * @param PostRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PostRequest $request, int $id): JsonResponse
    {
        $post = Post::find($id);

        if(empty($post))
        {
            return response()->json([
                'status' => 0,
                'msg' => 'Post not found.'
            ]);
        }

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => 1,
            'msg' => 'Post Updated Successfully.'
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
        $post = Post::find($id);

        if(empty($post))
        {
            return response()->json([
                'status' => 0,
                'msg' => 'Post not found.'
            ]);
        }

        $post->delete();

        return response()->json([
            'status' => 1,
            'msg' => 'Post Deleted Successfully.'
        ]);
    }
}
