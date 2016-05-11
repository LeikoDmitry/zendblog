<?php

namespace Admin\Controller;


use Application\Controller\BaseAdminController as BaseController;
use Blog\Entity\Comment;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

/**
 * Class CommentController
 *
 * Отвечает за работу с комментариями
 * @package Admin\Controller
 */
class CommentController extends BaseController
{
    protected function getCommentForm(Comment $comment)
    {
        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm(new Comment());
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), '\Comment'));
        $form->bind($comment);
        return $form;
    }

    public function indexAction()
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('Blog\Entity\Comment','a')
            ->orderBy('a.id', 'DESC');
        $adapter = new DoctrineAdapter(new ORMPaginator($query));
        $paginator = new Paginator($adapter);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page',1));

        return array(
            'comments' => $paginator,
        );
    }
    
    public function editAction()
    {
        $em = $this->getEntityManager();
        $status = "";
        $message = "";
        $id = (int)$this->params()->fromRoute('id', 0);

        $comment = $em->find('Blog\Entity\Comment',$id);
        if(empty($comment)){
            $message = "Комментарий не найден";
            $status = 'error';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
            return $this->redirect()->toRoute('admin/comment');
        }

        $form = $this->getCommentForm($comment);
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){
                $em->persist($comment);
                $em->flush();
                $status = 'success';
                $message = 'Комментарий успешно обновлен';

            }else{
                $status = 'error';
                $message = 'Комментарий не может быть обнавлен, проверьте параметры';
                foreach($form->getInputFilter()->getInvalidInput() as $error){
                    foreach($error->getMessages() as $err){
                        $message .= $err;
                    }
                }

            }
        }else{
            return array("form" => $form, 'id' => $id, 'comment' => $comment);
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/comment');
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();
        $status = 'success';
        $message = 'Коммент успешно удален';

        try{
            $repository = $em->getRepository('Blog\Entity\Comment');
            $article = $repository->find($id);
            $em->remove($article);
            $em->flush();

        }catch (\Exception $e){
            $status = 'error';
            $message = 'Комментарий не может быть удален.Ошибка: ' . $e->getMessage();
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/comment');


    }




}