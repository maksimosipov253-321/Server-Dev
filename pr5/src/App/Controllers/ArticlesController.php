<?php

namespace App\Controllers;

class ArticlesController extends AbstractController
{
    public function show($articleId)
    {
        $db = new \PDO('sqlite:' . __DIR__ . '/../../../data/blog.sqlite');

        $sth = $db->prepare('SELECT * FROM articles WHERE id = ?');
        $sth->execute([$articleId]);
        $article = $sth->fetch();

        $sth = $db->prepare('SELECT * FROM users WHERE id = ?');
        $sth->execute([$article['author_id']]);
        $author = $sth->fetch();

        $this->view->renderHtml('articles/show.php', [
            'article' => $article,
            'author' => $author,
            'title' => $article['name'],
        ]);
    }
}
