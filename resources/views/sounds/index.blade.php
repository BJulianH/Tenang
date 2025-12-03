@extends('layouts.app')

@section('title', 'Focus Sounds - Tenang')

@section('styles')
<style>
    /* Sound Card Styles */
    .sound-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 3px solid #e5e7eb;
        background: white;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .sound-card:hover {
        transform: translateY(-4px);
        border-color: #58cc70;
        box-shadow: 0 8px 0 rgba(88, 204, 112, 0.2);
    }

    .sound-card.active {
        border-color: #58cc70;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        box-shadow: 0 6px 0 #45b259;
    }

    .sound-card.active .sound-icon {
        transform: scale(1.1);
        color: #58cc70;
    }

    .sound-card.active::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 30px 30px 0;
        border-color: transparent #58cc70 transparent transparent;
    }

    .sound-card.active::before {
        content: '🔊';
        position: absolute;
        top: 2px;
        right: 2px;
        font-size: 10px;
        color: white;
        z-index: 1;
    }

    /* Volume Slider Custom Styles */
    .volume-slider {
        -webkit-appearance: none;
        width: 100%;
        height: 6px;
        border-radius: 3px;
        background: linear-gradient(90deg, #58cc70 var(--volume-percent, 50%), #e5e7eb var(--volume-percent, 50%));
        outline: none;
        transition: background 0.3s;
    }

    .volume-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #58cc70;
        cursor: pointer;
        border: 3px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        transition: all 0.2s;
    }

    .volume-slider::-webkit-slider-thumb:hover {
        transform: scale(1.1);
        background: #45b259;
    }

    .volume-slider::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #58cc70;
        cursor: pointer;
        border: 3px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    /* Equalizer Styles */
    .eq-band {
        transition: all 0.3s ease;
        border: 2px solid #e5e7eb;
    }

    .eq-band.active {
        transform: scale(1.02);
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: white;
        box-shadow: 0 4px 0 #3730a3;
        border-color: #3730a3;
    }

    /* Visualization */
    .visualizer-container {
        position: relative;
        height: 100px;
        background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
        border-radius: 12px;
        overflow: hidden;
        border: 3px solid #1e293b;
        box-shadow: inset 0 2px 8px rgba(0,0,0,0.3);
    }

    .visualizer-bar {
        position: absolute;
        bottom: 0;
        width: 4px;
        background: linear-gradient(to top, #58cc70, #3b82f6);
        border-radius: 2px 2px 0 0;
        transition: height 0.1s ease;
    }

    /* Preset Badge */
    .preset-badge {
        transition: all 0.2s ease;
        border: 2px solid transparent;
        cursor: pointer;
    }

    .preset-badge:hover {
        transform: translateY(-2px);
        border-color: #58cc70;
    }

    .preset-badge.active {
        background: #58cc70;
        color: white;
        box-shadow: 0 4px 0 #45b259;
        border-color: #45b259;
    }

    /* Timer Styles */
    .timer-display {
        font-family: 'Courier New', monospace;
        background: linear-gradient(135deg, #1e293b, #334155);
        color: white;
        text-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        border-radius: 16px;
        box-shadow: inset 0 4px 12px rgba(0,0,0,0.3);
        border: 3px solid #475569;
        letter-spacing: 2px;
    }

    /* Loading Animation */
    .sound-loading {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Wave Animation */
    .wave-container {
        position: relative;
        height: 30px;
        overflow: hidden;
        margin-top: 8px;
        border-radius: 4px;
        background: rgba(0,0,0,0.05);
    }

    .wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 200%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(88, 204, 112, 0.3), 
            rgba(59, 130, 246, 0.3),
            transparent);
        animation: waveMove 3s linear infinite;
    }

    @keyframes waveMove {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0%); }
    }

    /* Mixer Channel */
    .mixer-channel {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        background: white;
    }

    .mixer-channel.active {
        border-left-color: #58cc70;
        background: linear-gradient(90deg, rgba(88, 204, 112, 0.05), white);
        box-shadow: 0 4px 0 rgba(88, 204, 112, 0.1);
    }

    /* Sound Level Meter */
    .level-meter {
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        overflow: hidden;
        position: relative;
    }

    .level-fill {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        background: linear-gradient(90deg, #58cc70, #3b82f6);
        border-radius: 2px;
        transition: width 0.2s ease;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .sound-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .eq-bands {
            flex-wrap: wrap !important;
        }
        
        .timer-controls {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        
        .visualizer-container {
            height: 80px;
        }
    }

    @media (max-width: 480px) {
        .sound-grid {
            grid-template-columns: 1fr !important;
        }
        
        .timer-display {
            font-size: 2.5rem !important;
        }
    }

    /* Sound Category Badges */
    .category-badge {
        transition: all 0.2s ease;
    }
    
    .category-badge.active {
        background: #58cc70;
        color: white;
        border-color: #45b259;
        box-shadow: 0 2px 0 #45b259;
    }

    /* Progress Ring for Timer */
    .progress-ring {
        transform: rotate(-90deg);
    }

    .progress-ring-circle {
        transition: stroke-dashoffset 0.5s ease;
        stroke-linecap: round;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 bg-gradient-to-r from-primary-500 to-accent-purple rounded-full flex items-center justify-center mx-auto mb-4 shadow-duo-lg">
            <i class="fas fa-headphones text-white text-3xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-neutral-800 mb-2">Focus Sounds Studio</h1>
        <p class="text-neutral-600 text-lg">Mix ambient sounds for better concentration & relaxation</p>
        
        <!-- Gamification Stats -->
        <div class="flex justify-center space-x-4 mt-4">
            <div class="gamification-badge flex items-center px-4 py-2">
                <i class="fas fa-clock text-accent-blue mr-2"></i>
                <span class="font-bold">Listening: <span id="totalTime">0m</span></span>
            </div>
            <div class="gamification-badge flex items-center px-4 py-2">
                <i class="fas fa-star text-secondary-500 mr-2"></i>
                <span class="font-bold">Presets: <span id="presetCount">0</span></span>
            </div>
            <div class="gamification-badge flex items-center px-4 py-2">
                <i class="fas fa-wave-square text-primary-500 mr-2"></i>
                <span class="font-bold"><span id="activeSoundsCount">0</span> active</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Sound Library & Mixer -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Sound Library -->
            <div class="card rounded-duo-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-neutral-800 flex items-center">
                        <i class="fas fa-music text-accent-purple mr-3"></i>
                        Sound Library
                    </h2>
                    <div class="flex items-center space-x-2">
                        <button id="shuffleSounds" class="app-button-secondary px-4 py-2 text-sm">
                            <i class="fas fa-random mr-2"></i>Shuffle
                        </button>
                        <button id="stopAllSounds" class="app-button px-4 py-2 text-sm bg-accent-red hover:bg-red-500">
                            <i class="fas fa-stop mr-2"></i>Stop All
                        </button>
                    </div>
                </div>

                <!-- Categories Filter -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <button class="category-badge px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-700 border border-primary-300 active"
                            onclick="filterSounds('all')">
                        All Sounds
                    </button>
                    <button class="category-badge px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700 border border-blue-300"
                            onclick="filterSounds('nature')">
                        Nature
                    </button>
                    <button class="category-badge px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-700 border border-amber-300"
                            onclick="filterSounds('ambient')">
                        Ambient
                    </button>
                    <button class="category-badge px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700 border border-gray-300"
                            onclick="filterSounds('noise')">
                        Noise
                    </button>
                    <button class="category-badge px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-700 border border-indigo-300"
                            onclick="filterSounds('music')">
                        Music
                    </button>
                </div>

                <!-- Sound Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sound-grid">
                    <!-- Nature Sounds -->
                    @php
                        $sounds = [
                            [
                                'id' => 'rain',
                                'name' => 'Rain',
                                'icon' => 'fas fa-cloud-rain',
                                'color' => 'bg-blue-100',
                                'category' => 'nature',
                                'file' => 'nature/rain.mp3'
                            ],
                            [
                                'id' => 'ocean',
                                'name' => 'Ocean Waves',
                                'icon' => 'fas fa-water',
                                'color' => 'bg-teal-100',
                                'category' => 'nature',
                                'file' => 'nature/ocean.mp3'
                            ],
                            [
                                'id' => 'fire',
                                'name' => 'Fireplace',
                                'icon' => 'fas fa-fire',
                                'color' => 'bg-orange-100',
                                'category' => 'nature',
                                'file' => 'nature/fire.mp3'
                            ],
                            [
                                'id' => 'wind',
                                'name' => 'Wind',
                                'icon' => 'fas fa-wind',
                                'color' => 'bg-cyan-100',
                                'category' => 'nature',
                                'file' => 'nature/wind.mp3'
                            ],
                            [
                                'id' => 'forest',
                                'name' => 'Forest',
                                'icon' => 'fas fa-tree',
                                'color' => 'bg-green-100',
                                'category' => 'nature',
                                'file' => 'nature/forest.mp3'
                            ],
                            [
                                'id' => 'coffee',
                                'name' => 'Coffee Shop',
                                'icon' => 'fas fa-coffee',
                                'color' => 'bg-amber-100',
                                'category' => 'ambient',
                                'file' => 'ambient/coffee-shop.mp3'
                            ],
                            [
                                'id' => 'train',
                                'name' => 'Train',
                                'icon' => 'fas fa-train',
                                'color' => 'bg-gray-100',
                                'category' => 'ambient',
                                'file' => 'ambient/train.mp3'
                            ],
                            [
                                'id' => 'city',
                                'name' => 'City',
                                'icon' => 'fas fa-city',
                                'color' => 'bg-purple-100',
                                'category' => 'ambient',
                                'file' => 'ambient/city.mp3'
                            ],
                            [
                                'id' => 'white',
                                'name' => 'White Noise',
                                'icon' => 'fas fa-fan',
                                'color' => 'bg-gray-200',
                                'category' => 'noise',
                                'file' => 'noise/white-noise.wav'
                            ],
                            [
                                'id' => 'pink',
                                'name' => 'Pink Noise',
                                'icon' => 'fas fa-sliders-h',
                                'color' => 'bg-pink-100',
                                'category' => 'noise',
                                'file' => 'noise/pink-noise.wav'
                            ],
                            [
                                'id' => 'brown',
                                'name' => 'Brown Noise',
                                'icon' => 'fas fa-wave-square',
                                'color' => 'bg-yellow-100',
                                'category' => 'noise',
                                'file' => 'noise/brown-noise.wav'
                            ],
                            [
                                'id' => 'ambient',
                                'name' => 'Ambient Music',
                                'icon' => 'fas fa-moon',
                                'color' => 'bg-indigo-100',
                                'category' => 'music',
                                'file' => 'music/ambient.mp3'
                            ],
                            [
                                'id' => 'piano',
                                'name' => 'Piano',
                                'icon' => 'fas fa-guitar',
                                'color' => 'bg-red-100',
                                'category' => 'music',
                                'file' => 'music/piano.mp3'
                            ],
                        ];
                    @endphp

                    @foreach($sounds as $sound)
                    <div class="sound-card rounded-duo p-4 text-center relative group sound-item"
                         data-sound-id="{{ $sound['id'] }}"
                         data-sound-name="{{ $sound['name'] }}"
                         data-sound-category="{{ $sound['category'] }}"
                         data-sound-file="{{ $sound['file'] }}"
                         onclick="toggleSound(this, '{{ $sound['id'] }}')">
                        <div class="{{ $sound['color'] }} w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 transition-transform duration-300 group-hover:scale-110">
                            <i class="{{ $sound['icon'] }} text-2xl sound-icon text-neutral-700"></i>
                        </div>
                        <h3 class="font-bold text-neutral-800 mb-1">{{ $sound['name'] }}</h3>
                        <p class="text-xs text-neutral-500 capitalize">{{ $sound['category'] }}</p>
                        
                        <!-- Loading Indicator -->
                        <div class="sound-loading hidden absolute inset-0 bg-white bg-opacity-80 rounded-duo flex items-center justify-center">
                            <div class="w-6 h-6 border-2 border-primary-500 border-t-transparent rounded-full animate-spin"></div>
                        </div>
                        
                        <!-- Volume Control (appears on hover/active) -->
                        <div class="volume-control hidden mt-3 px-2">
                            <input type="range" 
                                   min="0" 
                                   max="100" 
                                   value="50" 
                                   class="volume-slider w-full"
                                   oninput="updateSoundVolume(this, '{{ $sound['id'] }}')"
                                   onclick="event.stopPropagation()">
                            <div class="flex justify-between text-xs text-neutral-500 mt-1">
                                <span>0%</span>
                                <span class="volume-value">50%</span>
                                <span>100%</span>
                            </div>
                        </div>
                        
                        <!-- Level Meter -->
                        <div class="level-meter mt-2">
                            <div class="level-fill" style="width: 0%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Visualizer -->
                <div class="mt-6">
                    <div class="visualizer-container" id="visualizerContainer">
                        <!-- Bars will be generated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Audio Mixer -->
            <div class="card rounded-duo-xl p-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-6 flex items-center">
                    <i class="fas fa-sliders-h text-primary-500 mr-3"></i>
                    Audio Mixer
                </h2>

                <!-- Master Controls -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <label class="text-lg font-medium text-neutral-800 flex items-center">
                            <i class="fas fa-volume-up text-accent-purple mr-2"></i>
                            Master Controls
                        </label>
                        <div class="flex items-center space-x-4">
                            <span id="masterVolumeValue" class="text-lg font-bold text-primary-600">50%</span>
                            <button id="masterMute" class="p-2 rounded-duo hover:bg-neutral-100 transition-colors">
                                <i class="fas fa-volume-up"></i>
                            </button>
                            <button id="masterPlayPause" class="p-2 rounded-duo hover:bg-neutral-100 transition-colors">
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">
                                Master Volume
                            </label>
                            <input type="range" 
                                   id="masterVolume" 
                                   min="0" 
                                   max="100" 
                                   value="50"
                                   class="volume-slider w-full h-3"
                                   oninput="updateMasterVolume(this.value)">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">
                                Fade Duration <span id="fadeValue" class="text-primary-600">3s</span>
                            </label>
                            <input type="range" 
                                   id="fadeDuration" 
                                   min="0" 
                                   max="10" 
                                   value="3"
                                   class="volume-slider w-full h-3"
                                   oninput="updateFadeDuration(this.value)">
                        </div>
                    </div>
                </div>

                <!-- Active Sounds Mixer -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-medium text-neutral-800 flex items-center">
                            <i class="fas fa-wave-square text-accent-blue mr-2"></i>
                            Active Sounds (<span id="activeSoundsCount2">0</span>)
                        </h3>
                        <button onclick="clearMixer()" class="text-sm text-neutral-500 hover:text-red-500 transition-colors">
                            <i class="fas fa-trash mr-1"></i> Clear All
                        </button>
                    </div>
                    
                    <div class="space-y-3" id="activeSoundsMixer">
                        <!-- Active sounds will be added here dynamically -->
                        <div class="text-center py-8 text-neutral-500" id="noActiveSounds">
                            <i class="fas fa-music text-3xl mb-3 opacity-30"></i>
                            <p class="font-medium">No sounds playing</p>
                            <p class="text-sm mt-1">Click on sounds to start mixing</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Equalizer & Timer -->
        <div class="space-y-8">
            <!-- Equalizer -->
            <div class="card rounded-duo-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-neutral-800 flex items-center">
                        <i class="fas fa-wave-square text-accent-blue mr-3"></i>
                        5-Band Equalizer
                    </h2>
                    <div class="flex space-x-2">
                        <button onclick="resetEqualizer()" class="p-2 rounded-duo hover:bg-neutral-100 transition-colors" title="Reset EQ">
                            <i class="fas fa-redo text-sm"></i>
                        </button>
                        <button onclick="toggleEQ()" id="eqToggle" class="app-button px-3 py-1 text-sm">
                            <i class="fas fa-power-off mr-1"></i> ON
                        </button>
                    </div>
                </div>

                <!-- EQ Bands -->
                <div class="space-y-4">
                    @php
                        $eqBands = [
                            ['label' => 'Sub Bass', 'freq' => '60Hz', 'color' => 'from-red-500 to-orange-500'],
                            ['label' => 'Bass', 'freq' => '250Hz', 'color' => 'from-orange-500 to-yellow-500'],
                            ['label' => 'Mid', 'freq' => '1kHz', 'color' => 'from-yellow-500 to-green-500'],
                            ['label' => 'High Mid', 'freq' => '4kHz', 'color' => 'from-green-500 to-blue-500'],
                            ['label' => 'Treble', 'freq' => '16kHz', 'color' => 'from-blue-500 to-purple-500'],
                        ];
                    @endphp

                    @foreach($eqBands as $index => $band)
                    <div class="eq-band p-3 rounded-duo border-2 border-neutral-300 bg-white">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <span class="font-medium text-neutral-800">{{ $band['label'] }}</span>
                                <span class="text-xs text-neutral-500 ml-2">{{ $band['freq'] }}</span>
                            </div>
                            <span id="eq{{ $index }}Value" class="text-sm font-bold text-primary-600">0dB</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-xs text-neutral-500 w-8">-12</span>
                            <input type="range" 
                                   id="eq{{ $index }}" 
                                   min="-12" 
                                   max="12" 
                                   value="0"
                                   class="flex-1 h-2 bg-gradient-to-r {{ $band['color'] }} rounded-full appearance-none [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-neutral-400 [&::-webkit-slider-thumb]:shadow-sm"
                                   oninput="updateEQ({{ $index }}, this.value)"
                                   onchange="updateEQ({{ $index }}, this.value)">
                            <span class="text-xs text-neutral-500 w-8">+12</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Preset EQ Settings -->
                <div class="mt-6 pt-6 border-t border-neutral-200">
                    <h3 class="font-medium text-neutral-700 mb-3">EQ Presets</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="applyEQPreset('flat')" class="preset-badge px-3 py-2 rounded-duo text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-minus mr-1"></i> Flat
                        </button>
                        <button onclick="applyEQPreset('bassBoost')" class="preset-badge px-3 py-2 rounded-duo text-sm font-medium bg-red-100 text-red-700 hover:bg-red-200">
                            <i class="fas fa-volume-up mr-1"></i> Bass Boost
                        </button>
                        <button onclick="applyEQPreset('vocal')" class="preset-badge px-3 py-2 rounded-duo text-sm font-medium bg-blue-100 text-blue-700 hover:bg-blue-200">
                            <i class="fas fa-microphone mr-1"></i> Vocal
                        </button>
                        <button onclick="applyEQPreset('bright')" class="preset-badge px-3 py-2 rounded-duo text-sm font-medium bg-yellow-100 text-yellow-700 hover:bg-yellow-200">
                            <i class="fas fa-sun mr-1"></i> Bright
                        </button>
                    </div>
                </div>
            </div>

            <!-- Focus Timer -->
            <div class="card rounded-duo-xl p-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-6 flex items-center">
                    <i class="fas fa-clock text-secondary-500 mr-3"></i>
                    Focus Timer
                </h2>

                <div class="text-center mb-6">
                    <!-- Circular Progress -->
                    <div class="relative w-48 h-48 mx-auto mb-6">
                        <svg class="progress-ring w-full h-full" viewBox="0 0 100 100">
                            <circle class="text-neutral-200" stroke="currentColor" stroke-width="8" fill="transparent" r="42" cx="50" cy="50"/>
                            <circle id="progressCircle" class="progress-ring-circle text-primary-500" stroke="currentColor" stroke-width="8" stroke-linecap="round" fill="transparent" r="42" cx="50" cy="50" stroke-dasharray="264" stroke-dashoffset="264"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <div class="timer-display text-3xl font-bold mb-1 px-6 py-3 rounded-duo">
                                <span id="timerMinutes">25</span>:<span id="timerSeconds">00</span>
                            </div>
                            <p class="text-sm text-neutral-500">Focus Time</p>
                        </div>
                    </div>
                    
                    <div class="timer-controls flex justify-center space-x-4">
                        <button onclick="startTimer()" id="timerStart" class="app-button px-6 py-2">
                            <i class="fas fa-play mr-2"></i>Start
                        </button>
                        <button onclick="pauseTimer()" id="timerPause" class="app-button-secondary px-6 py-2" disabled>
                            <i class="fas fa-pause mr-2"></i>Pause
                        </button>
                        <button onclick="resetTimer()" class="p-2 rounded-duo hover:bg-neutral-100 transition-colors">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </div>

                <!-- Preset Times -->
                <div class="mt-6">
                    <h3 class="font-medium text-neutral-700 mb-3">Quick Start</h3>
                    <div class="grid grid-cols-3 gap-2">
                        <button onclick="setTimer(25)" class="py-2 rounded-duo bg-primary-50 text-primary-700 font-medium hover:bg-primary-100 transition-colors border border-primary-200">
                            25 min
                        </button>
                        <button onclick="setTimer(15)" class="py-2 rounded-duo bg-blue-50 text-blue-700 font-medium hover:bg-blue-100 transition-colors border border-blue-200">
                            15 min
                        </button>
                        <button onclick="setTimer(5)" class="py-2 rounded-duo bg-green-50 text-green-700 font-medium hover:bg-green-100 transition-colors border border-green-200">
                            5 min
                        </button>
                        <button onclick="setTimer(45)" class="py-2 rounded-duo bg-purple-50 text-purple-700 font-medium hover:bg-purple-100 transition-colors border border-purple-200">
                            45 min
                        </button>
                        <button onclick="setTimer(60)" class="py-2 rounded-duo bg-orange-50 text-orange-700 font-medium hover:bg-orange-100 transition-colors border border-orange-200">
                            60 min
                        </button>
                        <button onclick="setTimer(90)" class="py-2 rounded-duo bg-red-50 text-red-700 font-medium hover:bg-red-100 transition-colors border border-red-200">
                            90 min
                        </button>
                    </div>
                </div>
            </div>

            <!-- Save Preset -->
            <div class="card rounded-duo-xl p-6">
                <h2 class="text-xl font-bold text-neutral-800 mb-4 flex items-center">
                    <i class="fas fa-save text-accent-purple mr-3"></i>
                    Save Mix
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            Preset Name
                        </label>
                        <input type="text" 
                               id="presetName" 
                               placeholder="e.g., Study Mix, Relaxation"
                               class="w-full px-4 py-3 border-2 border-neutral-300 rounded-duo focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                    </div>
                    
                    <div class="flex space-x-2">
                        <button onclick="savePreset()" class="app-button flex-1 py-3">
                            <i class="fas fa-save mr-2"></i>Save Mix
                        </button>
                        <button onclick="loadPresetModal()" class="app-button-secondary flex-1 py-3">
                            <i class="fas fa-folder-open mr-2"></i>Load
                        </button>
                    </div>
                    
                    <!-- Saved Presets -->
                    <div class="mt-6 pt-6 border-t border-neutral-200">
                        <h3 class="font-medium text-neutral-700 mb-3">Your Presets</h3>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-2" id="savedPresets">
                            <!-- Presets will be loaded here -->
                            <div class="text-center py-4 text-neutral-500">
                                <i class="fas fa-inbox text-2xl mb-2 opacity-30"></i>
                                <p class="text-sm">No presets saved yet</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Templates -->
<template id="mixerChannelTemplate">
    <div class="mixer-channel p-3 rounded-duo border-2 border-neutral-300" data-sound-id="">
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                    <i class="fas fa-music text-primary-600"></i>
                </div>
                <div>
                    <h4 class="font-bold text-neutral-800 sound-name text-sm">Sound Name</h4>
                    <div class="text-xs text-neutral-500 flex items-center">
                        <span class="volume-percent">50%</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-wave-square text-xs"></i>
                    </div>
                </div>
            </div>
            <button class="remove-sound p-1 rounded-duo hover:bg-red-50 text-red-500 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="flex items-center space-x-2">
            <i class="fas fa-volume-down text-neutral-400 text-sm"></i>
            <input type="range" 
                   class="channel-volume flex-1 h-2 bg-neutral-200 rounded-full appearance-none [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary-500"
                   min="0" 
                   max="100" 
                   value="50">
            <i class="fas fa-volume-up text-neutral-400 text-sm"></i>
        </div>
        <div class="wave-container mt-2">
            <div class="wave"></div>
        </div>
    </div>
</template>
@endsection

@section('scripts')
<script>
// Audio System
class AudioMixer {
    constructor() {
        this.audioContext = null;
        this.masterGain = null;
        this.sounds = new Map();
        this.activeSounds = new Map();
        this.isMuted = false;
        this.isPlaying = true;
        this.masterVolume = 0.5;
        this.fadeDuration = 3;
        this.eqEnabled = true;
        
        // EQ Nodes
        this.eqNodes = [];
        
        // Visualizer
        this.analyser = null;
        this.visualizerBars = [];
        this.initVisualizer();
    }
    
    async ensureAudioContext() {
        if (!this.audioContext) {
            this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
            this.masterGain = this.audioContext.createGain();
            this.masterGain.gain.value = this.masterVolume;
            
            // Create EQ chain
            this.createEQNodes();
            
            // Create analyser for visualization
            this.analyser = this.audioContext.createAnalyser();
            this.analyser.fftSize = 256;
            this.masterGain.connect(this.analyser);
            
            if (this.eqEnabled && this.eqNodes.length > 0) {
                this.eqNodes[this.eqNodes.length - 1].node.connect(this.audioContext.destination);
            } else {
                this.analyser.connect(this.audioContext.destination);
            }
        }
        
        if (this.audioContext.state === 'suspended') {
            await this.audioContext.resume();
        }
    }
    
    createEQNodes() {
    if (!this.audioContext) {
        console.error("AudioContext not available");
        return;
    }

    const low = this.audioContext.createBiquadFilter();
    const mid = this.audioContext.createBiquadFilter();
    const high = this.audioContext.createBiquadFilter();

    if (!low || !mid || !high) {
        console.error("EQ node creation failed");
        return;
    }

    low.type = "lowshelf";
    mid.type = "peaking";
    high.type = "highshelf";

    // CEGAH ERROR CONNECT
    if (low.connect && mid.connect && high.connect) {
        low.connect(mid);
        mid.connect(high);
        high.connect(this.masterGain); // ← ini sering NULL
    } else {
        console.error("One EQ node is invalid:", { low, mid, high });
    }

    this.eqNodes = { low, mid, high };
}

    
    async loadSound(soundId, soundName, soundFile) {
        await this.ensureAudioContext();
        
        if (this.sounds.has(soundId)) {
            return this.sounds.get(soundId);
        }
        
        try {
            // Build correct local path
            const baseUrl = window.location.origin;
            
            // Check if running on Laravel
            const isLaravel = window.location.pathname.includes('/public/');
            let audioPath;
            
            if (isLaravel) {
                // Laravel dengan public folder
                audioPath = `${baseUrl}/public/assets/sounds/${soundFile}`;
            } else {
                // Standard path
                audioPath = `${baseUrl}/assets/sounds/${soundFile}`;
            }
            
            console.log(`Loading sound from: ${audioPath}`);
            
            const response = await fetch(audioPath);
            if (!response.ok) {
                throw new Error(`Failed to load ${soundFile} - Status: ${response.status}`);
            }
            
            const arrayBuffer = await response.arrayBuffer();
            const audioBuffer = await this.audioContext.decodeAudioData(arrayBuffer);
            
            this.sounds.set(soundId, {
                buffer: audioBuffer,
                name: soundName,
                file: soundFile,
                source: null,
                gainNode: null,
                isPlaying: false,
                volume: 0.5,
                startTime: 0,
                offset: 0
            });
            
            console.log(`Sound loaded successfully: ${soundName} (${soundId})`);
            return this.sounds.get(soundId);
        } catch (error) {
            console.error('Error loading sound:', error);
            
            // If local file fails, use fallback URLs
            console.log(`Trying fallback for: ${soundId}`);
            
            const fallbackUrls = {
                'rain': 'https://assets.mixkit.co/sfx/preview/mixkit-rain-loop-1249.mp3',
                'ocean': 'https://assets.mixkit.co/sfx/preview/mixkit-ocean-waves-loop-1245.mp3',
                'fire': 'https://assets.mixkit.co/sfx/preview/mixkit-crackling-fireplace-loop-1246.mp3',
                'wind': 'https://assets.mixkit.co/sfx/preview/mixkit-wind-loop-1248.mp3',
                'forest': 'https://assets.mixkit.co/sfx/preview/mixkit-forest-loop-1244.mp3',
                'coffee': 'https://assets.mixkit.co/sfx/preview/mixkit-crowd-at-a-cafe-ambience-444.wav',
                'train': 'https://assets.mixkit.co/sfx/preview/mixkit-train-ambience-438.wav',
                'city': 'https://assets.mixkit.co/sfx/preview/mixkit-city-traffic-ambience-1265.wav',
                'white': 'https://assets.mixkit.co/sfx/preview/mixkit-white-noise-buzzing-1330.wav',
                'pink': 'https://assets.mixkit.co/sfx/preview/mixkit-thunder-loop-1250.wav',
                'brown': 'https://assets.mixkit.co/sfx/preview/mixkit-busy-restaurant-ambience-444.wav',
                'ambient': 'https://assets.mixkit.co/music/preview/mixkit-deep-urban-623.mp3',
                'piano': 'https://assets.mixkit.co/music/preview/mixkit-piano-51.mp3'
            };
            
            if (fallbackUrls[soundId]) {
                try {
                    console.log(`Trying fallback URL for ${soundId}: ${fallbackUrls[soundId]}`);
                    const fallbackResponse = await fetch(fallbackUrls[soundId]);
                    const arrayBuffer = await fallbackResponse.arrayBuffer();
                    const audioBuffer = await this.audioContext.decodeAudioData(arrayBuffer);
                    
                    this.sounds.set(soundId, {
                        buffer: audioBuffer,
                        name: soundName,
                        file: soundFile,
                        source: null,
                        gainNode: null,
                        isPlaying: false,
                        volume: 0.5,
                        startTime: 0,
                        offset: 0
                    });
                    
                    console.log(`Fallback loaded successfully for: ${soundName}`);
                    return this.sounds.get(soundId);
                } catch (fallbackError) {
                    console.error('Fallback also failed:', fallbackError);
                    throw error; // Throw original error
                }
            }
            
            throw error; // Re-throw if no fallback
        }
    }
    
    async playSound(soundId, volume = 0.5) {
        const sound = this.sounds.get(soundId);
        if (!sound || sound.isPlaying) return null;
        
        await this.ensureAudioContext();
        
        try {
            const source = this.audioContext.createBufferSource();
            const gainNode = this.audioContext.createGain();
            
            source.buffer = sound.buffer;
            source.loop = true;
            
            // Connect through EQ if enabled
            if (this.eqEnabled && this.eqNodes.length > 0) {
                source.connect(gainNode);
                gainNode.connect(this.eqNodes[0].node);
            } else {
                source.connect(gainNode);
                gainNode.connect(this.masterGain);
            }
            
            // Set initial volume with fade in
            const now = this.audioContext.currentTime;
            gainNode.gain.setValueAtTime(0, now);
            gainNode.gain.linearRampToValueAtTime(volume * this.masterVolume, now + this.fadeDuration);
            
            sound.volume = volume;
            sound.source = source;
            sound.gainNode = gainNode;
            sound.isPlaying = true;
            sound.startTime = now;
            
            source.start();
            
            this.activeSounds.set(soundId, sound);
            this.updateActiveCount();
            
            console.log(`Playing sound: ${sound.name} at ${volume * 100}% volume`);
            return { source, gainNode };
        } catch (error) {
            console.error('Error playing sound:', error);
            return null;
        }
    }
    
    stopSound(soundId) {
        const sound = this.sounds.get(soundId);
        if (!sound || !sound.isPlaying) return;
        
        if (!this.audioContext) return;
        
        const now = this.audioContext.currentTime;
        
        // Fade out
        if (sound.gainNode) {
            sound.gainNode.gain.cancelScheduledValues(now);
            sound.gainNode.gain.setValueAtTime(sound.gainNode.gain.value, now);
            sound.gainNode.gain.linearRampToValueAtTime(0, now + this.fadeDuration);
        }
        
        // Stop source after fade
        setTimeout(() => {
            if (sound.source) {
                try {
                    sound.source.stop();
                    sound.source.disconnect();
                } catch (e) {
                    console.error('Error stopping source:', e);
                }
            }
            sound.isPlaying = false;
            sound.source = null;
            sound.gainNode = null;
            this.activeSounds.delete(soundId);
            this.updateActiveCount();
        }, this.fadeDuration * 1000);
    }
    
    setSoundVolume(soundId, volume) {
        const sound = this.sounds.get(soundId);
        if (!sound || !sound.isPlaying || !sound.gainNode || !this.audioContext) return;
        
        sound.volume = volume;
        const now = this.audioContext.currentTime;
        sound.gainNode.gain.cancelScheduledValues(now);
        sound.gainNode.gain.setValueAtTime(volume * this.masterVolume, now);
        
        // Update UI
        const card = document.querySelector(`[data-sound-id="${soundId}"]`);
        if (card) {
            const levelFill = card.querySelector('.level-fill');
            if (levelFill) {
                levelFill.style.width = `${volume}%`;
            }
            const volumeValue = card.querySelector('.volume-value');
            if (volumeValue) {
                volumeValue.textContent = `${Math.round(volume)}%`;
            }
        }
    }
    
    setMasterVolume(volume) {
        this.masterVolume = volume / 100;
        if (this.masterGain) {
            this.masterGain.gain.value = this.masterVolume;
        }
        
        // Update all active sounds
        this.activeSounds.forEach((sound, soundId) => {
            if (sound.gainNode) {
                sound.gainNode.gain.value = sound.volume * this.masterVolume;
            }
        });
    }
    
    toggleMute() {
        this.isMuted = !this.isMuted;
        if (this.masterGain) {
            this.masterGain.gain.value = this.isMuted ? 0 : this.masterVolume;
        }
        return this.isMuted;
    }
    
    togglePlayPause() {
        if (!this.audioContext) return false;
        
        this.isPlaying = !this.isPlaying;
        
        if (this.isPlaying) {
            this.audioContext.resume();
        } else {
            this.audioContext.suspend();
        }
        
        return this.isPlaying;
    }
    
    setEQBand(bandIndex, gain) {
        if (this.eqEnabled && this.eqNodes[bandIndex]) {
            this.eqNodes[bandIndex].node.gain.value = gain;
        }
    }
    
    toggleEQ() {
        this.eqEnabled = !this.eqEnabled;
        
        // Reconnect nodes based on EQ state
        if (this.masterGain && this.analyser) {
            this.masterGain.disconnect();
            
            if (this.eqEnabled) {
                this.masterGain.connect(this.eqNodes[0].node);
            } else {
                this.masterGain.connect(this.analyser);
            }
        }
        
        return this.eqEnabled;
    }
    
    setFadeDuration(duration) {
        this.fadeDuration = duration;
    }
    
    stopAll() {
        this.activeSounds.forEach((sound, soundId) => {
            this.stopSound(soundId);
        });
    }
    
    updateActiveCount() {
        const count = this.activeSounds.size;
        document.getElementById('activeSoundsCount').textContent = count;
        document.getElementById('activeSoundsCount2').textContent = count;
    }
    
    initVisualizer() {
        const container = document.getElementById('visualizerContainer');
        if (!container) return;
        
        container.innerHTML = '';
        this.visualizerBars = [];
        
        // Create 64 bars for visualization
        for (let i = 0; i < 64; i++) {
            const bar = document.createElement('div');
            bar.className = 'visualizer-bar';
            bar.style.left = `${(i / 64) * 100}%`;
            bar.style.width = `${(100 / 64) - 0.5}%`;
            bar.style.height = '0%';
            container.appendChild(bar);
            this.visualizerBars.push(bar);
        }
        
        this.animateVisualizer();
    }
    
    animateVisualizer() {
        if (!this.analyser || this.activeSounds.size === 0) {
            // Random gentle animation when no sounds
            this.visualizerBars.forEach((bar, i) => {
                const randomHeight = 10 + Math.sin(Date.now() / 1000 + i) * 10;
                bar.style.height = `${randomHeight}%`;
            });
        } else {
            const bufferLength = this.analyser.frequencyBinCount;
            const dataArray = new Uint8Array(bufferLength);
            this.analyser.getByteFrequencyData(dataArray);
            
            this.visualizerBars.forEach((bar, i) => {
                const dataIndex = Math.floor((i / this.visualizerBars.length) * bufferLength);
                const height = (dataArray[dataIndex] / 255) * 100;
                bar.style.height = `${height}%`;
                
                // Add color based on frequency
                const hue = 120 + (i / this.visualizerBars.length) * 240;
                bar.style.background = `linear-gradient(to top, hsl(${hue}, 80%, 60%), hsl(${hue}, 100%, 70%))`;
            });
        }
        
        requestAnimationFrame(() => this.animateVisualizer());
    }
    
    // Debug method to test sound loading
    async testAllSounds() {
        console.log('Testing all sounds...');
        const soundCards = document.querySelectorAll('.sound-card');
        
        for (const card of soundCards) {
            const soundId = card.dataset.soundId;
            const soundName = card.dataset.soundName;
            const soundFile = card.dataset.soundFile;
            
            console.log(`Testing: ${soundName} (${soundFile})`);
            
            try {
                await this.loadSound(soundId, soundName, soundFile);
                console.log(`✓ ${soundName} loaded successfully`);
            } catch (error) {
                console.log(`✗ ${soundName} failed: ${error.message}`);
            }
        }
    }
}

// Timer System
class FocusTimer {
    constructor() {
        this.totalSeconds = 25 * 60;
        this.timeLeft = this.totalSeconds;
        this.isRunning = false;
        this.timerInterval = null;
        this.startTime = null;
    }
    
    start() {
        if (this.isRunning) return;
        
        this.isRunning = true;
        this.startTime = Date.now() - (this.totalSeconds - this.timeLeft) * 1000;
        
        this.timerInterval = setInterval(() => {
            const elapsedSeconds = Math.floor((Date.now() - this.startTime) / 1000);
            this.timeLeft = Math.max(0, this.totalSeconds - elapsedSeconds);
            
            this.updateDisplay();
            
            if (this.timeLeft <= 0) {
                this.complete();
            }
        }, 100);
    }
    
    pause() {
        this.isRunning = false;
        if (this.timerInterval) {
            clearInterval(this.timerInterval);
            this.timerInterval = null;
        }
    }
    
    reset() {
        this.pause();
        this.timeLeft = this.totalSeconds;
        this.updateDisplay();
    }
    
    set(minutes) {
        this.totalSeconds = minutes * 60;
        this.timeLeft = this.totalSeconds;
        this.updateDisplay();
    }
    
    updateDisplay() {
        const minutes = Math.floor(this.timeLeft / 60);
        const seconds = Math.floor(this.timeLeft % 60);
        
        const minutesEl = document.getElementById('timerMinutes');
        const secondsEl = document.getElementById('timerSeconds');
        
        if (minutesEl) minutesEl.textContent = minutes.toString().padStart(2, '0');
        if (secondsEl) secondsEl.textContent = seconds.toString().padStart(2, '0');
        
        // Update progress circle
        const progress = 1 - (this.timeLeft / this.totalSeconds);
        const circle = document.getElementById('progressCircle');
        if (circle) {
            const circumference = 2 * Math.PI * 42;
            const offset = circumference - (progress * circumference);
            circle.style.strokeDashoffset = offset;
        }
    }
    
    complete() {
        this.pause();
        
        // Play completion sound
        try {
            const audio = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-achievement-bell-600.mp3');
            audio.volume = 0.3;
            audio.play().catch(e => console.error('Completion sound error:', e));
        } catch (e) {
            console.error('Completion sound error:', e);
        }
        
        // Show notification
        showNotification('🎉 Focus session complete! Great job!', 'success');
        
        // Auto-stop sounds after focus session
        if (audioMixer) {
            audioMixer.stopAll();
            showNotification('All sounds stopped automatically', 'info');
        }
    }
}

// Global instances
let audioMixer = null;
let focusTimer = null;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing Focus Sounds Studio...');
    
    // Initialize systems
    audioMixer = new AudioMixer();
    focusTimer = new FocusTimer();
    
    // Load saved presets
    loadPresets();
    
    // Start listening time counter
    startListeningTimeCounter();
    
    // Initialize event listeners
    initEventListeners();
    
    console.log('Focus Sounds Studio initialized');
    
    // Optional: Auto-test sounds (disable in production)
    // setTimeout(() => audioMixer.testAllSounds(), 1000);
});

function initEventListeners() {
    console.log('Initializing event listeners...');
    
    // Master volume slider
    const masterVolume = document.getElementById('masterVolume');
    if (masterVolume) {
        masterVolume.addEventListener('input', function(e) {
            const value = e.target.value;
            const volumeValueEl = document.getElementById('masterVolumeValue');
            if (volumeValueEl) volumeValueEl.textContent = value + '%';
            if (audioMixer) {
                audioMixer.setMasterVolume(value);
            }
            this.style.setProperty('--volume-percent', value + '%');
        });
    }
    
    // Master mute button
    const masterMute = document.getElementById('masterMute');
    if (masterMute) {
        masterMute.addEventListener('click', function() {
            if (audioMixer) {
                const isMuted = audioMixer.toggleMute();
                this.innerHTML = isMuted ? 
                    '<i class="fas fa-volume-mute"></i>' : 
                    '<i class="fas fa-volume-up"></i>';
                showNotification(isMuted ? 'All sounds muted' : 'Sounds unmuted', 'info');
            }
        });
    }
    
    // Master play/pause button
    const masterPlayPause = document.getElementById('masterPlayPause');
    if (masterPlayPause) {
        masterPlayPause.addEventListener('click', function() {
            if (audioMixer) {
                const isPlaying = audioMixer.togglePlayPause();
                this.innerHTML = isPlaying ? 
                    '<i class="fas fa-pause"></i>' : 
                    '<i class="fas fa-play"></i>';
                showNotification(isPlaying ? 'Resumed all sounds' : 'Paused all sounds', 'info');
            }
        });
    }
    
    // Fade duration slider
    const fadeDuration = document.getElementById('fadeDuration');
    if (fadeDuration) {
        fadeDuration.addEventListener('input', function(e) {
            const value = e.target.value;
            const fadeValueEl = document.getElementById('fadeValue');
            if (fadeValueEl) fadeValueEl.textContent = value + 's';
            if (audioMixer) {
                audioMixer.setFadeDuration(parseFloat(value));
            }
        });
    }
    
    // Stop all sounds button
    const stopAllBtn = document.getElementById('stopAllSounds');
    if (stopAllBtn) {
        stopAllBtn.addEventListener('click', function() {
            if (audioMixer) {
                audioMixer.stopAll();
                document.querySelectorAll('.sound-card.active').forEach(card => {
                    card.classList.remove('active');
                    const volumeControl = card.querySelector('.volume-control');
                    if (volumeControl) volumeControl.classList.add('hidden');
                });
                showNotification('All sounds stopped', 'info');
            }
        });
    }
    
    // Shuffle sounds button
    const shuffleBtn = document.getElementById('shuffleSounds');
    if (shuffleBtn) {
        shuffleBtn.addEventListener('click', function() {
            const soundCards = Array.from(document.querySelectorAll('.sound-card'));
            const inactiveCards = soundCards.filter(card => !card.classList.contains('active'));
            
            if (inactiveCards.length === 0) {
                showNotification('All sounds are already playing!', 'info');
                return;
            }
            
            const randomCard = inactiveCards[Math.floor(Math.random() * inactiveCards.length)];
            if (randomCard) {
                toggleSound(randomCard, randomCard.dataset.soundId);
                showNotification(`Added ${randomCard.dataset.soundName} to mix`, 'success');
            }
        });
    }
    
    console.log('Event listeners initialized');
}

// Sound Functions
async function toggleSound(card, soundId) {
    const soundName = card.dataset.soundName;
    const soundFile = card.dataset.soundFile;
    const loadingIndicator = card.querySelector('.sound-loading');
    const volumeControl = card.querySelector('.volume-control');
    
    if (!soundId || !soundFile) {
        console.error('Missing sound data:', { soundId, soundFile });
        showNotification('Sound data missing', 'error');
        return;
    }
    
    if (card.classList.contains('active')) {
        // Stop sound
        console.log(`Stopping sound: ${soundName}`);
        if (audioMixer) {
            audioMixer.stopSound(soundId);
        }
        card.classList.remove('active');
        if (volumeControl) volumeControl.classList.add('hidden');
        removeFromMixer(soundId);
        showNotification(`Stopped ${soundName}`, 'info');
    } else {
        // Start sound
        console.log(`Starting sound: ${soundName} (${soundFile})`);
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        
        if (audioMixer) {
            try {
                const sound = await audioMixer.loadSound(soundId, soundName, soundFile);
                if (sound) {
                    const result = await audioMixer.playSound(soundId);
                    if (result) {
                        card.classList.add('active');
                        if (volumeControl) volumeControl.classList.remove('hidden');
                        addToMixer(soundId, soundName);
                        showNotification(`Playing ${soundName}`, 'success');
                    } else {
                        showNotification(`Failed to play ${soundName}`, 'error');
                    }
                } else {
                    showNotification(`Failed to load ${soundName}`, 'error');
                }
            } catch (error) {
                console.error('Error in toggleSound:', error);
                showNotification(`Error loading ${soundName}: ${error.message}`, 'error');
            }
        }
        
        if (loadingIndicator) loadingIndicator.classList.add('hidden');
    }
}

function updateSoundVolume(slider, soundId) {
    const volume = slider.value;
    if (audioMixer) {
        audioMixer.setSoundVolume(soundId, volume);
    }
}

function updateMasterVolume(value) {
    const volumeValueEl = document.getElementById('masterVolumeValue');
    if (volumeValueEl) volumeValueEl.textContent = value + '%';
    if (audioMixer) {
        audioMixer.setMasterVolume(value);
    }
}

// Mixer Functions
function addToMixer(soundId, soundName) {
    const mixerContainer = document.getElementById('activeSoundsMixer');
    const noSoundsMsg = document.getElementById('noActiveSounds');
    
    if (!mixerContainer) return;
    
    if (noSoundsMsg) {
        noSoundsMsg.classList.add('hidden');
    }
    
    // Check if already in mixer
    if (document.querySelector(`.mixer-channel[data-sound-id="${soundId}"]`)) {
        return;
    }
    
    const template = document.getElementById('mixerChannelTemplate');
    if (!template) return;
    
    const clone = template.content.cloneNode(true);
    const channel = clone.querySelector('.mixer-channel');
    
    channel.setAttribute('data-sound-id', soundId);
    const soundNameEl = channel.querySelector('.sound-name');
    if (soundNameEl) soundNameEl.textContent = soundName;
    
    const volumePercentEl = channel.querySelector('.volume-percent');
    if (volumePercentEl) volumePercentEl.textContent = '50%';
    
    // Set icon based on sound
    const iconMap = {
        'rain': 'fa-cloud-rain',
        'ocean': 'fa-water',
        'fire': 'fa-fire',
        'wind': 'fa-wind',
        'forest': 'fa-tree',
        'coffee': 'fa-coffee',
        'train': 'fa-train',
        'city': 'fa-city',
        'white': 'fa-fan',
        'pink': 'fa-sliders-h',
        'brown': 'fa-wave-square',
        'ambient': 'fa-moon',
        'piano': 'fa-music'
    };
    
    const icon = channel.querySelector('.fa-music');
    if (icon && iconMap[soundId]) {
        icon.className = `fas ${iconMap[soundId]}`;
    }
    
    // Volume slider
    const volumeSlider = channel.querySelector('.channel-volume');
    if (volumeSlider) {
        volumeSlider.addEventListener('input', function(e) {
            const value = e.target.value;
            if (volumePercentEl) volumePercentEl.textContent = value + '%';
            updateSoundVolume(this, soundId);
        });
    }
    
    // Remove button
    const removeBtn = channel.querySelector('.remove-sound');
    if (removeBtn) {
        removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const card = document.querySelector(`.sound-card[data-sound-id="${soundId}"]`);
            if (card) {
                card.classList.remove('active');
                const volumeControl = card.querySelector('.volume-control');
                if (volumeControl) volumeControl.classList.add('hidden');
            }
            if (audioMixer) {
                audioMixer.stopSound(soundId);
            }
            channel.remove();
            checkEmptyMixer();
            showNotification(`Removed ${soundName} from mix`, 'info');
        });
    }
    
    mixerContainer.appendChild(channel);
}

