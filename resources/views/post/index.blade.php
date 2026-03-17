<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-10">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-semibold text-gray-800">All Blog Posts</h2>
            <a href="{{ route('post.create') }}"
               class="px-5 py-2 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold rounded-xl shadow-sm transition">
                + New Blog Post
            </a>
        </div>

        {{-- Posts Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <div class="bg-yellow-300 rounded-2xl shadow-md flex flex-col justify-between hover:shadow-lg transition-shadow">

                    {{-- Post Body --}}
                    <div class="px-5 pt-5 pb-3">
                        <p class="text-gray-800 text-base leading-relaxed font-medium" style="font-family: 'Caveat', cursive; font-size: 1.2rem;">
                            {{ Str::words($post->body, 30) }}
                        </p>
                    </div>

                    {{-- Footer --}}
                    <div class="px-5 pb-4">
                        <p class="text-xs text-yellow-800 mb-3">
                            By <span class="font-semibold">{{ $post->user->name }}</span>
                            &middot; {{ $post->created_at->diffForHumans() }}
                        </p>

                        <div class="flex items-center gap-2 flex-wrap">
                            <a href="{{ route('post.show', $post) }}"
                               class="px-3 py-1.5 text-xs bg-white text-gray-700 font-medium rounded-lg shadow-sm hover:bg-gray-50 transition">
                                View
                            </a>
                            @if (auth()->id() === $post->user_id)
                                <a href="{{ route('post.edit', $post) }}"
                                   class="px-3 py-1.5 text-xs bg-blue-500 text-white font-medium rounded-lg shadow-sm hover:bg-blue-600 transition">
                                    Edit
                                </a>
                                <form action="{{ route('post.destroy', $post) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 text-xs bg-red-500 text-white font-medium rounded-lg shadow-sm hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                            @endif

                            <div class="ml-auto flex items-center gap-2">
                                <form action="{{ route('post.vote', [$post, 'like']) }}" method="POST">
                                    @csrf
                                    <button class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium transition
                                        {{ $post->userVote?->vote === 'like'
                                            ? 'bg-green-200 text-green-800 ring-1 ring-green-400'
                                            : 'bg-white/60 text-gray-700 hover:bg-green-100' }}">
                                        👍 {{ $post->votes()->where('vote', 'like')->count() }}
                                    </button>
                                </form>
                                <form action="{{ route('post.vote', [$post, 'dislike']) }}" method="POST">
                                    @csrf
                                    <button class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium transition
                                        {{ $post->userVote?->vote === 'dislike'
                                            ? 'bg-red-200 text-red-800 ring-1 ring-red-400'
                                            : 'bg-white/60 text-gray-700 hover:bg-red-100' }}">
                                        👎 {{ $post->votes()->where('vote', 'dislike')->count() }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $posts->links() }}
        </div>

    </div>
</x-app-layout>
