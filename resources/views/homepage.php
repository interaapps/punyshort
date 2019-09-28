<?php tmpl("header", ["title"=>"Welcome"]); ?>
<div class="homepageimage">
    
    <div class="shortlink" id="shortlinkdiv">
        <input type="text" class="shortlinkinput" id="shortlinkinput" placeholder="https://pnsh.ga">
        <a class="noSelection shortlinksubmit" id="shortlinksubmit">Send</a>
    </div>

    <br><br><div class="shortlink" style="display: none" id="outputlink">
        <input readonly type="text" class="shortlinkinput" id="outputlinkinput">
        <a style="border-radius: initial" class="noSelection shortlinksubmit" id="outputlinkstats">Stats</a>
        <a class="noSelection shortlinksubmit" id="outputlinkcopy">Copy</a>
    </div>

    <p id="shortlinkerroralert" style="display: none; height: 0px">a</p>


</div>

<br><br><br><br>

<div class="contents">
    <h1>What?</h1>
    <p>PunyShort is a open source Linkshortener. You can easily short long links to a short one!</p>
</div>
<div style="text-align: center; margin-top: 40px; background: #1a1e27; color: #FFF; padding: 70px 0px; width: 100%; max-width: 100%;" class="contents">
    <h1>Open Source</h1><br>
    <p>Do you want to contribute and help? Or do you want transparency and look into the code? This project is open source!</p>
</div>
<!--
<div style="text-align: right; margin-top: 60px;" class="contents">
    <h1>Self hosted</h1>
    <p>Using Punyshort on my own server? Do it! You can download Punyshort and put it on your server!</p>
</div>
-->


<br><br><br><br><br><br><br><br>

<script>
    var link = {};

    /**
     * Not really clean but it works
     */
    function scrollUpAnimation() {
        if (window.scrollY != 0) {
            setTimeout(()=>{
                window.scrollTo(0, window.scrollY-10);
                scrollUpAnimation();
            }, 1);
        }
    }

    function showError(error) {
        $("#shortlinkerroralert").text(error);
        
        $("#shortlinkerroralert").css({
            display: "block",
            opacity: "0"
        });
        setTimeout(() => {
            $("#shortlinkerroralert").animate({
                height: "",
                opacity: 1
            }, 500);
        }, 500);
    }

    function hideError() {
        $("#shortlinkerroralert").animate({
            height: "0px",
            opacity: "0"
        }, 500);
        setTimeout(() => {
            $("#shortlinkerroralert").css("display", "none");
        }, 500);
    }
    
    $(document).ready(function(){
        $("#outputlink").hide();
        scrollPageYOffsetMin = 100;
        
        window.onscroll = function() {
            checkScroll();

            if (window.pageYOffset > 283 && window.innerWidth > 720) {
                $("#shortlinkdiv").css({
                    position: "fixed",
                    top: "3.3px",
                    left: "50%",
                    "width": "calc(100% - 500px)",
                    transform: "translateX(-50%)",
                    boxShadow: "0px 3px 5px 0px rgba(0,0,0,0.5)",
                    zIndex: "10001"
                });
            } else {
                $("#shortlinkdiv").css({
                    position: "",
                    top: "",
                    left: "",
                    "width": "",
                    transform: "",
                    boxShadow: "",
                    zIndex: "10001"
                });
            }
        };
        
        $("#shortlinksubmit").click(function() {
            if ($("#shortlinkinput").val() != "") {
                Cajax.post("/api/v2/short", {
                    link: $("#shortlinkinput").val()
                }).then((resp)=>{
                    link = JSON.parse(resp.responseText);
                    $("#outputlink").hide();
                    console.log(link.error);
                    if (link.error == 0) {
                        hideError();
                        $("#outputlink").show();
                        $("#outputlinkinput").val(link.full_link);
                    } else if (link.error == 1)
                        showError("Invalid Link");
                    else if (link.error == 2)
                        showError("Please input something");
                    else
                        showError("Internal error");
                    if (window.pageYOffset > 283) {
                        scrollUpAnimation();
                    }
                }).send();
            } else
                showError("Please input something");
        });

        $("#outputlinkcopy").click(function() {
            $("#outputlinkinput").elem[0].select();
            document.execCommand("copy");
        });

        $("#outputlinkstats").click(function() {
            window.location = "/info/"+link.link;
        });
    });
</script>

<style>
    .homepageimage {
        padding-top: 290px;
        padding-bottom: 490px;
        background: url("/assets/images/homepagebackground.svg");
        background-position-x: 0%;
        background-position-y: 0%;
        background-repeat: repeat;
        background-size: auto;
        background-position-x: 0%;
        background-position-y: 0%;
        background-repeat: repeat;
        background-size: auto;
        background-repeat: no-repeat;
        background-position: bottom;
        background-size: cover;
        padding-left: 13px;
        padding-right: 13px;
    }

    .nav_not_scrolled a,
    .nav_not_scrolled a:link,
    .nav_not_scrolled a:visited {
        color: #FFFFFF;
    }
    
    #shortlinkerroralert {
        background: #ed3e3e;
        color: #FFFFFF;
        padding: 10px 20px;
        max-width: 960px;
        border-radius: 10px;
        margin: 0px auto;
        box-sizing: border-box;
    }

</style>

<?php tmpl("footer", ["title"=>"V1"]); ?>