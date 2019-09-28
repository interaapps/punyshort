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

    getFitstElement() {
        if (this.usign == "htmlelement")
            return this.elem;
        else if (typeof this.elem[0] != 'undefined')
            return this.elem[0];
        return undefined;
    }

    html(html) {
    	if (typeof html == 'undefined') {
            var element = this.getFitstElement();
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
            var element = this.getFitstElement();
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
            var element = this.getFitstElement();
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
            var element = this.getFitstElement();

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
            var element = this.getFitstElement();
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
            var element = this.getFitstElement();
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
        this.on('click', func);
        return this;
    }

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
        this.css("transition", "all "+duration+"ms ease 0ms");
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
}