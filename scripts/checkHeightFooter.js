var html = document.documentElement;
var ftr = document.getElementById("footer");

var htmlHeight = html.offsetHeight;
var screenHeight = screen.height;

if (htmlHeight < screenHeight) {
    ftr.style.position = "absolute";
    ftr.style.width = "100%";
    ftr.style.bottom = 0;
} else {
    ftr.style.position = "relative";
}