class CajaxRequest {
    constructor(url,method, data=null, options={}) {
        // INIT        
        this.onResponseFunction = ()=>{};
        this.catchFunction = ()=>{};
        this.thenFunction = ()=>{};
    
        if (data != null) {        
            var urlEncodedData = "";
            var urlEncodedDataPairs = [];
            var name;
            for(name in data) {
                urlEncodedDataPairs.push(encodeURIComponent(name) + '=' + encodeURIComponent(data[name]));
            }
            this.data = urlEncodedDataPairs.join('&').replace(/%20/g, '+');
        } else this.data = null;
        this.method = method;
        this.contenttype = (options.usinginput) ? "application/json; charset=utf-8" : "application/x-www-form-urlencoded";
        
        var xhr = new XMLHttpRequest();
        
        if (options != null) 
            for (var options_key__cajax in options) {
                xhr[options_key__cajax] = options[options_key__cajax];
            }
            
        
        xhr.open(method, url+((this.method=="GET")? "?"+this.data : "" ));
        if (options.header != null) for (var requestheader_obj__cajax in options.header) {
            xhr.setRequestHeader(requestheader_obj__cajax, options.header[requestheader_obj__cajax]);
        }
        
        xhr.setRequestHeader('Content-type', this.contenttype);
        this.request = xhr;
        if (options.usinginput && data != null) this.data = JSON.stringify(data);
    }
    
    response (func) {
        this.onResponseFunction = func;
        return this;
    }
    
    then (func) {
        this.thenFunction = func;
        return this;
    }
    
    catch (func) {
        this.catchFunction = func;
        return this;
    }
    
    custom (func) {
        func(this.request);
        return this;
    }
    
    send () {
    
        (this.request).onload = () => {
            this.onResponseFunction(this.request);
            if ((this.request).readyState == 4 && ((this.request).status == "200" || (this.request).status == "201")) {
		        this.thenFunction((this.request));
	        } else {
		        this.catchFunction((this.request));
	        }
        };

        (this.request).send(this.data);
        return this;
    }
}

function PrajaxPromise(url,method, data=null, options={}) {
    return new Promise( (done, error)=>{
            
            var request = new CajaxRequest(url,method, data, options);
            request.then((resp)=>{
                done(resp);
            });

            request.catch((resp)=>{
                error(resp);
            });

            if (typeof options.cajax != 'undefined') {
                if (typeof options.cajax.custom != 'undefined')
                    request.cajax.custom(options.cajax.custom);

                if (typeof options.cajax.response != 'undefined')
                    request.cajax.response(options.cajax.response);
            }

            request.send();

        }
    )
}

class Cajax {
    
    static post(url, data={}, options={}, usinginput=false) {
        return new CajaxRequest(url, "POST", data, options, usinginput);
    }
    
    static get(url, data={}, options={}, usinginput=false) {
        return new CajaxRequest(url, "GET", data, options, usinginput);
    }
    
    static put(url, data={}, options={}, usinginput=false) {
        return new CajaxRequest(url, "POST", data, options, usinginput);
    }
    
    static delete(url, data={}, options={}, usinginput=false) {
        return new CajaxRequest(url, "DELETE", data, options, usinginput);
    }
    
    static trace(url, data={}, options={}, usinginput=false) {
        return new CajaxRequest(url, "TRACE", data, options, usinginput);
    }
    
    static connect(url, data={}, options={}, usinginput=false) {
        return new CajaxRequest(url, "CONNECT", data, options, usinginput);
    }
    
    static options(url, data={}, options={}, usinginput=false) {
        return new CajaxRequest(url, "OPTIONS", data, options, usinginput);
    }
    
    static ajax (json) {
        return new CajaxRequest(
        ((json.url != null) ? json.url : false ), 
        ((json.method != null) ? json.method : false ), 
        ((json.options != null) ? json.options : false ), 
        ((json.data != null) ? json.data : false ),
        ((json.input != null) ? json.input : false ));
    }
}


class Prajax {
    
    static post(url, data={}, options={}, usinginput=false) {
        return PrajaxPromise(url, "POST", data, options, usinginput);
    }
    
    static get(url, data={}, options={}, usinginput=false) {
        return PrajaxPromise(url, "GET", data, options, usinginput);
    }
    
    static put(url, data={}, options={}, usinginput=false) {
        return PrajaxPromise(url, "POST", data, options, usinginput);
    }
    
    static delete(url, data={}, options={}, usinginput=false) {
        return PrajaxPromise(url, "DELETE", data, options, usinginput);
    }
    
