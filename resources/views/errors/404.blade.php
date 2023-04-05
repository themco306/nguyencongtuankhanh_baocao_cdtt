<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lỗi[404]</title>
 <link rel="stylesheet" href="{{ asset('css/error_404.css') }}">
</head>
<body>
    <div class="mars"></div>
<img src="https://assets.codepen.io/1538474/404.svg" class="logo-404" />
<img src="https://assets.codepen.io/1538474/meteor.svg" class="meteor" />
<p class="title">Ôi không!!Có gì đó không ổn</p>
<p class="subtitle" >
	Đường dẫn @if ( isset($slug))<span style="color: #F55B13 ">"{{ $slug }}"</span>@endif của bạn sai <br /> hoặc nó không còn tồn tại ở đây nữa.
</p>
<div align="center">
	<span class="btn-back" onclick="window.history.back()" >Về Trang Hồi Nãy</span>
</div>
<img src="https://assets.codepen.io/1538474/astronaut.svg" class="astronaut" />
<img src="https://assets.codepen.io/1538474/spaceship.svg" class="spaceship" />
</body>
</html>