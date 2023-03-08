<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use Auth;

class PostsController extends Controller
{

  protected function create(array $data)
  {
      return Post::create([
          'user_id' => $data['user_id'],
          'posts' => $data['posts'],
          'created_at' => now(),
      ]);
  }

  protected function userInfomation(){
      $user = Auth::user();
      $name = $user['username'];
      $image = 'images/'.$user['images'];
      $user_id = (string)$user['id'];
      $follower_count = DB::table('follows')->where('follow','=',$user_id)->count();
      $follow_count = DB::table('follows')->where('follower','=',$user_id)->count();
      //session(['user_id' => $user_id]);
      $user_info = compact('name','image','user_id','follower_count','follow_count');
      return $user_info;
  }

  protected function postsDisplay($user_id){
      $posts = DB::select("select DISTINCT users.images, users.username, posts.user_id, posts.posts, posts.id,  posts.created_at
                           FROM users INNER JOIN posts ON users.id = posts.user_id LEFT JOIN follows ON users.id = follows.follow
                           WHERE (follows.follower = ? AND follows.follow IS NOT NULL) OR users.id = ?
                           ORDER BY posts.created_at DESC;",[$user_id,$user_id]);
      return $posts;
  }

    public function index(){
      $user_info = PostsController::userInfomation();
      $posts = PostsController::postsDisplay($user_info['user_id']);
      return view("posts.index",[
        'user_info' => $user_info,
        'posts' => $posts,
      ]);
    }

    public function post(Request $request){
      $request->validate([
        'posts' => 'required|max:150|min:1',
      ]);

      $data = $request->input();
      $this->create($data);
      $user_info = PostsController::userInfomation();
      $posts = PostsController::postsDisplay($user_info['user_id']);
      return view("posts.index",[
        'user_info' => $user_info,
        'posts' => $posts,
      ]);
    }

    public function postDelete(Request $request){
      $data = $request->input();
      DB::table('posts')->where('id','=',$data['post_id'])
                        ->delete();
      $user_info = PostsController::userInfomation();
      $posts = PostsController::postsDisplay($user_info['user_id']);
      return view("posts.index",[
        'user_info' => $user_info,
        'posts' => $posts,
      ]);
    }

    public function postUpdate(Request $request){
      $data = $request->input();
      DB::table('posts')->where('posts','=',$data['before_post'])
                        ->update([
                          'posts' => $data['new_post'],
                          'updated_at' => now(),
                        ]);
      $user_info = PostsController::userInfomation();
      $posts = PostsController::postsDisplay($user_info['user_id']);
      return view("posts.index",[
        'user_info' => $user_info,
        'posts' => $posts,
      ]);
    }

}
