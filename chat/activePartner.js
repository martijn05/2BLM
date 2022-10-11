var partnerButtons = document.getElementsByClassName("partner_btn");

for (let index = 1; index <= partnerButtons.length; index++) {
    var button = document.getElementById("chat_knop_" + index);
    button.addEventListener('click', function() {
        allUnactive();
        this.classList.add("active");

        waitForElement("#divToRefresh", function() {
            $("#divToRefresh").scrollTop($("#divToRefresh")[0].scrollHeight);
        });
    })
}

function allUnactive() {
    for (let index = 1; index <= partnerButtons.length; index++) {
        var button = document.getElementById("chat_knop_" + index);
        button.classList.remove("active");
    }
}

allUnactive();

function waitForElement(elementPath, callBack) {
    window.setTimeout(function() {
        if ($(elementPath).length) {
            callBack(elementPath, $(elementPath));
        } else {
            waitForElement(elementPath, callBack);
        }
    }, 500)
}