@extends('layouts.logout')

@section('content')
<div class="login-wrapper">
  <header>
      <h1></h1>
      <p class="title">Social Network Service</p>
  </header>
</div>

<div id="container-login">
  <p >DAWNSNSへようこそ</p>
  <div class="form-login">
  {!! Form::open(['url' => '/login-check']) !!}

    <div class="input">
      {{ Form::label('MailAdress')}}
      {{ Form::text('mail',null,['class' => 'input']) }}
      {{ Form::label('Password')}}
      {{ Form::password('password',['class' => 'input']) }}
    </div>

    <div class="button">
        {{ Form::submit('LOGIN') }}
    </div>
  </div>

  <p class="register"><a href="register">新規ユーザーの方はこちら</a></p>

</div>


{!! Form::close() !!}


@endsection
