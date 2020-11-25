<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Our List</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
          integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

</head>

<body>
@include('header')
<div style="padding: 40px;">
    <div class="row">
        <div class="col-4">
            <div style="width: 300px">
                <form action="{{ route('{collection}.index', ['collection' => $collection]) }}" method="get">
                    <div class="input-group mb-3">
                        <input class="form-control" type="date" id="date-input" name="date-input" value="{{ $date }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-4 d-flex justify-content-center">
            <input class="form-control" id="myInput" type="text" placeholder="Search.." style="width: 100%;">
        </div>
        <div class="col-4 d-flex justify-content-end">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link"
                           href="{{ route('{collection}.index', ['collection' => $collection, 'p' => $prev, 'date-input' => $date]) }}">
                            Previous
                        </a>
                    </li>
                    @for($i = 1; $i <= $pages; $i++)
                        @if($current >= $i - 2 && $current <= $i + 2)
                            <li class="page-item @if($current === $i) active @endif">
                                <a class="page-link"
                                   href="{{ route('{collection}.index', ['collection' => $collection, 'p' => $i, 'date-input' => $date]) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    <li class="page-item">
                        <a class="page-link"
                           href="{{ route('{collection}.index', ['collection' => $collection, 'p' => $next, 'date-input' => $date]) }}">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <table class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>NAME</th>
            <th>DESCRIPTION</th>
            <th>DATE</th>
            <th>PICTURE</th>
            <th>HOST NAME</th>
            <th>ABOUT HOST</th>
            <th>HOST RESPONSE TIME</th>
            <th>HOST PICTURE</th>
            <th>ACTIONS</th>
        </tr>
        </thead>
        <tbody id="table">
        @isset($datas)
            @foreach ($datas as $data)
                <tr>
                    <td>{{ $data['name'] }}</td>
                    <td>{{ $data['description'] }}</td>
                    <td>{{ $data['last_scraped'] }}</td>
                    <td>
                        <a href="{{ $data['picture_url'] }}" target="_blank">
                            <img src="{{ $data['picture_url'] }}" style="max-height: 100px;" class="rounded d-block">
                        </a>
                    </td>
                    <td>{{ $data['host_name'] }}</td>
                    <td>{{ $data['host_about'] }}</td>
                    <td>{{ $data['host_response_time'] }}</td>
                    <td>
                        <a href="{{ $data['host_picture_url'] }}" target="_blank">
                            <img src="{{ $data['host_picture_url'] }}" style="max-height: 100px;"
                                 class="rounded d-block">
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('{collection}.show', ['collection' => $collection, 'id' => $data['_id']]) }}"
                           class="btn btn-secondary"><i class="fas fa-search"></i></a>
                        <a href="{{ route('{collection}.edit', ['collection' => $collection, 'id' => $data['_id']]) }}"
                           class="btn btn-info"><i class="fas fa-edit"></i></a>
                        <form
                            action="{{ route('{collection}.destroy', ['collection' => $collection, 'id' => $data['_id']]) }}"
                            method="post">
                            @method('DELETE')
                            @csrf

                            <button class="btn btn-danger" type="submit"><i class="fas fa-times"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endisset
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    $(document).ready(function () {
        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#table tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

</html>
