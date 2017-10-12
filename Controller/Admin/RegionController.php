<?php


namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Region;

class RegionController extends ControllerAbstract
{
    public function listAction()
    {
        $regions = $this->app['region.repository']->findAll();

        return $this->render('admin/region/list.html.twig',
            [
                'regions' => $regions
            ]
        );
    }

    public function editAction($id_region = null)
    {
        if (!is_null($id_region)){

            $region = $this->app['region.repository']->find($id_region);

            if (!$region instanceof Region) {
                $this->app->abort(404);
            }
        } else {

            $region = new Region();
        }

        if (!empty($_POST)) {
            $region
                ->setRegion_name($_POST['region_name'])
            ;

            if (empty($_POST['region_name'])){
                $errors['region_name'] = 'Le nom de la région est obligatoire';
            }elseif(!empty($this->app['region.repository']->isUnique($_POST['region_name'], $id_region))){
                $errors['region_name'] = 'Cette région existe déjà';
            }

            if (empty($errors)){
                $this->app['region.repository']->save($region);

                $this->addFlashMessage('La région est bien enregistrée');
                return $this->redirectRoute('admin_regions');
            } else {
                $message = '<strong>Le formulaire contient des erreurs</strong>';
                $message .= '<br>' . implode('<br>', $errors);
                $this->addFlashMessage($message, 'error');
            }

        }

        return $this->render(
            'admin/region/edit.html.twig',
            [
                'region' => $region
            ]
        );
    }

//    public function deleteAction($id_region)
//    {
//        $region = $this->app['region.repository']->find($id_region);
//
//        if (!$region instanceof Region) {
//            $this->app->abort(404);
//        }
//
//        $this->app['region.repository']->delete($region);
//
//        $this->addFlashMessage('La région est supprimée');
//
//        return $this->redirectRoute('admin_regions');
//    }

}