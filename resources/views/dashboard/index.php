<?php tmpl("header", ["title"=>"Dashboard"]); ?>

<div id="dashboard">
    <?php tmpl("dashboard/navigation"); ?>
    <div id="dashboardcontents">
        <h2 style="text-align: center;margin-top:100px;">Welcome, <?php echo (htmlspecialchars($user->username)); ?>!</h2>
        <h3>More will be added soon!</h3>
    </div>
</div>

<?php tmpl("footer"); ?>