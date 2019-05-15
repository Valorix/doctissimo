<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\Type\ArticleType;
use App\Service\Database;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends AbstractController
{
    /**
     * Limit of result per source
     */
    const LIMIT_PER_SOURCE = 10;

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/api/articles/{id}")
     *
     * @param Database $database
     * @param int|null $id
     * @return array
     */
    public function getArticle(Database $database, int $id = null)
    {
        $articles = $database->getArticle($id);

        if ($id) {
            if (empty($articles)) {
                throw new NotFoundHttpException('Article not found');
            }

            return $articles[0];
        }

        return $articles;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/api/articles")
     *
     * @param Request $request
     * @param Database $database
     * @return Article|\Symfony\Component\Form\FormInterface
     */
    public function postArticle(Request $request, Database $database)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $database->createArticle($article);
            return $article;
        } else {
            return $form;
        }
    }
}
