<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo ($title); ?></title>

    <script src="/assets/js/app.js"></script>

    <link rel="stylesheet" href="/assets/css/app.css">

    <link rel="stylesheet" href="https://indestructibletype.com/fonts/Jost.css" type="text/css" charset="utf-8" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

    <script data-ad-client="ca-pub-7136454966632869" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body>
    <div id="nav">
        <a id="logo" href="/">PunyShort</a>
        <div id="navmenu">
            <a href="/docs/v2">Developer API</a>
            <a href="/dashboard"><?php echo ( app\classes\user\IaAuth::loggedIn() ? "Dashboard" : "Login" ); ?></a>
        </div>
    </div>
