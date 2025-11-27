{{-- resources/views/community/partials/trending-communities.blade.php --}}
<div class="bg-white rounded-xl card-shadow p-6">
    <h3 class="font-bold text-lg text-neutral-800 mb-4 flex items-center">
        <i class="fas fa-fire text-secondary-500 mr-2"></i>
        Trending Communities
    </h3>
    <div class="space-y-3">
        @foreach($trendingCommunities as $community)
        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-neutral-50 transition-colors">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-100 to-secondary-100 flex items-center justify-center text-primary-600">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <div>
                    <a href="{{ route('community.show', $community->slug) }}" class="font-medium text-neutral-800 hover:text-primary-600">
                        {{ $community->name }}
                    </a>
                    <p class="text-xs text-neutral-500">{{ $community->members_count }} members</p>
                </div>
            </div>
            <button class="join-community-btn {{ $community->isMember(auth()->id()) ? 'joined' : '' }}" 
                    data-community-id="{{ $community->id }}"
                    data-join-url="{{ route('communities.join', $community) }}"
                    data-leave-url="{{ route('communities.leave', $community) }}">
                @if($community->isMember(auth()->id()))
                    <span class="text-xs bg-primary-100 text-primary-700 px-3 py-1 rounded-full">Joined</span>
                @else
                    <span class="text-xs bg-neutral-100 text-neutral-700 px-3 py-1 rounded-full hover:bg-primary-100 hover:text-primary-700">Join</span>
                @endif
            </button>
        </div>
        @endforeach
    </div>
    <a href="{{ route('community.explore') }}" class="block text-center mt-4 text-primary-600 hover:text-primary-700 font-medium text-sm">
        Explore More Communities
    </a>
</div>