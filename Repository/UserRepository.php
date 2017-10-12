<?php

namespace Repository;

use Entity\User;

class UserRepository extends RepositoryAbstract
{
    protected function getTable()
    {
        return 'users';
    }

    /**
     *
     * @return array Un tableau d'objets Entity\Category
     */
    public function findAll()
    {
        $query = 'SELECT * FROM users u JOIN regions r ON u.id_region = r.id_region';

        $dbusers = $this->db->fetchAll($query);

        $users = [];
        foreach ($dbusers as $dbuser) {
            $user = $this->buildEntity($dbuser);
            $users[] = $user;
        }
        return $users;
    }

    public function find($id_user)
    {
        $query = 'SELECT u.*, r.region_name FROM users u'
            . ' JOIN regions r ON u.id_region = r.id_region'
            . ' WHERE u.id_user = :id_user';

        $dbUser = $this->db->fetchAssoc(
            $query,
            [':id_user' => $id_user]
        );
        if (!empty($dbUser)) {
            return $this->buildEntity($dbUser);
        }
    }

    public function findSort($orderField = 'username', $order = 'ASC')
    {
        $query = 'SELECT * FROM users u JOIN regions r ON u.id_region = r.id_region';

        $query .= " ORDER BY $orderField $order";

        $dbUsers = $this->db->fetchAll($query);

        $users = [];

        foreach ($dbUsers as $dbUser)
        {
            $user = $this->buildEntity($dbUser);

            $users[] = $user;
        }

        return $users;
    }

    public function findById($id_user)
    {
        $query = 'SELECT c.*, u.* FROM comments c JOIN users u ON c.id_user = u.id_user WHERE c.id_user = :id_comment';

        $dbComment = $this->db->fetchAssoc($query,
            [
                ':id_comment' => $id_user
            ]
        );

        if (!empty($dbComment)) {
            return $this->buildEntity($dbComment);

        }
    }

    public function findByUsername($username)
    {
        $dbUser = $this->db->fetchAssoc(
            'SELECT * FROM users WHERE username = :username',
            [
                ':username' => $username
            ]
        );

        if (!empty($dbUser)) {
            return $this->buildEntity($dbUser);
        }
    }

    public function findByEmail($email, $excludedId = null)
    {
        $query = 'SELECT * FROM users WHERE email = :email';
        $params = [ ':email' => $email ];

        if (!is_null($excludedId)) {
            $query .= ' AND id_user != :id';
            $params[ ':id' ] = $excludedId;
        }

        $dbUser = $this->db->fetchAssoc(
            $query,
            $params
        );

        if(!empty($dbUser)){
            return $this->buildEntity($dbUser);
        }
    }

    public function isUnique($username, $excluded = null)
    {
        $queries = 'SELECT * FROM users WHERE username = :username';
        $param = [':username' => $username];

        if(!is_null($excluded)){
            $queries .= ' AND id_user != :id';
            $param[ ':id' ] = $excluded;
        }

        $dbUser = $this->db->fetchAssoc(
            $queries,
            $param
        );

        if(!empty($dbUser)){
            return $this->buildEntity($dbUser);
        }
    }

    public function totalUsers() {
        $query = "SELECT COUNT(id_user) FROM users";

        return $this->db->fetchColumn($query);
    }

    public function myRecipe($id_user)
    {
        $dbMyRecipe = $this->db->fetchAll(
            'SELECT * FROM recipes WHERE id_user = :id_user',
            [
                ":id_user" => $id_user
            ]
        );

        $nb_myRecipe = count($dbMyRecipe);
        return $nb_myRecipe;
    }

    public function myComments($id_user)
    {
        $dbMyComments = $this->db->fetchAll(
            'SELECT * FROM comments WHERE id_user = :id_user',
            [
                ":id_user" => $id_user
            ]
        );

        $nb_myComments = count($dbMyComments);
        return $nb_myComments;
    }

    public function myRatings($id_user)
    {
        $dbMyRatings = $this->db->fetchAll(
            'SELECT * FROM rating WHERE id_user = :id_user',
            [
                ":id_user" => $id_user
            ]
        );

        $nb_myRatings = count($dbMyRatings);
        return $nb_myRatings;
    }


    public function save(User $user)
    {
        // les données à enregistrer en bdd
        $data = [
            'lastname' => $user->getLastname(),
            'firstname' => $user->getFirstname(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'civility' => $user->getCivility(),
            'id_region' => $user->getId_region(),
            'status' => $user->getStatus(),
            'password' => $user->getPassword(),
            'user_picture' => $user->getUser_picture()
        ];

        $where = !empty($user->getId_user())
            ? ['id_user' => $user->getId_user()]
            : null;

        // appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data, $where);

        // on set l'id quand on est en insert
        if (empty($user->getId_user())) {
            $user->setId_user($this->db->lastInsertId());
        }

    }

    public function delete(User $user)
    {
        $this->db->delete(
            'users',
            ['id_user' => $user->getId_user()]
        );
    }

    /*
    @param array $data
    @return User
     */
    private function buildEntity(array $data)
    {
        $user = new User();

        $user
            ->setId_user($data['id_user'])
            ->setLastname($data['lastname'])
            ->setFirstname($data['firstname'])
            ->setEmail($data['email'])
            ->setCivility($data['civility'])
            ->setUsername($data['username'])
            ->setStatus($data['status'])
            ->setPassword($data['password'])
            ->setId_region($data['id_region'])
            ->setUser_picture($data['user_picture'])
        ;

        if (isset($data['region_name'])) {
            $user->setRegionName($data['region_name']);
        }

        return $user;
    }
}
