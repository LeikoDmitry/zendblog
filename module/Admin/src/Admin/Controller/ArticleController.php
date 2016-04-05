<?php
namespace Admin\Controller;

use Admin\Form\AddArticleForm;
use Application\Controller\BaseAdminController as BaseController;
use Blog\Entity\Article;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;



/**
 * Class ArcticleController
 * Контроллер,отвечающий за работу со статьями
 * @package Admin\Controller
 */
class ArticleController extends BaseController
{
    public function indexAction()
    {
        // Делаем выборку из базы данных, получаем все записи
        $query = $this->getEntityManager()->createQueryBuilder()->select('a')->from('Blog\Entity\Article','a')->orderBy('a.id', 'DESC');
        // Создаем адаптер
        $adapter = new DoctrineAdapter(new ORMPaginator($query));

        // Создаем пагинатор
        $paginator = new Paginator($adapter);

        // Сколько статей будет на странице
        $paginator->setItemCountPerPage(2);

        // Откуда будем брать get параметр для пагинатора
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page',1));

        return array(
            'articles' => $paginator,
        );


    }

    /**
     * Метод добаления статьи
     * @return array|\Zend\Http\Response
     */
    public function addAction()
    {
        $em = $this->getEntityManager();
        $form = new AddArticleForm($em);

        $request = $this->getRequest();

        if($request->isPost())
        {
            $message = '';
            $status = '';

            $data = $request->getPost();
            $article = new Article();

            $form->setHydrator(new DoctrineHydrator($em, 'Article'));
            $form->bind($article);
            $form->setData($data);

            if($form->isValid()){
                $em->persist($article);
                $em->flush();

                $message = 'Статья успешно добавлена';
                $status = 'success';
            }else{

                $message = 'Ошибка параметров';
                $status = 'error';

                foreach($form->getInputFilter()->getInvalidInput() as $errors){
                    foreach($errors->getMessages() as $error){
                        $message .= ' ' . $error;
                    }
                }
            }
        }else{
            return array(
                'form' => $form,
            );
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/article');
    }

    /**
     * Метод редактирования статьи
     * @return array|\Zend\Http\Response
     */
    public function editAction()
    {
        $em = $this->getEntityManager();
        $status = "";
        $message = "";
        $form = new AddArticleForm($em);

        $id = (int)$this->params()->fromRoute('id', 0);

        $article = $em->find('Blog\Entity\Article',$id);
        if(empty($article)){
            $message = "Статья не найдена";
            $status = 'error';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
            return $this->redirect()->toRoute('admin/article');
        }

        $form->setHydrator(new DoctrineHydrator($em,'\Article'));
        $form->bind($article);

        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){
                $em->persist($article);
                $em->flush();

                $status = 'success';
                $message = "Статья успешно обновлена";
            }else{
                $status = 'error';
                $message = "Произошла ошибка.";
                foreach($form->getInputFilter()->getInvalidInput() as $error){
                    foreach($error->getMessages() as $err){
                        $message .= $err;
                    }
                }
            }

        }else{
            return array("form" => $form, 'id' => $id);
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/article');

    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();
        $status = 'success';
        $message = 'Статья успешно удалена';

        try{
            $repository = $em->getRepository('Blog\Entity\Article');
            $article = $repository->find($id);
            $em->remove($article);
            $em->flush();

        }catch (\Exception $e){
            $status = 'error';
            $message = 'Статья не может быть удалена.Ошибка: ' . $e->getMessage();
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/article');

    }

}