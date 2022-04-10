<?php



?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>使い方</title>
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
  <link rel="stylesheet" href="css/how.css">



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
    <div id="link_top hidden">
      <!-- モーダルを開くボタン・リンク -->
      <div id="link">
        <button type="button" data-toggle="modal" data-target="#testModal">投稿</button>
      </div>
    </div>
  </header>

  <main>
    <h1>使い方</h1>
    <article>
      <h2 class="none"></h2>
      <section>
        <div class="flex_img">
          <img src="img/topimg1.jpg" alt="">
        </div>
        <div class="flex_text">
          <h3>すべての映像を学ぶ人たちへ<br>
            映像製作に役立つ情報を用意しています。</h3>

          <p>はぶあとらいでは映像製作に関するチュートリアルを<br>みたり、自分の作った作品を投稿することができます。</p>
        </div>
      </section>

      <p class="design_text">HAVE A TRY</p>

      <section>
        <div class="flex_text">
          <h3>チュートリアルを見てみる</h3>

          <p>基礎から応用までさまざまななチュートリアルがあります。わからないことがあればコメントすることもできます。
            　またチュートリアルを投稿することもできます。技術のことや、映像製作の裏側など投稿してみましょう</p>
        </div>
        <div class="flex_img">
          <img src="img/how2.png" alt="">
        </div>
      </section>


      <section>
        <div class="flex_img">
          <img src="img/how3.png" alt="">
        </div>
        <div class="flex_text">
          <h3>作品を作ったら投稿してみよう</h3>

          <p>作品を投稿し互いにモチベーションを高めよう。勉強しているもの同士、作品を参考にしてみましょう。</p>
        </div>
      </section>


    </article>
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
  </script>
</body>

</html>