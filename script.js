let checkList = document.querySelectorAll("#userInfoForm input:not(input[type=submit])");
let sumbitButton = document.querySelector("#userInfoForm input[type=submit]");

function UpdateSubmitButton() {
    for (let i = 0; i < checkList.length; i++)
    {
        if (checkList[i].value == "")
        {
            sumbitButton.disabled = true;
            return;
        }
    }
    sumbitButton.disabled = false;
}

for (let i = 0; i < checkList.length; i++)
{
    checkList[i].addEventListener("change", UpdateSubmitButton);
}