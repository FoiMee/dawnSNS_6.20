<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Follow;
use Auth;
use Hash;

class FollowsController extends Controller
{



    protected function create(array $data)
    {
        return Follow::create([
            'follow' => $data['follow'],
            'follower' => $data['follower'],
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

    //

    protected function postsDisplay($user_id){
        $posts = DB::select("select DISTINCT users.images, users.username, posts.posts, posts.created_at
                             FROM users INNER JOIN posts ON users.id = posts.user_id INNER JOIN follows ON users.id = follows.follow
                             WHERE (follows.follower = ? AND follows.follow IS NOT NULL) OR users.id = ?
                             ORDER BY posts.created_at DESC;",[$user_id,$user_id]);
        return $posts;
    }
    //自分がフォローしているリスト
    public function followList(){
        $user_info = FollowsController::userInfomation();
        $posts = FollowsController::postsDisplay($user_info['user_id']);
        $follows = DB::select("select DISTINCT follows.follow, users.images FROM follows INNER JOIN users ON follows.follow = users.id WHERE follows.follower = ?;",[$user_info['user_id']]);
        return view("follows.followList",[
          'user_info' => $user_info,
          'posts' => $posts,
          'follows' => $follows,
        ]);
    }
    //自分をフォローしているリスト
    public function followerList(){
        $user_info = FollowsController::userInfomation();
        $posts = FollowsController::postsDisplay($user_info['user_id']);
        $follows = DB::select("select DISTINCT follows.follower, users.images FROM follows INNER JOIN users ON follows.follow = users.id WHERE follows.follow = ?;",[$user_info['user_id']]);
        return view("follows.followerList",[
          'user_info' => $user_info,
          'posts' => $posts,
          'follows' => $follows,
        ]);
    }

    //フォローする
    public function follow(Request $request){
        $data=$request->only('follow_id','follower_id');
        DB::table('follows')->insert([
            'follow'  => $data['follow_id'],
            'follower'   => $data['follower_id'],
            'created_at' => now(),
        ]);
        $user_info = FollowsController::userInfomation();
        $result = DB::select("select * from users
                              Where id != ?;",[$user_info['user_id']]);
        $check = DB::select("select follow from follows
                              Where follower = ?;",[$user_info['user_id']]);
        return view("users.search",[
          'user_info' => $user_info,
          'result' => $result,
          'check' => $check,
        ]);
    }

    //フォロー解除
    public function followOut(Request $request){
        $data=$request->only('follow_id','follower_id');
        DB::table('follows')->where('follow','=',$data['follow_id'])
                            ->where('follower','=',$data['follower_id'])
                            ->delete();
        $user_info = FollowsController::userInfomation();
        $result = DB::select("select * from users
                              Where id != ?;",[$user_info['user_id']]);
        $check = DB::select("select follow from follows
                              Where follower = ?;",[$user_info['user_id']]);
        return view("users.search",[
          'user_info' => $user_info,
          'result' => $result,
          'check' => $check,
        ]);
    }
}