function removeFromMixer(soundId) {
    const channel = document.querySelector(`.mixer-channel[data-sound-id="${soundId}"]`);
    if (channel) {
        channel.remove();
    }
    checkEmptyMixer();
}

function checkEmptyMixer() {
    const mixerContainer = document.getElementById('activeSoundsMixer');
    const noSoundsMsg = document.getElementById('noActiveSounds');
    
    if (!mixerContainer || !noSoundsMsg) return;
    
    // Count only mixer channels (exclude the no sounds message)
    const channels = mixerContainer.querySelectorAll('.mixer-channel');
    if (channels.length === 0) {
        noSoundsMsg.classList.remove('hidden');
    }
}

function clearMixer() {
    if (audioMixer) {
        audioMixer.stopAll();
    }
    
    document.querySelectorAll('.sound-card.active').forEach(card => {
        card.classList.remove('active');
        const volumeControl = card.querySelector('.volume-control');
        if (volumeControl) volumeControl.classList.add('hidden');
    });
    
    document.querySelectorAll('.mixer-channel').forEach(channel => {
        channel.remove();
    });
    
    const noSoundsMsg = document.getElementById('noActiveSounds');
    if (noSoundsMsg) {
        noSoundsMsg.classList.remove('hidden');
    }
    
    showNotification('Mixer cleared', 'info');
}

