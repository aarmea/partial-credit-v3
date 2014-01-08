<? $articleEdited = new Article($_GET['article']);
?><div class="row">
  <div class="large-12 columns">
    <h1>Edit Article</h1>
<? if ($articleEdited->exists()) { ?>

    <p>
      Format the article using <a href="https://help.github.com/articles/github-flavored-markdown">GitHub Flavored Markdown</a>.
      Don't know Markdown?
      Here's a quick <a href="http://www.markdowntutorial.com/">tutorial</a>.
    </p>
    <form action="post.php" method="post">
      <input type="hidden" name="rcsid" value="<?=$currentUser->rcsid()?>">
      <input type="hidden" name="article_id" value="<?=$articleEdited->articleId()?>">
      <div class="medium-8 columns">
        <div class="row">
          <div class="small-12 columns">
            <label for="article-title">Title</label>
            <input type="text" id="article-title" name="article_title" value="<?=$articleEdited->title()?>">
            <label for="article-text">Article text</label>
            <textarea class="markdown" id="article-text" name="article_text" rows="15"><?=$articleEdited->textMarkdown()?></textarea>
            <button type="submit" name="action" value="edit_article">Submit</button>
          </div>
        </div>
      </div>
    </form>
<? } else { ?>

    <p>The requested article does not exist.</p>
<? } ?>

  </div>
</div>
