<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id="divTest">
        <div>xiaopo</div>
    </div>
</body>
<script language="javascript">
    var div = document.getElementById('divTest');
    console.log(div.innerHTML);
    console.log(div.innerText);
    console.log(div.textContent);
    console.log(div.childNodes[1].nodeType);
    console.log(div.childNodes[1].nodeName);
    console.log(div.childNodes[1].nodeValue);
    console.log(div.childNodes[1].innerHTML);
    console.log(div.childNodes[1].childNodes[0].nodeType);
    console.log(div.childNodes[1].childNodes[0].nodeName);
    console.log(div.childNodes[1].childNodes[0].nodeValue);
    console.log(div.childNodes[1].childNodes[0].innerHTML);
    console.log(div.childNodes[1].childNodes[0].hasChildNodes());
</script>
</html>