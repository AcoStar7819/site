let checkList = document.querySelectorAll("#defaultForm input:not(input[type=submit])");
let sumbitButton = document.querySelector("#defaultForm input[type=submit]");

function UpdateSubmitButton(button, checkList) {
    for (let i = 0; i < checkList.length; i++)
    {
        if (checkList[i].value == "")
        {
            button.disabled = true;
            return;
        }
    }
    button.disabled = false;
}

for (let i = 0; i < checkList.length; i++)
{
    checkList[i].addEventListener("change", function (){
        UpdateSubmitButton(sumbitButton, checkList);
    });
}