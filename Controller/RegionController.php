<?php

namespace Controller;

class RegionController extends ControllerAbstract
{
	public function listAction()
	{
		
		$regions = $this->app['region.repository']->findAll();

		return $this->render(
			'index.html.twig',
			[
				'regions' => $regions
			]
		);
	}

    public function indexAction($id_region)
    {
        $region = $this->app['region.repository']->find($id_region);

        if (empty($region)) {
            $this->app->abort(404);
        }

        $Rdetail = $this->app['regiondetail.repository']->find($id_region);
        $lastRegion = $this->app['recipe.repository']->lastRecipe($id_region);
        $topRegions = $this->app['recipe.repository']->top($id_region);

        return $this->render('region/index.html.twig',
            [
                'region'        => $region,
                'regionDetail'  => $Rdetail,
                'topRegions'    => $topRegions,
                'lastRegion'    => $lastRegion,
            ]
        );
    }

    public function menuAction()
    {
        $regions = $this->app['region.repository']->findAll();

        return $this->render(
            'region/menu.html.twig',
            [
                'regions' => $regions
            ]
        );
    }
}