    static trace(url, data={}, options={}, usinginput=false) {
        return PrajaxPromise(url, "TRACE", data, options, usinginput);
    }
    
    static connect(url, data={}, options={}, usinginput=false) {
        return PrajaxPromise(url, "CONNECT", data, options, usinginput);
    }
    
    static options(url, data={}, options={}, usinginput=false) {
        return PrajaxPromise(url, "OPTIONS", data, options, usinginput);
    }
    
    static ajax (json) {
        return PrajaxPromise(
        ((json.url != null) ? json.url : false ), 
        ((json.method != null) ? json.method : false ), 
        ((json.options != null) ? json.options : false ), 
        ((json.data != null) ? json.data : false ),
        ((json.input != null) ? json.input : false ));
    }
}

/*
    JDOM IS A SIMPLE DOM SELECTOR WITH FUNCTIONS!
    This is not finished! If you want to add something, just do it!
*/


class jdom {
    constructor(element, parent=undefined) {
        if (typeof parent=='undefined')
            parent = document;

        this.usign = "queryselector";
        if (element instanceof HTMLElement || element===document  || element===window) {
            this.elem = element;
            this.usign = "htmlelement";
        } else if (element instanceof jdom) {
            this.elem = element.elem;
            this.usign = "jdom";
        } else
            this.elem = parent.querySelectorAll(element);

        this.$ = function(element){
            if (typeof this.elem[0] !== 'undefined')
                return (new jdom(element, this.elem[0]));
            return (new jdom(element, this.elem));
        }
    }

    each(func) {
        if (this.usign == "htmlelement")
            func(this.elem);
        else
            [].forEach.call(this.elem, func);
    }

    getFirstElement() {
        if (this.usign == "htmlelement")
            return this.elem;
        else if (typeof this.elem[0] != 'undefined')
            return this.elem[0];
        return undefined;
    }


    html(html) {
        if (typeof html == 'undefined') {
            var element = this.getFirstElement();
            if (typeof element !== 'undefined')
                return element.innerHTML;
            return "";
        } else {
            this.each( function (element) { element.innerHTML = html; });
            return this;
        }
    }

    text(text) {
        if (typeof text == 'undefined') {
            var element = this.getFirstElement();
            if (typeof element !== 'undefined')
                return element.innerText;
            return "";
        } else {
            this.each( function (element) { element.innerText = text; });
            return this;
        }
    }

    css(css={}, alternativeValue=undefined) {
        if (typeof css == "string" && typeof alternativeValue == 'undefined') {
            var element = this.getFirstElement();
            if (typeof element.style[css] !== 'undefined')
                return element.style[css];
            return "";
        } else
            this.each( function (element) {
                if (typeof css == "string" && typeof alternativeValue != 'undefined') {
                    element.style[css] = alternativeValue;
                } else {
                    for (var styleAttr in css)
                        element.style[styleAttr] = css[styleAttr];
                }
            });
        return this;
    }

    attr(attributes={}, alternativeValue=undefined) {
        if (typeof attributes == "string" && typeof alternativeValue == 'undefined') {
            var element = this.getFirstElement();

            if (typeof element !== 'undefined')
                return element.getAttribute(attributes);
        } else
            this.each( function (element) {
                if (typeof attributes == "string" && typeof alternativeValue != 'undefined') {
                    element.setAttribute(attributes, alternativeValue);
                } else {
                    for (var attribute in attributes)
                        element.setAttribute(attribute, attributes[attribute]);
                }
            });
        return this;
    }

    removeAttr(name) {
        this.each(function(element) {
            element.removeAttribute(name);
        });
        return this;
    }

    addClass(name) {
        this.each( function (element) {
            element.classList.add(name);
        });
        return this;
    }

    removeClass(name) {
        this.each( function (element) {
            element.classList.remove(name);
        });
        return this;
    }

    id(name) {
        if (typeof name == 'undefined') {
            var element = this.getFirstElement();
            if (typeof element !== 'undefined')
                return element.id;
        } else {
            this.each(function(element) {
                element.id = name;
            });
        }
        return this;
    }

    val(value) {
        if (typeof value == 'undefined') {
            var element = this.getFirstElement();
            if (typeof element !== 'undefined')
                return element.value;
        } else {
            this.each(function(element) {
                element.value = value;
            });
        }
        return this;
    }

    append(append) {
        if (append instanceof HTMLElement)
            this.each( function (element) {
                element.appendChild(append);
            });
        else if (append instanceof jdom)
            this.each( function (element) {
                element.appendChild(append.elem);
            });
        else {
            var outerThis = this;
            this.each( function (element) {
                outerThis.html(outerThis.html() + append);
            });
        }
        return this;
    }

