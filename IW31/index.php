<?php

try {

  $link = mysqli_connect('localhost', 'root', '', 'haveatry');

  // 接続状況をチェックします
  if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
  }
  // userテーブルの全てのデータを取得する
  $query = "SELECT * FROM article ORDER BY id desc;";
} catch (PDOException $ex) {
  var_dump($ex);
  echo "DB接続に失敗しました。";
} finally {
  $db = null;
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script>
    (function(d) {
      var config = {
          kitId: 'xtj6snd',
          scriptTimeout: 3000,
          async: true
        },
        h = d.documentElement,
        t = setTimeout(function() {
          h.className = h.className.replace(/\bwf-loading\b/g, "") + " wf-inactive";
        }, config.scriptTimeout),
        tk = d.createElement("script"),
        f = false,
        s = d.getElementsByTagName("script")[0],
        a;
      h.className += " wf-loading";
      tk.src = 'https://use.typekit.net/' + config.kitId + '.js';
      tk.async = true;
      tk.onload = tk.onreadystatechange = function() {
        a = this.readyState;
        if (f || a && a != "complete" && a != "loaded") return;
        f = true;
        clearTimeout(t);
        try {
          Typekit.load(config)
        } catch (e) {}
      };
      s.parentNode.insertBefore(tk, s)
    })(document);
  </script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.core.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.snow.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.bubble.css" />
  <link rel="stylesheet" href="css/destyle.css">
  <link rel="stylesheet" href="css/index.css">

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue-quill-editor@3.0.6/dist/vue-quill-editor.js"></script>





</head>

<body>
  <div id="loader-bg">
    <img src="img/load.gif" width="800px">
  </div>


  <header>
    <div>
      <a href=""><img src="img/logo.png" alt="logo" class="toplogo"></a>
    </div>
    <div>
      <nav>
        <ul>
          <li><a href="index.php">チュートリアル</a></li>
          <li><a href="worklist.php">投稿一覧</a></li>
          <li><a href="how.php">使い方</a></li>
          <li><a href="mypage.php">マイページ</a></li>
        </ul>
      </nav>
    </div>
    <div id="link_top">
      <a id="link" href="add.html">投稿</a>
    </div>
  </header>
  <main>

    <div id="top">
      <img src="img/topimg1.jpg" id="topimg" class="fade-in-bottom" alt="">
    </div>

    <h1></h1>
    <div id="flex">
      <article id="navi">
        <h2 class="none"></h2>
        <dt>使用ソフト</dt>
        <div class="search">
          <dd class="search_item is-active" data-group="">ALL</dd><br>
          <dd class="search_item" data-group="ae"><img src="img/ae.png" alt="" width="25px"><span class="icon">After Effects</span></dd><br>
          <dd class="search_item" data-group="pre"><img src="img/pre.png" alt="" width="25px"><span class="icon">Premiere Pro</span></dd><br>
          <dd class="search_item" data-group="fcp"><img src="img/fcp.png" alt="" width="25px"><span class="icon">Final Cut Pro X</span></dd><br>
          <dd class="search_item" data-group="dr"><img src="img/dr.png" alt="" width="25px"><span class="icon">DaVinci Resolve</span></dd><br>
          <dd class="search_item" data-group="ble"><img src="img/ble.png" alt="" width="25px"><span class="icon">Blender</span></dd>
        </div>
      </article>


      <article id="list">
     
          <h2>チュートリアル</h2>
    
        <div id="listflex">
          <?php if ($result = mysqli_query($link, $query)) {
            foreach ($result as $row) { ?>
                <section class="list_item animation_target" data-group="<?php echo $row['type']; ?>">
                  <div>
                  <div class="zoom-in">
                    <div class="zoom-in-img">
                      <a href="./article.php?article_id=<?php echo $row['id']; ?>"><img src="./php/upload/<?php echo $row['imgname']; ?>" alt="" class="topimg"></a>
                    </div>
                  </div>

                  <div class="listdesign">
                    <a href="./php/article.php?article_id=<?php echo $row['id']; ?>">
                      <h3><?php echo $row['title']; ?></h3>
                    </a>
                    <p class="fav hidden">☆<?php echo $row['fav']; ?></p>
                    <img src="img/<?php echo $row['type']; ?>.png" alt="アイコン" class="type"><br>
                    <p class="name"><?php echo $row['name']; ?>　<span><?php echo $row['date']; ?></span></p>
                  </div>
                  </div>
                </section>
          <?php }
          } ?>
        </div>
      </article>
    </div>
  </main>
  <footer>
    <h2 class="hidden"></h2>
    <div class="footer_flex">
      <div class="footer_logo">
        <img src="img/logo.png" alt="">
      </div>

      <div class="bg">
        <p class="design_text">HAVE A TRY</p>
      </div>

      <div class="footer_ele">
        <dl>
          <dd>チュートリアル</dd>
          <dd>投稿一覧</dd>
          <dd>使い方</dd>
          <dd>マイページ</dd>
        </dl>

        <dl>
          <dd>お問い合わせ</dd>
          <dd>利用規約</dd>
          <dd>プライバシーポリシー</dd>
        </dl>
      </div>
    </div>
  </footer>

  <script>
    $(window).on('load', function() {
      $('#loader-bg').hide();
    });

    var searchItem = '.search_item'; // 絞り込む項目を選択するエリア
    var listItem = '.list_item'; // 絞り込み対象のアイテム
    var hideClass = 'is-hide'; // 絞り込み対象外の場合に付与されるclass名
    var activeClass = 'is-active'; // 選択中のグループに付与されるclass名

    $(function() {
      // 絞り込みを変更した時
      $(searchItem).on('click', function() {
        $(searchItem).removeClass(activeClass);
        var group = $(this).addClass(activeClass).data('group');
        search_filter(group);
      });
    });

    /**
     * リストの絞り込みを行う
     * @param {String} group data属性の値
     */
    function search_filter(group) {
      // 非表示状態を解除
      $(listItem).removeClass(hideClass);
      // 値が空の場合はすべて表示
      if (group === '') {
        return;
      }
      // リスト内の各アイテムをチェック
      for (var i = 0; i < $(listItem).length; i++) {
        // アイテムに設定している項目を取得
        var itemData = $(listItem).eq(i).data('group');
        // 絞り込み対象かどうかを調べる
        if (itemData !== group) {
          $(listItem).eq(i).addClass(hideClass);
        }
      }
    }


    $(function() {
      $(window).on('load scroll', function() {
        var winScroll = $(window).scrollTop();
        var winHeight = $(window).height();
        var scrollPos = winScroll + (winHeight * 0.8);

        $(".show").each(function() {
          if ($(this).offset().top < scrollPos) {
            $(this).css({
              opacity: 1,
              transform: 'translate(0, 0)'
            });
          }
        });
      });
    });
    window.onload = function() {
      document.getElementById('wrap').classList.add('is-show');
    }




    const showElements = document.querySelectorAll(".animation_target")
    window.addEventListener("scroll", function(){
      for(let i = 0; i < showElements.length; i++){
        //画面の上からんお距離
        const getElementDistance = showElements[i].getBoundingClientRect().top + showElements[i].clientHeight * .5;
        if(window.innerHeight > getElementDistance){
          showElements[i].classList.add("show")
        }
      }
    })
  </script>
</body>

</html>