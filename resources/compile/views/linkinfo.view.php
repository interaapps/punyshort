@template(("header", ["title"=>"Welcome"]))!
<br><br><br><br>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>

<div class="contents">
    <h1>pnsh.ga/{[{$name}]} · ID: {[{$id}]}</h1>
    <p>PunyshortLink: <a href="/{[{$name}]}">pnsh.ga/{[{$name}]}</a><br>
    Real: <a href="{[{$link}]}">{[{$link}]}</a></p>

    <h4>Clicks</h4>
    <canvas id="clicks_chart" width="400" height="175"></canvas>

    <h4>Countries</h4>
    <canvas id="country_chart" width="400" height="175"></canvas>

    <h4>Operating Systems</h4>
    <canvas id="os_chart" width="400" height="175"></canvas>

    <h4>Browser</h4>
    <canvas id="browser_chart" width="400" height="175"></canvas>

</div>



<br><br><br><br><br><br><br><br>

<script>
function createChart(div, label, data, type="line"){

    var labels = [];
    var outData = [];

    for (singleLabel in data) {
        labels.push(singleLabel);
        outData.push(data[singleLabel]);
    }

    var ctx = document.getElementById(div).getContext('2d');
    var myChart = new Chart(ctx, {
    type: type,
    data: {
        labels: labels,
        datasets: [{
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
            borderWidth: 1
        }]
    }
    });
}

$(document).ready(function(){

    Cajax.get("/api/v2/getinformation/{[{$name}]}").then(function(response){
        const parsed = JSON.parse(response.responseText);

        createChart("clicks_chart", "Clicks", parsed.click);

        createChart("country_chart", "Countries", parsed.countries, "pie");

        createChart("os_chart", "OS", parsed.os, "pie");

        createChart("browser_chart", "Browser", parsed.browser, "pie");

    }).send();

});

</script>

@template(("footer"))!