    prepend(prepend) {
        if (prepend instanceof HTMLElement)
            this.each( function (element) {
                element.prepend(prepend);
            });
        else if (prepend instanceof jdom)
            this.each( function (element) {
                element.prepend(prepend.elem);
            });
        else {
            var outerThis = this;
            this.each( function (element) {
                outerThis.html(prepend+outerThis.html());
            });
        }
        return this;
    }


    getElem(){
        return this.elem;
    }

    on(what, func, option) {
        this.each( function(element){
            element.addEventListener(what,func);
        }, option);
        return this;
    }

    rmEvent(what, func) {
        this.each(function(element) {
            element.removeEventListener(what, func);
        });
    }

    bind(binds={}) {
        this.each( function(element){
            for (var bind in binds)
                element.addEventListener(bind, binds[bind]);
        });
        return this;
    }

    click(func){
        if (typeof func != 'undefined')
            this.on('click', func);
        else
            (this.getFirstElement()).click();

        return this;
    }

    contextmenu(func) { return this.on('contextmenu', func); }
    change(func) { return this.on('change', func); }
    mouseover(func) { return this.on('mouseover', func); }
    keypress(func) { return this.on('keypress', func); }
    keyup(func) { return this.on('keyup', func); }
    keydown(func) { return this.on('keydown', func); }
    dblclick(func) { return this.on('dblclick', func); }
    resize(func) { return this.on('resize', func); }

    timeupdate(func) { return this.on('timeupdate', func); }
    touchcancle(func) { return this.on('touchcancle', func); }
    touchend(func) { return this.on('touchend', func); }
    touchmove(func) { return this.on('touchmove', func); }
    touchstart(func) { return this.on('touchstart', func); }

    drag(func) { return this.on('drag', func); }
    dragenter(func) { return this.on('dragenter', func); }
    dragleave(func) { return this.on('dragleave', func); }
    dragover(func) { return this.on('dragover', func); }
    dragend(func) { return this.on('dragend', func); }
    dragstart(func) { return this.on('dragstart', func); }
    drop(func) { return this.on('drop', func); }

    focus(func) { return this.on('focus', func); }
    focusout(func) { return this.on('focusout', func); }
    focusin(func) { return this.on('focusin', func); }
    invalid(func) { return this.on('invalid', func); }
    popstate(func) { return this.on('popstate', func); }
    volumechange(func) { return this.on('volumechange', func); }
    unload(func) { return this.on('unload', func); }
    offline(func) { return this.on('offline', func); }
    online(func) { return this.on('online', func); }
    focus(func) { return this.on('focus', func); }

    ready(func) {
        this.on('DOMContentLoaded', func);
        return this;
    }

    hide() {
        this.each( function(element){
            element.style.display = "none";
        });
        return this;
    }

    show() {
        this.each( function(element){
            element.style.display = "";
        });
        return this;
    }

    toggle() {
        this.each( function(element){
            if (element.style.display == "none")
                element.style.display = "";
            else
                element.style.display = "none";
        });
        return this;

    }

    animate(css={}, duration=1000, then=function(){}) {
        this.css("transition", duration+"ms");
        this.css(css);
        setTimeout(function() {
            then();
        }, duration);
        return this;
    }

    animator(animations=[], async = false){
        var counting = 0;
        var outerThis = this;
        for (var animation in animations) {
            const css = typeof animations[animation].css != 'undefined' ? animations[animation].css : {};
            const then = typeof animations[animation].then != 'undefined' ? animations[animation].then : function () {};
            const duration = typeof animations[animation].duration != 'undefined' ? animations[animation].duration : 1000;
            setTimeout(function(){
                outerThis.animate(css, duration, then);
            }, counting);
            if (!async)
                counting += duration;
        }
        return this;
    }

    static noConflict() {
        var $ = _$beforeJdom;
        var $n = _$nBeforeJdom;
        var $$ = _$$beforeJdom;
    }

}

if (typeof $ != 'undefined')
    var _$beforeJdom  = $;
if (typeof $n != 'undefined')
    var _$nBeforeJdom = $n;
if (typeof $$ != 'undefined')
    var _$$beforeJdom = $$;

$jdomfn = function(name, func){
    jdom.prototype[name] = func;
}

