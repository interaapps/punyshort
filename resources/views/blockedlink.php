<?php tmpl("header", ["title"=>"Welcome"]); ?>

<br><br><br><br>

<div class="contents">
    <h1>Stop!</h1>
    <p>This links redirection has been blocked by our Team, because of one of this reasons:</p>
    <ul>
        <li>Scam
            <ul>
                <li>Phishing</li>
                <li>Pornographic scam</li>
            </ul>
        </li>
        <li>Viruses</li>
        <li>Illegal page</li>
    </ul>

    <p>If you anyway want to go to this link: <a href="<?php echo (htmlspecialchars($link)); ?>"><?php echo (htmlspecialchars($link)); ?></a></p>
</div>



<br><br><br><br><br><br><br><br>


<?php tmpl("footer", ["title"=>"V1"]); ?>