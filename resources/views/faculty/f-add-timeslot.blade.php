@extends('layouts.faculty-nav')
@section('content')
    <div class="main_container">
        <div class="container">
            <div class="box right-box">
                <h3 class="title-container">Add Timeslot</h3>
                <div class="content">

                    <form id="addslotFormId{{ $user->id }}" action="{{ route('timeslots.store') }}" method="POST"
                        class="custom-form">
                        @csrf
                        <div class="form-group">
                            <select name="user_id" id="user_id" class="custom-select" required hidden>
                                <option value="">-- Select Faculty --</option>
                                @foreach ($faculty as $member)
                                    <option value="{{ $member->id }}" {{ $id == $member->id ? 'selected' : '' }}>
                                        {{ $member->fname }} {{ $member->lname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="user_id" value="{{ $id }}">

                        <div class="form-group">
                            <label for="day">Select Day</label>
                            <select name="day" id="day" class="custom-select" required>
                                <option value="">-- Select Day --</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start">Start Time</label>
                            <input type="time" name="start" id="start" class="custom-input" required>
                        </div>

                        <div class="form-group">
                            <label for="end">End Time</label>
                            <input type="time" name="end" id="end" class="custom-input" required>
                        </div>

                        <button type="button" class="custom-button" onclick="confirmAddSlot({{ $user->id }})">Add
                            Timeslot</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    @if (session('error'))
        <script>
            swal("Failed!", "{{ session('error') }}", "error");
        </script>
    @endif

    @if (session('success'))
        <script>
            swal("Success!", "{{ session('success') }}", "success");
        </script>
    @endif
    <script>
        function confirmAddSlot(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to add this time slot?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed8936",
                cancelButtonColor: "#ccc",
                cancelButtonText: "Cancel",
                confirmButtonText: "Yes, Add it!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('addslotFormId' + id).submit();
                }
            });
        }
    </script>
@endsection
