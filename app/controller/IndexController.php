<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
class IndexController
{
    public function index()
    {
        $view = new View();
        $posts = Post::all();

        $view->render('index', [
            "posts" => $posts
        ]);
    }

    public function view($id = 0)
    {
        $view = new View();

        $view->render('view', [
            "post" => Post::find($id)
        ]);
    }

    public function newPost()
    {
        $data = $this->_validate($_POST);

        if ($data === false) {
            header('Location: ' . App::config('url'));
        } else {

            if ($_FILES['image']['type'] != NULL){
                $dir = 'public/images/'; //save img to dir
                if ($_FILES['image']['type'] != 'image/jpeg'){ // if file type not jps
                    echo 'file is not jpg!';
                    exit();
                }
                if (move_uploaded_file($_FILES['image']['tmp_name'], $dir.$_FILES['image']['name'])){
                    $data['image'] = $_FILES['image']['name'];
                }
            }

            $connection = Db::connect();
            $sql = 'INSERT INTO post (content, image) VALUES (:content, :image)';
            $stmt = $connection->prepare($sql);
            $stmt->bindValue('content', $data['content']);
            $stmt->bindValue('image', $dir.$data['image']);
            $stmt->execute();
            header('Location: ' . App::config('url'));

        }
    }

    /**
     * @param $data
     * @return array|bool
     */
    private function _validate($data)
    {
        $required = ['content'];


        //validate required keys
        foreach ($required as $key) {
            if (!isset($data[$key])) {
                return false;
            }

            $data[$key] = trim((string)$data[$key]);
            if (empty($data[$key])) {
                return false;
            }
        }
        return $data;
    }


}
;