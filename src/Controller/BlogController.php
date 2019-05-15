<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\Database;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(Database $database)
    {
        $articles = $database->getArticle();

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles]
        );
    }

    /**
     * @Route("/article/{id}", name="view_article", methods={"GET"})
     *
     * @param Database $database
     * @param int $id
     * @return Response
     */
    public function viewArticle(Database $database, int $id)
    {
        $articles = $database->getArticle($id);

        if (empty($articles)) {
            throw new NotFoundHttpException('Article not found');
        }

        return $this->render(
            'blog/article.html.twig',
            ['article' => $articles[0]]
        );
    }

}