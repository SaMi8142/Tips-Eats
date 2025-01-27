var alr_clicked = false;

function popup_logout() {
    var popup = document.getElementById("popuplogout");
    if (alr_clicked == false) {
        popup.style.display = "block";
        alr_clicked = true;
    } else {
        popup.style.display = "none";
        alr_clicked = false;
    }
}