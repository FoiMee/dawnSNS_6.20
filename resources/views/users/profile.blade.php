@extends('layouts.login')

@section('content')
  <div id="content-split">
      @php
        $profile = $user_profile[0];
        $image = $profile->images;
        $username = $profile->username;
        $bio = $profile->bio;
        echo "<img src='images/".$image."' class='profile-logo'>";
        echo "<p class='name-label'>Name</p>";
        echo "<p class='profile-name'>".$username."</p>";
        echo "<p class='bio-label'>Bio</p>";
        echo "<p class='profile-bio'>".$bio."</p>";
      @endphp
        @if(!(empty($follow_check)))
          {!! Form::open(['url' => '/follow-out']) !!}
          {{Form::hidden('follow_id', $id)}}
          {{Form::hidden('follower_id', $user_info['user_id'])}}
          {{Form::submit('フォローをはずす',['class' => 'profile-follow-out'])}}
        @else
          {!! Form::open(['url' => '/follow']) !!}
          {{Form::hidden('follow_id', $id)}}
          {{Form::hidden('follower_id', $user_info['user_id'])}}
          {{Form::submit('フォローする',['class' => 'profile-follow'])}}
        @endif
        {!! Form::close() !!}
    <p class="profile-sizing"></p>
  </div>
@endsection

@section('postsContent')
  @foreach($posts as $post)
    <div id="post-wrapper">
      @php
        $image = $post->images;
        $postname = $post->username;
        $post_text = $post->posts;
        $time = $post->created_at;
        echo "<img src='images/".$image."' class='postuser-logo'>";
        echo "<p class='postuser-name'>".$postname."</p>";
        echo "<p class='postuser-post'>".$post_text."</p>";
        echo "<p class='postuser-time'>".$time."</p>";
      @endphp
    </div>
  @endforeach
@endsection
