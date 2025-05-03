@extends("dashboard")

@section("content")
<div class="bg-gray-100 py-6">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-purple-700"><i class="fa-solid fa-comments"></i> Student Feedback & Support</h2>

        <!-- Search Bar -->
        <div class="mb-4 flex justify-between items-center">
            <input type="text" id="searchInput" placeholder="Search by student name or issue..."
                   class="w-1/3 p-2 border border-purple-300 rounded">
            <button onclick="openModal()" 
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                <i class="fa-solid fa-plus-circle"></i> Add Feedback
            </button>
        </div>

        <!-- Feedback Table -->
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-purple-100 text-purple-800">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Student Name</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Issue Type</th>
                    <th class="border p-2">Message</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody id="feedbackTable"></tbody>
        </table>

        <!-- Pagination -->
        <div id="pagination" class="mt-4 flex justify-between items-center"></div>
    </div>

    <!-- Modal -->
    <div id="feedbackModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 id="modalTitle" class="text-xl font-bold mb-4 text-purple-700"><i class="fa-solid fa-comment-medical"></i> Add Feedback</h3>
            <input type="hidden" id="feedbackId">
            <input type="text" id="studentName" placeholder="Student Name"
                   class="w-full p-2 border rounded mb-2">
            <input type="email" id="studentEmail" placeholder="Email"
                   class="w-full p-2 border rounded mb-2">
            <input type="text" id="issueType" placeholder="Issue Type (e.g. Login Issue)"
                   class="w-full p-2 border rounded mb-2">
            <textarea id="message" placeholder="Feedback or support message"
                      class="w-full p-2 border rounded mb-2"></textarea>
            <label class="flex items-center mb-4">
                <input type="checkbox" id="statusResolved" class="mr-2"> Mark as Resolved
            </label>
            <div class="flex justify-end">
                <button onclick="closeModal()" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
                    Cancel
                </button>
                <button onclick="saveFeedback()" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                    <i class="fa-solid fa-paper-plane"></i> Save
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;

        function openModal(id = null) {
            if (id) {
                $.get(`/feedbacks/${id}`, function(feedback) {
                    $('#modalTitle').text('Edit Feedback');
                    $('#feedbackId').val(feedback.id);
                    $('#studentName').val(feedback.name);
                    $('#studentEmail').val(feedback.email);
                    $('#issueType').val(feedback.issue_type);
                    $('#message').val(feedback.message);
                    $('#statusResolved').prop('checked', feedback.status === 'Resolved');
                });
            } else {
                $('#modalTitle').text('Add Feedback');
                $('#feedbackId').val('');
                $('#studentName').val('');
                $('#studentEmail').val('');
                $('#issueType').val('');
                $('#message').val('');
                $('#statusResolved').prop('checked', false);
            }
            $('#feedbackModal').removeClass('hidden');
        }

        function closeModal() {
            $('#feedbackModal').addClass('hidden');
        }

        function fetchFeedbacks(page = 1, search = '') {
            $.get(`/feedbacks?page=${page}&search=${search}`, function(response) {
                let table = $('#feedbackTable');
                table.html('');
                response.data.data.forEach(fb => {
                    table.append(`
                        <tr>
                            <td class="border p-2 text-center">${fb.id}</td>
                            <td class="border p-2 text-center">${fb.name}</td>
                            <td class="border p-2 text-center">${fb.email}</td>
                            <td class="border p-2 text-center">${fb.issue_type}</td>
                            <td class="border p-2 text-center">${fb.message}</td>
                            <td class="border p-2 text-center">
                                ${fb.status === 'Resolved' 
                                    ? '<span class="text-green-600 font-semibold"><i class="fa-solid fa-check-circle"></i> Resolved</span>' 
                                    : '<span class="text-red-500 font-semibold"><i class="fa-solid fa-circle-exclamation"></i> Pending</span>'}
                            </td>
                            <td class="border p-2 text-center">
                                <button onclick="openModal(${fb.id})" 
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded mr-2">
                                        <i class="fa-solid fa-edit"></i></button>
                                <button onclick="deleteFeedback(${fb.id})" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">
                                        <i class="fa-solid fa-trash-can"></i></button>
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
                <span>Showing ${data.from || 0} to ${data.to || 0} of ${data.total} feedbacks</span>
                <div>
                    <button ${data.prev_page_url ? '' : 'disabled'} 
                            onclick="fetchFeedbacks(${data.current_page - 1}, $('#searchInput').val())"
                            class="bg-purple-200 text-purple-900 px-4 py-2 rounded mr-2">Previous</button>
                    <button ${data.next_page_url ? '' : 'disabled'} 
                            onclick="fetchFeedbacks(${data.current_page + 1}, $('#searchInput').val())"
                            class="bg-purple-200 text-purple-900 px-4 py-2 rounded">Next</button>
                </div>
            `);
        }

        function saveFeedback() {
            let id = $('#feedbackId').val();
            let feedbackData = {
                name: $('#studentName').val(),
                email: $('#studentEmail').val(),
                issue_type: $('#issueType').val(),
                message: $('#message').val(),
                status: $('#statusResolved').is(':checked') ? 'Resolved' : 'Pending',
                _token: '{{ csrf_token() }}'
            };

            if (!feedbackData.name || !feedbackData.email || !feedbackData.issue_type || !feedbackData.message) {
                Swal.fire('Error', 'All fields are required!', 'error');
                return;
            }

            let url = id ? `/feedbacks/${id}` : '/feedbacks';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: feedbackData,
                success: function() {
                    closeModal();
                    fetchFeedbacks(currentPage, $('#searchInput').val());
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON.message || 'Something went wrong!', 'error');
                }
            });
        }

        function deleteFeedback(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This feedback will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6b21a8',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/feedbacks/${id}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function() {
                            fetchFeedbacks(currentPage, $('#searchInput').val());
                            Swal.fire('Deleted!', 'The feedback has been removed.', 'success');
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            fetchFeedbacks();
            $('#searchInput').on('keyup', function() {
                fetchFeedbacks(1, $(this).val());
            });
        });
    </script>
</div>
@endsection
