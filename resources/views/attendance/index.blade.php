<x-app-layout>

    <x-emp-atten-cdn />
    <link rel="stylesheet" type="text/css" href="{{asset('css/attendance.css')}}">


    @can('showattendance')

    <main>
        @can('fetchattendance')
        <div class="text-center mt-4">
            <form action="attendance" class="mt-3" method="POST">
                @csrf
                <label for=""> Date:</label>
                <input type="date" placeholder="yyyy-mm-dd" id="fetch_date" class="mt-2" value="" name="date" size="14">
                &nbsp;
                <button type="submit" name="fetch" class="btn btn-primary">fetch data</button>
            </form>
        </div>
        @endcan

        <!-- ////////////////first/////////// -->

        <h2>Attendance</h2>
    <div class="table-wrapper">
    <table id="employee_data" class="fl-table">
    <thead>
                                <tr>
                                <th>Id</th>
                                <th>Employee Id</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Reason</th>
                                <th>Summary</th>
                                <th>date</th>
                                <th>Edit</th>
                                </tr>
                            </thead>

        
    </table>
</div>




        <!-- //////////////modal////////////////////// -->


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
                        <form id="updateForm" class="bg-light p-4">

                            <input type="hidden" name="update_id" id="update_id">
                            <div class="user-details">
                                <div class="input-box">
                                    <span class="details">Employee id</span>
                                    <input type="text" id="emp_id" name="emp_id" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">Name</span>
                                    <input type="text" id="name" name="name" required>

                                </div>
                                <div class="input-box">
                                    <span class="details">Status</span>
                                    <input type="text" id="status" name="status">
                                </div>
                                <div class="input-box">
                                    <span class="details">Reason</span>
                                    <textarea name="reason" id="reason" cols="20" rows="2"></textarea>

                                </div>


                            </div>
                            <div class="input-box">
                                <span class="details">Summary</span>
                                <textarea name="summary" id="summary" cols="50" rows="4"></textarea>
                            </div>

                        </form>
                        <div class="button w-75">
                            <input type="submit" id="update" value="update">
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <!-- //////////////////////reason modal/////////////////// -->


        <div class="modal fade" id="reasonmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">view or Edit reason</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="content p-4">
                        <form id="reasonform">

                            <input type="hidden" name="update_id" id="update_id">
                            <div class="user-details">

                                <div class="input-box">
                                    <span class="details">Reason</span>
                                    <textarea name="reason" id="reas" cols="50" rows="4"></textarea>
                                </div>


                            </div>


                        </form>
                        <div class="button w-75">
                            <input type="submit" id="reas_update" value="update">
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- //////////////////////summary modal////////////// -->

        <div class="modal fade" id="summodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> view or edit summary </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="content p-4">
                        <form id="sumform">

                            <input type="hidden" name="update_id" id="update_id">
                            <div class="input-box">
                                <span class="details">Summary</span>
                                <textarea name="summary" id="sum" cols="50" rows="4"></textarea>
                            </div>

                        </form>
                        <div class="button w-75">
                            <input type="submit" id="sum_update" value="update">
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </main>
    @endcan

    </div>



    <x-emp-attend-footer />
    <script src="{{ asset('js/addpay.js') }}"></script>
    <script src="{{ asset('js/atten.js') }}"></script>
</x-app-layout>