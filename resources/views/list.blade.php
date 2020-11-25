<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Our List</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

  </head>

  <body>
    <div class="navbar navbar-dark bg-dark">
      <a href="/list" class="navbar-brand" style="padding: 15px;"> HOME </a>
    </div>
    <div style="padding: 40px;">
      <table id="exemple" class="table table-striped table-bordered" style="width:100%">
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
        <tbody>
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
                    <img src="{{ $data['host_picture_url'] }}" style="max-height: 100px;" class="rounded d-block">
                  </a>
                </td>
                <td>
                  <a href="{{ '/view/' . $data['id'] }}" class="btn btn-secondary"><i class="fas fa-search"></i></a>
                  <a href="{{ '/edit/' . $data['id'] }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                  <a href="{{ '/delete/' . $data['id'] }}" class="btn btn-danger"><i class="fas fa-times"></i></a>
                </td>
              </tr>
            @endforeach
          @endisset
        </tbody>
      </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

    <script>
      $(document).ready(function() {
        $('#exemple').DataTable();
      });
    </script>
  </body>
</html>
