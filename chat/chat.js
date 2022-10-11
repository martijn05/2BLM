function setSession(variable, value) {
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../setSession.php?variable=" + variable + "&value=" + value, true);
    xmlhttp.send();
}

function setActive(idRec) {
    var partnerButtons = document.getElementsByClassName("partner_btn");

    for (let index = 1; index <= partnerButtons.length; index++) {
        var button = document.getElementById("chat_knop_" + index);
        if (button.getAttribute("value") == idRec) {
            button.classList.add("active");
        }
    }
}
