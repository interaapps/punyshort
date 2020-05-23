@template(("header", ["title"=>"Dashboard"]))!

<div id="dashboard">
    @template(("dashboard/navigation"))!
    <div id="dashboardcontents">
        <h2 style="text-align: center;margin-top:60px;">Your Links</h2>
        <a id="addlink" class="button">Add a link</a><br><br>
        <div id="ownlinks" class="datatable"></div>
    </div>
</div>

<script>
    let outerDataTable;
    createDataTable($("#ownlinks"), ["id", "domain", "name", "link", "clicks", "created"], "ownlinks", function (dataTable) {

        dataTable.options.limit = 20;
        dataTable.buttons = function (data, element) {
            element
                .append($n("a").addClass("button")
                    .text("stats")
                    .css({
                        background: "rgb(43, 202, 170)",
                        padding: "4px 14px",
                        marginRight: "5px"
                    }).attr("target", "_blank").attr("href", "/info/"+data.values.name+"?domain="+data.values.domain))
                .append($n("a").addClass("button")
                    .text("edit")
                    .css({
                        background: "rgb(51, 127, 255)",
                        padding: "4px 14px"
                    })
                    .click(() => {
                        var editLinkAlert = new Alert({
                            canexit: true,
                            closebtn: true,
                            title: "Add new link"
                        });

                        const linkInput = $n("input").attr("type", "text").addClass("flatInput").val(data.values.link).attr("placeholder", "Link");
                        const customUrlInput = $n("input").attr("type", "text").val(data.values.name).addClass("flatInput").attr("readonly", "");
                        const domainsInput = $n("input").attr("type", "text").val(data.values.domain).addClass("flatInput").attr("readonly", "");

                        editLinkAlert.addHtml(linkInput)
                            .addHtml(domainsInput)
                            .addHtml(customUrlInput);

                        editLinkAlert.addButton("EDIT", function () {
                            Cajax.post("/dashboard/link/"+data.values.id+"/edit", {
                                link: linkInput.val()
                            }).then(function(res){
                                const parsed = JSON.parse(res.responseText);
                                if (parsed.done) {
                                    showSnackBar("Done");
                                    editLinkAlert.close();
                                    dataTable.load();
                                } else {
                                    showSnackBar("Error: "+parsed.error);
                                }
                            }).send();
                        });

                        editLinkAlert.addButton("DELETE", function () {
                            Cajax.delete("/dashboard/link/"+data.values.id+"/delete").then(function(res){
                                const parsed = JSON.parse(res.responseText);
                                if (parsed.done) {
                                    showSnackBar("Done");
                                    editLinkAlert.close();
                                    dataTable.load();
                                } else {
                                    showSnackBar("Error: "+parsed.error);
                                }
                            }).send();
                        });

                        editLinkAlert.open();
                    }));
        };

        dataTable.render = function (data) {
        };
        outerDataTable = dataTable;
    });

        var addLinkAlert = new Alert({
            canexit: true,
            closebtn: true,
            title: "Add new link"
        });

        const linkInput = $n("input").attr("type", "text").addClass("flatInput").attr("placeholder", "Link");
        const customUrlInput = $n("input").attr("type", "text").addClass("flatInput").attr("placeholder", "Custom URL (Optional)");
        const domainsInput = $n("select").attr("type", "text").addClass("flatInput").attr("placeholder", "Domain");

        Cajax.get("/dashboard/api/getdomains").then((res)=>{
            const parsed = JSON.parse(res.responseText);

            for (let link in parsed) {
                const element = $n("option").text(parsed[link].domain).val(parsed[link].domain);
                if (parsed[link].customUrl)
                    element.attr("customUrl", "false");
                else
                    element.attr("customUrl", "true");
                domainsInput.append(element);
            }
        }).send();

        addLinkAlert.addHtml(linkInput)
            .addHtml(domainsInput)
            .addHtml(customUrlInput);

        addLinkAlert.addButton("ADD", function () {
            Cajax.post("/api/v2/short", {
                link: linkInput.val(),
                domain: domainsInput.val(),
                name: customUrlInput.val()
            }).then((res)=>{
                const parsed = JSON.parse(res.responseText);
                if (parsed.error == 0) {
                    outerDataTable.load();
                    showSnackBar("Done");
                    addLinkAlert.close();


                    var newLinkAddedAlert = new Alert({
                        canexit: true,
                        closebtn: true,
                        title: "Link"
                    });

                    newLinkAddedAlert.addHtml($n("input").attr("type", "text").val(parsed.full_link).addClass("flatInput").attr("readonly", "")
                        .click(function(){
                            this.select();
                            document.execCommand("copy");
                            showSnackBar("Copied "+parsed.full_link);
                        }));
                    newLinkAddedAlert.open();
                } else {
                    showSnackBar("Error while creating link. Error-Code: "+parsed.error, "#FF3333");
                }
            }).send();
        });


        $("#addlink").click(function(){
            addLinkAlert.open();
        });
</script>

<style>
   .datatable-value-td-clicks {
        text-align: center;
   }

   .datatable-value-td-created {
        text-align: center;
   }
</style>

@template(("footer"))!