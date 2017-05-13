document.getElementById("testConnection")
    .addEventListener("click", function(e) {
        e.preventDefault();
        var data = {
            host: document.getElementById('host')
                .value,
            username: document.getElementById('username')
                .value,
            password: document.getElementById('password')
                .value,
            name: document.getElementById('name')
                .value
        }
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (this.readyState === 4) {
                console.log(xhr.response);
            }
        }

        xhr.open('POST', '/install/test', true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(JSON.stringify(data));
    });