// Equalizer Functions
function updateEQ(bandIndex, value) {
    const valueEl = document.getElementById(`eq${bandIndex}Value`);
    if (valueEl) valueEl.textContent = value + 'dB';
    if (audioMixer) {
        audioMixer.setEQBand(bandIndex, parseInt(value));
    }
    
    // Highlight active band
    const bandElement = document.getElementById(`eq${bandIndex}`);
    if (bandElement) {
        const parent = bandElement.parentElement.parentElement;
        if (parent) parent.classList.toggle('active', value !== 0);
    }
}

function toggleEQ() {
    const button = document.getElementById('eqToggle');
    if (!audioMixer || !button) return;
    
    const eqEnabled = audioMixer.toggleEQ();
    
    if (eqEnabled) {
        button.innerHTML = '<i class="fas fa-power-off mr-1"></i> ON';
        button.classList.remove('app-button-secondary');
        button.classList.add('app-button');
        showNotification('Equalizer enabled', 'success');
    } else {
        button.innerHTML = '<i class="fas fa-power-off mr-1"></i> OFF';
        button.classList.remove('app-button');
        button.classList.add('app-button-secondary');
        showNotification('Equalizer disabled', 'info');
    }
}

function resetEqualizer() {
    for (let i = 0; i < 5; i++) {
        const slider = document.getElementById(`eq${i}`);
        if (slider) {
            slider.value = 0;
            updateEQ(i, 0);
        }
    }
    showNotification('Equalizer reset to flat', 'info');
}

