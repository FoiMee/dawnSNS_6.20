@extends('layouts.login')

@section('content')
  <div id="content-split">
    <h1 class="list-label">Follow list</h1>
      <div class="list-wrapper">
        @foreach($follows as $follow)
          @php
            $image = $follow->images;
            $follow_id = $follow->follow;
          @endphp
          {!! Form::open(['url' => '/profile']) !!}
          {{Form::hidden('id',  $follow_id, [])}}
          @php
            echo "<input type='image' src='storage/".$image."' class='list-logo'>";
          @endphp
          {!! Form::close() !!}
        @endforeach
      </div>
    <p class="follows-sizing"></p>
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
      echo "<img src='storage/".$image."' class='postuser-logo'>";
      echo "<p class='postuser-name'>".$postname."</p>";
      echo "<p class='postuser-post'>".$post_text."</p>";
      echo "<p class='postuser-time'>".$time."</p>";
    @endphp
  </div>
  @endforeach

@endsection
