<?php

class Verbalizer
{
    protected $post;
    protected $db;
    protected $currentpost = 0;
    public $user;

    // test variables
    protected $pagination = false;
    protected $ppp = 5;

    /**
     * controller construction
     * @param Post $post
     * @param mysqli $db
     * @return void
     */
    public function __construct(Post $post, mysqli $db)
    {
        $this->post = $post;
        $this->db = $db;
        $this->user = new User($this->db);
    }

    /**
     * constructs a post object with a given id
     * used to generate posts
     * @param int $id
     * @return Post $post
     */
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
            $this->post->excerpt = $this->formatContent(substr($this->post->content, 0, 400)."... (excerpt).");
        }
        $result->free();
        $this->post->content = $this->formatContent($this->post->content);
        $this->formatDate();
        return $this->post;
    }

    /**
     * counts all the posts in the database
     * returns all post id's
     * used by getPosts
     * @param boolean $hidden = false, set to true to show posts that are not public
     * @return int count of the array
     */
    public function countPosts($hidden = false)
    {
        $sql = "SELECT id FROM `vb_post` WHERE PUBLIC = 1 ORDER BY id DESC";
        if ($hidden) {
            $sql = "SELECT id FROM `vb_post` ORDER BY id DESC";
        }
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

    /**
     * uses the constructPost() method on all posts
     * and assembles them in an array
     * @param boolean $hidden = false set to true to show hidden posts
     * @return array of post objects
     */
    public function getPosts($hidden = false)
    {
        $num = $this->countPosts($hidden);
        if ($num == 0) {
            return null;
        }
        $return = array();
        foreach ($num as $id) {
            $return[] = $this->constructPost($id);
        }
        return $return;
    }

    /**
     * loops the getPosts() method
     * increments and returns post objects in every iteration
     * usage: while($vb->loopPosts()) {}
     * @param boolean $hidden = false set to true to show hidden posts
     * @return true|false
     */
    public function loopPosts($hidden = false)
    {
        if ($this->pagination) {
            $posts = filter_var($_GET['posts'], FILTER_VALIDATE_INT);
            $size = count($this->getPosts($hidden));
            $offset = $posts * $this->ppp;
            $currents = array_slice($this->getPosts($hidden), $offset, $this->ppp);
            if ($this->currentpost < $size) {
                global $post;
                $post = $this->constructPost($this->getPosts($hidden)[$this->currentpost]->id);
                $this->currentpost++;
                return true;
            } else {
                return false;
            }
        } else {
            $size = count($this->getPosts($hidden));
            if ($this->currentpost < $size) {
                global $post;
                $post = $this->constructPost($this->getPosts($hidden)[$this->currentpost]->id);
                $this->currentpost++;
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * formats post content lines into paragraphs
     * @return void
     */
    private function formatContent($string)
    {
        $string = str_replace("\r\n", "<br />", $string);
        $string = str_replace("<br /><br />", "</p><p>", $string);
        $string = str_replace("{<br />", "{<br />&nbsp;&nbsp;&nbsp;&nbsp;", $string);
        $string = "<p>".$string."</p>";
        return $string;
    }

    /**
     * formats post date into F j, Y for better readability
     * @return void
     */
    private function formatDate()
    {
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $this->post->date);
        $this->post->date = $date->format("F j, Y");
    }

    /**
     * removes a post with the given id
     * @param int $id specific id of the post
     * @return header|false
     */
    public function removePost($id)
    {
        $sql = "DELETE FROM `vb_post` WHERE id = $id";
        if ($this->db->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * updates a post with a given id
     * @param int $id specific id of the post
     * @param int $public wether post is public or not
     * @param string $title
     * @param string $content
     * @param $_FILES|null $thumb include post image
     * @return header|false
     */
    public function updatePost($id, $public, $title, $content)
    {
        $title = trim($title);
        $title = htmlspecialchars($title);

        $content = trim($content);
        $content = str_replace("[code]", '<span class="code">', $content);
        $content = str_replace("[/code]", '</span>', $content);

        $content = str_replace("[link to=#", '<a href="', $content);
        $content = str_replace("[/link]", '</a>', $content);
        $content = str_replace("#]", '">', $content);

        $content = str_replace("[img]", '<img src="', $content);
        $content = str_replace("[/img]", '" class="post-image" />', $content);

        $stmt = $this->db->prepare("UPDATE `vb_post` SET public = ?, title = ?, content = ? WHERE id=?");
        $stmt->bind_param("issi", $public, $title, $content, $id);
        if ($stmt->execute()) {
            // success
            $last = $this->db->insert_id;
            $stmt->close();
            return "Post updated successfully!";
        } else {
            return "Something went wrong. Try again!";
        }
    }

    /**
     * adds a post
     * @param int $public wether post should be public or not
     * @param string $title
     * @param string $content
     * @param $_FILES|null $thumb include post image
     * @return header|false
     */
    public function addPost($public, $title, $content)
    {
        $title = trim($title);
        $title = htmlspecialchars($title);

        $content = trim($content);
        $content = str_replace("[code]", '<span class="code">', $content);
        $content = str_replace("[/code]", '</span>', $content);

        $content = str_replace("[link to=#", '<a href="', $content);
        $content = str_replace("[/link]", '</a>', $content);
        $content = str_replace("#]", '">', $content);

        $content = str_replace("[img]", '<img src="', $content);
        $content = str_replace("[/img]", '" class="post-image" />', $content);

        $authorName = $_SESSION['username'];
        $authorID = $_SESSION['id'];

        if (strlen($title) < 2 || strlen($content) < 10) {
            return "Please adress these issues: Title needs to be over 2 characters and content needs to be over 10 characters.";
        }

        $stmt = $this->db->prepare("INSERT INTO `vb_post` (public, title, content, authorName, authorID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $public, $title, $content, $authorName, $authorID);
        
        if ($stmt->execute()) {
            // success
            $last = $this->db->insert_id;
            $stmt->close();
            return "Post added successfully!";
        } else {
            return "Something went wrong. Try again!";
        }
    }
}
