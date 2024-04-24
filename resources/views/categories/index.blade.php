<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('css/employee.css')}}">

    <div>
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 mt-3">

            <div class="container mx-auto px-6 py-2">
                <div class="text-right">
                    @can('createcategories')
                    <button
                        class="create-btn bg-blue-500 text-white font-bold px-5 py-1 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors ">New
                        Category</button>
                    @endcan
                </div>

                <div class="bg-white shadow-md rounded my-6">
                    <table class="text-left w-full border-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">
                                    Categories</th>
                                <!-- <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Role</th> -->
                                <th
                                    class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @can('showcategories')
                            @foreach($data_general as $data_general)
                            <tr class="hover:bg-grey-lighter">
                                <td class="py-4 px-6 border-b border-grey-light">{{ $data_general->category }}</td>

                                <td class="py-4 px-6 border-b border-grey-light text-right">


                                    @can('deletecategories')
                                    <form action="{{ route('admin.categories.destroy', $data_general->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{$data_general->id}}">


                                        <button
                                            class="text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-blue hover:bg-blue-dark text-red-400">Delete</button>
                                    </form>
                                    @endcan

                                </td>
                            </tr>
                            @endforeach
                            @endcan

                        </tbody>
                    </table>
                </div>

            </div>

            <!-- //////////////modal for edit//////////////////// -->
            <div class="modal fade" id="createmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> Create Category </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>


                        <div class="content">
                            <form action="{{ route('admin.categories.store')}}" method="POST" class="bg-light p-4">
                                @csrf
                                <input type="hidden" name="update_id" id="update_id">

                                <div class="input-box">
                                    <span class="details Name">Name</span>
                                    <input type="text" id="category" name="category" placeholder="Category" required>
                                </div>

                                <div class="button w-75">
                                    <input type="submit" value="Create">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('js/category.js') }}"></script>


</x-app-layout>