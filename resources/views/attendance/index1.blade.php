<x-app-layout>

    <!-- <link rel="stylesheet" type="text/css" href="{{asset('css/attendance.css')}}"> -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/singleattendance.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">

    @can('showattendance1')
    <main>
        @can('showattendance')

        <button class="btn btn-primary mx-3 mt-3"><a href="{{ route('admin.attendance.index')}}"
                class="link-light">complete attendance</a></button>
        @endcan

        <!-- //////////calendar///////// -->
        <div class="text-center mt-1">
            <form action="attendance" class="mt-3" method="POST">
                @csrf
                <label for=""> Date:</label>
                <input type="date" placeholder="yyyy-mm-dd" id="fetch_date" class="mt-2" value="" name="date" size="14">
                &nbsp;
                <button type="submit" name="fetch" class="btn btn-primary">fetch data</button>
            </form>
        </div>

        <!-- //////////////table////// -->
                <h2>Attendance</h2>
                <div class="table-wrapper">
                    @csrf
                    <table id="employee_data" class="fl-table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>employee_id</th>
                                <th>name</th>
                                <th>status</th>
                                <th>reason</th>
                                <th>summary</th>
                                <th>date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_general as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->employee_id }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->reason }}</td>
                                <td>{{ $row->work_sum }}</td>
                                <td>{{ $row->date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

    </main>
    @endcan



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>

    <script src="{{ asset('js/singleattendance.js') }}"></script>

</x-app-layout>