<?php
class Post
{
    private $id;
    private $content;
    private $cr_date;  //dodavanje cr_date kako bi u listi dobio podatke iz base
    private $image;

    public function __construct($id, $content,$cr_date, $image)
    {
        $this->setId($id);
        $this->setContent($content);
        $this->setDate($cr_date);
        $this->setImage($image);
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
        $list = [];
        $db = Db::connect();
        $statement = $db->prepare("select * from post as d order by d.cr_date DESC"); //zadnji ide na prvo mjesto
        $statement->execute();
        foreach ($statement->fetchAll() as $post) {
            $list[] = new Post($post->id, $post->content, $post->cr_date, $post->image);
        }
        return $list;
    }
    public static function find($id)
    {
        $id = intval($id);
        $db = Db::connect();
        $statement = $db->prepare("select * from post where id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        $post = $statement->fetch();
        return new Post($post->id, $post->content, $post->cr_date, $post->image);
    }
}
