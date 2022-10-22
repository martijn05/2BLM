var html = document.documentElement;

var htmlHeight = html.offsetHeight;
var screenHeight = screen.height;

var chatItemsHeight = screenHeight - 300;

document.getElementById("partners").style.height = chatItemsHeight + "px";
document.getElementById("divToRefresh").style.height = (chatItemsHeight - 230) + "px";