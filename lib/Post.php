<?php

class Post {
	protected $title;
	protected $content;
	protected $date;
	protected $thumb;
	protected $authorID;
	protected $authorName;
	protected $id;
	protected $public;

	// autoconstruct
	function __construct($id) {
		global $db;

		$sql = "SELECT * FROM `VB_post` WHERE id = $id";
		$result = $db->query($sql);
		if ($result->num_rows == 0) {
			return;
		} else {
			$row = $result->fetch_assoc();
			$this->title = $row['title'];
			$this->content = $row['content'];
			$this->date = $row['date'];
			$this->thumb = $row['thumb'];
			$this->authorID = $row['authorID'];
			$this->authorName = $row['authorName'];
			$this->id = $row['id'];
			$this->public = $row['public'];
		}
		$result->free();
	}

	// getters
	public function getTitle() {
		return $this->title;
	}

	public function getContent() {
		return $this->content;
	}

	public function getDate() {
		return $this->date;
	}

	public function getThumb() {
		return $this->thumb;
	}

	public function getAuthorID() {
		return $this->authorID;
	}

	public function getAuthorName() {
		return $this->authorName;
	}

	public function getID() {
		return $this->id;
	}

	public function getPublic() {
		return $this->public;
	}

	public function removePost($id) {
		global $db;

		$sql = "DELETE FROM `vb_post` WHERE id = $id";
		if($db->query($sql)) {
			// success
			header("Location: index.php");
		} else {
			return false;
		}
	}

	public function updatePost($id, $public, $title, $content, $thumb = null) {
		global $db;
		
		$title = trim($title);
		$content = trim($content);

		$title = htmlspecialchars($title);

		$thumb = $thumb['tmp_name'];
		$thumb = htmlspecialchars($thumb);
		$thumb = trim($thumb);

		$stmt = $db->prepare("UPDATE `vb_post` SET public = ?, title = ?, content = ?, thumb = ? WHERE id=?");
		$stmt->bind_param("isssi", $public, $title, $content, $thumb, $id);
		if ($stmt->execute()); {
			// success
			$last = $db->insert_id;
			$stmt->close();
			header("Location: index.php");
		}
	}

	// STATICS

	// return all
	public static function getFeed($public = null, $order = "DESC") {
		global $db;

		$insert = " WHERE public = 1";
		if ($public == "all") $insert = "";
		$sql = "SELECT * FROM `vb_post`".$insert." ORDER BY id $order";
		$result = $db->query($sql);
		if ($result->num_rows == 0) {
			echo "<p>No posts yet.</p>";
		} else {
			while($row = $result->fetch_assoc()) {
				yield $row;
			}
		}
		$result->free();
		
	}

	// add post
	public static function addPost($public, $title, $content, $thumb = null) {
		global $db;

		$title = trim($title);
		$content = trim($content);

		$title = htmlspecialchars($title);

		$thumb = $thumb['tmp_name'];
		$thumb = htmlspecialchars($thumb);
		$thumb = trim($thumb);

		$authorName = $_SESSION['username'];
		$authorID = $_SESSION['id'];

		if (strlen($title) < 2 || strlen($content) < 10) return false;

		$stmt = $db->prepare("INSERT INTO `vb_post` (public, title, content, authorName, authorID, thumb) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("isssis", $public, $title, $content, $authorName, $authorID, $thumb);
		
		if($stmt->execute()) {
			// success
			$last = $db->insert_id;
			$stmt->close();
			header("Location: ../index.php?id=".$last);
		}

	}

}

?>