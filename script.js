function UpdateSubmitButton() {
    let name = document.getElementById("name");
    let age = document.getElementById("age");
    let submit = document.getElementById("submit");
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
    document.getElementById("name").addEventListener("change", UpdateSubmitButton);
    document.getElementById("age").addEventListener("change", UpdateSubmitButton);
}