function applyEQPreset(preset) {
    const presets = {
        flat: [0, 0, 0, 0, 0],
        bassBoost: [8, 4, 0, -2, -3],
        vocal: [-2, 2, 4, 3, 1],
        bright: [-3, -1, 1, 4, 6]
    };
    
    const values = presets[preset] || [0, 0, 0, 0, 0];
    
    values.forEach((value, index) => {
        const slider = document.getElementById(`eq${index}`);
        if (slider) {
            slider.value = value;
            updateEQ(index, value);
        }
    });
    
    showNotification(`EQ preset "${preset}" applied`, 'success');
}

// Timer Functions
function startTimer() {
    if (focusTimer) {
        focusTimer.start();
        const startBtn = document.getElementById('timerStart');
        const pauseBtn = document.getElementById('timerPause');
        if (startBtn) startBtn.disabled = true;
        if (pauseBtn) pauseBtn.disabled = false;
        showNotification('Focus timer started', 'success');
    }
}

function pauseTimer() {
    if (focusTimer) {
        focusTimer.pause();
        const startBtn = document.getElementById('timerStart');
        const pauseBtn = document.getElementById('timerPause');
        if (startBtn) startBtn.disabled = false;
        if (pauseBtn) pauseBtn.disabled = true;
        showNotification('Timer paused', 'info');
    }
}

