<?php

namespace Entity;

class Region{

	private $id_region;

	private $region_name;



    /**
     * @return mixed
     */
    public function getId_region()
    {
        return $this->id_region;
    }

    /**
     * @param mixed $id_region
     *
     * @return self
     */
    public function setId_region($id_region)
    {
        $this->id_region = $id_region;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegion_name()
    {
        return $this->region_name;
    }

    /**
     * @param mixed $region_name
     *
     * @return self
     */
    public function setRegion_name($region_name)
    {
        $this->region_name = $region_name;

        return $this;
    }
}
