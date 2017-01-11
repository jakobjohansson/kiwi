<?php
class VB extends Post
{
    protected $post;
    protected $db;
    protected $currentpost = 0;

    public function __construct(Post $post, mysqli $db)
    {
        $this->post = $post;
        $this->db = $db;
    }

    public function displayPost()
    {
        echo "<strong>";
        echo $this->post->title;
        echo "</strong><br />";
        echo "posted ";
        echo $this->post->date;
        echo $this->post->content;
        echo "<hr />";
    }

    public function getPost()
    {
        return $this->post;
    }

    public function constructPost($id)
    {
        $sql = "SELECT * FROM `vb_post` WHERE id = '$id'";
        $result = $this->db->query($sql);
        if ($result->num_rows == 0) {
            return false;
        } else {
            $row = $result->fetch_assoc();
            $this->post = new Post();
            foreach ($row as $key => $value) {
                $this->post->$key = $value;
            }
        }
        $result->free();
        $this->formatContent();
        $this->formatDate();
        return $this->getPost();
    }

    public function countPosts()
    {
        $sql = "SELECT id FROM `vb_post`";
        $result = $this->db->query($sql);
        $ids = 0;
        if ($result->num_rows > 0) {
            $ids = array();
            while ($row = $result->fetch_assoc()) {
                $ids[] = $row['id'];
            }
        }
        $result->free();
        return $ids;
    }

    public function getPosts()
    {
        $num = $this->countPosts();
        $return = array();
        foreach ($num as $id) {
            $return[] = $this->constructPost($id);
        }
        return $return;
    }

    public function loopPosts()
    {
        $size = count($this->getPosts());
        if ($this->currentpost < $size) {
            global $post;
            $post = $this->constructPost($this->getPosts()[$this->currentpost]->id);
            $this->currentpost++;
            return true;
        } else {
            return false;
        }
    }


    public function formatContent()
    {
        $string = $this->post->content;
        $string = str_replace("\r\n", "<br />", $string);
        $string = str_replace("<br /><br />", "</p><p>", $string);
        $string = str_replace("<br />", "", $string);
        $string = "<p>".$string."</p>";
        $this->post->content = $string;
    }

    public function formatDate()
    {
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $this->post->date);
        $this->post->date = $date->format("F j, Y");
    }

    public function removePost($id)
    {
        $sql = "DELETE FROM `vb_post` WHERE id = $id";
        if ($this->db->query($sql)) {
            // success
            header("Location: index.php");
        } else {
            return false;
        }
    }

    public function updatePost($id, $public, $title, $content, $thumb = null)
    {
        $title = trim($title);
        $title = htmlspecialchars($title);

        $content = trim($content);
        $content = str_replace("[code]", '<span class="code">', $content);
        $content = str_replace("[/code]", '</span>', $content);

        $content = str_replace("[link to=", '<a href="', $content);
        $content = str_replace("[/link]", '</a>', $content);
        $content = str_replace("]", '">', $content);

        $thumb = $thumb['tmp_name'];
        $thumb = htmlspecialchars($thumb);
        $thumb = trim($thumb);

        $stmt = $this->db->prepare("UPDATE `vb_post` SET public = ?, title = ?, content = ?, thumb = ? WHERE id=?");
        $stmt->bind_param("isssi", $public, $title, $content, $thumb, $id);
        if ($stmt->execute()) {
            // success
            $last = $this->db->insert_id;
            $stmt->close();
            header("Location: index.php");
        }
    }

    public function addPost($public, $title, $content, $thumb = null)
    {
        $title = trim($title);
        $title = htmlspecialchars($title);

        $content = trim($content);
        $content = str_replace("[code]", '<span class="code">', $content);
        $content = str_replace("[/code]", '</span>', $content);

        $content = str_replace("[link to=", '<a href="', $content);
        $content = str_replace("[/link]", '</a>', $content);
        $content = str_replace("]", '">', $content);

        $thumb = $thumb['tmp_name'];
        $thumb = htmlspecialchars($thumb);
        $thumb = trim($thumb);

        $authorName = $_SESSION['username'];
        $authorID = $_SESSION['id'];

        if (strlen($title) < 2 || strlen($content) < 10) {
            return false;
        }

        $stmt = $this->db->prepare("INSERT INTO `vb_post` (public, title, content, authorName, authorID, thumb) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssis", $public, $title, $content, $authorName, $authorID, $thumb);
        
        if ($stmt->execute()) {
            // success
            $last = $this->db->insert_id;
            $stmt->close();
            header("Location: index.php");
        }
    }
}
