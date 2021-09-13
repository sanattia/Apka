<?php
/**
 * Home controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController.
 */
class HomeController extends AbstractController
{
    /**
     * Index action.
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="home",
     * )
     */
    public function index(): Response
    {
        return $this->render(
            'index.html.twig',
        );
    }
}
