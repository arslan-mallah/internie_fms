<x-app-layout>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <x-chartscdn />

    @can('showgraph')



    <main>

        <div class="sc-AxjAm sc-pBzUF fJZwvt mx-4 my-4 text-center">
            <div class="sc-AxjAm sc-pZBmh kpOYNK text-center">
                <h2 class="sc-fzoLag cfNXah">OverallDebit & Credit:</h2>
            </div>

        </div>
        <!-- ////////////functions.//////// -->
        <div class="container mb-4 text-center w-100">
            <button type="submit" onclick="debit()" name="t_debit" id="t_debit"
                class="btn btn-primary mr-2 active">Total Debit</button>
            <button type="submit" onclick="credit()" name="t_credit" id="t_credit" class="btn btn-warning">Total
                Credit</button>
        </div>


        <!-- /////////////////////////// -->
        <div class="container w-100">

            <div class="sc-AxjAm sc-fzoyTs sc-qYIQh firstdiv mx-4 ">
                <div class="sc-AxjAm seconddiv">



                    <!-- ////////////include////   -->
                    <div class="chartBox_p">
                        <div id="progress" class="mx-4">
                            <h4>Your debit report:</h4>
                        </div>
                        <canvas id="myChart_p"></canvas>
                    </div>
                </div>

            </div>
        </div>

        <!-- //////////////month data//////////// -->
        <div class="sc-AxjAm sc-pBzUF fJZwvt mx-4 my-4 text-center">
            <div class="sc-AxjAm sc-pZBmh kpOYNK text-center">
                <h2 class="sc-fzoLag cfNXah">Monthly graph:</h2>
            </div>

        </div>

        <!-- ////////////////filter month////////////// -->


        <div class="container mb-4 text-center justify-content-center w-100  d-flex  align-items-center">

            <form action="graph_analysis" id="demoform" method="POST"
                class="px-1 ml-1 mb-5 flex flex-col space-y-3 sm:flex-row sm:space-x-3 sm:space-y-0">
                @csrf

                <div class="flex flex-col sm:flex-row sm:space-x-3">
                    <label for="txtFrom" class="mx-2 text-sm"><b>From date:</b></label>
                    <input type="text" id="txtFrom" placeholder="yyyy-mm-dd"
                        class="mt-2 px-3 py-2 rounded border focus:ring focus:ring-blue-300 focus:border-blue-300 w-full sm:w-auto"
                        value="{{$min}}" name="startDate" size="13">
                </div>

                <div class="flex flex-col sm:flex-row sm:space-x-3">
                    <label for="txtTo" class="mx-2 text-sm"><b>To date:</b></label>
                    <input type="text" id="txtTo"
                        class="mt-2 px-3 py-2 rounded border focus:ring focus:ring-blue-300 focus:border-blue-300 w-full sm:w-auto"
                        placeholder="yyyy-mm-dd" value="{{$max}}" name="endDate" size="13">
                </div>

                <button type="submit" name="submit" class="btn btn-primary mt-2 w-full sm:w-auto"><b>Search</b></button>
            </form>

        </div>
        <!-- //////////////////////month graph div////////////// -->

        <div class="sc-AxjAm sc-qQxXP fuTEF mx-4" height="380">

            <canvas width="740" id="myChart4" height="380" overflow="visible">

            </canvas>
        </div>


        <!-- //////////////end month/////// -->

        <!-- //////////weekly graph//////////// -->
        <div class="sc-AxjAm sc-pBzUF fJZwvt mx-4 my-4 text-center">
            <div class="sc-AxjAm sc-pZBmh kpOYNK text-center">
                <h2 class="sc-fzoLag cfNXah">Weekly graph:</h2>
            </div>
        </div>

        <!-- //////////////////// -->
        <div class="sc-AxjAm fyNUoA">

            <div class="mb-4 container d-flex align-items-center  justify-content-center ">

                <div class="form-group float-left pd-0 m-0">

                    <div class="input-group-prepend">

                        <label class="float-left  mx-2">Category:</label>
                        <select class="custom-select-lg ml-2" size="1" name="cat2" id="inputGroupSelect01">
                            @foreach($category as $dataops)

                            <option>{{$dataops}}</option>

                            @endforeach
                        </select>

                        <div class="container mt-4" id="btn">
                            <button type="submit" onclick="debit7()" name="t_debit" id="t_debit"
                                class="btn btn-primary mx-2 active">Bar chart</button>
                            <button type="submit" onclick="credit7()" name="t_credit" id="t_credit"
                                class="btn btn-warning">Line chart</button>
                        </div>


                    </div>

                </div>


            </div>


            <div class="sc-AxjAm sc-pJUVA fcRxvB  ">

                <div class="sc-AxjAm imVUDT">
                    <div data-id="metric-wrapper" class="sc-AxjAm sc-AxiKw krvuUX">

                        <span data-id="metric" id="cat_graph3" class="sc-AxhCb jXrfzm mx-4">{{$cat}}</span>
                        <span data-id="metric" id="debit_graph3" class="sc-AxhCb jXrfzm mx-4">Debit: {{$total_d}}</span>
                        <span data-id="metric" id="credit_graph3" class="sc-AxhCb jXrfzm mx-4">Credit:
                            {{$total_c}}</span>
                    </div>
                    </span>

                    <div class="sc-AxjAm sc-prOVx eopTOK mx-2">
                        <canvas id="myChart3" width="740" height="500"></canvas>
                    </div>
                    <div class="w-75">
                        Start date:<input type="text" id="start" value="{{$firstDate}}">
                        End date: <input type="text" id="end" value="{{$lastDate}}">
                        <button class="btn btn-primary mx-2" onclick="filterDate()">Filter</button>
                        <button class="btn btn-danger mx-2 " onclick="resetDate()">Reset</button>
                    </div>
                </div>
            </div>


        </div>


    </main>
    @endcan

    </div>

</x-app-layout>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript" src="{{asset('js/date.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>




<!-- /////////end weeek///////////// -->
<script>
////////progress//////////
const expenses_p = @json($expenses);
const revenue_p = @json($revenue);
const category_p = @json($category);

////////////month///////////

const expenses_m = @json($expense_m);
const revenue_m = @json($revenue_m);
const type_m = @json($type_m);

var expenses3 = @json($expenses3);
var revenue3 = @json($revenue3);
var type3 = @json($type3);
</script>


<script>
// Check if the page was accessed via a form submission
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>

<script type="text/javascript" src="{{asset('js/ajax.js') }}"></script>
<script type="text/javascript" src="{{asset('js/ajax2.js') }}"></script>
<script type="text/javascript" src="{{asset('js/ajax3.js') }}"></script>
<script type="text/javascript" src="{{asset('js/week.js') }}"></script>
<script type="text/javascript" src="{{asset('js/graph.js') }}"></script>
<script type="text/javascript" src="{{asset('js/month.js') }}"></script>