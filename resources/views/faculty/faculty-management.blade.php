@extends("dashboard")

@section("content")
<div class="bg-gray-100 py-6">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-green-700">Faculty Management</h2>
        
        <!-- Search Bar -->
        <div class="mb-4 flex justify-between items-center">
            <input type="text" id="searchInput" placeholder="Search by name or email..." 
                   class="w-1/3 p-2 border rounded">
            <button onclick="openModal()" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Add New Faculty</button>
        </div>

        <!-- Faculty Table -->
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-green-100">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Phone</th>
                    <th class="border p-2">Department</th>
                    <th class="border p-2">Designation</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody id="facultyTable"></tbody>
        </table>

        <!-- Pagination -->
        <div id="pagination" class="mt-4 flex justify-between items-center"></div>
    </div>

    <!-- Modal for Add/Edit -->
    <div id="facultyModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 id="modalTitle" class="text-xl font-bold mb-4 text-green-700">Add Faculty</h3>
            <input type="hidden" id="facultyId">
            <input type="text" id="facultyName" placeholder="Faculty Name" 
                   class="w-full p-2 border rounded mb-2">
            <input type="email" id="facultyEmail" placeholder="Email" 
                   class="w-full p-2 border rounded mb-2">
            <input type="text" id="facultyPhone" placeholder="Phone (optional)" 
                   class="w-full p-2 border rounded mb-2">
            <input type="text" id="facultyDepartment" placeholder="Department" 
                   class="w-full p-2 border rounded mb-2">
            <input type="text" id="facultyDesignation" placeholder="Designation" 
                   class="w-full p-2 border rounded mb-2">
            <label class="flex items-center mb-4">
                <input type="checkbox" id="facultyStatus" class="mr-2" checked> Active
            </label>
            <div class="flex justify-end">
                <button onclick="closeModal()" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button onclick="saveFaculty()" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Save</button>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;

        function openModal(id = null) {
            if (id) {
                $.get(`/faculties/${id}`, function(faculty) {
                    $('#modalTitle').text('Edit Faculty');
                    $('#facultyId').val(faculty.id);
                    $('#facultyName').val(faculty.name);
                    $('#facultyEmail').val(faculty.email);
                    $('#facultyPhone').val(faculty.phone);
                    $('#facultyDepartment').val(faculty.department);
                    $('#facultyDesignation').val(faculty.designation);
                    $('#facultyStatus').prop('checked', faculty.status);
                });
            } else {
                $('#modalTitle').text('Add Faculty');
                $('#facultyId').val('');
                $('#facultyName').val('');
                $('#facultyEmail').val('');
                $('#facultyPhone').val('');
                $('#facultyDepartment').val('');
                $('#facultyDesignation').val('');
                $('#facultyStatus').prop('checked', true);
            }
            $('#facultyModal').removeClass('hidden');
        }

        function closeModal() { $('#facultyModal').addClass('hidden'); }

        function fetchFaculties(page = 1, search = '') {
            $.get(`/faculties?page=${page}&search=${search}`, function(response) {
                let table = $('#facultyTable');
                table.html('');
                response.data.data.forEach(faculty => {
                    table.append(`
                        <tr>
                            <td class="border p-2 text-center">${faculty.id}</td>
                            <td class="border p-2 text-center">${faculty.name}</td>
                            <td class="border p-2 text-center">${faculty.email}</td>
                            <td class="border p-2 text-center">${faculty.phone || '-'}</td>
                            <td class="border p-2 text-center">${faculty.department}</td>
                            <td class="border p-2 text-center">${faculty.designation}</td>
                            <td class="border p-2 text-center">${faculty.status ? 'Active' : 'Inactive'}</td>
                            <td class="border p-2 text-center">
                                <button onclick="openModal(${faculty.id})" 
                                        class="bg-blue-500 hover:bg-yellow-600 text-white px-2 py-1 rounded mr-2"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button onclick="deleteFaculty(${faculty.id})" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded"><i class="fa-solid fa-trash"></i></button>
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
                <span>Showing ${data.from || 0} to ${data.to || 0} of ${data.total} faculties</span>
                <div>
                    <button ${data.prev_page_url ? '' : 'disabled'} 
                            onclick="fetchFaculties(${data.current_page - 1}, $('#searchInput').val())"
                            class="bg-gray-300 px-4 py-2 rounded mr-2">Previous</button>
                    <button ${data.next_page_url ? '' : 'disabled'} 
                            onclick="fetchFaculties(${data.current_page + 1}, $('#searchInput').val())"
                            class="bg-gray-300 px-4 py-2 rounded">Next</button>
                </div>
            `);
        }

        function saveFaculty() {
            let id = $('#facultyId').val();
            let facultyData = {
                name: $('#facultyName').val(),
                email: $('#facultyEmail').val(),
                phone: $('#facultyPhone').val(),
                department: $('#facultyDepartment').val(),
                designation: $('#facultyDesignation').val(),
                status: $('#facultyStatus').is(':checked') ? 1 : 0,
                _token: '{{ csrf_token() }}'
            };

            if (!facultyData.name || !facultyData.email || !facultyData.department || !facultyData.designation) {
                Swal.fire('Error', 'Name, Email, Department, and Designation are required!', 'error');
                return;
            }

            let url = id ? `/faculties/${id}` : '/faculties';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: facultyData,
                success: function() {
                    closeModal();
                    fetchFaculties(currentPage, $('#searchInput').val());
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON.message || 'Something went wrong!', 'error');
                }
            });
        }

        function deleteFaculty(id) {
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
                        url: `/faculties/${id}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function() {
                            fetchFaculties(currentPage, $('#searchInput').val());
                            Swal.fire('Deleted!', 'Faculty has been deleted.', 'success');
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            fetchFaculties();
            $('#searchInput').on('keyup', function() {
                fetchFaculties(1, $(this).val());
            });
        });
    </script>
</div>
@endsection