function resetTimer() {
    if (focusTimer) {
        focusTimer.reset();
        const startBtn = document.getElementById('timerStart');
        const pauseBtn = document.getElementById('timerPause');
        if (startBtn) startBtn.disabled = false;
        if (pauseBtn) pauseBtn.disabled = true;
        showNotification('Timer reset', 'info');
    }
}

function setTimer(minutes) {
    if (focusTimer) {
        focusTimer.set(minutes);
        showNotification(`Timer set to ${minutes} minutes`, 'success');
    }
}

// Sound Filtering
function filterSounds(category) {
    const soundItems = document.querySelectorAll('.sound-item');
    const categoryButtons = document.querySelectorAll('.category-badge');
    
    // Update active category button
    categoryButtons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filter sounds
    soundItems.forEach(item => {
        if (category === 'all' || item.dataset.soundCategory === category) {
            item.style.display = 'block';
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'scale(1)';
            }, 10);
        } else {
            item.style.opacity = '0';
            item.style.transform = 'scale(0.8)';
            setTimeout(() => {
                item.style.display = 'none';
            }, 300);
        }
    });
}

// Preset Functions
function savePreset() {
    const nameInput = document.getElementById('presetName');
    if (!nameInput) return;
    
    const name = nameInput.value.trim();
    if (!name) {
        showNotification('Please enter a name for your preset', 'error');
        return;
    }
    
    if (!audioMixer || audioMixer.activeSounds.size === 0) {
        showNotification('No active sounds to save', 'error');
        return;
    }
    
    // Collect preset data
    const preset = {
        name: name,
        date: new Date().toISOString(),
        sounds: [],
        masterVolume: document.getElementById('masterVolume')?.value || 50,
        eqSettings: []
    };
    
    // Add active sounds
    audioMixer.activeSounds.forEach((sound, soundId) => {
        preset.sounds.push({
            id: soundId,
            name: sound.name,
            volume: sound.volume * 100
        });
    });
    
    // Add EQ settings
    for (let i = 0; i < 5; i++) {
        const eqValue = document.getElementById(`eq${i}`)?.value || 0;
        preset.eqSettings.push(eqValue);
    }
    
    // Save to localStorage
    const presets = JSON.parse(localStorage.getItem('soundPresets') || '[]');
    
    // Check if preset with same name exists
    const existingIndex = presets.findIndex(p => p.name === name);
    if (existingIndex >= 0) {
        if (!confirm(`Preset "${name}" already exists. Overwrite?`)) {
            return;
        }
        presets[existingIndex] = preset;
    } else {
        presets.push(preset);
    }
    
    localStorage.setItem('soundPresets', JSON.stringify(presets));
    
    showNotification(`Preset "${name}" saved successfully!`, 'success');
    nameInput.value = '';
    
    updatePresetCount();
    loadPresets();
}

