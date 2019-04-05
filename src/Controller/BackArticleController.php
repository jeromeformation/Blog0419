<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back-office/articles")
 */
class BackArticleController extends AbstractController
{
    /**
     * @Route("/")
     * @return Response
     */
    public function list(): Response
    {
        return $this->render('back-office/articles/index.html.twig');
    }
    /**
     * @Route("/creation")
     * @return Response
     */
    public function create(): Response
    {
        // Création d'une catégorie
        $category = new Category();
        $category->setName('Voyage');

        // Création d'un utilisateur
        $user = new User();
        $user->setEmail('test@test.fr');
        $user->setRole('ROLE_ADMIN');
        $user->setUsername('user_admin');
        $user->setIsEnabled(true);

        // Création d'un article
        $article = new Article();
        $article->setTitle('Titre de l\'article');
        $article->setSlug('titre-de-l-article');
        $article->setContent('Contenu de l\'article');
        $article->setCategory($category);
        $article->setPublisher($user);

        // On insert en BDD
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->persist($category);
        $manager->persist($article);
        $manager->flush();

        // Ajout d'un message flash
        $this->addFlash('success', 'Votre article a été ajouté');

        return $this->render('back-office/articles/create.html.twig');
    }

    /**
     * @Route("/{slug}/modification")
     * @param string $slug
     * @return Response
     */
    public function update(string $slug): Response
    {
        // Récupération du Repository
        $repository = $this->getDoctrine()
            ->getRepository(Article::class);

        // Récupération de tous les articles
        $article = $repository->findOneBy([
            'slug' => $slug
        ]);

        // On imagine des changements faits avec le formulaire
        $article->setTitle('le titre a été changé');

        // On insert en BDD
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($article);
        $manager->flush();

        // Ajout d'un message flash
        $this->addFlash('success', 'Votre article a été modifié');

        return $this->render('back-office/articles/update.html.twig');
    }

    /**
     * @Route("/{slug}/suppression")
     * @return Response
     */
    public function delete(string $slug): Response
    {
        // Récupération du Repository
        $repository = $this->getDoctrine()
            ->getRepository(Article::class);

        // Récupération de tous les articles
        $article = $repository->findOneBy([
            'slug' => $slug
        ]);

        // On insert en BDD
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($article);
        $manager->flush();

        // Ajout d'un message flash
        $this->addFlash('danger', 'Votre article a été supprimé');

        return $this->render('back-office/articles/delete.html.twig');
    }
}