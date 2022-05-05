<?php

namespace App\Http\Controllers\Admin\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Return info about all rows in JSON
     * 
     * @return object $result is array of JSON for each row
     */
    public function getAllComment(Comment $comment) : object {
        $result = $comment->getAllCommentInfo();     
        return response()->json([
            "data" => $result
         ], 200);
    }

    /**
     * Return info about 1 row in JSON, by id
     * 
     * @return object $result is array with JSON for 1 row
     */
    public function getComment(int $id, Comment $comment) : object {
        if (Comment::where('id', $id)->exists()) {
            $result = $comment->getOneCommentInfo($id);
            return response()->json([
                "data" => $result
             ], 200);
        } else {
            return response()->json([
                "message" => "Record not found"
            ], 404);
        }
    }

    /**
     * Create new row
     * 
     * @return object response with JSON (success message)
     */
    public function createComment(CommentRequest $request) : object {
        Comment::create($request->input("commentInfo"));
        return response()->json([
            "message" => "Record created"
        ], 201);
    }

    /**
     * Update row by id
     * 
     * @return object response with JSON (success message)
     */
    public function updateComment(CommentRequest $request, int $id) : object {
        if (Comment::where('id', $id)->exists()) {
            $data = $request->input("commentInfo");
            Comment::where('id', $id)->update($data);
            return response()->json([
                "message" => "Record updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Record not found"
            ], 404);
        }
    }

    /**
     * Delete row by id
     * 
     * @return object response with JSON (success message)
     */
    public function deleteComment(int $id) : object {
        if (Comment::where('id', $id)->exists()) {
            Comment::where('id', $id)->delete();
            return response()->json([
                "message" => "Record deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Record not found"
            ], 404);
        }
    }
}
