<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Auth;

class UsersController extends Controller
{
    //

    protected function userInfomation($flag){ //bio、メールアドレスを送るかどうか
        $info = Auth::user();
        $_SESSION = array();
        $_SESSION['user_id'] = $info['id'];
        $user_id = $_SESSION['user_id'];
        $user = DB::select("select * from users where id = ?;",[$user_id]);
        foreach ($user as $column) {
          $name = $column->username;
          $image = $column->images;
        }
        $follower_count = DB::table('follows')->where('follow','=',$user_id)->count();
        $follow_count = DB::table('follows')->where('follower','=',$user_id)->count();
        if($flag){
          foreach ($user as $column) {
            $bio = $column->bio;
            $mail = $column->mail;
            $password = $column->password;
          }
            $user_info = compact('name','image','user_id','follower_count','follow_count','bio','mail','password');
        }else{
            $user_info = compact('name','image','user_id','follower_count','follow_count');
        }
        return $user_info;
    }

    public function myProfile(){
        $user_info = UsersController::userInfomation(true);
        return view('users.myProfile',[
          'user_info' => $user_info,
        ]);


    }

    public function profile(Request $request){
        $data = $request->input();
        $id = $data['id'];
        $user_info = UsersController::userInfomation(false);
        $posts = DB::select("select * from users inner join posts on users.id = posts.user_id
                                    where users.id = ? order by posts.created_at desc;",[$id]);
        $profile = DB::select("select * from users where id = ?;",[$id]);
        $follow_check = DB::select("select * from follows
                                    where follow = ? and follower = ?;",[$id,$user_info['user_id']]);
        return view('users.profile',[
          'user_info' => $user_info,
          'posts' => $posts,
          'user_profile' => $profile,
          'follow_check' => $follow_check,
          'id' => $id,
        ]);
    }

    public function profileUpdate(Request $request){
          $request->validate([
            'username' => 'required|max:12|min:4',
            'mail' => 'required|max:12|min:4',
            'password' => 'nullable|max:12|min:4|regex:/^[a-zA-Z0-9]+$/',
          ]);
          $user_info = UsersController::userInfomation(true);
          $data = $request->input();


          if(empty($data['password'])){
              $password = $user_info['password'];
          }else {
              $_SESSION = array();
              $_SESSION['password'] = $data['password'];
              $_SESSION['user_id'] = $data['id'];
              $password = bcrypt($data['password']);
          }

          if(empty($data['file-image'])){
              $image = $data['before_image'];
          }else{
              $image = $data['file_image'];
          }


          $id = $data['id'];

          DB::table('users')->where('id', '=', $id)
                            ->update([
                                'username' => $data['username'],
                                'mail' => $data['mail'],
                                'password' => $password,
                                'bio' => $data['bio'],
                                'images' => $image,
                                'updated_at' => now(),
                            ]);
          $user_info = UsersController::userInfomation(true);
          return view('users.myProfile',[
            'user_info' => $user_info,
          ]);

    }

    public function userList(){
        $user_info = UsersController::userInfomation(false);
        $result = DB::select("select * from users
                              where id != ?;",[$user_info['user_id']]);
        $check = DB::select("select follow from follows
                              where follower = ?;",[$user_info['user_id']]);
        $search_name = NULL;
        return view("users.search",[
          'user_info' => $user_info,
          'result' => $result,
          'check' => $check,
          'search_name' => $search_name,
        ]);
    }

    public function search(Request $request){
        $data = $request->input();
        $search_name = $data['user_id'];
        $user_info = UsersController::userInfomation(false);
        $result = DB::table('users')->where('id','!=',[$user_info['user_id']])
                                    ->where('username','like','%'.$data['user_id'].'%')
                                    ->get();
        $check = DB::select("select follow from follows
                              where follower = ?;",[$user_info['user_id']]);
        return view("users.search",[
          'user_info' => $user_info,
          'result' => $result,
          'check' => $check,
          'search_name' => $search_name,
        ]);
    }

}
