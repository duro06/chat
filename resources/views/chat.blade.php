<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <title>Realtime Chat</title>
 <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
 <div class="container">
  <div class="row" id="wawan">   
   
  </div>
 </div>

 <script src="{{asset('js/app.js')}}"></script>
</body>
</html>