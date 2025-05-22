<div class="w-64 bg-blue-900 text-white p-5 fixed h-full hidden md:block">
            <h2 class="text-xl pl-2 font-bold mb-5">
                <a href="/dashboard">Dashboard</a>
            </h2>
            <ul>
               
                <li class="mb-3 hover:bg-blue-700 p-2 rounded cursor-pointer">
                    <a href="/student-management">Student Managment</a>
                </li>
                <li class="mb-3 hover:bg-blue-700 p-2 rounded cursor-pointer">
                    <a href="/faculty-management">Faculty Managment</a>
                <li class="mb-3 hover:bg-blue-700 p-2 rounded cursor-pointer">
                    <a href="/course-management">
                        Course Management
                    </a>
                </li>
                <li class="mb-3 hover:bg-blue-700 p-2 rounded cursor-pointer">
                    <a href="/exam-management">
                        Exam & Grade
                    </a>
                </li>
                <li class="mb-3 hover:bg-blue-700 p-2 rounded cursor-pointer">
                    <a href="/student-feedback">
                        Student Feedback
                    </a>
                </li>
                <li class="mb-3 hover:bg-blue-700 p-2 rounded cursor-pointer">
                    <a href="/fee-payment">
                        Fee & Payment
                    </a>
                </li>
                 <form method="POST" action="{{ route('logout') }}" class="mt-6">
            @csrf
            <button type="submit"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                Logout
            </button>
        </form>
            </ul>
        </div>