<?php

try {

  $link = mysqli_connect('localhost', 'root', '', 'haveatry');

  // 接続状況をチェックします
  if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
  }
  // userテーブルの全てのデータを取得する
  $query = "SELECT * FROM movie ORDER BY id DESC;";
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
  <title>投稿作品</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

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

  <link rel="stylesheet" href="css/destyle.css">
  <link rel="stylesheet" href="css/worklist.css">
  <link rel="stylesheet" href="css/add_movie.css">
  <!-- <link rel="stylesheet" href="css/bg.css"> -->


  <style>

  </style>
</head>

<body>

  <header>
    <div>
      <a href="index.php"><img src="img/logo.png" alt="logo" class="toplogo"></a>
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
      <!-- モーダルを開くボタン・リンク -->
      <div id="link">
        <button type="button" data-toggle="modal" data-target="#testModal">投稿</button>
      </div>
    </div>
  </header>





  <!-- ボタン・リンククリック後に表示される画面の内容 -->
  <div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">

          <div id="app">
            <label for="input-video">{{ isLoading ? '読み込み中...' : '動画を選択'}}</label>
            <input id="input-video" type="file" name="movie_file" accept="video/mp4,video/x-m4v" @change="handleFileSelect">
            <video controls v-if="src">
              <source :src="src" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
            </video>
            <div class="thumbnail-list">
              <transition-group name="fade">
                <img class="thumbnail" id="movie_img" name="movie_img" v-for="(thumbnail, index) in thumbnails" :key="'thumbnail' + index" :src="thumbnail" :class="{ active: index === selected }" @click="selected = index">
              </transition-group>
            </div>


            <form action="php/addwork.php" method="POST">
              <input type="hidden" name="src" v-bind:value="src">
              <input type="hidden" name="img" v-bind:value="thumbnails[selected]">
              <input type="hidden" name="user_id" value="Tanaka">
              <div id="title"><input type="text" name="title" class="title" placeholder="タイトル"></div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger">投稿</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>




  <main>
    <h1></h1>
    <article class="list_top">
      <h2>投稿一覧</h2>
      <div class="flex">
        <?php if ($result = mysqli_query($link, $query)) {
          foreach ($result as $row) { ?>
            <section class="list">
              <h3></h3>
              <div class="stage">
                <a href="#"><img src="<?php echo $row['img']; ?>" width="400" height="225" alt=""></a>
                <video class="v" loop poster="<?php echo $row['img']; ?>" width="400" height="225" muted>
                  <source src="<?php echo $row['fname']; ?>">
                </video>
                <!-- 名前、タイトル -->
                <div class="detail">
                  <p class="movie_title"><?php echo $row['title']; ?></p>
                  <p class="movie_name"><?php echo $row['user_id']; ?></p>
                </div>
              </div>
            </section>
        <?php }
        } ?>


      </div>
    </article>
  </main>

  <footer>
    <h2 class="hidden"></h2>
    <div class="footer_flex">
      <div class="footer_logo">
        <img src="img/logo.png" alt="">
      </div>

      <div class="bg">
      <p class="design_text_1">HAVE A TRY</p>
      <p class="design_text_2">HAVE A TRY</p>
      </div>

      <div class="footer_ele">
        <dl>
          <dd>チュートリアル</dd>
          <dd>投稿一覧</dd>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://jp.vuejs.org/js/vue.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
  <script>
    new Vue({
      el: "#app",
      data: {
        src: null,
        thumbnails: [],
        selected: 0,
        isLoading: false
      },
      methods: {
        handleFileSelect(event) {
          // reset data
          this.src = null
          this.thumbnails = []
          this.selected = 0

          // varidate file
          const file = event.target.files[0]
          if (!file || !file.type.match('video/*')) return

          // read file
          const reader = new FileReader()
          reader.onload = (evt) => {
            this.src = evt.target.result
            this.createThumbnails(this.src)
            this.isLoading = false
          }
          reader.readAsDataURL(file)
          this.isLoading = true
        },
        createThumbnails(src) {
          const video = document.createElement('video')
          const canvas = document.createElement('canvas')
          const context = canvas.getContext('2d')

          // set canvas
          video.onloadeddata = () => {
            canvas.width = video.videoWidth
            canvas.height = video.videoHeight
            video.currentTime = 0
          }

          // capture thumbnail
          video.onseeked = () => {
            if (video.currentTime < video.duration) {
              context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight)
              this.thumbnails.push(canvas.toDataURL('image/jpeg'))
              video.currentTime += Math.ceil(video.duration / 4)
            } else {
              context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight)
              this.thumbnails.push(canvas.toDataURL('image/jpeg'))
            }
          }

          // set video source
          video.src = src
          video.load()
        }
      },
    })




    // 動画自動再生hover
    $(document).on({
      mouseenter: function() {
        $(this).addClass('on');
        $(this).find('.v')[0].currentTime = $(this).find('.v')[0].initialTime || 0;
        $(this).find('.v')[0].play();
      },
      mouseleave: function() {
        $(this).removeClass('on');
        $(this).find('.v')[0].pause();
      }
    }, '.stage');
  </script>
</body>

</html>