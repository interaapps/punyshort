@template(("header", ["title"=>"Welcome"]))!
<br><br><br><br>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.2/Chart.bundle.js"></script>
@if((app\classes\user\IaAuth::loggedIn() && \app\classes\user\User::$user->id == $userid))#
<div id="dashboard">
    @template(("dashboard/navigation"))!
@endif

    <div class="contents">
        @if((app\classes\user\IaAuth::loggedIn() && \app\classes\user\User::$user->id == $userid))#
            <a style="float: right" id="edit-btn" class="button">Edit</a>
        @endif
        <h1>{{$domain}}/{[{$name}]} · ID: {[{$id}]}</h1>
        <p>
            Created: {{$created}}<br>
            PunyshortLink: <a href="https://{{$domain}}/{[{$name}]}">{{$domain}}/{[{$name}]}</a><br>
            Real (Hover for full link):<br> <a  href="{[{$link}]}" id="real-clicks">{[{$link}]}</a><br>

        </p>


        <h3>Clicks | Total: <span id="total-clicks">0</span></h3>
        <canvas id="clicks_chart" width="400" height="200"></canvas>
        <div class="dual-charts">
            <div>
                <h3>Countries</h3>
                <canvas id="country_chart" width="400" height="300"></canvas>
            </div>
        </div>

        <div class="dual-charts">
            <div>
                <h3>Operating Systems</h3>
                <canvas id="os_chart" width="400" height="300"></canvas>
            </div>
            <div>
                <h3>Browser</h3>
                <canvas id="browser_chart" width="400" height="300"></canvas>
            </div>
        </div>
        <br><br>
        <br><br>
        <h3>QR-Code</h3>
        <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{urlencode("https://".$domain."/".$name)}}&chld=L|1&choe=UTF-8" alt="">
    </div>

@if((app\classes\user\IaAuth::loggedIn() && \app\classes\user\User::$user->id == $userid))#
</div>
@endif


<br><br><br><br><br><br><br><br>

<script>
function createChart(div, label, data, type="line", options = {}){

    var labels = [];
    var outData = [];

    for (singleLabel in data) {
        labels.push(singleLabel);
        outData.push(data[singleLabel]);
    }

    var ctx = document.getElementById(div).getContext('2d');
    var myChart = new Chart(ctx, {
    type: type,
    options: {
        responsive: true,
        
    },
    data: {
        labels: labels,
        datasets: [{...({
            label: label,
            data: outData,
            backgroundColor: [
                '#fb174066',
                "#6603fc66",
                "#22abf066",
                "#f0225666",
                "#e6db1c66",
                "#f0632266",
                "#22f03366",
                "#e622f066",
                "#f0222266"
            ],
            borderColor: [
                '#fb1740',
                "#6603fc",
                "#22abf0",
                "#f02256",
                "#e6db1c",
                "#f06322",
                "#22f033",
                "#e622f0",
                "#f02222"
            ],
            borderWidth: 3
        }), ...options}]
    }
    });
}

$(document).ready(function(){

    Cajax.get("/api/v2/getinformation/{[{$name}]}", {
        domain: "{{$domain}}"
    }).then(function(response){
        const parsed = JSON.parse(response.responseText);
        $("#total-clicks").text(parsed.clicks);


        createChart("clicks_chart", "Clicks", parsed.click, "line", {borderColor: "#FF4543", fill: false, borderWidth: 4});

        createChart("country_chart", "Countries", parsed.countries, "pie");

        createChart("os_chart", "OS", parsed.os, "pie");

        createChart("browser_chart", "Browser", parsed.browser, "pie");

        $("#edit-btn").click(function(){
            editLink(parsed.id, parsed.link, parsed.url, parsed.domain, function(){window.location = "";});
        });
    }).send();

});

</script>

<style>
    .dual-charts {
        display: flex;
    }

    .dual-charts div {
        width: 48%;
        padding: 1%;
    }

    #real-clicks {
        max-width: 100%;
        color: red;
        text-overflow: ellipsis;
        overflow: hidden;
        display: inline-block;
        white-space: pre;
    }

    #real-clicks:hover {
        white-space: break-spaces;
    }

    @media screen and (max-width: 720px) {
        .dual-charts {
            display: block;
        }

        .dual-charts div {
            width: 100%;
            padding: 0px;
        }
    }
</style>

@template(("footer"))!