@template(("header", ["title"=>"Dashboard"]))!

<div id="dashboard">
    @template(("dashboard/navigation"))!
    <div id="dashboardcontents">
        <h2 style="text-align: center;margin-top:100px;">Welcome, {{htmlspecialchars($user->username)}}!</h2>
        <h3>More will be added soon!</h3>
    </div>
</div>

@template(("footer"))!