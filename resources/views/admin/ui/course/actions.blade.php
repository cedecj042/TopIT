<div class="text-center">
    <form action="{{ route('delete-pdf', $row->pdf_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this PDF?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">
            Delete
        </button>
    </form>
</div>