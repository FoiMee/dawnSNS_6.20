<?php
use Illuminate\Support\Facades\DB;
?>
@extends('layouts.login')

@section('content')
<div id="content-split">
  @php
  $image = $user_info['image'];
  echo "<img src='storage/".$image."' class='user-logo'>";
  @endphp
  {!! Form::open(['url' => '/post']) !!}
  {{Form::hidden('user_id',  $user_info['user_id'], [])}}
  {{Form::textarea('posts', null, ['class' => 'post-area','placeholder' => '何をつぶやこうか...？'])}}
  <input type="image" src='images/post.png' class="post-logo">
  {!! Form::close() !!}
  <div class="modal-container">
	   <div class="modal-body">
        {!! Form::open(['url' => '/post-update']) !!}
          <textarea id='target' class="post-edit" name="new_post" value=""></textarea>
          <input id='target2' type="hidden" name="before_post" value="">
          <input type='image' src='images/edit.png' class='update-logo'>
        {!! Form::close() !!}
	   </div>
  </div>
  <p class="form-sizing"></p>
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
      $user_id = $post->user_id;
      $post_id = $post->id;
      echo "<img src='storage/".$image."' class='postuser-logo'>";
      echo "<p class='postuser-name'>".$postname."</p>";
      echo "<p class='postuser-post'>".$post_text."</p>";
      echo "<p class='postuser-time'>".$time."</p>";
    @endphp
    @if($user_id == $user_info['user_id'])
      {!! Form::open(['url' => '']) !!}
      @php
        echo "<input type='image' src='images/edit.png' class='edit-logo post-switch' value='$post_text'>";
      @endphp
      {!! Form::close() !!}

      {!! Form::open(['url' => '/post-delete']) !!}
      {{Form::hidden('post_id',  $post_id, [])}}
      @php
        echo "<input type='submit' class='trash-logo' value=' '>";
      @endphp
      {!! Form::close() !!}
    @endif
  </div>
  @endforeach
@endsection
