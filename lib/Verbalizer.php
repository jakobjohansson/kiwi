<?php

class Verbalizer
{
    protected $post;
    protected $db;
    protected $currentpost = 0;
    public $user;
    public $pagination = false;
    public $posts_per_page = 5;
    public $active = false;
    public $comments = false;

    public function __construct(Post $post, mysqli $db)
    {
        $this->post = $post;
        $this->db = $db;
        $this->setMeta();
        $this->user = new User($this->db);
    }

    private function setMeta()
    {
        $sql = "SELECT vb_key, vb_value FROM `vb_meta`";
        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            $key = $row['vb_key'];
            $value = $row['vb_value'];
            if ($row['vb_value'] === "false") {
                $value = false;
            } elseif ($row['vb_value'] === "true") {
                $value = true;
            }
            $this->$key = $value;
        }
        $result->free();
    }

    public function updateMeta(array $settings)
    {
        if (array_key_exists('pagination', $settings)) {
            $stmt = $this->db->prepare("UPDATE `vb_meta` SET vb_value = ? WHERE vb_key = 'pagination'");
            $stmt->bind_param("s", $settings['pagination']);
            $stmt->execute();
            $stmt->close();
        }
        if (array_key_exists('posts_per_page', $settings)) {
            $stmt1 = $this->db->prepare("UPDATE `vb_meta` SET vb_value = ? WHERE vb_key = 'posts_per_page'");
            $stmt1->bind_param("i", $settings['posts_per_page']);
            $stmt1->execute();
            $stmt1->close();
        }
        if (array_key_exists('comments', $settings)) {
            $stmt2 = $this->db->prepare("UPDATE `vb_meta` SET vb_value = ? WHERE vb_key = 'comments'");
            $stmt2->bind_param("s", $settings['comments']);
            $stmt2->execute();
            $stmt2->close();
        }
        if (array_key_exists('active', $settings)) {
            $stmt3 = $this->db->prepare("UPDATE `vb_meta` SET vb_value = ? WHERE vb_key = 'active'");
            $stmt3->bind_param("s", $settings['active']);
            $stmt3->execute();
            $stmt3->close();
        }
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
            $posts = isset($_GET['posts']) ? filter_var($_GET['posts'], FILTER_VALIDATE_INT) : 0;
            $size = count($this->getPosts($hidden));
            $offset = $posts * $this->posts_per_page;
            $currents = array_slice($this->getPosts($hidden), $offset, $this->posts_per_page);
            if ($this->currentpost < count($currents)) {
                global $post;
                $post = $this->constructPost($currents[$this->currentpost]->id);
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

    public function pageLinks($numbers = false, $next = "Next", $previous = "Previous", $first = "First", $last = "Last", $hidden = false)
    {
        if ($this->pagination) {
            $posts = isset($_GET['posts']) ? filter_var($_GET['posts'], FILTER_VALIDATE_INT) : 0;
            $size = count($this->getPosts($hidden));
            $max = floor($size / $this->posts_per_page);
            echo '<div class="page-links">';

            if ($posts > 0) {
                if ($posts - 1 > 0) {
                    if (!$numbers) {
                        echo "<a href='?posts=0'>1</a>";
                    } else {
                        echo "<a href='?posts=0'>$first</a>";
                    }
                }
                if (!$numbers) {
                    echo "<a href='?posts=".($posts - 1)."'>".($posts)."</a>";
                } else {
                    echo "<a href='?posts=".($posts - 1)."'>$previous</a>";
                }
            }

            echo "<a href='?posts=$posts'>" . ($posts + 1) . "</a>";

            if ($posts < $max) {
                if (!$numbers) {
                    echo "<a href='?posts=".($posts + 1)."'>" . ($posts + 2) . "</a>";
                } else {
                    echo "<a href='?posts=".($posts + 1)."'>$next</a>";
                }

                if ($posts + 1 < $max) {
                    if (!$numbers) {
                        echo "<a href='?posts=$max'>" . ($max + 1) . "</a>";
                    } else {
                        echo "<a href='?posts=$max'>$last</a>";
                    }
                }
            }

            echo '</div>';
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