function loadPresets() {
    const container = document.getElementById('savedPresets');
    if (!container) return;
    
    const presets = JSON.parse(localStorage.getItem('soundPresets') || '[]');
    
    if (presets.length === 0) {
        container.innerHTML = `
            <div class="text-center py-4 text-neutral-500">
                <i class="fas fa-inbox text-2xl mb-2 opacity-30"></i>
                <p class="text-sm">No presets saved yet</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = presets.map((preset, index) => `
        <div class="p-3 rounded-duo bg-neutral-50 border-2 border-neutral-300 flex justify-between items-center hover:border-primary-300 transition-colors">
            <div class="flex-1">
                <div class="font-medium text-neutral-800 truncate">${preset.name}</div>
                <div class="text-xs text-neutral-500 mt-1 flex items-center">
                    <span>${new Date(preset.date).toLocaleDateString()}</span>
                    <span class="mx-2">•</span>
                    <span>${preset.sounds.length} sounds</span>
                </div>
            </div>
            <div class="flex space-x-1">
                <button onclick="loadPreset('${index}')" class="p-2 rounded-duo hover:bg-primary-100 text-primary-600 transition-colors" title="Load">
                    <i class="fas fa-play"></i>
                </button>
                <button onclick="deletePreset('${index}')" class="p-2 rounded-duo hover:bg-red-100 text-red-500 transition-colors" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `).join('');
}

function loadPreset(index) {
    const presets = JSON.parse(localStorage.getItem('soundPresets') || '[]');
    if (!presets[index]) return;
    
    const preset = presets[index];
    
    // Clear current sounds
    clearMixer();
    
    // Load sounds
    setTimeout(async () => {
        for (const sound of preset.sounds) {
            const card = document.querySelector(`[data-sound-id="${sound.id}"]`);
            if (card) {
                await toggleSound(card, sound.id);
                
                // Set volume
                if (audioMixer) {
                    audioMixer.setSoundVolume(sound.id, sound.volume);
                }
                
                const volumeSlider = card.querySelector('.volume-slider');
                if (volumeSlider) {
                    volumeSlider.value = sound.volume;
                    volumeSlider.dispatchEvent(new Event('input'));
                }
                
                await new Promise(resolve => setTimeout(resolve, 100));
            }
        }
        
        // Set master volume
        const masterVolume = document.getElementById('masterVolume');
        if (masterVolume) {
            masterVolume.value = preset.masterVolume;
            masterVolume.dispatchEvent(new Event('input'));
        }
        
        // Set EQ settings
        preset.eqSettings.forEach((value, i) => {
            const eqSlider = document.getElementById(`eq${i}`);
            if (eqSlider) {
                eqSlider.value = value;
                eqSlider.dispatchEvent(new Event('input'));
            }
        });
        
        showNotification(`Preset "${preset.name}" loaded!`, 'success');
    }, 500);
}

function deletePreset(index) {
    if (!confirm('Delete this preset?')) return;
    
    const presets = JSON.parse(localStorage.getItem('soundPresets') || '[]');
    presets.splice(index, 1);
    localStorage.setItem('soundPresets', JSON.stringify(presets));
    
    loadPresets();
    updatePresetCount();
    showNotification('Preset deleted', 'info');
}

function updatePresetCount() {
    const presetCountEl = document.getElementById('presetCount');
    if (!presetCountEl) return;
    
    const presets = JSON.parse(localStorage.getItem('soundPresets') || '[]');
    presetCountEl.textContent = presets.length;
}

function loadPresetModal() {
    const presets = JSON.parse(localStorage.getItem('soundPresets') || '[]');
    if (presets.length === 0) {
        showNotification('No presets saved yet', 'info');
        return;
    }
    
    // Create modal
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50';
    modal.innerHTML = `
        <div class="bg-white rounded-duo-xl p-6 max-w-md w-full max-h-[80vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-neutral-800">Load Preset</h3>
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="p-2 rounded-duo hover:bg-neutral-100">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-3">
                ${presets.map((preset, index) => `
                    <div class="p-3 rounded-duo border-2 border-neutral-300 hover:border-primary-300 transition-colors">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-medium">${preset.name}</div>
                                <div class="text-xs text-neutral-500 mt-1">
                                    ${preset.sounds.length} sounds • ${new Date(preset.date).toLocaleDateString()}
                                </div>
                            </div>
                            <button onclick="loadPreset(${index}); this.closest('.fixed').remove();" 
                                    class="app-button px-4 py-1 text-sm">
                                Load
                            </button>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
}

// Listening Time Counter
let listeningTime = parseInt(localStorage.getItem('totalListeningTime') || '0');
function startListeningTimeCounter() {
    setInterval(() => {
        if (audioMixer && audioMixer.activeSounds.size > 0) {
            listeningTime++;
            localStorage.setItem('totalListeningTime', listeningTime.toString());
            updateListeningTimeDisplay();
        }
    }, 60000); // Every minute
    
    updateListeningTimeDisplay();
}

function updateListeningTimeDisplay() {
    const timeEl = document.getElementById('totalTime');
    if (!timeEl) return;
    
    const minutes = listeningTime;
    const hours = Math.floor(minutes / 60);
    const display = hours > 0 ? `${hours}h ${minutes % 60}m` : `${minutes}m`;
    timeEl.textContent = display;
}

// Helper function for notifications
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-duo font-medium z-50 shadow-duo-lg animate-slide-in border-2 ${
        type === 'success' ? 'bg-green-100 text-green-800 border-green-300' :
        type === 'error' ? 'bg-red-100 text-red-800 border-red-300' :
        'bg-blue-100 text-blue-800 border-blue-300'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${
                type === 'success' ? 'fa-check-circle' :
                type === 'error' ? 'fa-exclamation-triangle' :
                'fa-info-circle'
            } mr-3"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, 3000);
}

// Initialize visualizer on load
window.addEventListener('load', function() {
    updateListeningTimeDisplay();
    loadPresets();
});

// Debug helper
window.debugAudio = function() {
    if (audioMixer) {
        console.log('Audio Mixer Debug:');
        console.log('- Audio Context:', audioMixer.audioContext ? 'Active' : 'Not created');
        console.log('- Master Gain:', audioMixer.masterGain ? 'Created' : 'Not created');
        console.log('- Active Sounds:', audioMixer.activeSounds.size);
        console.log('- Loaded Sounds:', audioMixer.sounds.size);
        
        audioMixer.sounds.forEach((sound, id) => {
            console.log(`  - ${id}: ${sound.name} (${sound.isPlaying ? 'Playing' : 'Stopped'})`);
        });
    }
};

// Export untuk testing
window.audioMixer = audioMixer;
window.focusTimer = focusTimer;
</script>
@endsection