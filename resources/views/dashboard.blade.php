<x-app-layout>
    <div>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
            <div class="container mx-auto px-6 py-8">


                <h3 class="text-gray-700 text-3xl font-medium">Welcome : {{ auth()->user()->name }}</h3>

                <p>Role : <b>
                        @foreach(auth()->user()->roles as $role)
                        {{ $role->name }}
                        @endforeach
                    </b> </p>

                @can('fetchattendance')
                <div class="container mt-3 mb-0">

                    <h4 style='color:blue;'>you have {{$number}} new notifications</h4>

                </div>
                @endcan
            </div>
        </main>
    </div>
    </div>
</x-app-layout>