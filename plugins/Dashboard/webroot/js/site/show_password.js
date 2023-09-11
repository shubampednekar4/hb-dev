"use strict";

function myFunction() {
    let x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

const button = document.getElementById('showPassword');
button.addEventListener('click', function () {
    myFunction();
});