$jdomGetter = function(varName){
    varNameArray = varName.split("");
    if (varNameArray[0] !== undefined)
        varNameArray[0] = varName[0].toUpperCase();
    var out = "";
    for (letter in varNameArray)
        out += varNameArray[letter];
    jdom.prototype["get"+out] = function(){
        return this.getFirstElement()[varName];
    }
}

$jdomSetter = function(varName){
    varNameArray = varName.split("");
    if (varNameArray[0] !== undefined)
        varNameArray[0] = varName[0].toUpperCase();
    var out = "";
    for (letter in varNameArray)
        out += varNameArray[letter];
    jdom.prototype["set"+out] = function(value){
        this.each(function(elem){
            elem[varName] = value;
        });
        return this;
    }
}

var $ = function(element){
    return (new jdom(element));
}

var $jdom = function(element){
    return (new jdom(element));
}

var $n = function(element="div"){
    return (new jdom(document.createElement(element)));
}

var $$ = function (element) {
    return document.querySelectorAll(element);
}


if ( typeof module === "object" && typeof module.exports === "object" ) {
    module.exports = $;
}class Alert {
    constructor(settings = {closebtn: true, canexit: true, title: ""}) {
        this.canexit = (settings.canexit != null) ? settings.canexit : true;
        this.closebtn = (settings.closebtn != null) ? settings.closebtn : true;
        this.title = (settings.title != null) ? settings.title : "";

        this.backElement = document.createElement("div");
        $(this.backElement).addClass("alert_background");
        $("html").append(this.backElement);
        this.element = document.createElement("div");
        this.contents = document.createElement("div");
        $(this.contents).addClass("alert_contents");
        this.backElement.appendChild(this.element);
        this.element.appendChild(this.contents);
        $(this.element).addClass("alert_alert");
        var outerThis = this;

        $(this.backElement).click(function() {
            console.log(outerThis.canexit);
            if (outerThis.canexit) {
                outerThis.close();
            }
        });

        $(this.element).click(function(e) {
            e.stopPropagation();
        });
        if (this.closebtn) {
            var close = document.createElement("a");
            $(close).addClass("waves-effect");
            $(close).addClass("alert_closebutton");
            $(close).html("<i class='material-icons'>close</i>");
            $(close).click(function() {
                outerThis.close();
            });
            outerThis.element.appendChild(close);
        }

        var titleElement = document.createElement("a");
        $(titleElement).html(this.title).addClass("alert_title");
        this.element.appendChild(titleElement);

        this.toolbar = document.createElement("div");
        $(this.toolbar).addClass("alert_toolbar");
        this.element.appendChild(this.toolbar);

        this.close();
    }

    close() {
        $(this.backElement).hide();
        return this;
    }

    open() {
        $(this.backElement).show();
        return this;
    }

    addButton(name, clicked, icon=false) {
        var btn = document.createElement("a");
        $(btn).addClass("alert_button");
        $(btn).click(clicked);
        var iconHtml = "";
        if (icon !== false)
            iconHtml = "<i class='material-icons'>"+icon+"</i>";

        $(btn).html(iconHtml+"<span>"+name+"</span>");
        this.toolbar.appendChild(btn);
        return this;
    }

    addHtml(html) {
        $(this.contents).append(html);
        return this;
    }

    setHtml(html) {
        $(this.contents).html(html);
        return this;
    }

    e() {
        return this.element;
    }

    be() {
        return this.backElement;
    }


}class RowData {
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
}let scrollPageYOffsetMin = 1;

function checkScroll() {
    if (window.pageYOffset > scrollPageYOffsetMin) {
        $("#nav").addClass("nav_scrolled");
        $("#nav").removeClass("nav_not_scrolled");
    } else {
        $("#nav").removeClass("nav_scrolled");
        $("#nav").addClass("nav_not_scrolled");
    }
}

function copyStringToClipboard(str) {
    var el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.style = {display: none};
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
 }

$(document).ready(function() {
    
    window.onscroll = function() {
        checkScroll();
    };
    checkScroll();


});

var snackBarTimeout;
  
function showSnackBar(text, color="#17fc2e", background="#1e212b") {
    var snackbar = document.querySelector('#snackbar');
    snackbar.textContent = text;
    snackbar.style.color = color;
    snackbar.style.backgroundColor = background;
    snackbar.classList.add('show');
    clearTimeout(snackBarTimeout);
    snackBarTimeout = setTimeout(() => {
        snackbar.classList.remove('show');
    }, 1500);
}



$(window).on("online", function(){
    showSnackBar("You are online!");
});

$(window).on("offline", function(){
    showSnackBar("You are offline!", "#fa1121");
});