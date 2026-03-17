<x-app-layout>
    <div class="note-container single-note">
        <h1>Create new blog post</h1>
        <form action="{{ route('post.store') }}" method="POST" class="note">
            @csrf
            <textarea name="body" rows="10" class="note-body" placeholder="Enter your blog post here"></textarea>
            <div class="note-buttons">
                <a href="{{ route('post.index') }}" class="note-cancel-button">Cancel</a>
                <button class="note-submit-button">Submit</button>
            </div>
        </form>
    </div>
</x-app-layout>
