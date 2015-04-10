<?php
namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager
{
  protected function add(Comment $comment)
  {
    $q = $this->dao->prepare('INSERT INTO T_BLG_comments SET news = :news, auteur = :auteur, contenu = :contenu, date = NOW(), email = :email');
    
    $q->bindValue(':news', $comment->news(), \PDO::PARAM_INT);
    $q->bindValue(':auteur', $comment->auteur());
    $q->bindValue(':contenu', $comment->contenu());
    $q->bindValue(':email', $comment->email());
    $q->execute();
    //If the comment's author checked the box : his email is added to newsd table with the news' Id .
    if($comment->avertissement() == 1)
    {
      $request = $this->dao->prepare('INSERT INTO T_BLG_newsd SET email = :Commentemail, newsd_fk_news = :CommentnewsId');

      $request->bindValue(':Commentemail' , $comment->email());
      $request->bindValue(':CommentnewsId', $comment->news());
      $request->execute();
    }
    $comment->setId($this->dao->lastInsertId());

  }
  
  public function getFollowersAuthors($newsId)
  {
    //Send a mail to each person on the list
    $request = $this->dao->prepare('SELECT DISTINCT email FROM T_BLG_newsd WHERE newsd_fk_news = :newsId');
    $request->bindValue(':newsId', $newsId, \PDO::PARAM_INT);
    $request->execute();
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

    $personList = $request->fetchAll();

    return $personList;
  }

  public function getListOf($news)
  {
    if (!ctype_digit($news))
    {
      throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
    }
    
    $q = $this->dao->prepare('SELECT id, email, news, auteur, contenu, date FROM T_BLG_comments WHERE news = :news');
    $q->bindValue(':news', $news, \PDO::PARAM_INT);
    $q->execute();
    
    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
    
    $comments = $q->fetchAll();
    
    foreach ($comments as $comment)
    {
      $comment->setDate(new \DateTime($comment->date()));
    }
    
    return $comments;
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM T_BLG_comments WHERE id = '.(int) $id);
  }

  public function deleteFromNews($news)
  {
    $this->dao->exec('DELETE FROM T_BLG_comments WHERE news = '.(int) $news);
  }
  public function get($id)
  {
    $q = $this->dao->prepare('SELECT id, news, auteur, contenu FROM T_BLG_comments WHERE id = :id');
    $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $q->execute();
 
    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
 
    return $q->fetch();
  }

  public function getNewsCommentedByEmail($email)
  {
    $q = $this->dao->prepare('SELECT N.id, N.titre, N.contenu, N.dateAjout
                                FROM T_BLG_news AS N
                                INNER JOIN T_BLG_comments AS C ON C.news = N.id
                                WHERE strcmp(C.email, :email) = 0');
    $q->bindValue(':email', $email);
    $q->execute();
    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\news');
 
    $news = $q->fetchAll();
    
    return $news;
  }

    
}
?>