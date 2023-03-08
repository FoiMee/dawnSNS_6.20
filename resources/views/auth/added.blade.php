@extends('layouts.logout')

@section('content')
<div class="added-wrapper">
  <header class="added">
      <h1></h1>
  </header>
</div>

<div id="container-added">

  <div class="welcome">
    <p class="user">{{ $name}}さん</p>
    <p class="comment">ようこそ！DAWNSNSへ！</p>
  </div>

  <div class="done">
    <p>ユーザー登録が完了しました。</p>
    <p>さっそく、ログインをしてみましょう。</p>
  </div>

  <p class="button"><a href="login">ログイン画面へ</a></p>
</div>

@endsection
