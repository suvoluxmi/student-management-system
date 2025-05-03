@extends("dashboard")

@section("content")
<div class="bg-gray-100 py-6">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Course Management</h2>
        
        <!-- Search Bar -->
        <div class="mb-4 flex justify-between items-center">
            <input type="text" id="searchInput" placeholder="Search by name or code..." 
                   class="w-1/3 p-2 border rounded">
            <button onclick="openModal()" 
                    class="bg-blue-500 text-white px-4 py-2 rounded">Add New Course</button>
        </div>

        <!-- Course Table -->
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Code</th>
                    <th class="border p-2">Type</th>
                    <th class="border p-2">Credit</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody id="courseTable"></tbody>
        </table>

        <!-- Pagination -->
        <div id="pagination" class="mt-4 flex justify-between items-center"></div>
    </div>

    <!-- Modal for Add/Edit courses -->
    <div id="courseModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 id="modalTitle" class="text-xl font-bold mb-4">Add Course</h3>
            <input type="hidden" id="courseId">
            <input type="text" id="courseName" placeholder="Course Name" 
                   class="w-full p-2 border rounded mb-2">
            <input type="text" id="courseCode" placeholder="Course Code" 
                   class="w-full p-2 border rounded mb-2">
            <input type="text" id="courseType" placeholder="Course Type" 
                   class="w-full p-2 border rounded mb-2">
            <input type="text" id="courseCredit" placeholder="Credit" 
                   class="w-full p-2 border rounded mb-2">
      <!-- Checkbox for active/inactive status -->               
            <label class="flex items-center mb-4">
                <input type="checkbox" id="courseStatus" class="mr-2"> Active
            </label>
     <!-- Save and Cancel Buttons -->        
            <div class="flex justify-end">
                <button onclick="closeModal()" 
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button onclick="saveCourse()" 
                        class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;
    // Open Modal: If 'id' is given, fill the form for editing, otherwise open blank form for adding
        function openModal(id = null) {
            if (id) {
                $.get(`/courses/${id}`, function(course) {
                    $('#modalTitle').text('Edit Course');
                    $('#courseId').val(course.id);
                    $('#courseName').val(course.name);
                    $('#courseCode').val(course.code);
                    $('#courseType').val(course.type);
                    $('#courseCredit').val(course.credit);
                    $('#courseStatus').prop('checked', course.status);
                });
            } else {
                $('#modalTitle').text('Add Course');
                $('#courseId').val('');
                $('#courseName').val('');
                $('#courseCode').val('');
                $('#courseType').val('');
                $('#courseCredit').val('');
                $('#courseStatus').prop('checked', false);
            }
            $('#courseModal').removeClass('hidden');
        }
    // Close the modal
        function closeModal() { $('#courseModal').addClass('hidden'); }
    // Fetch and display courses with optional search and pagination
        function fetchCourses(page = 1, search = '') {
            $.get(`/courses?page=${page}&search=${search}`, function(response) {
                let table = $('#courseTable');
                table.html('');
    // Fill table rows with course data            
                response.data.data.forEach(course => {
                    table.append(`
                        <tr>
                            <td class="border p-2 text-center">${course.id}</td>
                            <td class="border p-2 text-center">${course.name}</td>
                            <td class="border p-2 text-center">${course.code}</td>
                            <td class="border p-2 text-center">${course.type}</td>
                            <td class="border p-2 text-center">${course.credit}</td>
                            <td class="border p-2 text-center">${course.status ? 'Active' : 'Inactive'}</td>
                            <td class="border p-2 text-center">
                                <button onclick="openModal(${course.id})" 
                                        class="bg-yellow-500 text-white px-2 py-1 rounded mr-2">Edit</button>
                                <button onclick="deleteCourse(${course.id})" 
                                        class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                            </td>
                        </tr>
                    `);
                });
                updatePagination(response.data);
            });
        }
     // Update the pagination display
        function updatePagination(data) {
            let pagination = $('#pagination');
            pagination.html('');                 // Clear previous pagination
            pagination.append(`
                <span>Showing ${data.from || 0} to ${data.to || 0} of ${data.total} courses</span>
                <div>
                    <button ${data.prev_page_url ? '' : 'disabled'} 
                            onclick="fetchCourses(${data.current_page - 1}, $('#searchInput').val())"
                            class="bg-gray-300 px-4 py-2 rounded mr-2">Previous</button>
                    <button ${data.next_page_url ? '' : 'disabled'} 
                            onclick="fetchCourses(${data.current_page + 1}, $('#searchInput').val())"
                            class="bg-gray-300 px-4 py-2 rounded">Next</button>
                </div>
            `);
        }
    // Save course: handles both Create and Update
        function saveCourse() {
            let id = $('#courseId').val();
            let courseData = {
                name: $('#courseName').val(),
                code: $('#courseCode').val(),
                type: $('#courseType').val(),
                credit: $('#courseCredit').val(),
                status: $('#courseStatus').is(':checked') ? 1 : 0,
                _token: '{{ csrf_token() }}'
            };

            if (!courseData.name || !courseData.code || !courseData.type || !courseData.credit) {
                Swal.fire('Error', 'All fields are required!', 'error');
                return;
            }
     // If ID exists, update; otherwise create
            let url = id ? `/courses/${id}` : '/courses';
            let method = id ? 'PUT' : 'POST';
    // Make AJAX call to save data
            $.ajax({
                url: url,
                type: method,
                data: courseData,
                success: function() {
                    closeModal();
                    fetchCourses(currentPage, $('#searchInput').val());
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON.message || 'Something went wrong!', 'error');
                }
            });
        }
    // Delete a course by ID
        function deleteCourse(id) {
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
                        url: `/courses/${id}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function() {
                            fetchCourses(currentPage, $('#searchInput').val());
                            Swal.fire('Deleted!', 'Course has been deleted.', 'success');
                        }
                    });
                }
            });
        }
    // On page load, fetch courses and setup search bar
        $(document).ready(function() {
            fetchCourses();
            $('#searchInput').on('keyup', function() {
                fetchCourses(1, $(this).val());         // Fetch courses when typing in search
            });
        });
    </script>
</div>
@endsection