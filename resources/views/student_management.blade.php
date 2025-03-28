@extends('dashboard')

@section('content')
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Student Management</h2>
            <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Add New Student</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-blue-900 text-white">
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">ID Card Number</th>
                        <th class="p-3 text-left">Semester</th>
                        <th class="p-3 text-left">Faculty</th>
                        <th class="p-3 text-left">Phone Number</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3">Trisha</td>
                        <td class="p-3">220201008</td>
                        <td class="p-3">6th</td>
                        <td class="p-3">Computer Science</td>
                        <td class="p-3">+880123456789</td>
                        <td class="p-3">
                            <a href="#" class="text-blue-500 hover:underline mr-2">Edit</a>
                            <a href="#" class="text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3">Suvo luxmi</td>
                        <td class="p-3">220201035</td>
                        <td class="p-3">6th</td>
                        <td class="p-3">Business Administration</td>
                        <td class="p-3">+880987654321</td>
                        <td class="p-3">
                            <a href="#" class="text-blue-500 hover:underline mr-2">Edit</a>
                            <a href="#" class="text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3">Sehrin</td>
                        <td class="p-3">220201040</td>
                        <td class="p-3">6th</td>
                        <td class="p-3">Business Administration</td>
                        <td class="p-3">+880987654321</td>
                        <td class="p-3">
                            <a href="#" class="text-blue-500 hover:underline mr-2">Edit</a>
                            <a href="#" class="text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3">Nusrat</td>
                        <td class="p-3">220201025</td>
                        <td class="p-3">6th</td>
                        <td class="p-3">Business Administration</td>
                        <td class="p-3">+880987654321</td>
                        <td class="p-3">
                            <a href="#" class="text-blue-500 hover:underline mr-2">Edit</a>
                            <a href="#" class="text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3">Moon</td>
                        <td class="p-3">220201016</td>
                        <td class="p-3">6th</td>
                        <td class="p-3">Business Administration</td>
                        <td class="p-3">+880987654321</td>
                        <td class="p-3">
                            <a href="#" class="text-blue-500 hover:underline mr-2">Edit</a>
                            <a href="#" class="text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection