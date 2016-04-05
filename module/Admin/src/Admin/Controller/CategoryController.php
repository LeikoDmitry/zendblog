<?php
namespace Admin\Controller;

use Admin\Form\CategoryAddForm;
use Application\Controller\BaseAdminController as BaseController;
use Blog\Entity\Category;


/**
 * Class CategoryController
 * Отвечает за вывод категорий
 * @package Admin\Controller
 */
class CategoryController extends BaseController
{

    public function indexAction()
    {
        //Получение объект EntityManager, отвечающий за сущности doctrine и  выполняем запрос
        $query = $this->getEntityManager()->createQuery("SELECT u FROM Blog\Entity\Category u ORDER BY u.id DESC");
        $rows = $query->getResult();

        // Возращаем результат в вид
        return array('category' => $rows);
    }

    /**
     * Метод добавление категории
     */
    public function addAction()
    {
        $form = new CategoryAddForm();
        $em = $this->getEntityManager();
        $status = "";
        $message = "";
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){

                $category = new Category();
                $category->exchangeArray($form->getData());
                $em->persist($category);
                $em->flush();

                $status = 'success';
                $message = 'Категория добавлена';

            }else{
                $status = 'error';
                $message = 'Категория не может быть добавлена, проверьте параметры';
            }
        }else{
            return array(
                'form' => $form,
            );
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/category');
    }

    /**
     * Метод редактирование категорий
     */
    public function editAction()
    {
        $form = new CategoryAddForm();
        $em = $this->getEntityManager();
        $status = "";
        $message = "";
        $id = (int) $this->params()->fromRoute('id', 0); // Получение индификатора из маршрута
        $category = $em->find('Blog\Entity\Category',$id);// Получение категории по пришедшему индификатору

        if(empty($category)){
            $status = 'error';
            $message = 'Категория не найдена';
            if($message){
                $this->flashMessenger()->setNamespace($status)->addMessage($message);
            }

            return $this->redirect()->toRoute('admin/category');
        }

        $form->bind($category);// Привязка данных категории с формой
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $em->persist($category);
                $em->flush();

                $status = 'success';
                $message = 'Категория обнавлена';
            }else{
                $status = 'error';
                $message = 'Ошибка параметров';
            }
        }else{
            return array(
                'form' => $form,
                'id' => $id,
            );
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/category');
    }

    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();
        $status = 'success';
        $message = 'Категория успешно удалена';

        try{
            $repository = $em->getRepository('Blog\Entity\Category');
            $category = $repository->find($id);
            $em->remove($category);
            $em->flush();

        }catch (\Exception $e){
            $status = 'error';
            $message = 'Категория не может быть удалена.Ошибка: ' . $e->getMessage();
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/category');
    }

}