@extends("dashboard")

@section("content")
<div class="bg-gray-100 py-6">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-teal-700"><i class="fa-solid fa-credit-card"></i> Fee & Payment Management</h2>

        <!-- Search Bar -->
        <div class="mb-4 flex justify-between items-center">
            <input type="text" id="searchInput" placeholder="Search by student name or fee type..."
                   class="w-1/3 p-2 border border-teal-300 rounded">
            <button onclick="openModal()" 
                    class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
                <i class="fa-solid fa-plus-circle"></i> Add Payment
            </button>
        </div>

        <!-- Payment Table -->
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-teal-100 text-teal-800">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Student Name</th>
                    <th class="border p-2">Fee Type</th>
                    <th class="border p-2">Amount</th>
                    <th class="border p-2">Payment Date</th>
                    <th class="border p-2">Method</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody id="paymentTable"></tbody>
        </table>

        <!-- Pagination -->
        <div id="pagination" class="mt-4 flex justify-between items-center"></div>
    </div>

    <!-- Modal for Add/Edit Payment -->
    <div id="paymentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 id="modalTitle" class="text-xl font-bold mb-4 text-teal-700"><i class="fa-solid fa-edit"></i> Add Payment</h3>
            <input type="hidden" id="paymentId">
            <input type="text" id="studentName" placeholder="Student Name"
                   class="w-full p-2 border rounded mb-2">
            <input type="text" id="feeType" placeholder="Fee Type (e.g. Tuition, Hostel)"
                   class="w-full p-2 border rounded mb-2">
            <input type="number" step="0.01" id="amount" placeholder="Amount"
                   class="w-full p-2 border rounded mb-2">
            <input type="date" id="paymentDate"
                   class="w-full p-2 border rounded mb-2">
            <input type="text" id="paymentMethod" placeholder="Payment Method (e.g. Cash, Card)"
                   class="w-full p-2 border rounded mb-2">
            <label class="flex items-center mb-4">
                <input type="checkbox" id="paymentStatus" class="mr-2"> Mark as Confirmed
            </label>
            <div class="flex justify-end">
                <button onclick="closeModal()" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button onclick="savePayment()" 
                        class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
                    <i class="fa-solid fa-paper-plane"></i> Save
                </button>
            </div>
        </div>
    </div>

   
</div>
@endsection
