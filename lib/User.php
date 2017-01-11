<?php

class User
{
    protected $id;
    protected $name;
    protected $status;
    protected $postcount;
    protected $loggedIn = false;

    // autoconstruct
    public function __construct()
    {
        $this->name = $_SESSION['username'] ? $_SESSION['username'] : null;
        $this->id = $_SESSION['id'] ? $_SESSION['id'] : null;
        $this->loggedIn = (isset($_SESSION['username'])) ? true : false;
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

    // log out
    public function logOut()
    {
        session_unset();
        session_destroy();
        $this->loggedIn = false;
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

        $pass = password_hash($pass, PASSWORD_DEFAULT);

        // check if username already exist
        $sql = "SELECT * FROM `vb_user` WHERE name = '$username'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return false;
        }
        $result->free();

        // proceed to add user
        $stmt = $db->prepare("INSERT INTO `vb_user` (name, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $pass);
        if ($stmt->execute()) {
            $last = $db->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $last;
            // success, redirect to welcome page
            header("Location: ../admin/");
        }
        $stmt->close();
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
