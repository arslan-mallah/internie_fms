<x-app-layout>
<x-cdn>

</x-cdn>
<link rel="stylesheet" type="text/css" href="{{asset('css/addpay.css')}}">

@can('editgeneral')
<main>
@if(session()->has('message')) 
       <div class="alert alert-success w-25">
       {{session()->get('message')}}
       <button type="button" class="close" data-dismiss="alert" id="alert">x</button>
       </div>
@endif

<div class="container mt-3">
            <div class="container mt-3">
                <div class="title">Update Payment</div>
                <div class="content">
        
<form action="{{ route('admin.general_ledger.update',$general_ledger->id)}}" method="POST" class="row">
    @csrf
    @method('put')
            <input type="hidden" name="id" value="{{$data['id']}}">
            <input type="hidden" name="sessionid" value="{{Auth::user()->id}}">
            <div class="user-details">
                    <div class="input-box">
                                <span class="details">Date</span>
                                <input type="date" name="joining" placeholder="Date Of Joining">
                            </div>
                            <div class="input-box">
                                <span class="details">Day</span>
                                <input type="text" name="details" >
                            </div>
                            <div class="input-box">
                                <span class="details">Deatail</span>
                                <input type="text" name="details" >
                            </div>
                            
                    </div>
                    <div class="input-box">
                        <div class="">
                            <span class="details">Category</span>
                        </div>
                <select class="" name="cat" >
                <option selected>{{$data['category']}}</option>
                @foreach($category as $dataops)
                    @if($dataops===$data['category'])

                    @else
                    <option >{{$dataops}}</option>
                    
                    @endif
                      @endforeach
                    
                </select>
                </select>
            </div>

            <div class="input-box">
             <span class="details">Debit & Credit</span>   
                     
        @if ($data->debit==0)
               <!-- form-control -->
                <input class="" name="amt" size="24" type="number" value="{{$data['credit']}}" required />

                  @else 

             <input class="" name="amt" size="24" type="number" value="{{$data['debit']}}" required />

      @endif
               </div>

            <div class="flex-container">
                <div class=" pl-0 mt-2">
                    <label>Type:</label>
                </div>
                <div class="flex-container-radio d-flex">
                    <div class="ml-5">
                    @if ($data->debit==0)
                        <input type="radio" name="type" value="debit" id="debit-radio" >
                    @else
                    <input type="radio" name="type" value="debit" id="debit-radio" checked>
                    @endif
                        <label id="radio-label"><span class="radio">Debit</span></label>
                    </div>
                    <div class="">
                    @if ($data->credit==0)
                        <input type="radio" name="type" value="credit" id="credit-radio" >
                    @else
                    <input type="radio" name="type" value="credit" id="credit-radio" checked>
                    @endif
                        <label id="radio-label"><span class="radio">Credit</span></label>
                    </div>
                </div>
            </div>
            <div type="hidden" class="form-group col-md-6">
                <!-- <label  type="hidden">created ID</label> -->
                <input type="hidden" class="form-control" name="created_id" id="created_id"
                    value="" required>
            </div>
            <div type="hidden" class="form-group col-md-6">
                <!-- <label  type="hidden">created Date</label> -->
                <input type="hidden" class="form-control" name="created_date" id="created_date"
                    value="" required>
            </div>
            <div class="button">
                <input type="submit" class="" name="updatebtn"></input>
            </div>


        </form>
        </div>
</div>
</main>
@endcan
</div>
</x-app-layout>