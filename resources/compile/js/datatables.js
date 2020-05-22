class RowData {
    htmlEncode = true;
    key = "";
    value = "";
    extraData = {};
    column = {values:{}, extraData:{}};
}

class DataTable {
    element;
    thead;
    tbody;

    databaseRows = [];

    options = {
        table: "",
        limit: 10,
        sortBy: "",
        sortDesc: "false",
        search: "",
        page: 0
    };

    elements = {
        rowNum: null,
        pageRowNum: null,
        searchInput: null,
        nextPage: null,
        previousPage: null,
        pagesIndicator: null,
        currentPage: null,
        entriesIndicator: null,
        rowsPerPage: null
    };

    pages = 1;

    render = function(data){};

    buttons = function(data, element){}

    constructor(element, rows) {
        this.databaseRows = rows;
        this.element = element;
    }

    load(){

        Cajax.get("/datatable", this.options).then((res)=>{
            const parsed = JSON.parse(res.responseText);
            this.tbody.html("");
            for (let column in parsed.data) {
                let tr = $n("tr");

                for (let databaseRow in this.databaseRows) {
                    let rowData = new RowData();
                    rowData.column = parsed.data[column];
                    rowData.extraData = parsed.data[column].extra;
                    rowData.key = this.databaseRows[databaseRow];
                    rowData.value = parsed.data[column].values[this.databaseRows[databaseRow]];
                    this.render(rowData);
                    tr.append(
                        rowData.htmlEncode ? $n("td").text(rowData.value) : $n("td").html(rowData.value)
                    );
                }


                let buttonsElem = $n("td").addClass("dt-buttons");
                this.buttons(parsed.data[column], buttonsElem);
                tr.append(buttonsElem);

                this.tbody.append(tr);
            }
            if (this.elements.pageRowNum !== null)
                this.elements.pageRowNum.text(parsed.pageRowNum);
            if (this.elements.rowNum !== null)
                this.elements.rowNum.text(parsed.count);

            let tabCount = Math.ceil(parsed.count/this.options.limit);

            if (this.elements.pagesIndicator !== null)
                this.elements.pagesIndicator.text(tabCount);

            if (this.elements.currentPage !== null)
                this.elements.currentPage.text(this.options.page+1);

            if (this.elements.entriesIndicator !== null)
                this.elements.entriesIndicator.text(parsed.count);

            this.pages = tabCount;
        }).send();
    }

    init(){
        this.thead = $n("thead");
        this.tbody = $n("tbody");

        for (let databaseRow in this.databaseRows) {
            let _this = this;
            this.thead.append($n("th")
                .text(this.databaseRows[databaseRow])
                .click(function(){
                    _this.options.sortBy = _this.databaseRows[databaseRow];
                    _this.load();
                    if (_this.options.sortBy == _this.databaseRows[databaseRow]) {
                        _this.options.sortDesc = _this.options.sortDesc == "false" ? "true" : "false";
                        console.log($(this).$(".select-indicator").text());
                        _this.thead.$(".select-indicator").text("");
                        $(this).$(".select-indicator").text(_this.options.sortDesc == "false" ? "arrow_downward" : "arrow_upward");
                        _this.options.page = 0;
                    }
                })
                .append($n("i").addClass("material-icons").addClass("select-indicator").css({
                    fontSize: "16px",
                    verticalAlign: "middle"
                })
                .text(""))
                .css("cursor", "pointer"));
        }

        this.thead.append($n("th").text(""));

        this.load();

        if (this.elements.searchInput !== null) {
            this.elements.searchInput.keyup(()=>{
                this.options.search = this.elements.searchInput.val();
                this.load();
            });
        }

        if (this.elements.rowsPerPage !== null) {
            this.elements.rowsPerPage.change(()=>{
                this.options.limit = this.elements.rowsPerPage.val();
                this.load();
            });
        }

        if (this.elements.previousPage != null) {
            this.elements.previousPage.click(()=>{
                if (this.options.page > 0) {
                    this.options.page -= 1;
                    this.load();
                }
            });
        }

        if (this.elements.nextPage != null) {
            this.elements.nextPage.click(()=>{
                if (this.pages > this.options.page+1) {
                    this.options.page += 1;
                    this.load();
                }
            });
        }
        console.log("OK");
        console.log(this.element);
        this.element
            .append(this.thead)
            .append(this.tbody);
    }

}


function createDataTable(element, rows, table, customDT = function (datatable) {}){

    element.append(
        $n("select").addClass("dt-rows-per-page")
            .append($n("option").val("10").text("10"))
            .append($n("option").val("25").text("25"))
            .append($n("option").val("50").text("50"))
            .append($n("option").val("75").text("75"))
            .append($n("option").val("100").text("100"))
            .append($n("option").val("250").text("250"))
    )
    .append($n("input").addClass("dt-search").attr("placeholder", "Search").attr("type","text"))
    .append($n("table").addClass("dt-table"))
    .append(
        $n("a").append($n("span").addClass("dt-entries-indicator").text("0")).append($n("span").text(" Entries"))
    )
    .append($n("nav").addClass("dt-pagination")
        .append($n("a").addClass("dt-previous-page").text("navigate_before"))
        .append(
            $n("a")
                .append($n("span").addClass("dt-current-page-indicator").text("0"))
                .append($n("span").text("/"))
                .append($n("span").addClass("dt-pages-indicator").text("0"))
        )
        .append($n("a").addClass("dt-next-page").text("navigate_next"))
    );

    let dataTable = new DataTable(element.$(".dt-table"), rows);

    dataTable.options.table = table;
    dataTable.options.sortBy = "id";
    dataTable.options.sortDesc = "true";

    dataTable.elements.searchInput =      element.$(".dt-search");
    dataTable.elements.nextPage =         element.$(".dt-next-page");
    dataTable.elements.previousPage =     element.$(".dt-previous-page");
    dataTable.elements.pagesIndicator =   element.$(".dt-pages-indicator");
    dataTable.elements.currentPage =      element.$(".dt-current-page-indicator");
    dataTable.elements.entriesIndicator = element.$(".dt-entries-indicator");
    dataTable.elements.rowsPerPage =      element.$(".dt-rows-per-page");
    customDT(dataTable);
    dataTable.init();
}