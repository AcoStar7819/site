let checkList = document.querySelectorAll("#defaultForm input:not(input[type=submit])");
let sumbitButton = document.querySelector("#defaultForm input[type=submit]");

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

// TODO: Работает только если блок с формой на странице один