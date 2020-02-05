@extends('admin.main')
@section('admin_container')

<body class="theme-orange {{rami_get_backend_language_dir()}}" style="zoom:90%">
  <div class="container-fluid">
    {!!show_flash_msg()!!}
    <div class="row clearfix">
      <div class="col-lg-12">
        <table class="table">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">IP</th>
            </tr>
          </thead>
          <tbody>
            @foreach($bans as $b)
            <tr>
              <td>
              <form action="/admin/bans/{{$b->id}}" method="POST">
              @csrf
              @method('PATCH')
              <input class="form-check-input" type="checkbox" name="is_ban" value="{{$b->is_ban}}" >
              @if ($b->is_ban)
              <button type="submit" class="btn btn-primary">אל תחסום</button>
              @else
              <button type="submit" class="btn btn-primary">חסום</button>
              @endif
              </form>
              </td>
              <td>@if ($b->is_ban) <strong>המשתמש חסום</strong> @endif</td>
              <td>{{ $b->full_name}}</td>
              <td>{{ $b->email}}</td>
              <td>{{ $b->ip_address}}</td>
            </tr>
           @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
@endsection