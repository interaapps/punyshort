@template(("header", ["title"=>"Docs V2"]))!

<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.13.1/highlight.min.js"></script>
<script>
    $(document).ready(function() {
        hljs.initHighlightingOnLoad();
    });
</script>

<div class="firstcontents" id="docsv2">
    
    <div id="docsv2sidenav">
        <h3>Docs V2</h3>
        @foreach(($pages as $page=>$link))#
            <a class="link_black" style="display:block" href="{{$link}}">{{$page}}</a>
        @endforeach
    </div>

    <div id="docsv2contents">
        {{ $doc }}
    </div>


</div>
<style>
#docsv2 {
    display: flex;
    padding: 20px 50px;
    margin-top: 60px;
    box-sizing: border-box;
    min-height: calc(100% - 100px)
}

#docsv2contents h1,
#docsv2contents h2,
#docsv2contents h3,
#docsv2contents h4,
#docsv2contents h5 {
  margin-bottom: 16px;
  margin-top: 16px;
}

#docsv2sidenav {
    background: #00000010;
    border-radius: 6px;
    width: 300px;
    box-sizing: border-box;
    padding: 20px;
    display: inline-table;
}

#docsv2contents {
    width: 100%;
    box-sizing: border-box;
    padding: 0px 40px;
}


#docsv2contents th {
  background: #F9F9F977;
}


#docsv2contents th, #docsv2contents td {
  border: solid 1px #434343;
  padding: 6px 10px;
}

#docsv2contents table {
  border-collapse: collapse;
}

#docsv2contents pre {
    background: #00000011;
    padding: 6px;
    border-radius: 6px;
}

#docsv2contents code {
    font-size: 16px;
    padding: 2px 5px;
    border-radius: 6px;
}

.article_creator {
    background: #00000011;
    border-radius: 6px;
    margin-top: 40px;
    padding: 17px;
    box-sizing: border-box;
    display: flex;
    width: max-content;
    max-width: 100%;
}

.article_creator img {
    border-radius: 100%;
    width: 40px;
    height: 40px;
    vertical-align: top
}

.article_creator a {
    
}

.article_creator p {
    font-size: 14px;
    color: #989898;
}

.article_creator div {
  margin-left: 20px;
}


@media screen and (max-width: 720px) {

  .article_creator {
      display: block;
  }
  .article_creator div {
    margin-left: 0px;
  }

  #docsv2 {
    display: block;
  }

  #docsv2sidenav {
    width: 100%;
    display: block;
  }

  #docsv2contents {
    width: 100%;
  }
}


.hljs {
    display: block;
    overflow-x: auto;
    padding: 0.5em;
    background: none;
  }
  
  .hljs,
  .hljs-tag,
  .hljs-subst {
    color: #323232;
  }
  
  .hljs-strong,
  .hljs-emphasis {
    color: #a8a8a2;
  }
  
  .hljs-bullet,
  .hljs-quote,
  .hljs-number,
  .hljs-regexp,
  .hljs-literal,
  .hljs-link {
    color: #ae81ff;
  }
  
  .hljs-code,
  .hljs-title,
  .hljs-section,
  .hljs-selector-class {
    color: #a6e22e;
  }
  
  .hljs-strong {
    font-weight: normal;
  }
  
  .hljs-emphasis {
    font-style: italic;
  }
  
  .hljs-keyword,
  .hljs-selector-tag,
  .hljs-name {
    color: #22863a;
  }
  
  .hljs-keyword {
      font-weight: normal;
  }
  
  .hljs-symbol,
  .hljs-attribute,
  .hljs-attr {
    color: #5880ee;
  }
  
  .hljs-params,
  .hljs-class .hljs-title {
    color: #f8f4f2;
  }
  
  .hljs-type,
  .hljs-built_in,
  .hljs-builtin-name,
  .hljs-selector-id,
  .hljs-selector-attr,
  .hljs-selector-pseudo,
  .hljs-addition,
  .hljs-variable,
  .hljs-template-variable {
    color: #6f42c1;
  }
  
  .hljs-deletion,
  .hljs-meta {
    color: #ff7567;
  }
  
  .hljs-comment {
  color: #75715e
  }
  
  .hljs-string {
  color: #032f62;
  }


</style>
@template(("footer", ["title"=>"V1"]))!