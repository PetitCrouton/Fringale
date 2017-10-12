<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 11/08/2017
 * Time: 10:02
 */

namespace Repository;

use Entity\Region;
use Entity\Recipe;
use Entity\RegionDetail;
class RegionDetailRepository extends RepositoryAbstract
{
    protected function getTable()
    {
        return 'regions_details';
    }

    public function find($id_region)
    {
        $dbRdetail = $this->db->fetchAssoc('SELECT * FROM regions_details WHERE id_region =:id_region',
            [
                ':id_region' => $id_region
            ]
        );

        if (!empty($dbRdetail))
        {
            return $this->buildEntity($dbRdetail);
        }
    }

    private function buildEntity(array $data)
    {
        $Rdetail = new regionDetail();

        $Rdetail
            ->setId_region_detail($data['id_region_detail'])
            ->setPicture_region($data['picture_region'])
            ->setDetails($data['details'])
            ->setRegion_story($data['region_story'])
        ;

        return $Rdetail;
    }

}