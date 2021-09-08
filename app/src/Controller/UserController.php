<?php
/**
 * User controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController.
 *
 * @Route("/user")
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends AbstractController
{

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Repository\UserRepository            $userRepository User repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator      Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="user_index",
     * )
     */
    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $userRepository->queryAll(),
            $request->query->getInt('page', 1),
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'user/index.html.twig',
            ['pagination' => $pagination]
        );
    }


    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/edit",
     *     methods={"GET", "PUT"},
     *     name="user_edit",
     * )
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class, $user, ['method' => 'PUT']);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            $currentPassword = $request->request->get('password');
            $encoderService = $this->container->get('old_password');
            $match = $encoderService->isPasswordValid($user, $currentPassword);

            if($match) {
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', "Password changed successfully");
                return $this->redirectToRoute('user_index');
            }
            else{
                $this->addFlash('success', "Error");
            }
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }



}