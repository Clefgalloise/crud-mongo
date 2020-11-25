<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Our List</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

  </head>

  <body>
    <div class="navbar navbar-dark bg-dark">
      <a href="/list" class="navbar-brand" style="padding: 15px;"> HOME </a>
    </div>
    <div style="padding: 30px;">
      <h2>View :</h2><hr>
        @isset($data)
          @foreach ($data as $line => $value)
            <p>{{ $line }} : {{ $value }}</p>
          @endforeach
        @endisset
    </div>
  </body>
</html>
    

    
