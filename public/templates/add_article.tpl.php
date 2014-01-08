<div class="row">
  <div class="large-12 columns">
    <h1>Write a News Article</h1>
    <p>
      Write a news article here, and it will be posted to the "news" section.
      You can add a photo to the article after submitting the article text.
    </p>
    <p>
      Format the article using <a href="https://help.github.com/articles/github-flavored-markdown">GitHub Flavored Markdown</a>.
      Don't know Markdown?
      Here's a quick <a href="http://www.markdowntutorial.com/">tutorial</a>.
    </p>
    <form action="post.php" method="post">
      <input type="hidden" name="rcsid" value="<?=$currentUser->rcsid()?>">
      <div class="medium-8 columns">
        <div class="row">
          <div class="small-12 columns">
            <label for="article-title">Title</label>
            <input type="text" id="article-title" name="article_title">
            <label for="article-text">Article text</label>
            <textarea class="markdown" id="article-text" name="article_text" rows="15"></textarea>
            <button type="submit" name="action" value="add_article">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
