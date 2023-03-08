<?php
use Illuminate\Support\Facades\View;

$imgFile = "../../public/";

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <script src="https://code.jquery.com/jquery.min.js"></script>
    <script type="text/javascript" src="js/action.js"></script>
    <!--IEブラウザ対策-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="ページの内容を表す文章" />
    <title></title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <!--スマホ,タブレット対応-->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <!--サイトのアイコン指定-->
    <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
    <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
    <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
    <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
    <!--iphoneのアプリアイコン指定-->
    <link rel="apple-touch-icon-precomposed" href="画像のURL" />
    <!--OGPタグ/twitterカード-->
</head>
<body>
    <header>
      <div id = "head">
        <h1><a><img src="images/main_logo.png" class="img"></a></h1>
            <div id="menu-wrapper">
                <div id="pulldown">
                    <p>{{ $user_info['name'] }} さん</p>
                  <div class="menu-switch">
                    <div class="arrow-left"></div><div class="arrow-right"></div>
                  </div>
                  @php
                  $image = $user_info['image'];
                    echo "<img src='storage/".$image."'>";
                  @endphp
                </div>
                <div class="pulldown-menu">
                  <ul class="dropdown-menu">
                      <li><a href="/top"><p>ホーム</p></a></li>
                      <li><a href="/my-profile"><p>プロフィール</p></a></li>
                      <li><a href="/logout"><p>ログアウト</p></a></li>
                  </ul>
                </div>
            </div>
        </div>
    </header>
    <div id="row">
        <div id="container">
            @yield('content')
            @hasSection('postsContent')
              @yield('postsContent')
            @endif
        </div >
        <div id="side-bar">
                <p class="name">{{ $user_info['name'] }}さんの</p>
                <div class="follow-wrapper">
                  <p class="text">フォロー数</p><p class="number">{{$user_info['follow_count']}}名</p>
                </div>
                <a href="/follow-list" class="follow"><p class="btn">フォローリスト</p></a>
                <div class="follower-wrapper">
                  <p class="text">フォロワー数</p><p class="number">{{$user_info['follower_count']}}名</p>
                </div>
                <a href="/follower-list" class="follower"><p class="btn">フォロワーリスト</p></a>
                <a href="/search" class="search"><p class="btn">ユーザー検索</p></a>
        </div>
    </div>
    <footer>
    </footer>
    <script src="JavaScriptファイルのURL"></script>
</body>
</html>
