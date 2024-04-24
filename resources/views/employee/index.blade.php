<x-app-layout>


    <x-emp-atten-cdn />
    <link rel="stylesheet" type="text/css" href="{{asset('css/employee.css')}}">


    @can('showemployee')

    <main>

        @if(session()->has('message'))
        <div class="alert alert-success w-50">
            {{session()->get('message')}}
            <button type="button" class="close" data-bs-dismiss="alert" id="alert">x</button>
        </div>
        @endif
        <div class="container mt-3">
            <div class="container mt-3">
                <div class="title">Employees Detail</div>
                <div class="content">
                    <form action="{{ route('admin.employee.store')}}" method="POST" class=" bg-light p-4">
                        @csrf
                        <div class="user-details">
                            <div class="input-box">
                                <span class="details Name">Full Name</span>
                                <input type="text" name="name" placeholder="Full Name" required>
                            </div>
                            <div class="input-box">
                                <span class="details">Email</span>
                                <input type="email" name="email" placeholder="Employee Email">
                            </div>
                            <div class="input-box">
                                <span class="details">Mobile no.</span>
                                <input type="text" name="contact1" data-inputmask="'mask': '9999-9999999'"
                                    placeholder="contact number">

                            </div>
                            <div class="input-box">
                                <span class="details">Emergency contact no.</span>
                                <input type="text" name="contact2" data-inputmask="'mask': '9999-9999999'"
                                    placeholder="Emergency Contact">
                            </div>
                            <div class="input-box">
                                <span class="details">Address</span>
                                <input type="text" name="address" placeholder="Employee Address">
                            </div>
                            <div class="input-box">
                                <span class="details">CNIC</span>
                                <input type="text" data-inputmask="'mask': '99999-9999999-9'" placeholder="CNIC"
                                    name="cnic">
                            </div>
                            <div class="input-box">
                                <span class="details">Date Of Joining</span>
                                <input type="date" name="joining" placeholder="Date Of Joining">
                            </div>
                            <div class="input-box">
                                <span class="details">Date Of Left</span>
                                <input type="date" name="left" placeholder="Date Of Left">
                            </div>
                            <div class="input-box">
                                <span class="details">Employee id</span>
                                <input type="number" name="emp_id" placeholder="Employee_id">
                            </div>
                        </div>

                        <div class="button">
                            <input type="submit" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- ///////////////table/////////// -->
         <h2>Employees Data</h2>
<div class="table-wrapper">
    <table id="employee_data" class="fl-table">
    <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile no.</th>
                                <th>Emergency contact</th>
                                <th>Address</th>
                                <th>Cnic</th>
                                <th>Date of joining</th>
                                <th>Date of Left</th>
                                <th>Employee id</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_general as $dataops)
                            <tr>

                                <td>{{$dataops->id}}</td>
                                <td>{{$dataops->name}}</td>
                                <td>{{$dataops->email}}</td>
                                <td>{{$dataops->mobile_no}}</td>
                                <td>{{$dataops->contact_no}}</td>
                                <td>{{$dataops->address}}</td>
                                <td>{{$dataops->cnic}}</td>
                                <td>{{$dataops->join}}</td>
                                <td>{{$dataops->left}}</td>
                                <td>{{$dataops->employee_id}}</td>



                                <td>
                                    @can('editemployee')
                                    <button type="button" class="btn btn-primary editbtn"><i
                                            class="fas fa-pen"></i></button>
                                    @endcan
                                    @can('deleteemployee')
                                    <button type="button" class="btn btn-dark deletebtn"><i
                                            class="far fa-trash-alt"></i></button>
                                    @endcan
                                </td>

                            </tr>

                            @endforeach

    </table>
</div>


        <!-- //////////////modal for edit//////////////////// -->
        <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Edit Student Data </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="content">
                        <form action="{{ route('admin.employee.update',1)}}" method="POST" class="bg-light p-4">
                            @csrf
                            @method('put')
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="user-details">
                                <div class="input-box">
                                    <span class="details Name">Full Name</span>
                                    <input type="text" id="name" name="name" placeholder="Full Name" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <input type="email" id="email" name="email" placeholder="Employee Email">
                                </div>
                                <div class="input-box">
                                    <span class="details">Mobile no.</span>
                                    <input type="text" id="contact1" name="contact1"
                                        data-inputmask="'mask': '9999-9999999'" placeholder="contact number">

                                </div>
                                <div class="input-box">
                                    <span class="details">Emergency contact no.</span>
                                    <input type="text" id="contact2" name="contact2"
                                        data-inputmask="'mask': '9999-9999999'" placeholder="Emergency Contact">
                                </div>
                                <div class="input-box">
                                    <span class="details">Address</span>
                                    <input type="text" id="address" name="address" placeholder="Employee Address">
                                </div>
                                <div class="input-box">
                                    <span class="details">CNIC</span>
                                    <input type="text" id="cnic" data-inputmask="'mask': '99999-9999999-9'"
                                        placeholder="CNIC" name="cnic">
                                </div>
                                <div class="input-box">
                                    <span class="details">Date Of Joining</span>
                                    <input type="date" id="joining" name="joining" placeholder="Date Of Joining">
                                </div>
                                <div class="input-box">
                                    <span class="details">Date Of Left</span>
                                    <input type="date" id="left" name="left" placeholder="Date Of Left">
                                </div>
                                <div class="input-box">
                                    <span class="details">Employee id</span>
                                    <input type="number" id="emp_id" name="emp_id" placeholder="Employee_id">
                                </div>
                            </div>
                            <div class="button w-75">
                                <input type="submit" value="update">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- //////////////end model//////////////////// -->
        <!-- ////////modal delete/////// -->

        <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Delete Student Data </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ route('admin.employee.destroy', ['employee' => 1]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">

                            <input type="hidden" name="delete_id" id="delete_id">

                            <h4> Do you want to Delete this Data ??</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> NO </button>
                            <button type="submit" name="deletedata" class="btn btn-primary"> Yes !! Delete it. </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </main>
    @endcan
    </div>

</x-app-layout>

<x-emp-attend-footer />


<script src="{{ asset('js/employee.js') }}"></script>
<script src="{{ asset('js/alert.js') }}"></script>
<script>
$(function() {
    $("#txtFrom").datepicker({
        dateFormat: 'yy-mm-dd',
        numberOfMonths: 1,
        onSelect: function(selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#txtTo").datepicker("option", "minDate", dt);
        }
    });
    $("#txtTo").datepicker({
        dateFormat: 'yy-mm-dd',
        numberOfMonths: 1,
        onSelect: function(selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#txtFrom").datepicker("option", "maxDate", dt);
        }
    });
});
</script>