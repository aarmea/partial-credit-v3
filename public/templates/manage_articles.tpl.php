<div class="row">
  <div class="large-12 columns">
    <h1>Manage Articles</h1>
    <div class="row">
      <div class="medium-10 columns">
        <ul class="member-list">
<? foreach(listArticles() as $article) { ?>

          <li>
            <?=$article->title()?>
            <ul class="actions-list">
              <li><a href="?p=edit_article&article=<?=$article->articleId()?>">Edit</a></li>
              <li><a href="?p=remove_article&article=<?=$article->articleId()?>" class="alert">Remove</a></li>
            </ul>
          </li>
<? } ?>

        </ul>
        <a href="?p=add_article" class="button">Write an article</a>
      </div>
    </div>
  </div>
</div>
