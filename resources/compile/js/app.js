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


function editLink(id, link, name, domain, onAction){
    var editLinkAlert = new Alert({
        canexit: true,
        closebtn: true,
        title: "Add new link"
    });

    const linkInput = $n("input").attr("type", "text").addClass("flatInput").val(link).attr("placeholder", "Link");
    const customUrlInput = $n("input").attr("type", "text").val(name).addClass("flatInput").attr("readonly", "");
    const domainsInput = $n("input").attr("type", "text").val(domain).addClass("flatInput").attr("readonly", "");

    editLinkAlert.addHtml(linkInput)
        .addHtml(domainsInput)
        .addHtml(customUrlInput);

    editLinkAlert.addButton("EDIT", function () {
        Cajax.post("/dashboard/link/"+id+"/edit", {
            link: linkInput.val()
        }).then(function(res){
            const parsed = JSON.parse(res.responseText);
            if (parsed.done) {
                showSnackBar("Done");
                editLinkAlert.close();
                onAction();
            } else {
                showSnackBar("Error: "+parsed.error);
            }
        }).send();
    });

    editLinkAlert.addButton("DELETE", function () {
        Cajax.delete("/dashboard/link/"+id+"/delete").then(function(res){
            const parsed = JSON.parse(res.responseText);
            if (parsed.done) {
                showSnackBar("Done");
                editLinkAlert.close();
                onAction();
            } else {
                showSnackBar("Error: "+parsed.error);
            }
        }).send();
    });

    editLinkAlert.open();
}