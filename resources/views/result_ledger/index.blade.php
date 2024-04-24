<x-app-layout>

    <x-cdn />
    <link rel="stylesheet" type="text/css" href="{{asset('css/resultledger.css')}}">
    <main>

        @can('showresult')



        <form action="result_ledger" method="POST" class="mt-2 ml-8>
            @csrf
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label>Category:</label>

            <select class=" custom-select" name="cat" id="inputGroupSelect01" style="width: 170px;">
                <option selected>All Category</option>
                @foreach($category as $dataops)

                <option>{{$dataops}}</option>

                @endforeach
            </select>
            &nbsp; &nbsp;
            &nbsp; &nbsp;
            <label>From Date:</label>

            <input type="text" id="txtFrom" placeholder="yyyy-mm-dd" class="" value="{{$min}}" name="from_date"
                size="15"> &nbsp;
            &nbsp;
            &nbsp; &nbsp; &nbsp; &nbsp;
            <label>To Date:</label>
            <input type="text" id="txtTo" placeholder="yyyy-mm-dd" class="" value="{{$max}}" name="to_date"
                size="15">

            <button type="submit" class="btn btn-primary ml-2">Search</button>

           
        </form>
        <div class="container">
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            
            <label><b>Total Debit =></b></label>
            &nbsp;
            {{$debit}}
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            <label><b>Total Credit =></b></label>
            &nbsp;
            {{$credit}}
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            <label><b>Total Amount =></b></label> &nbsp;
            {{$total}}
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
</div>

        <!-- ///////////////////table//////////////////// -->
      
<div class="table-wrapper">
    <table id="employee_data" class="fl-table">
    <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>start Date</th>
                                    <th>End Date</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Total</th>

                                </tr>
                            </thead>
                            <tbody>

@foreach($result_data as $result)
<tr>

    <td>{{$result->id}}</td>
    <td>{{$result->category}}</td>
    <td>{{$result->type}}</td>
    <td>{{$result->start_date}}</td>
    <td>{{$result->end_date}}</td>
    <td>{{$result->debit_amount}}</td>
    <td>{{$result->credit_amount}}</td>
    <td>{{$result->total_amount}}</td>

</tr>


@endforeach
        
    </table>
</div>


    </main>
    @endcan


    </div>


    <x-footer />
    <script src="{{ asset('js/general.js') }}"></script>
</x-app-layout>