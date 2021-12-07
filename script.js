
function UpdateSubmitButton() {
    if (name.value == "" || age.value == "")
    {
        submit.disabled = true;
    }
    else
    {
        submit.disabled = false;
    }
}

window.onload = function() {
    var name = document.getElementById("name");
    var age = document.getElementById("age");
    var submit = document.getElementById("submit");
    name.addEventListener("change", UpdateSubmitButton);
    age.addEventListener("change", UpdateSubmitButton);
}