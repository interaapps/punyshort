@template(("header", ["title"=>"Welcome"]))!
<div class="homepageimage">
    
    <div class="shortlink" id="shortlinkdiv">
        <input type="text" class="shortlinkinput" id="shortlinkinput" placeholder="https://example.interaapps.de">
        <select id="shortlinkdomain">
            @foreach(($domains as $domain))#
                <option @if(($_SERVER['SERVER_NAME'] == $domain["domain_name"]))#selected@endif value="{{$domain["domain_name"]}}">{{$domain["domain_name"]}}</option>
            @endforeach
        </select>
        <a class="noSelection shortlinksubmit" id="shortlinksubmit">Send</a>
    </div>

    <br><br><div class="shortlink" style="display: none" id="outputlink">
        <input readonly type="text" class="shortlinkinput" id="outputlinkinput">
        <a style="border-radius: initial" class="noSelection shortlinksubmit" id="outputlinkstats">Stats</a>
        <a class="noSelection shortlinksubmit" id="outputlinkcopy">Copy</a>
    </div>

    <p id="shortlinkerroralert" style="display: none; height: 0px">a</p>


</div>

<div class="sectioned-part" id="whats-punyshort">
    <div>
        <h1>What is punyshort?</h1>
        <p>
            PunyShort is an open source Linkshortener, with which can short huge links in to a tiny one!<br>   
            You want to track the clicks on the link? No problem! It is also possible. 
            You can track non-user-related data like the country, browser and the time with which/when the user clicked on the link!
        </p>
    </div>
    <img id="top-what-is-punyshort-image" src="/assets/images/illustrations/linkshortener.svg">
</div>



<div style="width: 100%; background: #1a1e27EE; padding: 20px 0px;">
    <h1 style="text-align: center; color: #FFFFFF; display: block; margin: 30px 0px;">Features</h1>
    <div id="features-list">
        <div style="margin-top: 45px;">
            <img src="/assets/images/illustrations/domains.svg">
            <h5>Custom Brand URLs</h5>
            <span>Use your own domain to create custom shorten urls like go.interaapps.de/donate</span>
        </div>
        <div>
            <img src="/assets/images/illustrations/stats.svg">
            <h5>Statistics</h5>
            <span>Track the non-user-specific data like the date when he visited, the browser, the estimated country and operating system.</span>
        </div>
        <div style="margin-top: 15px;">
            <img src="/assets/images/illustrations/socialgrowth.svg">
            <h5>Share</h5>
            <span>Share it on social media and get better results. People do more often click on shorten links.</span>
        </div>
    </div>
</div>

<div style="text-align: center; margin-top: 40px; padding: 70px 0px; width: 100%; max-width: 100%;" class="contents">
    <h1>Open Source</h1><br>
    <p>
        Do you want to contribute and help? Or do you want transparency and look into the code? This project is open source!
        <br>If you want to contribute stuff, than you should check out <a href="https://github.com/interaapps/punyshort">Our GitHub page</a>. 
    </p>
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
                $(".homepageimage").css("marginTop", "43px");
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
                $(".homepageimage").css("marginTop", "");
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

            if (window.pageYOffset > scrollPageYOffsetMin) {
                $("#logo img").attr("src", "/assets/images/icons/icon.svg");
            } else {
                $("#logo img").attr("src", "/assets/images/icons/light-icon.svg");
            }
        };
        
        $("#shortlinksubmit").click(function() {
            if ($("#shortlinkinput").val() != "") {
                Cajax.post("/api/v2/short", {
                    link: $("#shortlinkinput").val(),
                    domain: $("#shortlinkdomain").val()
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
            window.location = link.full_link+"/info";
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

    .sectioned-part {
        display: flex;
        width: 80%;
        margin: 120px auto;
    }

    .sectioned-part img {
        width: 350px;
        max-width: 30%;
        margin-right: 40px;
    }

    #top-what-is-punyshort-image {
        width: 350px;
    }

    #whats-punyshort div {
        padding-top: 100px;
    }

    #features-list {
        display: flex;
        width: fit-content;
        margin: auto;
    }

    #features-list div {
        display: block;
        margin: 0px 30px;
        text-align: center;
        color: #FFFFFF;
        text-decoration: none;
        padding: 10px 20px;
        width: 200px;
    }

    #features-list div img {
        display: block;
        width: 200px;
        margin-bottom: 40px;
    }

    #features-list div span {
        font-size: 20px;
    }

    #features-list div h5 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #FFFFFFDD;
    }

    @media screen and (max-width: 720px) {
        #features-list {
            display: block;
        }

        #features-list div {
            display: block;
            margin: 30px 0px;
            width: 90%;
        }

        #features-list div img {
            margin: auto;
            width: 65%;
        }

        #top-what-is-punyshort-image {
            display: none;
        }
    }

</style>

@template(("footer", ["title"=>"V1"]))!