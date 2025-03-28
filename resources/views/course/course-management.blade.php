<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Course Management</h2>
        <button onclick="openModal()" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Add New Course</button>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Course Name</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody id="courseTable">
                <!-- Courses will be dynamically loaded here -->
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="courseModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-xl font-bold mb-4">Add Course</h3>
            <input type="text" id="courseName" placeholder="Course Name" class="w-full p-2 border rounded mb-4">
            <div class="flex justify-end">
                <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button onclick="addCourse()" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </div>
    </div>

    <script>
        let courses = [];
        function openModal() { document.getElementById('courseModal').classList.remove('hidden'); }
        function closeModal() { document.getElementById('courseModal').classList.add('hidden'); }

        function addCourse() {
            let courseName = document.getElementById('courseName').value;
            if (courseName.trim() === '') return;
            let id = courses.length + 1;
            courses.push({ id, name: courseName });
            document.getElementById('courseName').value = '';
            closeModal();
            renderCourses();
        }

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
                    courses = courses.filter(course => course.id !== id);
                    renderCourses();
                    Swal.fire('Deleted!', 'Course has been deleted.', 'success');
                }
            });
        }

        function renderCourses() {
            let table = document.getElementById('courseTable');
            table.innerHTML = '';
            courses.forEach(course => {
                table.innerHTML += `<tr>
                    <td class="border p-2 text-center">${course.id}</td>
                    <td class="border p-2 text-center">${course.name}</td>
                    <td class="border p-2 text-center">
                        <button onclick="deleteCourse(${course.id})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    </td>
                </tr>`;
            });
        }
    </script>
</body>
</html>
