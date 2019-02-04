<?php
/**
 * Created by PhpStorm.
 * User: kruno
 * Date: 04/02/19
 * Time: 12.47
 */

class Comment {
    private $id;
    private $content;
    private $cr_date;
    private $id_post;


    public function __construct($id, $content, $cr_date, $id_post)
    {
        $this->setId($id);
        $this->setContent($content);
        $this->setDate($cr_date);
        $this->setIdPost($id_post);

    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : null;
    }
    public function __call($name, $arguments)
    {
        $function = substr($name, 0, 3);
        if ($function === 'set') {
            $this->__set(strtolower(substr($name, 3)), $arguments[0]);
            return $this;
        } else if ($function === 'get') {
            return $this->__get(strtolower(substr($name, 3)));
        }
        return $this;
    }
    public static function all()
    {
        $commentList = [];
        $db = Db::connect();
        $statement = $db->prepare("select * from comment"); //zadnji ide na prvo mjesto
        $statement->execute();
        foreach ($statement->fetchAll() as $comment) {
            $commentList[] = new Comment($comment->id, $comment->content, $comment->cr_date, $comment->id_post);
        }
        return $commentList;
    }
    public static function find($id)
    {
        $commentList = [];
        $id = intval($id);
        $db = Db::connect();
        $statement = $db->prepare("select * from comment as d where id_post = :id order by d.cr_date DESC");
        $statement->bindValue('id', $id);
        $statement->execute();
        foreach ($statement->fetchAll() as $comment) {
            $commentList[] = new Comment($comment->id, $comment->content, $comment->cr_date, $comment->id_post);
        }
        return $commentList;

    }






}