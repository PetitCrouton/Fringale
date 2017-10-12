<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 11/08/2017
 * Time: 10:01
 */

namespace Entity;


class RegionDetail
{
    /**
     * @var
     */
    private $id_region_detail;

    /**
     * @var
     */
    private $picture_region;

    /**
     * @var
     */
    private $region_story;

    /**
     * @var
     */
    private $details;

    /**
     * @var
     */
    private $id_region;

    /**
     * @return mixed
     */
    public function getId_region_detail()
    {
        return $this->id_region_detail;
    }

    /**
     * @param mixed $id_region_detail
     * @return RegionDetail
     */
    public function setId_region_detail($id_region_detail)
    {
        $this->id_region_detail = $id_region_detail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPicture_region()
    {
        return $this->picture_region;
    }

    /**
     * @param mixed $picture_region
     * @return RegionDetail
     */
    public function setPicture_region($picture_region)
    {
        $this->picture_region = $picture_region;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegion_story()
    {
        return $this->region_story;
    }

    /**
     * @param mixed $region_story
     * @return RegionDetail
     */
    public function setRegion_story($region_story)
    {
        $this->region_story = $region_story;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     * @return RegionDetail
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId_region()
    {
        return $this->id_region;
    }

    /**
     * @param mixed $id_region
     * @return RegionDetail
     */
    public function setId_region($id_region)
    {
        $this->id_region = $id_region;
        return $this;
    }
}