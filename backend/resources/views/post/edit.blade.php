<x-app-layout>
    <div class="note-container single-note">
        <h1 class="text-3xl py-4">Edit your blog post</h1>
        <form action="{{ route('post.update', $post) }}" method="POST" class="note">
            @csrf
            @method('PUT')
            <textarea name="body" rows="10" class="note-body" placeholder="Enter your blog post here">{{ $post->body }}</textarea>
            <div class="note-buttons">
                <a href="{{ route('post.index') }}" class="note-cancel-button">Cancel</a>
                <button class="note-submit-button">Submit</button>
            </div>
        </form>
    </div>
</x-app-layout>
