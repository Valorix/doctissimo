<?php

namespace App\Service;

use App\Entity\Article;

class Database
{
    /**
     * @var \PDO
     */
    private $PDO;

    public function __construct(string $dbURL, string $user, string $pass = null)
    {
        $this->PDO = new \PDO($dbURL, $user, $pass);
    }

    public function createArticle(Article &$article)
    {
        $stmt = $this->PDO->prepare('INSERT INTO articles  (title, description) VALUES  (?, ?)');
        $stmt->execute([$article->getTitle(), $article->getDescription()]);
        $article->id = $this->PDO->lastInsertId();
    }

    public function getArticle(int $id = null)
    {
        $params = [];
        if ($id) {
            $stmt = $this->PDO->prepare("SELECT * FROM articles where id = ?");
            $params = [$id];
        } else {
            $stmt = $this->PDO->prepare("SELECT * FROM articles");
        }

        $articles = [];

        if ($stmt->execute($params)) {
            while ($row = $stmt->fetch()) {
                $article = new Article($row['title'], $row['description']);
                $article->id = $row['id'];
                $articles[] = $article;
            }
        }

        return $articles;
    }
}