<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
<tr>
    <td>
        Dear {{$name}}
    </td>
</tr>
<tr>
    <td>
&nbsp;    </td>
</tr>
<tr>
    <td>
      please click on below link to activate your link
    </td>
</tr>
<tr>
    <td>
&nbsp;    </td>
</tr>
<tr>
    <td>
     <a href="{{url('confirm/'.$code)}}">confirm account</a>
    </td>
</tr>
<tr>
    <td>
     thanks regards
    </td>
</tr>
<tr>
    <td>
     E-commerce website
    </td>
</tr>

    </table>
</body>
</html>