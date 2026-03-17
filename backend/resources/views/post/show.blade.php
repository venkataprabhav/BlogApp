<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-10">

        <div class="bg-white rounded-2xl shadow-md overflow-hidden">

            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-300 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-900 text-sm font-medium">{{ $post->user->name }}</p>
                        <p class="text-yellow-800 text-xs mt-1">{{ $post->created_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                    @if (auth()->id() === $post->user_id)
                        <div class="flex gap-2">
                            <a href="{{ route('post.edit', $post) }}"
                               class="px-4 py-1.5 text-sm bg-white text-yellow-800 font-medium rounded-lg shadow-sm hover:bg-yellow-50 transition">
                                Edit
                            </a>
                            <form action="{{ route('post.destroy', $post) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="px-4 py-1.5 text-sm bg-red-500 text-white font-medium rounded-lg shadow-sm hover:bg-red-600 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Post Body --}}
            <div class="px-8 py-8">
                <p class="text-gray-800 text-lg leading-relaxed whitespace-pre-wrap">{{ $post->body }}</p>
            </div>

            {{-- Like / Dislike Footer --}}
            <div class="border-t border-gray-100 px-8 py-4 flex items-center gap-3">
                <form action="{{ route('post.vote', [$post, 'like']) }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition
                        {{ $post->userVote?->vote === 'like'
                            ? 'bg-green-100 text-green-700 ring-1 ring-green-400'
                            : 'bg-gray-100 text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <span>👍</span>
                        <span>{{ $post->votes()->where('vote', 'like')->count() }}</span>
                    </button>
                </form>
                <form action="{{ route('post.vote', [$post, 'dislike']) }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition
                        {{ $post->userVote?->vote === 'dislike'
                            ? 'bg-red-100 text-red-700 ring-1 ring-red-400'
                            : 'bg-gray-100 text-gray-600 hover:bg-red-50 hover:text-red-700' }}">
                        <span>👎</span>
                        <span>{{ $post->votes()->where('vote', 'dislike')->count() }}</span>
                    </button>
                </form>
                <a href="{{ route('post.index') }}"
                   class="ml-auto text-sm text-gray-400 hover:text-gray-600 transition">
                    ← Back to blog posts
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
