<?php


namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\User;
use Entity\Region;


class UserController extends ControllerAbstract
{
    public function listAction()
    {
        if (isset($_GET['col'])) {
            $users = $this->app['user.repository']->findSort($_GET['col'], $_GET['order']);
        } else{
            $users = $this->app['user.repository']->findAll();
        }

        return $this->render(
            'admin/user/list.html.twig',
            [
                'users' => $users
            ]
        );
    }

    public function editAction($id_user = null)
    {
        if (!is_null($id_user)){

            $user = $this->app['user.repository']->find($id_user);

            if (!$user instanceof User) {
                $this->app->abort(404);
            }
        } else {

            $user = new User();
        }

        $regions = $this->app["region.repository"]->findAll();
        $errors = [];

        if (!empty($_POST)) {
            $user
                ->setLastname($_POST['lastname'])
                ->setFirstname($_POST['firstname'])
                ->setEmail($_POST['email'])
                ->setUsername($_POST['username'])
                ->setCivility($_POST['civility'])
                ->setId_region($_POST['region'])
                ->setStatus($_POST['status'])
            ;

            if (empty($_POST['username'])){
                $errors['username'] = 'Le pseudo est obligatoire';
            }elseif(!empty($this->app['user.repository']->isUnique($_POST['username'], $id_user))){
                $errors['username'] = 'Ce pseudo est déjà utilisé';
            }

            if(empty($_POST['lastname'])){
                $errors['lastname'] = 'Le nom est obligatoire';
            } elseif(strlen($_POST['lastname']) > 100){
                $errors['lastname'] = 'Le nom ne doit pas faire plus de 100 caractères';
            }

            if(empty($_POST['firstname'])){
                $errors['firstname'] = 'Le prénom est obligatoire';
            } elseif(strlen($_POST['firstname']) > 100){
                $errors['firstname'] = 'Le prénom ne doit pas faire plus de 100 caractères';
            }

            if(empty($_POST['email'])){
                $errors['email'] = 'L\'email est obligatoire';
            } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'L\'email n\'est pas valide';
            } elseif(!empty($this->app['user.repository']->findByEmail($_POST['email'], $id_user))){
                $errors['email'] = 'Cet email est déjà utilisé';
            }

            if (empty($errors)){
                $this->app['user.repository']->save($user);

                $this->addFlashMessage('L\'utilisateur a bien été modifié');
                return $this->redirectRoute('admin_users');
            } else {
                $message = '<strong>Le formulaire contient des erreurs</strong>';
                $message .= '<br>' . implode('<br>', $errors);
                $this->addFlashMessage($message, 'error');
            }

        }

        return $this->render(
            'admin/user/edit.html.twig',
            [
                'user' => $user,
                'regions' => $regions
            ]
        );
    }

    public function deleteAction($id_user)
    {
        $user = $this->app['user.repository']->find($id_user);

        if (!$user instanceof User) {
            $this->app->abort(404);
        }

        $this->app['user.repository']->delete($user);

        $this->addFlashMessage('L\'utilisateur est supprimé');

        return $this->redirectRoute('admin_users');
    }

}