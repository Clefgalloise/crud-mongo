<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Our List</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

</head>

<body>
@include('header')
<div style="padding: 30px;">
    <h2>Edition :</h2>
    <hr>
    @isset($data)
        <form action="{{ route('{collection}.update', ['collection' => $collection, 'id' => $data['_id']]) }}"
              method="post">
            @method('put')
            @csrf

            @foreach ($data as $line => $value)
                @if($line !== '_id')
                    <div class="form-group">
                        <label for="{{ $line }}">{{ $line }}</label>
                        @if(strlen($value) <= 250)
                            <input type="text" class="form-control" id="{{ $line }}" name="{{ $line }}" value="{{ $value }}" @if($line === 'id') disabled @endif>
                        @else
                            <textarea class="form-control" id="{{ $line }}" rows="3" name="{{ $line }}">{{ $value }}</textarea>
                        @endif
                    </div>
                @endif
            @endforeach

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    @endisset
</div>
</body>
</html>
