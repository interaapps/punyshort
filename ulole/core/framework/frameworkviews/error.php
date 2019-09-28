<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error :(</title>
</head>
<body>

    <div id="contents">
        <div id="side">
            <div id="errormessage">
                <?= htmlspecialchars($error) ?>
            </div>
            <div class="sidenavcontents">
                <a class="link_white" href="https://google.com/search?q=<?=urlencode("PHP ".$error)?>">Google</a> |
                <a class="link_white" href="https://duckduckgo.com/?q=<?=urlencode("PHP ".$error)?>">DuckDuckGo</a>
            </div>
        </div>

        <div id="inner">
            <pre id="code"><code><?php

                    $lines = [
                        ($line-17), ($line-16), ($line-15), ($line-14),  ($line-13),
                        ($line-12), ($line-11), ($line-10), ($line-9),  ($line-8),
                        ($line-7),  ($line-6),  ($line-5),  ($line-4),  ($line-3),
                        ($line-2),  ($line-1),  ($line),    ($line+1),  ($line+2),
                        ($line+3),  ($line+4),  ($line+5),  ($line+6),  ($line+7),
                        ($line+8),  ($line+9),  ($line+10), ($line+11), ($line+12),
                        ($line+12),  ($line+13),  ($line+14), ($line+15), ($line+16),
                    ];
                    $out = "";
                    foreach ($lines as $thisLine) {
                        if (isset($fileContentsLines[$thisLine])) {
                            $out .= "<p class='line' ".($thisLine==$line-1 ? "style='background: #ee5648; color: #FFFFFF'" : "").($thisLine==$line-2 || $thisLine==$line ? "style='background: #ee564808; color: #FFFFFF'" : "").">";
                            $out .= "<a class='rownum' href='#num_".$thisLine."'>".$thisLine."</a>";
                            $out .= htmlspecialchars($fileContentsLines[$thisLine])."\n";
                            $out .= "</p>";
                        }
                    }
                    echo $out;

                    ?></code></pre>
                    <div id="details">
                        <h3>Error Details</h3>
                        <p>Message: <?=$error?></p>
                        <p>Type: <?=$type?></p>
                        <p>File: <?=$file?></p>
                        <p>Line: <?=$line?></p>

                        <h3>Request details</h3>
                        <h4>Request header</h4>
                        <?php
                        echo str_replace("\n", "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", json_encode(getallheaders(), JSON_PRETTY_PRINT));
                        ?>

                        <h4>$_SERVER</h4>
                        <?php
                        echo str_replace("\n", "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", json_encode($_SERVER, JSON_PRETTY_PRINT));
                        ?>
                    </div>
        </div>
    </div>
    <p id="information">INFORMATION!: THIS IS JUST FOR DEVELOPMENT PURPOSES! IF YOU DONT WANT DEBUGGING SET "debug" IN THE "conf.json" to false!</p>
</body>
</html>



<style>

    * {
        margin: 0px;
        padding: 0px;
        font-family: sans-serif;
    }

    #code {
        background: #373737;
        color: #FFFFFF;
    }

    body,
    html {
        height: 100%;
    }

    #errormessage {
        background: #00000011;
        padding: 10px;
        color: #FFFFFF;
        font-size: 20px;
        display: block;
    }

    .sidenavcontents {
        padding: 10px;
        box-sizing: border-box;
        color: #FFFFFF;
    }

    #contents {
        display: flex;
        height: 100%;
        position: absolute;
        top: 0px;
        width: 100%;
    }

    #side {
        width: 25%;
        background: #616165;
        border-right: #373737 2px solid;
        border-bottom: #373737 2px solid;
        border-bottom-right-radius: 10px;
        height: 100%;
        box-sizing: border-box;
    }

    #inner {
        width: 75%;
        box-sizing: border-box;
        height: 100%;
    }

    .line {
        font-family: monospace;
    }

    .rownum {
        width: 40px;
        display: inline-block;
        background: #00000022;
        color: #FFFFFF !important;
        text-decoration: none !important;
        margin-right: 4px;
        font-family: monospace;
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;

    }

    #details {
        padding: 20px;
        box-sizing: border-box;
    }

    #information {
        width: 100%;
        position: fixed;
        bottom: 0px;
        left: 0px;
        background: #ee5648;
        color: #FFFFFF;
        text-align: center;
    }

    .link_black {
        color: #000000 !important;
        text-decoration: none !important;
    }

    .link_white {
        color: #FFFFFF !important;
        text-decoration: none !important;
    }

</style>
