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

   
</div>
@endsection
