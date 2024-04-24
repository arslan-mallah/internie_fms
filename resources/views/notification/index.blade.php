<x-app-layout>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <link rel="stylesheet" type="text/css" href="{{asset('css/notification.css')}}">


    @can('shownotification')


    <main >    
        @if(session()->has('message'))
        <div class="alert alert-success w-50">
            {{session()->get('message')}}
            <button type="button" class="close" data-bs-dismiss="alert" id="alert">x</button>
        </div>
        @endif

        <!-- ///////////////table/////////// -->
        <h2>Notification</h2>
<div class="table-wrapper">
    <table id="notification" class="fl-table">
        <thead>
        <tr>
                                <th>Id</th>
                                <th>user id</th>
                                <th>user name</th>
                                <th>Affected page</th>
                                <th>Action done</th>
                                <th class="d-none">old data</th>
                                <th class="d-none">new data</th>
                                <th>Date</th>
                                <th>Mark</th>
                                <th>Action</th>
        </tr>
        </thead>
        
    </table>
</div>

        <!-- //////////////modal for edit//////////////////// -->
        <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="content">
                        <form class="bg-light p-4">

                            <input type="hidden" name="update_id" id="update_id">
                            <h3>Old data</h3>
                            <div class="user-details">
                                <div class="input-box">
                                    <span class="details Name">Date</span>
                                    <textarea name="first" id="first" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Category</span>
                                    <textarea name="second" id="second" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Detail</span>
                                    <textarea name="third" id="third" cols="20" rows="2"></textarea>

                                </div>
                                <div class="input-box">
                                    <span class="details">Debit</span>
                                    <textarea name="fourth" id="fourth" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Credit</span>
                                    <input type="text" id="five" name="five" placeholder="Credit">
                                </div>

                            </div>
                            <h3>New data</h3>
                            <div class="user-details">


                                <div class="input-box">
                                    <span class="details">Category</span>
                                    <textarea name="second1" id="second1" cols="20" rows="2"></textarea>

                                </div>
                                <div class="input-box">
                                    <span class="details">Detail</span>
                                    <textarea name="third1" id="third1" cols="20" rows="2"></textarea>

                                </div>

                                <div class="input-box">
                                    <span class="details">Debit</span>
                                    <textarea name="fourth1" id="fourth1" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Credit</span>
                                    <textarea name="five1" id="five1" cols="20" rows="2"></textarea>
                                </div>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- //////////////end model//////////////////// -->


        <!-- ////////////modal for attendance////////// -->

        <div class="modal fade" id="attendancemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="content">
                        <form class="bg-light p-4">

                            <input type="hidden" name="update_id" id="update_id">
                            <h3>Old data</h3>
                            <div class="user-details">
                                <div class="input-box">
                                    <span class="details Name">Employee name</span>
                                    <textarea name="first3" id="first3" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Status</span>
                                    <textarea name="second3" id="second3" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">reason</span>
                                    <textarea name="third3" id="third3" cols="20" rows="2"></textarea>

                                </div>
                                <div class="input-box">
                                    <span class="details">Work summary</span>
                                    <textarea name="fourth3" id="fourth3" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Date</span>
                                    <input type="text" id="five3" name="five3">
                                </div>

                            </div>
                            <h3>New data</h3>
                            <div class="user-details">

                                <div class="input-box">
                                    <span class="details Name">Employee name</span>
                                    <input type="text" id="first4" name="first4">
                                </div>
                                <div class="input-box">
                                    <span class="details">Status</span>
                                    <textarea name="second4" id="second4" cols="20" rows="2"></textarea>

                                </div>
                                <div class="input-box">
                                    <span class="details">Reason</span>
                                    <textarea name="third4" id="third4" cols="20" rows="2"></textarea>

                                </div>

                                <div class="input-box">
                                    <span class="details">Work summary</span>
                                    <textarea name="fourth4" id="fourth4" cols="20" rows="2"></textarea>
                                </div>


                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- //////////end modal///////////// -->

        <!-- ////////////modal for employee////////// -->

        <div class="modal fade" id="employeemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="content">
                        <form class="bg-light p-4">

                            <input type="hidden" name="update_id" id="update_id">
                            <h3>Old data</h3>
                            <div class="user-details">
                                <div class="input-box">
                                    <span class="details Name">Employee name</span>
                                    <textarea name="first5" id="first5" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <textarea name="second5" id="second5" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Mobile</span>
                                    <textarea name="third5" id="third5" cols="20" rows="2"></textarea>

                                </div>
                                <div class="input-box">
                                    <span class="details">Contact</span>
                                    <textarea name="fourth5" id="fourth5" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Address</span>
                                    <textarea name="five5" id="five5" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">CNIC</span>
                                    <textarea name="six5" id="six5" cols="20" rows="2"></textarea>

                                </div>
                                <div class="input-box">
                                    <span class="details">Date of joining</span>
                                    <textarea name="seven5" id="seven5" cols="20" rows="2"></textarea>

                                </div>
                                <div class="input-box">
                                    <span class="details">Date Left</span>
                                    <textarea name="eight5" id="eight5" cols="20" rows="2"></textarea>

                                </div>
                                <div class="input-box">
                                    <span class="details">Employee idate</span>
                                    <textarea name="nine5" id="nine5" cols="20" rows="2"></textarea>

                                </div>
                            </div>
                            <h3>New data</h3>
                            <div class="user-details">

                                <div class="input-box">
                                    <span class="details Name">Employee name</span>
                                    <textarea name="first6" id="first6" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <textarea name="second6" id="second6" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Mobile</span>
                                    <textarea name="third6" id="third6" cols="20" rows="2"></textarea>

                                </div>
                                <div class="input-box">
                                    <span class="details">Contact</span>
                                    <textarea name="fourth6" id="fourth6" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Address</span>
                                    <textarea name="five6" id="five6" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">CNIC</span>
                                    <textarea name="six6" id="six6" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Date of joining</span>
                                    <textarea name="seven6" id="seven6" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Date Left</span>
                                    <textarea name="eight6" id="eight6" cols="20" rows="2"></textarea>
                                </div>
                                <div class="input-box">
                                    <span class="details">Employee id</span>
                                    <textarea name="nine6" id="nine6" cols="20" rows="2"></textarea>
                                </div>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- //////////end modal///////////// -->
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

        <script src="https://code.jquery.com/jquery.min.js"></script>
    </main>
    @endcan
    </div>

</x-app-layout>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>


<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/notification.js') }}"></script>
<script src="{{ asset('js/alert.js') }}"></script>