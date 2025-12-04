<div class="profile-section p-6">
                <div class="flex flex-col items-center mb-6">
                    <form id="avatar-form" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="avatar-upload mb-4">
                            <div class="avatar-preview pulse-gentle">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset(auth()->user()->avatarUrl) }}" alt="Avatar" class="w-full h-full rounded-full object-cover">
                                @else
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                @endif
                            </div>
                            <input type="file" id="avatar" name="avatar" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
                        </div>
                    </form>
                    <h2 class="text-xl font-bold text-neutral-800">{{ auth()->user()->name }}</h2>
                    <p class="text-neutral-600 text-sm mt-1">{{ auth()->user()->email }}</p>
                    <div class="flex items-center mt-2 gamification-badge">
                        <i class="fas fa-fire text-accent-red mr-2 streak-flame"></i>
                        <span class="text-sm font-bold text-neutral-700">{{ auth()->user()->streak ?? 0 }} hari beruntun</span>
                    </div>
                </div>
                
                <div class="border-t border-neutral-200 pt-4">
                    <div class="flex justify-between mb-3">
                        <span class="text-neutral-600 font-medium">Level</span>
                        <span class="font-bold text-primary-600">Level {{ auth()->user()->level ?? 1 }}</span>
                    </div>
                    <div class="progress-bar mb-2">
                        <div class="progress-fill" style="width: {{ min(100, ((auth()->user()->level ?? 1) / 10) * 100) }}%"></div>
                    </div>
                    <p class="text-xs text-neutral-500 text-right">{{ min(100, ((auth()->user()->level ?? 1) / 10) * 100) }}% menuju Level {{ (auth()->user()->level ?? 1) + 1 }}</p>
                </div>
                
                <div class="border-t border-neutral-200 pt-4 mt-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-600 font-medium">Poin</span>
                        <div class="flex items-center gamification-badge px-3 py-1">
                            <i class="fas fa-coins text-secondary-500 mr-2"></i>
                            <span class="font-bold text-neutral-800">{{ auth()->user()->coins ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-600 font-medium">Berlian</span>
                        <div class="flex items-center gamification-badge px-3 py-1">
                            <i class="fas fa-gem text-accent-blue mr-2"></i>
                            <span class="font-bold text-neutral-800">{{ auth()->user()->diamonds ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
            

<style>
/* Styling untuk container profil dengan border Duolingo-style */
.profile-section {
    border: 3px solid #e5e7eb;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    position: relative;
    transition: all 0.2s ease;
}

.profile-section:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
    border-color: #d1d5db;
}

/* Gradient border top seperti sidebar item */
.profile-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #58cc70, #ffc800, #4a8cff);
    border-radius: 16px 16px 0 0;
}

/* Styling untuk avatar */
.avatar-upload {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 16px;
}

.avatar-preview {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 0 0 3px #58cc70, 0 4px 0 #45b259;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 700;
    color: white;
    background: linear-gradient(135deg, #58cc70 0%, #45b259 100%);
    transition: all 0.3s ease;
}

.avatar-preview:hover {
    box-shadow: 0 0 0 4px #58cc70, 0 6px 0 #45b259;
    transform: scale(1.05);
}

/* Styling untuk username dengan ikon */
.username-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin: 8px 0 4px;
    flex-wrap: wrap;
}

.username-text {
    font-size: 1.25rem;
    font-weight: 800;
    color: #212529;
    position: relative;
}

/* Ikon title dengan style Duolingo */
.title-badge {
    background: linear-gradient(135deg, #ffc800, #e6b400);
    color: #212529;
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 0.75rem;
    font-weight: 700;
    box-shadow: 0 2px 0 rgba(230, 180, 0, 0.3);
    border: 2px solid white;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
}

.title-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 0 rgba(230, 180, 0, 0.3);
}

.title-badge:active {
    transform: translateY(1px);
    box-shadow: 0 1px 0 rgba(230, 180, 0, 0.3);
}

/* Warna berbeda untuk status user */
.title-badge.premium {
    background: linear-gradient(135deg, #9b59b6, #8e44ad);
    color: white;
    box-shadow: 0 2px 0 rgba(142, 68, 173, 0.3);
}

.title-badge.verified {
    background: linear-gradient(135deg, #4a8cff, #357ae8);
    color: white;
    box-shadow: 0 2px 0 rgba(53, 122, 232, 0.3);
}

.title-badge.expert {
    background: linear-gradient(135deg, #ff6b6b, #ff5252);
    color: white;
    box-shadow: 0 2px 0 rgba(255, 82, 82, 0.3);
}

.title-badge.beginner {
    background: linear-gradient(135deg, #58cc70, #45b259);
    color: white;
    box-shadow: 0 2px 0 rgba(69, 178, 89, 0.3);
}

/* Tooltip untuk title badge */
.title-badge::after {
    content: attr(data-tooltip);
    position: absolute;
    top: -40px;
    left: 50%;
    transform: translateX(-50%);
    background: #212529;
    color: white;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.7rem;
    font-weight: 600;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.title-badge:hover::after {
    opacity: 1;
    visibility: visible;
}

/* Progress bar styling */
.progress-bar {
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
    margin: 8px 0;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #58cc70, #ffc800);
    border-radius: 4px;
    transition: width 0.5s ease;
    position: relative;
}

.progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 20%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3));
}

/* Stats container dengan border */
.stats-container {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 12px;
    border: 2px solid #e9ecef;
    margin-top: 8px;
}

.stats-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 0;
}

.stats-item:not(:last-child) {
    border-bottom: 1px solid #e9ecef;
}

/* Gamification badge di dalam profil */
.profile-section .gamification-badge {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 6px 12px;
    border: 2px solid #e9ecef;
    transition: all 0.2s ease;
}

.profile-section .gamification-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 0 rgba(0, 0, 0, 0.05);
    background: white;
}

/* Animation untuk avatar */
@keyframes gentlePulse {
    0%, 100% { 
        box-shadow: 0 0 0 3px #58cc70, 0 4px 0 #45b259;
    }
    50% { 
        box-shadow: 0 0 0 4px #58cc70, 0 6px 0 #45b259;
    }
}

.avatar-preview.pulse-gentle {
    animation: gentlePulse 2s ease-in-out infinite;
}

/* Responsive design */
@media (max-width: 768px) {
    .profile-section {
        border-width: 2px;
    }
    
    .avatar-upload {
        width: 100px;
        height: 100px;
    }
    
    .avatar-preview {
        font-size: 2.5rem;
    }
    
    .username-container {
        flex-direction: column;
        gap: 4px;
    }
    
    .title-badge {
        font-size: 0.7rem;
        padding: 3px 8px;
    }
}
</style>
