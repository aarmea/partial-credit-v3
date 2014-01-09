<div class="row">
  <div class="medium-8 columns">
    <h1>News</h1>

<? foreach(listArticles() as $article) { ?>

    <article class="news">
      <header>
        <h2><?=$article->title()?></h2>
        <p>
          Posted by <span class="author"><?=$article->authorName()?></span> on
          <time pubdate datetime="<?=$article->dateYMD()?>"><?=$article->dateText()?></time>
        </p>
      <header>
<?=templatePrefix(demoteUserHeaders($article->textHTML()), $PREFIX . '      ')?>
    </article>
<? } ?>

  </div>
  <div class="medium-4 columns">
    <!-- Facebook like box -->
    <div class="fb-like-box" data-href="http://www.facebook.com/partialcreditacappella" data-colorscheme="dark" data-show-faces="true" data-header="false" data-stream="true" data-show-border="false"></div>
  </div>
</div>

<!-- Facebook JavaScript SDK -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=184480688387232";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
