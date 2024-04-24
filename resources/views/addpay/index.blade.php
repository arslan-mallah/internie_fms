<x-app-layout>

<x-emp-atten-cdn />
<link rel="stylesheet" type="text/css" href="{{asset('css/addpay.css')}}">

    @can('addpay')
    <main>
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{session()->get('message')}}
                    <button type="button" class="close" data-dismiss="alert" id="alert">x</button>
                </div>
                @endif

                <div class="container mt-3">
            <div class="container mt-3">
                <div class="title">Add Payment</div>
                <div class="content">

                <form action="{{ route('admin.addpay.store') }}" method="POST" class="bg-light p-4">
                    @csrf
                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                   
                    <div class="user-details">
                    <div class="input-box">
                                <span class="details">Date</span>
                                <input type="date" name="joining" placeholder="Date Of Joining">
                            </div>

                    <div class="input-box">
                        <div class="">
                            <span class="details">Category</span>




                        </div>

                        <select class="" name="cat" id="inputGroupSelect01">

                            @foreach($category as $dataops)

                            <option selected>{{$dataops}}</option>

                            @endforeach

                        </select>

                    </div>
                   
                    <div class="input-box">
                                <span class="details">Deatail</span>
                                <input type="text" name="details" >
                            </div>

                 
                            <div class="input-box">
                                <span class="details">Enter Amount:</span>
                                <input type="number" name="amount" >
                            </div>

                            <div class="flex-container">
                        <div class=" pl-0 mt-2">
                            <label>Type:</label>
                        </div>
                        <div class="flex-container-radio d-flex">
                            <div class=" ml-5">
                                <input type="radio" name="type" value="debit" id="debit-radio" checked>
                                <label id="radio-label" for="debit-radio"><span
                                        class="radio">Debit</span></label>
                            </div>
                            <div class="">
                                <input type="radio" name="type" value="credit" id="credit-radio">
                                <label id="radio-label" for="credit-radio"><span
                                        class="radio">Credit</span></label>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="button">
                        <input type="submit"
                            name="savebtn"></input>
                    </div>


                </form>
            </div>
        </div>
        </div>
    </main>
    @endcan

   
    <x-footer>
    </x-footer>

</x-app-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="{{ asset('js/addpay.js') }}"></script>