<?php

namespace Models;

class Post extends BaseModel
{
   public string $entity = 'post';

    public function create(string $description, string $picture, string $date, string $idUser): bool
    {
        $values = [$description, $picture, $date, $idUser];
        $keys = ['description', 'picture', 'date', 'idUser'];

        return $this->createFromArray($values, $keys);
    }

    public function select(int $id)
    {
        $this->db->query("SELECT post.*, user.id, user.pseudo, user.name, user.firstname, user.profile_picture FROM post JOIN user on user.id = post.idUser WHERE post.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    public function selectAll(): array
    {
        $this->db->query("SELECT post.*, user.id, user.pseudo, user.name, user.firstname, user.profile_picture FROM post JOIN user on user.id = post.idUser");
        return $this->db->fetchAll();
    }

    //Méthode pour selectionner tous les posts d'un User
    public function selectAllPostsFromUserId(int $idUser)
    {
        $this->db->query("SELECT * FROM post INNER JOIN user ON post.idUser = user.id WHERE idUser = :id ORDER BY date DESC");
        $this->db->bind(':id', $idUser);
        return $this->db->fetchAll();
    }

    //Méthode pour compter tous les posts d'un User
    public function countPostsFromUserId(int $idUser)
    {
        $this->db->query("SELECT COUNT(*) FROM post WHERE idUser = :id");
        $this->db->bind(':id', $idUser);
        return $this->db->fetchAll();
    }

    //Méthode pour selectionner tous les posts publiés
    public function selectAllPostsWithUsers(){
        $this->db->query("SELECT post.*, user.pseudo FROM post INNER JOIN user ON post.idUser = user.id ORDER BY date DESC");
        return $this->db->fetchAll();
    }

    //Méthode pour selectionner tous les posts publiés par les Users suivies
    public function selectAllFollowedPostsFromLoggedUser (int $idUser){
        $this->db->query("SELECT post.*, user1.pseudo FROM post INNER JOIN user AS user1 ON post.idUser = user1.id INNER JOIN following ON user1.id = following.idFollowing INNER JOIN user AS user2 ON following.idFollower = user2.id WHERE idFollower=:id ORDER BY date DESC");
        $this->db->bind(':id', $idUser);
        return $this->db->fetchAll();
    }
}



