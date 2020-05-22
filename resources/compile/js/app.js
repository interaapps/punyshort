let scrollPageYOffsetMin = 1;

function checkScroll() {
    if (window.pageYOffset > scrollPageYOffsetMin) {
        $("#nav").addClass("nav_scrolled");
        $("#nav").removeClass("nav_not_scrolled");
    } else {
        $("#nav").removeClass("nav_scrolled");
        $("#nav").addClass("nav_not_scrolled");
    }
}

function copyStringToClipboard(str) {
    var el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.style = {display: none};
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
 }

$(document).ready(function() {
    
    window.onscroll = function() {
        checkScroll();
    };
    checkScroll();


});

var snackBarTimeout;
  
function showSnackBar(text, color="#17fc2e", background="#1e212b") {
    var snackbar = document.querySelector('#snackbar');
    snackbar.textContent = text;
    snackbar.style.color = color;
    snackbar.style.backgroundColor = background;
    snackbar.classList.add('show');
    clearTimeout(snackBarTimeout);
    snackBarTimeout = setTimeout(() => {
        snackbar.classList.remove('show');
    }, 1500);
}



$(window).on("online", function(){
    showSnackBar("You are online!");
});

$(window).on("offline", function(){
    showSnackBar("You are offline!", "#fa1121");
});