@extends('dashboard')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-blue-900">
            <i class="fas fa-user-graduate mr-2"></i> Student Management
        </h2>
        <div class="relative">
            <input type="text" id="searchInput" placeholder="Search by name or ID..." 
                   class="p-2 pl-10 border rounded mr-4">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
        </div>
        <button onclick="openModal()" 
                class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
            <i class="fas fa-plus mr-2"></i> Add New Student
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white shadow-md rounded-lg">
            <thead>
                <tr class="bg-blue-900 text-white">
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">ID Card Number</th>
                    <th class="p-3 text-left">Semester</th>
                    <th class="p-3 text-left">Faculty</th>
                    <th class="p-3 text-left">Phone Number</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="studentTable">
                <!-- Dynamic content will be loaded here -->
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div id="pagination" class="mt-4 flex justify-between items-center"></div>
</div>

<!-- Modal for Add/Edit -->
<div id="studentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 id="modalTitle" class="text-xl font-bold mb-4 text-blue-900">
            <i class="fas fa-user-plus mr-2"></i> Add Student
        </h3>
        <input type="hidden" id="studentId">
        <div class="relative mb-2">
            <input type="text" id="studentName" placeholder="Student Name" 
                   class="w-full p-2 pl-10 border rounded">
            <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
        </div>
        <div class="relative mb-2">
            <input type="text" id="studentIdCard" placeholder="ID Card Number" 
                   class="w-full p-2 pl-10 border rounded">
            <i class="fas fa-id-card absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
        </div>
        <div class="relative mb-2">
            <input type="text" id="studentSemester" placeholder="Semester" 
                   class="w-full p-2 pl-10 border rounded">
            <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
        </div>
        <div class="relative mb-2">
            <input type="text" id="studentFaculty" placeholder="Faculty" 
                   class="w-full p-2 pl-10 border rounded">
            <i class="fas fa-university absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
        </div>
        <div class="relative mb-2">
            <input type="text" id="studentPhone" placeholder="Phone Number" 
                   class="w-full p-2 pl-10 border rounded">
            <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
        </div>
        <label class="flex items-center mb-4">
            <input type="checkbox" id="studentStatus" class="mr-2" checked>
            <span><i class="fas fa-toggle-on mr-2 text-blue-500"></i> Active</span>
        </label>
        <div class="flex justify-end">
            <button onclick="closeModal()" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
                <i class="fas fa-times mr-2"></i> Cancel
            </button>
            <button onclick="saveStudent()" 
                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                <i class="fas fa-save mr-2"></i> Save
            </button>
        </div>
    </div>
</div>

<script>
    let currentPage = 1;

    function openModal(id = null) {
        if (id) {
            $.get(`/students/${id}`, function(student) {
                $('#modalTitle').html('<i class="fas fa-user-edit mr-2"></i> Edit Student');
                $('#studentId').val(student.id);
                $('#studentName').val(student.name);
                $('#studentIdCard').val(student.id_card_number);
                $('#studentSemester').val(student.semester);
                $('#studentFaculty').val(student.faculty);
                $('#studentPhone').val(student.phone_number);
                $('#studentStatus').prop('checked', student.status);
            });
        } else {
            $('#modalTitle').html('<i class="fas fa-user-plus mr-2"></i> Add Student');
            $('#studentId').val('');
            $('#studentName').val('');
            $('#studentIdCard').val('');
            $('#studentSemester').val('');
            $('#studentFaculty').val('');
            $('#studentPhone').val('');
            $('#studentStatus').prop('checked', true);
        }
        $('#studentModal').removeClass('hidden');
    }

    function closeModal() { $('#studentModal').addClass('hidden'); }

    function fetchStudents(page = 1, search = '') {
        $.get(`/students?page=${page}&search=${search}`, function(response) {
            let table = $('#studentTable');
            table.html('');
            response.data.data.forEach(student => {
                table.append(`
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3">${student.name}</td>
                        <td class="p-3">${student.id_card_number}</td>
                        <td class="p-3">${student.semester}</td>
                        <td class="p-3">${student.faculty}</td>
                        <td class="p-3">${student.phone_number}</td>
                        <td class="p-3">
                            <button onclick="openModal(${student.id})" 
                                    class="text-blue-500 hover:underline mr-2">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button onclick="deleteStudent(${student.id})" 
                                    class="text-red-500 hover:underline">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                `);
            });
            updatePagination(response.data);
        });
    }

    function updatePagination(data) {
        let pagination = $('#pagination');
        pagination.html('');
        pagination.append(`
            <span>Showing ${data.from || 0} to ${data.to || 0} of ${data.total} students</span>
            <div>
                <button ${data.prev_page_url ? '' : 'disabled'} 
                        onclick="fetchStudents(${data.current_page - 1}, $('#searchInput').val())"
                        class="bg-gray-300 px-4 py-2 rounded mr-2">
                    <i class="fas fa-arrow-left mr-2"></i> Previous
                </button>
                <button ${data.next_page_url ? '' : 'disabled'} 
                        onclick="fetchStudents(${data.current_page + 1}, $('#searchInput').val())"
                        class="bg-gray-300 px-4 py-2 rounded">
                    Next <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        `);
    }

    function saveStudent() {
        let id = $('#studentId').val();
        let studentData = {
            name: $('#studentName').val(),
            id_card_number: $('#studentIdCard').val(),
            semester: $('#studentSemester').val(),
            faculty: $('#studentFaculty').val(),
            phone_number: $('#studentPhone').val(),
            status: $('#studentStatus').is(':checked') ? 1 : 0,
            _token: '{{ csrf_token() }}'
        };

        if (!studentData.name || !studentData.id_card_number || !studentData.semester || 
            !studentData.faculty || !studentData.phone_number) {
            Swal.fire('Error', 'All fields are required!', 'error');
            return;
        }

        let url = id ? `/students/${id}` : '/students';
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: studentData,
            success: function() {
                closeModal();
                fetchStudents(currentPage, $('#searchInput').val());
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON.message || 'Something went wrong!', 'error');
            }
        });
    }

    function deleteStudent(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/students/${id}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        fetchStudents(currentPage, $('#searchInput').val());
                        Swal.fire('Deleted!', 'Student has been deleted.', 'success');
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        fetchStudents();
        $('#searchInput').on('keyup', function() {
            fetchStudents(1, $(this).val());
        });
    });
</script>
@endsection