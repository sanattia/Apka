<?php
/**
 * Trasa controller.
 */

namespace App\Controller;

use App\Entity\Trasa;
use App\Form\TrasaType;
use App\Service\TrasaService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TrasaController.
 *
 * @Route("/trasa")
 *
 * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
 */
class TrasaController extends AbstractController
{
    /**
     * Trasa service.
     *
     * @var TrasaService
     */
    private TrasaService $trasaService;

    /**
     * TrasaController constructor.
     *
     * @param TrasaService $trasaService Trasa service
     */
    public function __construct(TrasaService $trasaService)
    {
        $this->trasaService = $trasaService;
    }

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="trasa_index",
     * )
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->trasaService->createPaginatedList($page);

        return $this->render(
            'trasa/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Trasa           $trasa
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="trasa_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Trasa $trasa): Response
    {
        return $this->render(
            'trasa/show.html.twig',
            [
                'trasa' => $trasa
            ]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="trasa_create",
     * )
     *
     * @IsGranted("ROLE_ADMIN")
     * )
     */
    public function create(Request $request): Response
    {
        $trasa = new Trasa();
        $form = $this->createForm(TrasaType::class, $trasa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trasa->setCreatedAt(new \DateTime());
            $trasa->setUpdatedAt(new \DateTime());
            $this->trasaService->save($trasa);
            $this->addFlash('success', 'message_added_successfully');

            return $this->redirectToRoute('trasa_index');
        }

        return $this->render(
            'trasa/create.html.twig',
            ['form' => $form->createView(), 'trasa' => $trasa,
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Trasa                          $trasa    Trasa entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="trasa_edit",
     * )
     *
     * @IsGranted(
     *     "EDIT",
     *     subject="trasa",
     * )
     */
    public function edit(Request $request, Trasa $trasa): Response
    {
        $form = $this->createForm(TrasaType::class, $trasa, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trasa->setUpdatedAt(new \DateTime());
            $this->trasaService->save($trasa);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('trasa_index');
        }

        return $this->render(
            'trasa/edit.html.twig',
            [
                'form' => $form->createView(),
                'trasa' => $trasa,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Trasa                          $trasa    Trasa entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="trasa_delete",
     * )
     *
     * @IsGranted(
     *     "DELETE",
     *     subject="trasa",
     * )
     */
    public function delete(Request $request, Trasa $trasa): Response
    {
        $form = $this->createForm(FormType::class, $trasa, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->trasaService->delete($trasa);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('trasa_index');
        }

        return $this->render(
            'trasa/delete.html.twig',
            [
                'form' => $form->createView(),
                'trasa' => $trasa,
            ]
        );
    }

}
