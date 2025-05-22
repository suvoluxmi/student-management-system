@extends('dashboard')

@section('content')
<div class="bg-gray-100 py-6">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-blue-700">Exam and Grading Management</h2>

        <!-- Search Bar -->
        <div class="mb-4 flex justify-between items-center">
            <input type="text" id="searchInput" placeholder="Search by exam title or subject..." 
                   class="w-1/3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
            <button onclick="openModal()" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-200">Add New Exam</button>
        </div>

        <!-- Exam Table -->
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-blue-100">
                    <th class="border p-2 text-center">SL</th>
                    <th class="border p-2 text-center">Exam Title</th>
                    <th class="border p-2 text-center">Subject</th>
                    <th class="border p-2 text-center">Date</th>
                    <th class="border p-2 text-center">Total Marks</th>
                    <th class="border p-2 text-center">Passing Marks</th>
                    <th class="border p-2 text-center">Status</th>
                    <th class="border p-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="examTable"></tbody>
        </table>

        <!-- Pagination -->
        <div id="pagination" class="mt-4 flex justify-between items-center"></div>
    </div>

    <!-- Modal -->
    <div id="examModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 id="modalTitle" class="text-xl font-bold mb-4 text-blue-700">Add Exam</h3>
            <form id="examForm">
                <input type="hidden" id="examId" name="examId">
                <input type="text" id="examTitle" name="title" placeholder="Exam Title" 
                       class="w-full p-2 border rounded mb-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                <input type="text" id="examSubject" name="subject" placeholder="Subject" 
                       class="w-full p-2 border rounded mb-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                <input type="date" id="examDate" name="date" 
                       class="w-full p-2 border rounded mb-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                <input type="number" id="examTotalMarks" name="total_marks" placeholder="Total Marks" 
                       class="w-full p-2 border rounded mb-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                <input type="number" id="examPassingMarks" name="passing_marks" placeholder="Passing Marks" 
                       class="w-full p-2 border rounded mb-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                <label class="flex items-center mb-4">
                    <input type="checkbox" id="examStatus" name="status" class="mr-2" checked> Active
                </label>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2 transition duration-200">Cancel</button>
                    <button type="button" onclick="saveExam()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-200">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white p-5 my-8">
        <h2 class="text-xl font-bold mb-4 text-blue-700">BAUST Grading System</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-blue-100">
                    <th class="border p-2">Grade</th>
                    <th class="border p-2">Grade Point</th>
                    <th class="border p-2">Marks Range (%)</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="border p-2">A+</td><td class="border p-2">4.0</td><td class="border p-2">80 - 100</td></tr>
                <tr><td class="border p-2">A</td><td class="border p-2">3.75</td><td class="border p-2">75 - 80</td></tr>
                <tr><td class="border p-2">A-</td><td class="border p-2">3.50</td><td class="border p-2">70 - 74</td></tr>
                <tr><td class="border p-2">B+</td><td class="border p-2">3.25</td><td class="border p-2">65 - 69</td></tr>
                <tr><td class="border p-2">B</td><td class="border p-2">3.00</td><td class="border p-2">60 - 64</td></tr>
                <tr><td class="border p-2">B-</td><td class="border p-2">2.75</td><td class="border p-2">55 - 59</td></tr>
                <tr><td class="border p-2">C+</td><td class="border p-2">2.50</td><td class="border p-2">50 - 54</td></tr>
                <tr><td class="border p-2">C</td><td class="border p-2">2.25</td><td class="border p-2">45 - 49</td></tr>
                <tr><td class="border p-2">D</td><td class="border p-2">2.00</td><td class="border p-2">40 - 44/td></tr>
                <tr><td class="border p-2">F</td><td class="border p-2">0.0</td><td class="border p-2">0 - 40</td></tr>
            </tbody>
        </table>
    </div>

    <script>
        let currentPage = 1;

        function openModal(id = null) {
            if (id) {
                $.ajax({
                    url: `/exams/${id}`,
                    type: 'GET',
                    success: function(exam) {
                        $('#modalTitle').text('Edit Exam');
                        $('#examId').val(exam.id);
                        $('#examTitle').val(exam.title);
                        $('#examSubject').val(exam.subject);
                        $('#examDate').val(exam.date);
                        $('#examTotalMarks').val(exam.total_marks);
                        $('#examPassingMarks').val(exam.passing_marks);
                        $('#examStatus').prop('checked', exam.status);
                        $('#examModal').removeClass('hidden');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to fetch exam details',
                        });
                    }
                });
            } else {
                $('#modalTitle').text('Add Exam');
                $('#examForm')[0].reset();
                $('#examId').val('');
                $('#examStatus').prop('checked', true);
                $('#examModal').removeClass('hidden');
            }
        }

        function closeModal() {
            $('#examModal').addClass('hidden');
            $('#examForm')[0].reset();
        }

        function fetchExams(page = 1, search = '') {
            $.ajax({
                url: `/exams?page=${page}&search=${search}`,
                type: 'GET',
                success: function(response) {
                    let table = $('#examTable');
                    table.empty();

                    const exams = response.data.data;
                    exams.forEach((exam, index) => {
                        table.append(`
                            <tr>
                                <td class="border p-2 text-center">${(page - 1) * 10 + index + 1}</td>
                                <td class="border p-2 text-center">${exam.title}</td>
                                <td class="border p-2 text-center">${exam.subject}</td>
                                <td class="border p-2 text-center">${exam.date}</td>
                                <td class="border p-2 text-center">${exam.total_marks}</td>
                                <td class="border p-2 text-center">${exam.passing_marks}</td>
                                <td class="border p-2 text-center">${exam.status ? 'Active' : 'Inactive'}</td>
                                <td class="border p-2 text-center">
                                    <button onclick="openModal(${exam.id})" 
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded mr-2 transition duration-200">Edit</button>
                                    <button onclick="deleteExam(${exam.id})" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded transition duration-200">Delete</button>
                                </td>
                            </tr>
                        `);
                    });

                    updatePagination(response.data);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Failed to fetch exams',
                    });
                }
            });
        }

        function updatePagination(data) {
            let pagination = $('#pagination');
            pagination.empty();
            pagination.append(`
                <span>Showing ${data.from || 0} to ${data.to || 0} of ${data.total} exams</span>
                <div>
                    <button ${data.prev_page_url ? '' : 'disabled'}
                            onclick="fetchExams(${data.current_page - 1}, $('#searchInput').val())"
                            class="bg-gray-300 px-4 py-2 rounded mr-2 hover:bg-gray-400 transition duration-200 ${data.prev_page_url ? '' : 'opacity-50 cursor-not-allowed'}">Previous</button>
                    <button ${data.next_page_url ? '' : 'disabled'}
                            onclick="fetchExams(${data.current_page + 1}, $('#searchInput').val())"
                            class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition duration-200 ${data.next_page_url ? '' : 'opacity-50 cursor-not-allowed'}">Next</button>
                </div>
            `);
        }

        function saveExam() {
            let id = $('#examId').val();
            let examData = {
                title: $('#examTitle').val(),
                subject: $('#examSubject').val(),
                date: $('#examDate').val(),
                total_marks: $('#examTotalMarks').val(),
                passing_marks: $('#examPassingMarks').val(),
                status: $('#examStatus').is(':checked') ? 1 : 0,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: id ? `/exams/${id}` : '/exams',
                type: id ? 'PUT' : 'POST',
                data: examData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: id ? 'Exam updated successfully!' : 'Exam created successfully!',
                    });
                    closeModal();
                    fetchExams(currentPage, $('#searchInput').val());
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong!',
                    });
                }
            });
        }

        function deleteExam(id) {
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
                        url: `/exams/${id}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Exam has been deleted.',
                            });
                            fetchExams(currentPage, $('#searchInput').val());
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'Failed to delete exam',
                            });
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            fetchExams();
            $('#searchInput').on('keyup', function() {
                currentPage = 1;
                fetchExams(1, $(this).val());
            });
        });
    </script>
</div>
@endsection