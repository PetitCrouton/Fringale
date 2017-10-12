<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 14/08/2017
 * Time: 16:03
 */

namespace Repository;


use Entity\Rating;
use Entity\User;

class RatingRepository extends RepositoryAbstract
{
    public function save(Rating $rating)
    {
        // Les données à enregistrer en BDD
        $data = [
            'id_rate' => $rating->getId_rate(),
            'id_user' => $this->app['user.manager']->getUser()->getId_user(),
            'id_recipe' => $rating->getId_recipe(),
            'rate' => $rating->getRate()
        ];

        // Appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data);

        // On défini l'id quand on est en insert (setId())
        if (empty($rating->getId_rate())) {
            $rating->setId_rate($this->db->lastInsertId());
        }
    }

    public function ifRating($id_recipe, $id_user)
    {
        $query = 'SELECT * FROM rating WHERE id_user = :id_user AND id_recipe = :id_recipe';

        $check = $this->db->fetchAssoc($query,
            [
                ':id_recipe' => $id_recipe,
                ':id_user' => $id_user,
            ]
        );
        return $check;
    }

    public function avgRate($id_recipe)
    {
        $query = 'SELECT avg(rate) AS moyenne FROM rating WHERE id_recipe = :id_recipe';

        $dbRatings = $this->db->fetchColumn($query,
            [
                ':id_recipe' => $id_recipe
            ]
        );
        return $dbRatings;
    }

    public function countRating($id_recipe)
    {
        $query = 'SELECT COUNT( id_user ) AS votants FROM rating WHERE id_recipe = :id_recipe';

        $dbRatings = $this->db->fetchColumn($query,
            [
                ':id_recipe' => $id_recipe
            ]
        );
        return $dbRatings;
    }

    protected function getTable()
    {
        return 'rating';
    }

    private function buildEntity(array $data)
    {

        $rating = new Rating();

        $rating->setId_rate($data['id_rate'])
            ->setId_user($data['id_user'])
            ->setId_recipe($data['id_recipe'])
            ->setRate($data['rate']);

        $user = new User();

        $user
            ->setId_user($data['id_user'])
            ->setUsername($data['username']);

        $rating->setUser($user);

        return $rating;
    }
}