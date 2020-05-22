<?php tmpl("header", ["title"=>"Dashboard"]); ?>

<div id="dashboard">
    <?php tmpl("dashboard/navigation"); ?>
    <div id="dashboardcontents">
        <h2 style="text-align: center;margin-top:60px;">Your Domains</h2>
        <div id="owndomains" class="datatable"></div>
    </div>
</div>

<script>
    createDataTable($("#owndomains"), ["id", "domain_name", "created"], "owndomains", function (dataTable) {
        dataTable.buttons = function (data, element) {
        };

        dataTable.render = function (data) {
            if (data.key === "facedto") {
                data.value = "("+data.value+") "+data.extraData.user;
            }
        };
    });
</script>

<?php tmpl("footer"); ?>