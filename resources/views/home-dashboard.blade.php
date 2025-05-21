@extends('dashboard')

@section('content')
<div class="bg-gray-100 py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-700">Dashboard Overview</h2>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Students -->
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="p-3 rounded-full bg-blue-100 mr-4">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Students</h3>
                    <p id="totalStudents" class="text-2xl font-bold text-blue-700">0</p>
                </div>
            </div>

            <!-- Total Faculty -->
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="p-3 rounded-full bg-green-100 mr-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Faculty</h3>
                    <p id="totalFaculty" class="text-2xl font-bold text-blue-700">0</p>
                </div>
            </div>

            <!-- Total Exams -->
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 mr-4">
                    <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Exams</h3>
                    <p id="totalExams" class="text-2xl font-bold text-blue-700">0</p>
                </div>
            </div>

            <!-- Total Payment Amount -->
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="p-3 rounded-full bg-purple-100 mr-4">
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Payment Amount</h3>
                    <p id="totalPaymentAmount" class="text-2xl font-bold text-blue-700">$0.00</p>
                </div>
            </div>

            <!-- Total Feedback -->
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="p-3 rounded-full bg-red-100 mr-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5v-4a2 2 0 012-2h10a2 2 0 012 2v4h-4M9 16l3 3m0 0l3-3m-3 3V5"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Feedback</h3>
                    <p id="totalFeedback" class="text-2xl font-bold text-blue-700">0</p>
                </div>
            </div>

            <!-- Total Courses -->
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 mr-4">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Courses</h3>
                    <p id="totalCourses" class="text-2xl font-bold text-blue-700">0</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fetchDashboardData() {
            $.ajax({
                url: '/home-dashboard',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#totalStudents').text(response.total_students);
                    $('#totalFaculty').text(response.total_faculty);
                    $('#totalExams').text(response.total_exams);
                    $('#totalPaymentAmount').text('$' + parseFloat(response.total_payment_amount).toFixed(2));
                    $('#totalFeedback').text(response.total_feedback);
                    $('#totalCourses').text(response.total_courses);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Failed to fetch dashboard data',
                    });
                }
            });
        }

        $(document).ready(function() {
            fetchDashboardData();
        });
    </script>
</div>
@endsection
