document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").onsubmit = function () {
        let username = document.querySelector("input[name='username']").value;
        let password = document.querySelector("input[name='password']").value;
        
        if (username.length < 3 || password.length < 6) {
            alert("Username must be at least 3 characters & password 6 characters.");
            return false;
        }
        return true;
    };
});
