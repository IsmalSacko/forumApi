<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostsRequest;
use App\Models\Comment;
use App\Models\Feed; // Add missing import statement
use App\Models\Feedd;
use App\Models\Like;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(){
        $feeds = Feedd::with('user')->latest()->get();
        return response()->json([
            'Posts' => $feeds,
        ], 200);
    }
    public function store(PostsRequest $request){
        $request->validated();       
         // On utilise request->only pour récupérer les données de la requête
         
         $post = Feedd::create([
            'content'  => $request->get('content'),
            'user_id' => $request->user()->id,
        ]);        
        return response()->json([
            'message' => 'Post créé avec succès !',
            'post' => $post,
        ], 200);
        
    }
public function likePost($feedd_id)
{
    $feed = Feedd::where('id',$feedd_id)->first();
   
    if (!$feed) {
        return response()->json([
            'message' => '404 || Post non trouvé !',
        ], 500);
    }
    $unlike = Like::where('user_id',auth()->id())->where('feedd_id',$feedd_id)->delete();
    if($unlike){
        return response()->json([
            'message' => 'Post unliké avec succès !',
        ], 200);
    }
    $like = Like::create([
        'user_id' => auth()->id(),
        'feedd_id' => $feedd_id,
    ]);
    $like->save();
    return response()->json([
        'message' => 'Post liké avec succès !',
    ], 200);   

}

public function commentPost(Request $request, $feedd_id) 
{

    $request->validate([
        'content' => 'required|string',
    ]);

    $comment = Comment::create([
        'user_id' => $request->user()->id,
        'feedd_id' => $feedd_id,
        'content' => $request->get('content'),
    ]);

    //dd($comment);
    return response()->json([
        'message' => 'Commentaire créé avec succès !',
        'comment' => $comment,
    ], 200);   
    
}

public function getComments($feedd_id) {
      $comments = Comment::with('feedd','user')->whereFeeddId($feedd_id)->latest()->get();
        return response()->json([
            'comments' => $comments,
        ], 200);
}


public function updateComment(Request $request, $comment_id)
{
    $request->validate([
        'content' => 'required',
    ]);
    $comment = Comment::where('id',$comment_id)->first();
  
    
    if (!$comment) {
        return response()->json([
            'message' => '404 || Commentaire non trouvé !',
        ], 500);
    }
    $comment->update([
        'content' => $request->get('content'),
    ]);
    return response()->json([
        'message' => 'Commentaire modifié avec succès !',
    ], 200);   

}


public function deleteComment($comment_id)
{
    $comment = Comment::where('id',$comment_id)->first();
    if (!$comment) {
        return response()->json([
            'message' => '404 || Commentaire non trouvé !',
        ], 500);
    }
    $comment->delete();
    return response()->json([
        'message' => 'Commentaire supprimé avec succès !',
    ], 200);   
    
}

}