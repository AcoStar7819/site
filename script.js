let username;
let age;
let submit;
function UpdateSubmitButton() {
    if (username.value == "" || age.value == "")
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
    
    username.addEventListener("change", UpdateSubmitButton);
    age.addEventListener("change", UpdateSubmitButton);
}