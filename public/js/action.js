$(function() {
      //ドロップダウンメニュー切り替え
      $(".menu-switch").click(function() {
          $(".pulldown-menu").toggleClass("active");
          $(".arrow-left").toggleClass("active");
          $(".arrow-right").toggleClass("active");
          return false;
      });
      //更新用モーダル表示
      $(".post-switch").click(function() {
          $(".modal-container").addClass("active");
          var text = $($(this)).val();
          $("#target").val(text);
          $("#target2").val(text);
          return false;
      });
      //モーダルウィンドウ外をクリックで非表示
      $(document).on('click',function(e) {
        if(!$(e.target).closest('.modal-body').length) {
           $(".modal-container").removeClass('active');
        }
      });

      $(".trash-logo").click(function() {
          var result = window.confirm('このつぶやきを削除します。よろしいでしょうか？');
          if(result) {
            return true;
          }else{
            return false;
          }
      });

});
