<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function postsDisplay($user_id){
        $posts = DB::select("select DISTINCT users.images, users.username, posts.user_id, posts.posts, posts.id, posts.created_at
                             FROM users INNER JOIN posts ON users.id = posts.user_id INNER JOIN follows ON users.id = follows.follow
                             WHERE (follows.follower = ? AND follows.follow IS NOT NULL) OR users.id = ?
                             ORDER BY posts.created_at DESC;",[$user_id,$user_id]);
        return $posts;
    }

    public function login(Request $request){
    if($request->isMethod('post')){

        $data=$request->only('mail','password');
        // ログインが成功したら、トップページへ
        //↓ログイン条件は公開時には消すこと
        session_start();
        $_SESSION['password'] = $data['password'];
        if(Auth::attempt($data)){
            $user = Auth::user();
            $name = $user['username'];
            $image = $user['images'];
            $_SESSION['user_id'] = (string)$user['id'];
            $user_id = $_SESSION['user_id'];
            $follower_count = DB::table('follows')->where('follow','=',$user_id)->count();
            $follow_count = DB::table('follows')->where('follower','=',$user_id)->count();
            $posts = LoginController::postsDisplay($user_id);
            //session(['user_id' => $user_id]);
            $user_info = compact('name','image','user_id','follower_count','follow_count','posts');
            return view("posts.index",[
              'user_info' => $user_info,
              'posts' => $posts
            ]);
            //,['info'=>$info]
        }
    }
    return view("auth.login");
}
}
