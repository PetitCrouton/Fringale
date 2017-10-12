<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 11/08/2017
 * Time: 14:37
 */

namespace Repository;

use Entity\Comment;
use Entity\User;

class CommentRepository extends RepositoryAbstract
{
    protected function getTable()
    {
        return 'comments';
    }

    public function findAll()
    {
        //modif
        $query = 'SELECT * FROM comments c'
            . ' JOIN users u ON c.id_user = u.id_user'
            . ' JOIN recipes r ON c.id_recipe = r.id_recipe'
        ;

        $dbComments = $this->db->fetchAll($query);

        $comments = [];

        foreach ($dbComments as $dbComment)
        {
            $comment = $this->buildEntity($dbComment);

            $comments[] = $comment;
        }

        return $comments;
    }

    public function findSort($orderField = 'username', $order = 'ASC')
    {
        $query = 'SELECT * FROM comments c'
            . ' JOIN users u ON c.id_user = u.id_user'
            . ' JOIN recipes r ON c.id_recipe = r.id_recipe'
        ;

        $query .= " ORDER BY $orderField $order";

        $dbComments = $this->db->fetchAll($query);

        $comments = [];

        foreach ($dbComments as $dbComment)
        {
            $comment = $this->buildEntity($dbComment);

            $comments[] = $comment;
        }

        return $comments;
    }

    public function findByIdRecipe($id_recipe)
    {
        $query = 'SELECT * FROM comments c JOIN users u ON c.id_user = u.id_user WHERE c.id_recipe = :id_recipe';

        $dbComments = $this->db->fetchAll($query,
            [
                ':id_recipe' => $id_recipe
            ]
        );

        $comments = [];

        foreach ($dbComments as $dbComment)
        {
            $comment = $this->buildEntity($dbComment);

            $comments[] = $comment;
        }

        return $comments;
    }

    public function save(Comment $comment)
    {
        // Les données à enregistrer en BDD
        $data = [
            'id_comment' => $comment->getId_comment(),
            'id_user' => $this->app['user.manager']->getUser()->getId_user(),
            'id_recipe' => $comment->getId_recipe(),
            'content' => $comment->getContent(),
            'comment_date' => date("Y-m-d H:i:s")
        ];

        // Appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data);

        // On défini l'id quand on est en insert (setId())
        if (empty($comment->getId_comment()))
        {
            $comment->setId_comment($this->db->lastInsertId());
        }
    }

    public function find($id_comment)
    {
        $dbComment = $this->db->fetchAssoc(
            'SELECT * FROM comments WHERE id_comment = :id_comment',
            [
                ':id_comment' => $id_comment
            ]
        );
        if(!empty($dbComment)){
            return $this->buildEntity($dbComment);
        }
    }

    public function sendMail($id_comment)
    {
        $query = 'SELECT c.*, u.username, u.email FROM comments c JOIN users u ON c.id_user = u.id_user WHERE id_comment = :id_comment';

        $dbMail = $this->db->fetchAssoc($query, [':id_comment' => $id_comment]);

        if(!empty($dbMail)){

            // Subject of confirmation email.
            $subject = 'Suppression de votre commentaire';

            // Who should the confirmation email be from?
            $sender = 'J\'ai faim! <no-reply@myemail.co.uk>';

            $msg = $dbMail['username'] . ",\n\nNous jugeons votre commentaire inapproprié et nous l'avons donc supprimé.
            <br />Voici votre commentaire, on vous laisse refléchir là-dessus: <p>" . $dbMail['content'] . "</p>";

            @mail($dbMail['email'], $subject, $msg, 'From: ' . $sender);
        }
    }

    public function delete(Comment $comment)
    {
        $this->db->delete(
            'comments',
            ['id_comment' => $comment->getId_comment()]
        );
    }


    private function buildEntity(array $data)
    {

        $comment = new Comment();

        $comment->setId_comment($data['id_comment'])
                ->setId_user($data['id_user'])
                ->setId_recipe($data['id_recipe'])
                ->setContent($data['content'])
                ->setComment_date($data['comment_date']);

        $user = new User();

        if (isset($data['username'])) {
            $user->setUsername($data['username']);
            $user->setUser_picture($data['user_picture']);
            $comment->setUserName($data['username']);
        }

        if (isset($data['title'])) {
            $comment->setRecipeName($data['title']);
        }

        $comment->setUser($user);

        return $comment;
    }
}