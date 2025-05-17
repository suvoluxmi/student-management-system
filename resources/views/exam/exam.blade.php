@extends("dashboard")

@section("content")
<div class="bg-gray-100 py-6">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-blue-700">Exam and Grading Management</h2>

        <!-- Search Bar -->
        <div class="mb-4 flex justify-between items-center">
            <input type="text" id="searchInput" placeholder="Search by exam title..." 
                   class="w-1/3 p-2 border rounded">
            <button onclick="openModal()" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Add New Exam</button>
        </div>

        <!-- Exam Table -->
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-blue-100">
                    <th class="border p-2">#SL</th>
                    <th class="border p-2">Exam Title</th>
                    <th class="border p-2">Subject</th>
                    <th class="border p-2">Date</th>
                    <th class="border p-2">Total Marks</th>
                    <th class="border p-2">Passing Marks</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Actions</th>
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
            <input type="hidden" id="examId">
            <input type="text" id="examTitle" placeholder="Exam Title" class="w-full p-2 border rounded mb-2">
            <input type="text" id="examSubject" placeholder="Subject" class="w-full p-2 border rounded mb-2">
            <input type="date" id="examDate" class="w-full p-2 border rounded mb-2">
            <input type="number" id="examTotalMarks" placeholder="Total Marks" class="w-full p-2 border rounded mb-2">
            <input type="number" id="examPassingMarks" placeholder="Passing Marks" class="w-full p-2 border rounded mb-2">
            <label class="flex items-center mb-4">
                <input type="checkbox" id="examStatus" class="mr-2" checked> Active
            </label>
            <div class="flex justify-end">
                <button onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button onclick="saveExam()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save</button>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;

        function openModal(id = null) {
            if (id) {
                $.get(`/exams/${id}`, function(exam) {
                    $('#modalTitle').text('Edit Exam');
                    $('#examId').val(exam.id);
                    $('#examTitle').val(exam.title);
                    $('#examSubject').val(exam.subject);
                    $('#examDate').val(exam.date);
                    $('#examTotalMarks').val(exam.total_marks);
                    $('#examPassingMarks').val(exam.passing_marks);
                    $('#examStatus').prop('checked', exam.status);
                });
            } else {
                $('#modalTitle').text('Add Exam');
                $('#examId').val('');
                $('#examTitle').val('');
                $('#examSubject').val('');
                $('#examDate').val('');
                $('#examTotalMarks').val('');
                $('#examPassingMarks').val('');
                $('#examStatus').prop('checked', true);
            }
            $('#examModal').removeClass('hidden');
        }

        function closeModal() {
            $('#examModal').addClass('hidden');
        }

        function fetchExams(page = 1, search = '') {
    $.get(`/exams?page=${page}&search=${search}`, function(response) {
        let table = $('#examTable');
        table.html('');

        const exams = response.data.data; // exam array
        exams.forEach((exam, index) => {
            table.append(`
                <tr>
                    <td class="border p-2 text-center">${index + 1}</td>
                    <td class="border p-2 text-center">${exam.title}</td>
                    <td class="border p-2 text-center">${exam.subject}</td>
                    <td class="border p-2 text-center">${exam.date}</td>
                    <td class="border p-2 text-center">${exam.total_marks}</td>
                    <td class="border p-2 text-center">${exam.passing_marks}</td>
                    <td class="border p-2 text-center">${exam.status ? 'Active' : 'Inactive'}</td>
                    <td class="border p-2 text-center">
                        <button onclick="openModal(${exam.id})" class="bg-yellow-500 text-white px-2 py-1 rounded mr-2">Edit</button>
                        <button onclick="deleteExam(${exam.id})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
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
                <span>Showing ${data.from || 0} to ${data.to || 0} of ${data.total} exams</span>
                <div>
                    <button ${data.prev_page_url ? '' : 'disabled'}
                            onclick="fetchExams(${data.current_page - 1}, $('#searchInput').val())"
                            class="bg-gray-300 px-4 py-2 rounded mr-2">Previous</button>
                    <button ${data.next_page_url ? '' : 'disabled'}
                            onclick="fetchExams(${data.current_page + 1}, $('#searchInput').val())"
                            class="bg-gray-300 px-4 py-2 rounded">Next</button>
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

            if (!examData.title || !examData.subject || !examData.date || !examData.total_marks || !examData.passing_marks) {
                Swal.fire('Error', 'All fields are required!', 'error');
                return;
            }

            let url = id ? `/exams/${id}` : '/exams';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: examData,
                success: function() {
                    closeModal();
                    fetchExams(currentPage, $('#searchInput').val());
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong!', 'error');
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
                        success: function() {
                            fetchExams(currentPage, $('#searchInput').val());
                            Swal.fire('Deleted!', 'Exam has been deleted.', 'success');
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            fetchExams();
            $('#searchInput').on('keyup', function() {
                fetchExams(1, $(this).val());
            });
        });
    </script>
</div>
@endsection
