<tr onclick="window.location='{{ route('admin-course-detail', ['course_id' => $row->course_id]) }}';" style="cursor: pointer;">
    <td>{{ $row->course_id }}</td>
    <td>{{ $row->title }}</td>
    <td>{{ $row->description }}</td>
    <td>{{ $row->created_at }}</td>
</tr>