# VB
"humble effort at a blog module"

# Available functions

get_title() returns the title of a specific post

get_content() returns the content of a specific post

get_date() returns the date of a specific post

get_author($id) returns authorname if id is not specified, otherwise returns author id (specific post)

get_thumb() returns thumbnail array

get_id() returns the post id

get_url() returns the post url

is_public() checks wether the post is published or not

addPost() adds a post, linking to $_post (title, content, thumb)

removePost() removes the specific post

updatePost() updates the specific post, linking to $_post (public, title, content, thumb)

createUser() creates a new user, linking to $_post (username, pass, passrepeat)

userExists() returns true if vb_user has any rows

auth() returns true if user is logged in
