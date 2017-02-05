<?php

class User
{
    protected $id;
    protected $name;
    protected $age;
    protected $city;
    protected $bio;
    protected $status;
    protected $aliases;
    protected $website;
    protected $postcount = 0;
    protected $loggedIn = false;

    // autoconstruct
    public function __construct()
    {
        $this->name = isset($_SESSION['username']) ? $_SESSION['username'] : null;
        $this->id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $this->loggedIn = (isset($_SESSION['username'])) ? true : false;
        $this->setPostCount();
        $this->setInfo();
    }

    // getters
    public function getID()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getPostCount()
    {
        return $this->postcount;
    }

    public function isAuth()
    {
        return $this->loggedIn;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getAliases()
    {
        return $this->aliases;
    }

    public function getBio()
    {
        return $this->bio;
    }

    // log out
    public function logOut()
    {
        session_unset();
        session_destroy();
        $this->loggedIn = false;
    }

    public function setInfo()
    {
        if (!isset($this->id)) {
            return false;
        } else {
            global $db;
            $sql = "SELECT * FROM `vb_user` WHERE id = $this->id";
            $result = $db->query($sql);
            if ($result->num_rows == 0) {
                return false;
            }
            $row = $result->fetch_assoc();
            $this->website = $row['website'];
            $this->age = $row['age'];
            $this->city = $row['city'];
            $this->aliases = explode(",", $row['aliases']);
            $this->bio = $row['bio'];
            $result->free();
            return true;
        }
    }

    public function setPostCount()
    {
        if ($this->loggedIn) {
            global $db;
            $sql = "SELECT id FROM `vb_post` WHERE authorID = $this->id";
            $result = $db->query($sql);
            $this->postcount = $result->num_rows;
            $result->free();
        }
    }

    public function setPassword($old, $new)
    {
        global $db;

        $old = trim($old);
        $new = trim($new);

        $sql = "SELECT password FROM `vb_user` WHERE id = ".$this->getID();
        $result = $db->query($sql);
        $row = $result->fetch_object();

        if (!password_verify($old, $row->password)) {
            return false;
        }
        $result->free();

        $stmt = $db->prepare("UPDATE `vb_user` SET password = ? WHERE id = ".$this->getID());
        $stmt->bind_param("s", $new);
        $new = password_hash($new, PASSWORD_DEFAULT);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function updateUserFromAdminPage(array $form)
    {
        $needs = array("age", "city", "website", "bio", "username");
        foreach ($needs as $key) {
            if (!array_key_exists($key, $form)) {
                return false;
            }
        }
        global $db;
        $stmt = $db->prepare("UPDATE `vb_user` SET age = ?, city = ?, website = ?, bio = ?, name = ? WHERE id = ?");
        $stmt->bind_param("issssi", $form['age'], $form['city'], $form['website'], $form['bio'], $form['username'], $this->id);
        if ($stmt->execute()) {
            $stmt->close();
            $_SESSION['username'] = $form['username'];
            $this->updateUserName($form['username']);
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function updateUserName($new)
    {
        global $db;
        $stmt = $db->prepare("UPDATE `vb_post` SET authorName = ? WHERE authorID = ?");
        $stmt->bind_param("si", $new, $this->id);
        $stmt->execute();
        $stmt->close();
        $this->updateAliases($new);
    }

    public function updateAliases($new)
    {
        if (!in_array($new, $this->aliases)) {
            global $db;
            $this->aliases[] = $new;
            $stmt = $db->prepare("UPDATE `vb_user` SET aliases = ? WHERE id = ?");
            $stmt->bind_param("si", $alias, $this->id);
            $alias = implode(",", $this->aliases);
            $stmt->execute();
            $stmt->close();
            return true;
        }
    }

    // STATICS

    // create user
    public static function createUser($username, $pass, $passrepeat)
    {
        global $db;

        if ($pass != $passrepeat) {
            return false;
        }
        // validate
        $username = trim($username);
        $pass = trim($pass);

        $username = htmlspecialchars($username);
        $pass = htmlspecialchars($pass);

        if (strlen($pass) < 5) {
            return false;
            exit;
        }

        if (strlen($username) < 4) {
            return false;
            exit;
        }

        $pass = password_hash($pass, PASSWORD_DEFAULT);

        // check if username already exist
        $sql = "SELECT * FROM `vb_user` WHERE name = '$username'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return false;
            exit;
        }
        $result->free();

        // proceed to add user
        $stmt = $db->prepare("INSERT INTO `vb_user` (name, password, aliases) VALUES (?, ?, ?)");
        $stmt->bind_param("ss", $username, $pass, $username);
        if ($stmt->execute()) {
            $last = $db->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $last;
            // success, redirect to welcome page
            header("Location: ../admin/");
        }
        $stmt->close();
        return true;
    }

    // login
    public static function login($username, $pass)
    {
        global $db;

        $username = trim($username);
        $pass = trim($pass);

        $username = htmlspecialchars($username);
        $pass = htmlspecialchars($pass);

        $sql = "SELECT * FROM `vb_user` WHERE name = '$username'";
        $result = $db->query($sql);
        if ($result->num_rows == 0) {
            return false;
        }
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['name'];
            return true;
        } else {
            return false;
        }
    }
}
