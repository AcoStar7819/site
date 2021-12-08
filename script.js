let checkList = [];
let sumbitButton;
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

window.onload = function() {
    let userInfo = document.getElementById("userInfoForm").children;
    for (let i = 0; i < userInfo.length; i++)
    {
        if (userInfo[i].type == "submit")
        {
            sumbitButton = userInfo[i];
        }
        else if (userInfo[i].nodeName == "INPUT")
        {
            userInfo[i].addEventListener("change", UpdateSubmitButton);
            checkList.push(userInfo[i]);
        }
    }
}