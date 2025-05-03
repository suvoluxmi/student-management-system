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

    <script>
        let currentPage = 1;

        function openModal(id = null) {
            if (id) {
                $.get(`/payments/${id}`, function(payment) {
                    $('#modalTitle').html('<i class="fa-solid fa-edit"></i> Edit Payment');
                    $('#paymentId').val(payment.id);
                    $('#studentName').val(payment.student_name);
                    $('#feeType').val(payment.fee_type);
                    $('#amount').val(payment.amount);
                    $('#paymentDate').val(payment.payment_date);
                    $('#paymentMethod').val(payment.payment_method);
                    $('#paymentStatus').prop('checked', payment.status === 'Confirmed');
                });
            } else {
                $('#modalTitle').html('<i class="fa-solid fa-plus-circle"></i> Add Payment');
                $('#paymentId').val('');
                $('#studentName').val('');
                $('#feeType').val('');
                $('#amount').val('');
                $('#paymentDate').val('');
                $('#paymentMethod').val('');
                $('#paymentStatus').prop('checked', false);
            }
            $('#paymentModal').removeClass('hidden');
        }

        function closeModal() {
            $('#paymentModal').addClass('hidden');
        }

        function fetchPayments(page = 1, search = '') {
            $.get(`/payments?page=${page}&search=${search}`, function(response) {
                let table = $('#paymentTable');
                table.html('');
                response.data.data.forEach(payment => {
                    table.append(`
                        <tr>
                            <td class="border p-2 text-center">${payment.id}</td>
                            <td class="border p-2 text-center">${payment.student_name}</td>
                            <td class="border p-2 text-center">${payment.fee_type}</td>
                            <td class="border p-2 text-center">${payment.amount}</td>
                            <td class="border p-2 text-center">${payment.payment_date}</td>
                            <td class="border p-2 text-center">${payment.payment_method}</td>
                            <td class="border p-2 text-center">
                                ${payment.status === 'Confirmed' 
                                    ? '<span class="text-green-600 font-semibold"><i class="fa-solid fa-check-circle"></i> Confirmed</span>'
                                    : '<span class="text-red-500 font-semibold"><i class="fa-solid fa-hourglass-half"></i> Pending</span>'}
                            </td>
                            <td class="border p-2 text-center">
                                <button onclick="openModal(${payment.id})" 
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded mr-2">
                                    <i class="fa-solid fa-edit"></i></button>
                                <button onclick="deletePayment(${payment.id})" 
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
                <span>Showing ${data.from || 0} to ${data.to || 0} of ${data.total} records</span>
                <div>
                    <button ${data.prev_page_url ? '' : 'disabled'} 
                            onclick="fetchPayments(${data.current_page - 1}, $('#searchInput').val())"
                            class="bg-teal-200 text-teal-900 px-4 py-2 rounded mr-2">Previous</button>
                    <button ${data.next_page_url ? '' : 'disabled'} 
                            onclick="fetchPayments(${data.current_page + 1}, $('#searchInput').val())"
                            class="bg-teal-200 text-teal-900 px-4 py-2 rounded">Next</button>
                </div>
            `);
        }

        function savePayment() {
            let id = $('#paymentId').val();
            let paymentData = {
                student_name: $('#studentName').val(),
                fee_type: $('#feeType').val(),
                amount: $('#amount').val(),
                payment_date: $('#paymentDate').val(),
                payment_method: $('#paymentMethod').val(),
                status: $('#paymentStatus').is(':checked') ? 'Confirmed' : 'Pending',
                _token: '{{ csrf_token() }}'
            };

            if (!paymentData.student_name || !paymentData.fee_type || !paymentData.amount || !paymentData.payment_date || !paymentData.payment_method) {
                Swal.fire('Error', 'All fields are required!', 'error');
                return;
            }

            let url = id ? `/payments/${id}` : '/payments';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: paymentData,
                success: function() {
                    closeModal();
                    fetchPayments(currentPage, $('#searchInput').val());
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON.message || 'Something went wrong!', 'error');
                }
            });
        }

        function deletePayment(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This payment record will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d9488',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/payments/${id}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function() {
                            fetchPayments(currentPage, $('#searchInput').val());
                            Swal.fire('Deleted!', 'Payment record has been deleted.', 'success');
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            fetchPayments();
            $('#searchInput').on('keyup', function() {
                fetchPayments(1, $(this).val());
            });
        });
    </script>
</div>
@endsection
