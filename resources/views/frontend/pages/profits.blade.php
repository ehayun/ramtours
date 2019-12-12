@extends('frontend.front_part.head')

<br>
<br>
<form>
    @csrf
    <div class="col-auto">
        <div class="input-group col-lg-2">

            <input type="text" style="text-transform: lowercase" class="form-control" name="fnum"
                placeholder="חפוש טיסה">
        </div>
    </div>

</form>

<body>
    <table class=" table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">שם טיסה</th>
                <th scope="col">תאריך יציאה</th>
                <th scope="col">תאריך חזרה</th>
                <th scope="col"> פנויים</th>
                <th scope="col">רווח על כרטיס</th>
                <th scope="col">רווח לחבילה</th>
                <th scope="col">רווח לחבילה בטיסה</th>
            </tr>
        </thead>
        <tbody>
            @foreach($flights as $f)
            <tr>
                <th scope="row">{{$f->id}}</th>
                <td>{{$f->flight_sche_title}}</td>
                <td>{{rami_get_require_date_time_format($f->up_departure_time, "d-m-Y")}}</td>
                <td>{{rami_get_require_date_time_format($f->down_departure_time, "d-m-Y")}}</td>
                <td>{{$f->num_available_seat}}/{{$f->num_total_seat}}</td>
                <td>{{$f->flight_profit}}</td>
                <td>{{rami_get_first_package_for_flight($f->id)}}</td>
                <td>{{$f->package_profit}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
    {{$flights->appends(['id' => 4])->links()}}
</body>

</html>