@extends('layouts.login')

@section('content')
<div class="myprofile-wrapper">
  {!! Form::open(['url' => '/profile-update', 'enctype' => 'multipart/form-data']) !!}
    @php
      session_start();
      $username = $user_info['name'];
      $image = $user_info['image'];
      $mail = $user_info['mail'];
      $password  = $_SESSION['password'];
      $bio = $user_info['bio'];
      $id = $user_info['user_id'];
      echo "<img src='storage/".$image."' class='myprofile-logo'>";
      echo "<label class='myprofile-name'>UserName <input type='text' value='".$username."' name='username'></label>";
      echo "<label class='myprofile-mail'>MailAdress <input type='text' value='".$mail."' name='mail'></label>";
      echo "<label class='myprofile-old-pass'>Password <input type='password' disabled value='$password'></label>";
      echo "<label class='myprofile-new-pass'>new Password <input type='password' value='' name='password'></label>";
      echo "<label class='myprofile-bio'>Bio <textarea rows='3' name='bio'>$bio</textarea></label>";
      echo "<label class='myprofile-icon'>Icon Image <div class='file-style'><input type='file' accept='image/*' name='file_image'><span>ファイルを選択</span></div></label>";
      echo "<input type='hidden' name='id' value='$id'>";
      echo "<input type='hidden' name='before_image' value='$image'>";
      echo "<input class='myprofile-submit' type='submit' value='更新'>";
    @endphp
  {!! Form::close() !!}
</div>
@endsection
