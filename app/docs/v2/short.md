# Short
Short a link.

<br><br>
`POST https://punyshort.ga/api/v2/short`
<br><br>Parameters<br>
```json
link: "https://interaapps.de"
domain: "pnsh.ga"
```
<!--
<br><br>
`GET https://punyshort.ga/api/v2/short`
<br><br>Parameters<br>
```json
link: "https://interaapps.de"
```
`example: https://punyshort.ga/api/v2/short?link=https://interaapps.de`
-->
<br><br>
Return `JSON`:
<br><br>
```json
{
    "link": "i",
    "full_link": "https://pnsh.ga/i",
    "error": 0
}
```

## Code-Examples
### Javascript
```javascript
// Using Cajax.js
Cajax.post("https://punyshort.ga/api/v2/short", {
    link: "https://interaapps.de"
}).then((resp)=>{
    var response = JSON.parse(resp.responseText);
    console.log("Link: "+response.link_full);
}).send();
```

### PHP
```php
$postdata = http_build_query(
    [
        'link' => 'https://interaapps.de'
    ]
);

$context = stream_context_create(['http' =>
    [
        'method'  => 'POST',
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $postdata
    ]
]);


$result = json_decode(file_get_contents('https://punyshort.ga/api/v2/short', false, $context));
echo "Link: ".$result->full_link;
```

### Python
```python
link = "https://interaapps.de"

import urllib.request, json
with urllib.request.urlopen("https://punyshort.ga/api/v2/short?link="+urllib.parse.quote(link)) as url:
    data = json.loads(url.read().decode())
print("Link: "+data["full_link"])
```





<div class="article_creator">
    <img src="https://accounts.interaapps.de/userpbs/JulianFun123.png" />
    <div>
        <a>Documentation by JulianFun123</a>
        <p>Develops at InteraApps</p>
    </div>
</div>