<?php


try {
  $article_id = $_GET['article_id'];

  $link = mysqli_connect('localhost', 'root', '', 'haveatry');

  // 接続状況をチェックします
  if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
  }
  // userテーブルの全てのデータを取得する
  $query = "SELECT * FROM article WHERE id = '" . $article_id . "';";
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
  <link rel="stylesheet" href="css/article.css">


  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue-quill-editor@3.0.6/dist/vue-quill-editor.js"></script>





</head>

<body>

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
    <div id="link_top" class="hidden">
      <a id="link" href="add.html">投稿</a>
    </div>
  </header>

  <main>
    <div id="wrapper">
      <div class="top">
        <?php if ($result = mysqli_query($link, $query)) {
          foreach ($result as $row) { ?>
            <h1><?php echo $row['title']; ?></h1>
            <p class="name"><?php echo $row['name']; ?> <span id="date"><?php echo $row['date']; ?></span></p>

            <img src="./php/upload/<?php echo $row['imgname']; ?>" id="topimg">
      </div>
      <article>
        <section id="main">
          <?php echo $row['text']; ?>
      <?php }
      } ?>
        </section>

      </article>


      <article id="comtop">
        <h2><img src="img/pen.png" alt="" class="pen">コメント</h2>
        <?php
        $comment_sql = "SELECT * FROM comment WHERE article_id = '" . $article_id . "';";

        if ($result = mysqli_query($link, $comment_sql)) {
          foreach ($result as $row) { ?>
            <section class="comment">
              <h2 class="none"></h2>
              <p class="com_name"><?php echo $row['name']; ?></p>
              <p class="com"><?php echo $row['comment']; ?></p>
              <p class="com_data"><?php echo $row['date']; ?></p>
            </section>
        <?php }
        } ?>

        <hr>
        <!-- コメント送信 -->
        <!-- useridまだできてない -->
        <section>
          <form action="php/comment.php" method="post">
            <input type="hidden" name="user_id" value="1">
            <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
            <textarea row="10" cols="60" name="com" id="com"></textarea>
            <input type="submit" class="button" value="送信">
          </form>
        </section>
      </article>
    </div>
  </main>
  <footer>
    <h2 class="hidden"></h2>
    <div class="footer_flex">
      <div class="footer_logo">
        <img src="img/logo.png" alt="">
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

</body>

</html>