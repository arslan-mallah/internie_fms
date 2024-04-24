<x-app-layout>

    <x-cdn />
    <link rel="stylesheet" type="text/css" href="{{asset('css/generalledger.css')}}">


    @can('showgeneral')



    <main>

        @if(Session::has('message'))

        @if(Session::get('message') === 'Updated successfully')
        <div class="alert alert-success">
            Updated successfully
        </div>
        @elseif(Session::get('message') === 'You dont have access to edit this')
        <div class="alert alert-danger">
            You dont have access to edit this
        </div>
        @elseif(Session::get('message') === 'failed to update')
        <div class="alert alert-danger">
            failed to update
        </div>
        @else
        <div class="alert">
            {{ Session::get('message') }}
        </div>
        @endif

        @endif

        <form action="general_ledger" id="demoForm" method="POST" class=" mt-3 ml-20 pb-1">

            @csrf
            <label class="pt-1">Category:</label>


            <select class=" custom-select" name="cat" id="inputGroupSelect01" style="width: 170px;">
                <option selected>All Category</option>
                @foreach($category as $dataops)

                <option>{{$dataops}}</option>

                @endforeach

            </select>

            <label class="pt-1" for="">From Date:</label>
            <td>

                <input type="text" class="" id="txtFrom" placeholder="yyyy-mm-dd" value="{{$min}}" name="from_date" style="width: 170px;">

            </td>



            <label class="pt-1" for="">To Date:</label>
            <td>
                <input type="text" id="txtTo" placeholder="yyyy-mm-dd" class="" value="{{$max}}" name="to_date" style="width: 170px;"/>
            </td>


            <button type="submit" name="submit" class="btn btn-primary ml-2">Search</button>

        </form>

        <!-- for model/////////////////////////////////////////////////// -->
        <div class="modal" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Entry</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ route('admin.general_ledger.destroy', ['general_ledger' => 1]) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="delete_id" id="delete_id">
                            <h4>Do you want to delete this Entry?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="submit" name="deletedata" class="btn btn-primary">Yes, delete it</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- end model//////////////////////////////////////////////////// -->


        <!-- ///////////////table/////////// -->
       
<div class="table-wrapper">
    <table id="employee_data" class="fl-table">
    <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Category</th>
                                    <th>detail</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_general as $dataops)
                                <tr>

                                    <td>{{$dataops->id}}</td>
                                    <td>{{$dataops->date}}</td>
                                    <td>{{$dataops->day}}</td>
                                    <td>{{$dataops->category}}</td>
                                    <td>{{$dataops->detail}}</td>
                                    <td>{{$dataops->debit}}</td>
                                    <td>{{$dataops->credit}}</td>



                                    <td>
                                        @can('editgeneral')
                                        <input type="hidden" name="id" value=" ">
                                        <button class="btn btn-info" type="submit"><a
                                                href="{{route('admin.general_ledger.edit', $dataops->id)}}"><i
                                                    class="fas fa-pen"></i></a>

                                        </button>
                                        @endcan
                                        @can('deletegeneral')
                                        <input type="hidden" name="id" value=""><button id="delete"
                                            class="btn btn-dark delete deletebtn" name="delete" value="Delete"
                                            type="submit"><i class="far fa-trash-alt"></i></button>
                                        @endcan
                                    </td>

                                </tr>

                                @endforeach

        
    </table>
</div>


    </main>
    @endcan

    </div>
    <x-footer>
    </x-footer>
    <script src="{{ asset('js/addpay.js') }}"></script>
    <script src="{{ asset('js/general.js') }}"></script>

</x-app-layout>