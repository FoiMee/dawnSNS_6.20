@extends('layouts.login')

@section('content')
<div id="content-split">
  {!! Form::open(['url' => '/search-result']) !!}
  {{Form::text('user_id', null, ['class' => 'search-name','placeholder' => 'ユーザー名'])}}
  <input type="image" src='images/search.png' class="search-logo">
  @if(isset($search_name))
    <p class='search-word'>検索ワード：{{ $search_name }}</p>
  @endif
  {!! Form::close() !!}
  <p class="search-sizing"></p>
</div>
@endsection

@section('postsContent')
  <div class="search-wrapper">
  @php
    $empty = true;
  @endphp
  @foreach($result as $user)
    @php
      $image = $user->images;
      $followsname = $user->username;
    @endphp
    @foreach($check as $followed)
      @php
        $empty = false;
        $flag = $loop->last;
        $id = $user->id;
        $followed_id = $followed->follow;
      @endphp
      @if($id === $followed_id)
        {!! Form::open(['url' => '/follow-out','class' => 'search-form']) !!}
        {{Form::hidden('follow_id', $id)}}
        {{Form::hidden('follower_id', $user_info['user_id'])}}
        @php
          echo "<img src='storage/".$image."' class='search-userlogo'>";
          echo "<p class='search-username'>".$followsname."</p><br>";
        @endphp
        {{Form::hidden('view_switch', 0)}}
        {{Form::submit('フォローをはずす',['class' => 'search-follow-out'])}}
        {!! Form::close() !!}
        @break
      @elseif($flag)
        {!! Form::open(['url' => '/follow','class' => 'search-form']) !!}
        {{Form::hidden('follow_id', $id)}}
        {{Form::hidden('follower_id', $user_info['user_id'])}}
        @php
          echo "<img src='storage/".$image."' class='search-userlogo'>";
          echo "<p class='search-username'>".$followsname."</p><br>";
        @endphp
        {{Form::hidden('view_switch', 0)}}
        {{Form::submit('フォローする',['class' => 'search-follow'])}}
        {!! Form::close() !!}
      @endif
    @endforeach
    @if($empty)
      {!! Form::open(['url' => '/follow','class' => 'search-form']) !!}
      {{Form::hidden('follow_id', $user->id)}}
      {{Form::hidden('follower_id', $user_info['user_id'])}}
      @php
        echo "<img src='storage/".$image."' class='search-userlogo'>";
        echo "<p class='search-username'>".$followsname."</p><br>";
      @endphp
      {{Form::hidden('view_switch', 0)}}
      {{Form::submit('フォローする',['class' => 'search-follow'])}}
      {!! Form::close() !!}
    @endif
  @endforeach
</div>
@endsection
