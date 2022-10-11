$('#divToRefresh').load('./load.php');

$(document).ready(function() {
    $.ajaxSetup({ cache: false });
    setInterval(function() {
        $('#divToRefresh').load('./load.php');
    }, 1500);
});