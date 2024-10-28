@extends('layouts.faculty-nav')

@section('content')
    <div class="main_container">
        <div class="container">
            <div class="box left-box">
                <p class="title-container">Faculty Load</p>
                <table class="content-table">
                    <!-- Table headers -->
                    <thead>
                        <tr>
                            <th scope="col">Course</th>
                            <th scope="col">Year</th>
                            <th scope="col">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($professorLoad as $load)
                            <tr>
                                <td>
                                    {{ $load->course->name }}
                                </td>
                                <td>
                                    {{ $load->year->level }}
                                </td>
                                <td>
                                    <form id="remove-load-{{$load->id}}" action="{{ route('delete.load', [$load->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="queue-button" onclick="deleteLoad({{$load->id}})">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <div class="box right-box">
                <p class="title-container">Add Faculty Load</p>
                @if (session('error'))
                    <script>
                        Swal.fire("Failed!", "{{ session('error') }}", "error");
                    </script>
                @endif

                @if (session('success'))
                    <script>
                        Swal.fire("Success!", "{{ session('success') }}", "success");
                    </script>
                @endif

                <form  action="{{ route('store.load') }}" method="POST" >
                    @csrf
                    <table class="content-table">
                        <!-- Table headers -->
                        <thead>
                            <tr>
                                <th scope="col">Course</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courseYears as $courseYear)
                                <tr>
                                    <td>
                                        <label for="courseYear{{ $courseYear['course_id'] }}_{{ $courseYear['year_id'] }}">
                                            {{ $courseYear['course_name'] }} {{ $courseYear['year_level'] }}
                                        </label>
                                    </td>
                                    <td>
                                        <input type="checkbox"
                                            id="courseYear{{ $courseYear['course_id'] }}_{{ $courseYear['year_id'] }}"
                                            name="course_years[]"
                                            value="{{ $courseYear['course_id'] }}_{{ $courseYear['year_id'] }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="queue-button">Add</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function deleteLoad(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to remove this load!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ed8936',
                cancelButtonColor: '#ccc',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('remove-load-' + id).submit();
                }
            });
        }
    </script>

@endsection
