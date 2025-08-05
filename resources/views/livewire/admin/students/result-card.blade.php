<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Result Card</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            border: 1px solid #333;
            padding: 8px;
        }

        .table th {
            background: #f0f0f0;
        }
    </style>
</head>
<body>
<div class="header">
    <h2>Result Card</h2>
    <p><strong>{{ $student->user->name }}</strong> ({{ $student->student_id }})<br>
        {{ $student->user->email }}</p>
</div>
<table class="table">
    <thead>
    <tr>
        <th>Course</th>
        <th>Section</th>
        <th>Grade</th>
    </tr>
    </thead>
    <tbody>
    @foreach($student->enrollments as $enrollment)
        <tr>
            <td>{{ $enrollment->section->course->name ?? '-' }}</td>
            <td>{{ $enrollment->section->name ?? '-' }}</td>
            <td>{{ $enrollment->grade ?? 'N/A' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
