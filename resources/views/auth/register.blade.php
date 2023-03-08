@extends('layouts.logout')

@section('content')

@if ($errors->any())
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif

<div class="register-wrapper">
  <header class="register">
      <h1></h1>
  </header>
</div>
<div id="container-register">
<h2>新規ユーザー登録</h2>

<div class="form-register">
  {!! Form::open(['url' => '/register-check']) !!}

  <div class="input">
    {{ Form::label('UserName') }}
    {{ Form::text('username',null,['class' => 'input']) }}

    {{ Form::label('MailAdress') }}
    {{ Form::text('mail',null,['class' => 'input']) }}

    {{ Form::label('Password') }}
    {{ Form::password('password',['class' => 'input']) }}

    {{ Form::label('Password confirm') }}
    {{ Form::password('password_confirmation',['class' => 'input']) }}

  </div>
  <div class="button">
    {{ Form::submit('REGISTER') }}
  </div>
	{!! Form::close() !!}
</div>

<p class="login"><a href="login">ログイン画面へ戻る</a></p>

</div>




{!! Form::close() !!}


@endsection
