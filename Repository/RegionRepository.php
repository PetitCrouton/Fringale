<?php

namespace Repository;

use Entity\Region;

class RegionRepository extends RepositoryAbstract
{
	protected function getTable()
	{
		return 'regions';
	}

	public function findAll()
	{
		$dbRegions = $this->db->fetchAll('SELECT * FROM regions');

		$regions = [];

		foreach($dbRegions as $dbRegion){
			$region = $this->buildEntity($dbRegion);

			$regions[] = $region;
		}

		return $regions;
	}

	public function find($id_region)
	{
		$dbRegion = $this->db->fetchAssoc(
			'SELECT * FROM regions WHERE id_region = :id_region',
			[
				':id_region' => $id_region
			]
		);
		if(!empty($dbRegion)){
			return $this->buildEntity($dbRegion);
		}
	}

    public function isUnique($region_name, $excluded = null)
    {
        $queries = 'SELECT * FROM regions WHERE region_name = :region_name';
        $param = [':region_name' => $region_name];

        if(!is_null($excluded)){
            $queries .= ' AND id_region != :id';
            $param[ ':id' ] = $excluded;
        }

        $dbRegion = $this->db->fetchAssoc(
            $queries,
            $param
        );

        if(!empty($dbRegion)){
            return $this->buildEntity($dbRegion);
        }
    }

    public function save(Region $region)
    {
        // les données à enregistrer en bdd
        $data = [
            'region_name' => $region->getRegion_name()
        ];


        $where = !empty($region->getId_region())
            ? ['id_region' => $region->getId_region()]
            : null
        ;

        // appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data, $where);

        // on set l'id quand on est en insert
        $region->setId_region($this->db->lastInsertId());

    }

//    public function delete(Region $region)
//    {
//        $this->db->delete(
//            'regions',
//            ['id_region' => $region->getId_region()]
//        );
//    }

	private function buildEntity(array $data)
	{
		$region = new Region();

			$region
				->setId_region($data['id_region'])
				->setRegion_name($data['region_name'])
			;

			return $region;
	}

}