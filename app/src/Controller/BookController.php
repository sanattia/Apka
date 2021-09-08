<?php
/**
 * Book controller.
 */

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Comment;
use App\Form\BookType;
use App\Form\CommentType;
use App\Repository\BookRepository;
use App\Repository\CommentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class BookController.
 *
 * @Route("/book")
 * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
 */

class BookController extends AbstractController
{

    private BookRepository $bookRepository;

    /**
     * BookController constructor.
     * @param BookRepository $bookRepository Book Repository
     */


    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Repository\BookRepository            $bookRepository Book repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator      Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="book_index",
     * )
     */
    public function index(Request $request, BookRepository $bookRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $bookRepository->queryAll(),
            $request->query->getInt('page', 1),
            BookRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'book/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param BookRepository $bookRepository Book repository
     * @param BookRepository $commentRepository Comment repository
     * @param int                              $id         Book id
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="book_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     */
    public function show(BookRepository $bookRepository, CommentRepository $commentRepository, Book $book,  int $id): Response
    {
        return $this->render(
            'book/show.html.twig',
            [
                'book' => $bookRepository->findOneById($id),
                'comments' => $commentRepository->findBy(['book' => $book])

            ]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\BookRepository        $bookRepository Book repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="book_create",
     * )
     *
     * @IsGranted("ROLE_ADMIN")
     * )
     */
    public function create(Request $request, BookRepository $bookRepository): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setCreatedAt(new \DateTime());
            $book->setUpdatedAt(new \DateTime());
            $bookRepository->save($book);
            $this->addFlash('success', 'message_added_successfully');
            return $this->redirectToRoute('book_index');
        }

        return $this->render(
            'book/create.html.twig',
            ['form' => $form->createView(), 'book' => $book,
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Entity\Book                          $book           Book entity
     * @param \App\Repository\BookRepository            $bookRepository Book repository
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
     *     name="book_edit",
     * )
     *
     * @IsGranted(
     *     "EDIT",
     *     subject="book",
     * )
     */
    public function edit(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        $form = $this->createForm(BookType::class, $book, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setUpdatedAt(new \DateTime());
            $bookRepository->save($book);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('book_index');
        }

        return $this->render(
            'book/edit.html.twig',
            [
                'form' => $form->createView(),
                'book' => $book,
            ]
        );
    }
    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Entity\Book                          $book           Book entity
     * @param \App\Repository\BookRepository            $bookRepository Book repository
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
     *     name="book_delete",
     * )
     *
     * @IsGranted(
     *     "DELETE",
     *     subject="book",
     * )
     */
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        $form = $this->createForm(FormType::class, $book, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->delete($book);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('book_index');
        }

        return $this->render(
            'book/delete.html.twig',
            [
                'form' => $form->createView(),
                'book' => $book,
            ]
        );
    }

    /**
     * Comment action.
     *
     * @param \Symfony\Component\HttpFoundation\Request     $request            HTTP request
     * @param \App\Entity\Book                              $book               Book entity
     * @param \App\Entity\Comment                           $comment            Comment entity
     * @param CommentRepository                             $commentRepository  Comment Repository
     * @return \Symfony\Component\HttpFoundation\Response   HTTP response
     *
     * @Route(
     *     "/{id}/comment",
     *     methods={"GET", "POST"},
     *     name="book_comment",
     *     requirements={"id": "[1-9]\d*"},
     * )
     * @IsGranted("ROLE_USER")
     *
     */
    public function comment(Request $request, Book $book, CommentRepository $commentRepository): Response
    {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setBook($book);
            $comment->setAuthor($this->getUser());
            $comment->setCreatedAt(new \DateTime());
            $comment->setUpdatedAt(new \DateTime());
            $commentRepository->save($comment);

            $this->addFlash('success', 'message_added_successfully');

            return $this->redirectToRoute('book_show', ['id' => $book->getId()]);
        }

        return $this->render(
            'book/comment.html.twig',
            [
                'form' => $form->createView(),
                'book' => $book,
                'comment' => $comment,
            ]
        );
    }



}

