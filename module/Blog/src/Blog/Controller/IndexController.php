<?php
namespace Blog\Controller;


use Application\Controller\BaseController as BaseController;
use Blog\Entity\Comment;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\View\View;


/**
 * Class IndexController
 * Контроллер по умолчанию
 *
 * @package Blog\Controller
 */
class IndexController extends BaseController
{
    /**
     * Метод вывода постов на страницу
     *
     *
     */
    public function indexAction()
    { // Делаем выборку из базы данных, получаем все записи
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('Blog\Entity\Article','a')
            ->orderBy('a.id', 'ASC');
        // Создаем адаптер
        $adapter = new DoctrineAdapter(new ORMPaginator($query));

        // Создаем пагинатор
        $paginator = new Paginator($adapter);

        // Сколько статей будет на странице
        $paginator->setItemCountPerPage(1);

        // Откуда будем брать get параметр для пагинатора
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page',1));

       return array('article' => $paginator);
    }

    /**
     * Метод, отвечающий за показ статьи
     *
     *
     */
    public function articleAction()
    {
        $id = (int)$this->params()->fromRoute('id',0);
        $em = $this->getEntityManager();
        $article = $em->find('Blog\Entity\Article',$id);
        if(empty($article)){
            return $this->notFoundAction(); // метод вызывающий 404 ошибку
        }

        $comment = new Comment();
        $form = $this->getCommentForm($comment);
        return array('article' => $article, 'form' => $form);
    }

    /**
     * Метод создания формы из анотаций
     *
     * @param Comment $comment
     * @return \Zend\Form\Form
     */
    protected function getCommentForm(Comment $comment)
    {
        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm(new Comment());
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), '\Comment'));
        $form->bind($comment);

        return $form;
    }


}