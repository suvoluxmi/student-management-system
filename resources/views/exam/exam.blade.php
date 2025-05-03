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
            <input type="text" id="examTitle" placeholder="Exam Title" 
                   class="w-full p-2 border rounded mb-2">
            <input type="text" id="examSubject" placeholder="Subject" 
                   class="w-full p-2 border rounded mb-2">
            <input type="date" id="examDate" 
                   class="w-full p-2 border rounded mb-2">
            <input type="number" id="examTotalMarks" placeholder="Total Marks" 
                   class="w-full p-2 border rounded mb-2">
            <input type="number" id="examPassingMarks" placeholder="Passing Marks" 
                   class="w-full p-2 border rounded mb-2">
            <label class="flex items-center mb-4">
                <input type="checkbox" id="examStatus" class="mr-2" checked> Active
            </label>
            <div class="flex justify-end">
                <button onclick="closeModal()" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button onclick="saveExam()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save</button>
            </div>
        </div>
    </div>


</div>
@endsection
