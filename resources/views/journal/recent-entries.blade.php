{{-- resources/views/journal/recent-entries.blade.php --}}
@if(isset($journals))
<div class="card rounded-duo-xl p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-neutral-800 flex items-center">
            <i class="fas fa-history text-accent-purple mr-3"></i>
            Recent Entries
        </h2>
        <span class="gamification-badge px-3 py-1 text-sm font-bold">
            {{ $journals->count() }} entries
        </span>
    </div>
    
    <div class="space-y-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
        @forelse($journals as $entry)
            <div class="p-4 border-2 border-neutral-200 rounded-duo hover:border-primary-300 hover:shadow-duo transition-all duration-200 group cursor-pointer transform hover:scale-[1.02]" 
                    data-journal-id="{{ $entry->id }}"
                    onclick="window.location='{{ route('journal.index', ['edit' => $entry->id]) }}'">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-neutral-800 truncate text-lg">
                        {{ $entry->title ?: 'Untitled Entry' }}
                    </h3>
                    <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('journal.index', ['edit' => $entry->id]) }}" 
                            class="p-2 text-neutral-500 hover:text-primary-600 hover:bg-primary-50 rounded-duo transition-all duration-200"
                            title="Edit">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <form action="{{ route('journal.destroy', $entry) }}" method="POST" class="inline" onclick="event.stopPropagation()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="p-2 text-neutral-500 hover:text-red-600 hover:bg-red-50 rounded-duo transition-all duration-200"
                                    onclick="return confirmDelete()"
                                    title="Delete">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="text-neutral-600 line-clamp-2 journal-preview mb-2">
                    @if($entry->content)
                        {!! strip_tags($entry->content) !!}
                    @else
                        <span class="text-neutral-400 italic">No content</span>
                    @endif
                </div>
                <div class="flex justify-between items-center mt-3 pt-2 border-t border-neutral-100">
                    <span class="text-xs font-medium px-2 py-1 bg-neutral-100 rounded-full text-neutral-600">
                        {{ $entry->mood ?: 'No mood' }}
                    </span>
                    <span class="text-xs text-neutral-500 font-medium">
                        <i class="far fa-clock mr-1"></i>
                        {{ $entry->created_at->format('M j, Y') }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-neutral-500">
                <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-book-open text-2xl text-secondary-500"></i>
                </div>
                <p class="font-medium text-lg">No journal entries yet</p>
                <p class="text-sm mt-1">Start writing your first entry!</p>
            </div>
        @endforelse
    </div>
</div>
@endif