<?
require_once('php/db/init.php');
require_once('php/classes/member.php');

class Article {
  private $articleId = -1;
  private $title = "";
  private $dateWritten = false;
  private $authorId = "";
  private $authorName = "";
  private $photoFilename = "";
  private $text = "";

  public function __construct($articleId) {
    global $db;
    if ($articleId < 0) return; // This will always be invalid, so don't query
    $query = $db->prepare(
      'SELECT `article_id`, `title`, `date_written`, `author_rcsid`,
      `author_full_name`, `photo_filename`, `text`
      FROM `articles` where `article_id` = :article_id;'
    );
    $query->execute(array(':article_id' => $articleId));
    $article = $query->fetch();
    if (!$article) return;

    $this->articleId = $article->article_id;
    $this->title = $article->title;
    $this->dateWritten = new DateTime($article->date_written);
    $this->authorId = $article->author_rcsid;
    $this->authorName = $article->author_full_name;
    $this->photoFilename = $article->photo_filename;
    $this->text = $article->text;
  }

  public static function fromRow($row) {
    $article = new Article(-1);
    $article->articleId = $row->article_id;
    $article->title = $row->title;
    $article->dateWritten = new DateTime($row->date_written);
    $article->authorId = $row->author_rcsid;
    $article->authorName = $row->author_full_name;
    $article->photoFilename = $row->photo_filename;
    $article->text = $row->text;
    return $article;
  }

  public function exists() {
    return $this->articleId > 0;
  }

  public function articleId() {
    return $this->articleId;
  }

  public function title() {
    return $this->title;
  }

  public function dateWritten() {
    return $this->dateWritten;
  }

  public function author() {
    return new Member($this->authorId);
  }

  public function authorId() {
    return $this->authorId;
  }

  public function authorName() {
    return $this->authorName;
  }

  public function photoURL() {
    // TODO
  }

  public function textMarkdown() {
    return $this->text;
  }

  public function textHTML() {
    // TODO
  }

  public function deleteFromDB() {
    global $db;
    if (!$this->exists()) {
      die('This article does not exist');
    }

    // Attempt to delete the DB row first
    $query = $db->prepare('DELETE FROM `articles` WHERE `article_id`=:article_id');
    $query->execute(array(':article_id' => $this->articleId));
    // TODO: Do something about the photo
  }
}

function addArticle($articleInfo) {
  global $db;

  $author = new Member($articleInfo['rcsid']);

  $addArticle = $db->prepare(
    'INSERT INTO `articles`(
      `title`, `date_written`, `author_rcsid`, `author_full_name`, `text`
    ) VALUES (
      :title, NOW(), :author_rcsid, :author_full_name, :text
    );'
  );
  $addArticle->execute(array(
    ':title' => $articleInfo['article_title'],
    ':author_rcsid' => $author->rcsid(),
    ':author_full_name' => $author->fullName(),
    ':text' => $articleInfo['article_text']
  ));
}

function listArticles() {
  global $db;
  // Request needed columns from `articles`
  $query = $db->prepare(
    'SELECT `article_id`, `title`, `date_written`, `author_rcsid`,
    `author_full_name`, `photo_filename`, `text`
    FROM `articles` ORDER BY `date_written` DESC;'
  );
  $query->execute();

  // Create corresponding Article objects using Article::fromRow()
  $articles = array();
  while ($row = $query->fetch()) {
    $articles[] = Article::fromRow($row);
  }
  return $articles;
}

function editArticle($articleInfo) {
  global $db;

  $editArticle = $db->prepare(
    'UPDATE `articles`
    SET `title`=:title, `text`=:text
    WHERE `article_id`=:article_id;'
  );
  $editArticle->execute(array(
    ':article_id' => $articleInfo['article_id'],
    ':title' => $articleInfo['article_title'],
    ':text' => $articleInfo['article_text']
  ));
}
?>
