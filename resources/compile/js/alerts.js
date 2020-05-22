class Alert {
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


}