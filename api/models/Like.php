<?php

namespace Models;

use stdClass;

class Like extends BaseModel
{
    public string $entity = '`like`';

    public function create(int $idUser, int $idPost): bool
    {
        $values = [$idUser, $idPost];
        $keys = ['idUser', 'idPost'];

        return $this->createFromArray($values, $keys);
    }

    public function selectAllLikesOfUser(int $idUser)
    {
        $this->db->query("SELECT * FROM `like` JOIN post ON post.id = idPost WHERE idUser = :id");
        $this->db->bind(':id', $idUser);
        return $this->db->fetchAll();
    }

    public function selectAllLikersFromPost(int $idPost)
    {
        $this->db->query("SELECT user.pseudo, user.name, user.firstname, user.profile_picture FROM `like` JOIN user ON user.id = idUser WHERE idPost = :id");
        $this->db->bind(':id', $idPost);
        return $this->db->fetchAll();
    }

    public function countLikesOfUser(int $idUser)
    {
        $this->db->query("SELECT COUNT(*) FROM `like` WHERE idUser = :id");
        $this->db->bind(':id', $idUser);
        return $this->db->fetch();
    }

    public function countLikersFromPost(int $idPost)
    {
        $this->db->query("SELECT COUNT(*) FROM `like` WHERE idPost = :id");
        $this->db->bind(':id', $idPost);
        return $this->db->fetch();
    }

    public function delete(int $id, int $idPost = -1): bool
    {
        $this->db->query("DELETE FROM `like` WHERE idUser = :idUser AND idPost = :idPost");
        $this->db->bind(':idUser', $id);
        $this->db->bind(':idPost', $idPost);

        return $this->db->execute();
    }

    public function update(int $id, stdClass $fields): bool
    {
        return false;
    }

}
