let username;
let age;
let date;
let submit;
function UpdateSubmitButton() {
    if (username.value == "" || age.value == "" || date.value == "")
    {
        submit.disabled = true;
    }
    else
    {
        submit.disabled = false;
    }
}

window.onload = function() {
    username = document.getElementById("name");
    age = document.getElementById("age");
    submit = document.getElementById("submit");
    date = document.getElementById("date");

    username.addEventListener("change", UpdateSubmitButton);
    age.addEventListener("change", UpdateSubmitButton);
    date.addEventListener("change", UpdateSubmitButton);
}