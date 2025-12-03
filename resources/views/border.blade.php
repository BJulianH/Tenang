<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Reference Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        /* Card Styles */
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 3px solid #f1f3f4;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 0 rgba(0, 0, 0, 0.1);
            border-color: #e5e7eb;
        }
        
        /* Profile Borders */
        .profile-border {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            margin: 0 auto;
        }
        
        /* Icon Titles */
        .icon-title {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            border-radius: 12px;
            background: white;
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.1);
            border: 2px solid #f1f3f4;
            transition: all 0.3s ease;
        }
        
        .icon-title:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        }
        
        /* Code Display */
        .code-block {
            background: #1a1a1a;
            color: #f8f8f2;
            padding: 20px;
            border-radius: 12px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            overflow-x: auto;
            border-left: 4px solid #58cc70;
        }
        
        .code-comment {
            color: #75715e;
        }
        
        .code-tag {
            color: #f92672;
        }
        
        .code-attr {
            color: #a6e22e;
        }
        
        .code-value {
            color: #e6db74;
        }
        
        /* Animations */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #58cc70, #45b259);
            border-radius: 10px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .grid-4 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            .grid-3 {
                grid-template-columns: 1fr !important;
            }
            
            .code-block {
                font-size: 12px;
                padding: 15px;
            }
        }
        
        @media (max-width: 480px) {
            .grid-4 {
                grid-template-columns: 1fr !important;
            }
            
            body {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold mb-4" style="background: linear-gradient(45deg, #58cc70, #ffc800); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <i class="fas fa-palette mr-3"></i>Border & Icon Reference Gallery
        </h1>
        <p class="text-gray-600 text-lg max-w-3xl mx-auto px-4">
            Koleksi berbagai contoh border profil dan ikon title. Klik pada contoh untuk melihat kode HTML & CSS-nya!
        </p>
        
        <div class="flex flex-wrap justify-center gap-4 mt-6">
            <div class="px-4 py-2 rounded-full bg-gradient-to-r from-green-50 to-green-100 border border-green-200">
                <i class="fas fa-border-style text-green-600 mr-2"></i>
                <span class="font-semibold text-green-800">12 Border Examples</span>
            </div>
            <div class="px-4 py-2 rounded-full bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200">
                <i class="fas fa-icons text-yellow-600 mr-2"></i>
                <span class="font-semibold text-yellow-800">8 Icon Examples</span>
            </div>
            <div class="px-4 py-2 rounded-full bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200">
                <i class="fas fa-code text-blue-600 mr-2"></i>
                <span class="font-semibold text-blue-800">Ready-to-Use Code</span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        <!-- Section 1: Profile Borders -->
        <section class="mb-16">
            <div class="flex items-center justify-between mb-8 px-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-user-circle text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Profile Borders</h2>
                        <p class="text-gray-600">Various styles for user profile pictures</p>
                    </div>
                </div>
                <button onclick="toggleCode('profile-code')" class="px-4 py-2 rounded-lg bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold shadow-md hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-code mr-2"></i>Show All Code
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 grid-4">
                <!-- Example 1: Basic Border -->
                <div class="card p-6 cursor-pointer" onclick="showExample(1)">
                    <div class="flex justify-center mb-4">
                        <div class="profile-border w-24 h-24 rounded-full bg-gradient-to-r from-green-400 to-blue-500 border-4 border-white shadow-xl">
                            <span class="text-3xl">AB</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Basic Gradient</h3>
                    <p class="text-gray-600 text-sm text-center">Simple gradient with white border</p>
                    <div class="flex justify-center mt-4">
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Popular</span>
                    </div>
                </div>
                
                <!-- Example 2: Animated Border -->
                <div class="card p-6 cursor-pointer" onclick="showExample(2)">
                    <div class="flex justify-center mb-4">
                        <div class="profile-border w-24 h-24 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 relative animate-pulse" 
                             style="animation: pulse 2s infinite; background: linear-gradient(white, white) padding-box, 
                                    linear-gradient(45deg, #9b59b6, #e74c3c) border-box; border: 4px solid transparent;">
                            <span class="text-3xl">CD</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Animated Border</h3>
                    <p class="text-gray-600 text-sm text-center">Pulsating gradient border</p>
                    <div class="flex justify-center mt-4">
                        <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">Animated</span>
                    </div>
                </div>
                
                <!-- Example 3: Duolingo Style -->
                <div class="card p-6 cursor-pointer" onclick="showExample(3)">
                    <div class="flex justify-center mb-4">
                        <div class="profile-border w-24 h-24 rounded-2xl bg-white border-4 border-green-500 shadow-lg relative"
                             style="box-shadow: 0 6px 0 #45b259;">
                            <span class="text-3xl text-green-600">EF</span>
                            <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center text-white shadow-md">
                                <i class="fas fa-fire text-xs"></i>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Duolingo Style</h3>
                    <p class="text-gray-600 text-sm text-center">With streak badge</p>
                    <div class="flex justify-center mt-4">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Trending</span>
                    </div>
                </div>
                
                <!-- Example 4: Premium Border -->
                <div class="card p-6 cursor-pointer" onclick="showExample(4)">
                    <div class="flex justify-center mb-4">
                        <div class="profile-border w-24 h-24 rounded-full relative"
                             style="background: conic-gradient(from 0deg, #ffd700, #ffed4e, #ffd700); border: 4px solid transparent; background-clip: padding-box;">
                            <div class="absolute inset-2 rounded-full bg-gradient-to-r from-purple-600 to-pink-600 flex items-center justify-center">
                                <span class="text-3xl text-white">GH</span>
                            </div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-yellow-400 flex items-center justify-center">
                                <i class="fas fa-crown text-xs text-purple-800"></i>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Premium Border</h3>
                    <p class="text-gray-600 text-sm text-center">Gold border with crown</p>
                    <div class="flex justify-center mt-4">
                        <span class="px-3 py-1 bg-pink-100 text-pink-800 rounded-full text-xs font-medium">Premium</span>
                    </div>
                </div>
                
                <!-- Example 5: Minimal Border -->
                <div class="card p-6 cursor-pointer" onclick="showExample(5)">
                    <div class="flex justify-center mb-4">
                        <div class="profile-border w-24 h-24 rounded-full bg-gray-100 border-4 border-gray-300 hover:border-green-500 transition-all duration-300">
                            <span class="text-3xl text-gray-700">IJ</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Minimal Style</h3>
                    <p class="text-gray-600 text-sm text-center">Clean with hover effect</p>
                    <div class="flex justify-center mt-4">
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">Minimal</span>
                    </div>
                </div>
                
                <!-- Example 6: Neon Border -->
                <div class="card p-6 cursor-pointer" onclick="showExample(6)">
                    <div class="flex justify-center mb-4">
                        <div class="profile-border w-24 h-24 rounded-full bg-gray-900 border-4 border-transparent relative"
                             style="box-shadow: 0 0 20px #00ffea, inset 0 0 20px #00ffea;">
                            <span class="text-3xl text-white">KL</span>
                            <div class="absolute -inset-4 rounded-full border-4 border-transparent"
                                 style="background: linear-gradient(45deg, #00ffea, #00ff95, #00ffea) border-box; 
                                        mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
                                        mask-composite: exclude; animation: spin 3s linear infinite;"></div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Neon Border</h3>
                    <p class="text-gray-600 text-sm text-center">Glowing with rotation</p>
                    <div class="flex justify-center mt-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Neon</span>
                    </div>
                </div>
                
                <!-- Example 7: Community Border -->
                <div class="card p-6 cursor-pointer" onclick="showExample(7)">
                    <div class="flex justify-center mb-4">
                        <div class="profile-border w-24 h-24 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 border-4 border-white shadow-lg relative"
                             style="box-shadow: 0 4px 0 rgba(0,0,0,0.1), 0 0 0 4px rgba(59, 130, 246, 0.2);">
                            <span class="text-3xl text-white">MN</span>
                            <div class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-white border-2 border-blue-500 flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-xs"></i>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Community</h3>
                    <p class="text-gray-600 text-sm text-center">With group icon</p>
                    <div class="flex justify-center mt-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Social</span>
                    </div>
                </div>
                
                <!-- Example 8: Floating Border -->
                <div class="card p-6 cursor-pointer" onclick="showExample(8)">
                    <div class="flex justify-center mb-4">
                        <div class="profile-border w-24 h-24 rounded-full bg-gradient-to-br from-pink-400 to-red-500 border-4 border-white shadow-2xl"
                             style="animation: bounce 2s infinite ease-in-out; box-shadow: 0 10px 25px rgba(244, 63, 94, 0.3);">
                            <span class="text-3xl text-white">OP</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Floating Effect</h3>
                    <p class="text-gray-600 text-sm text-center">With bounce animation</p>
                    <div class="flex justify-center mt-4">
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Animated</span>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Section 2: Icon Titles -->
        <section class="mb-16">
            <div class="flex items-center justify-between mb-8 px-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-yellow-500 to-orange-500 flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-heading text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Icon Titles</h2>
                        <p class="text-gray-600">Icon and text combinations for headers</p>
                    </div>
                </div>
                <button onclick="toggleCode('icon-code')" class="px-4 py-2 rounded-lg bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-semibold shadow-md hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-code mr-2"></i>Show All Code
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 grid-3">
                <!-- Example 1: Basic Icon Title -->
                <div class="card p-6 cursor-pointer" onclick="showExample(9)">
                    <div class="flex flex-col gap-4 mb-4">
                        <div class="icon-title">
                            <i class="fas fa-home text-green-600 text-xl"></i>
                            <span class="font-bold text-gray-800 text-lg">Dashboard</span>
                        </div>
                        <div class="icon-title">
                            <i class="fas fa-book text-purple-600 text-xl"></i>
                            <span class="font-bold text-gray-800 text-lg">Journal</span>
                        </div>
                        <div class="icon-title">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                            <span class="font-bold text-gray-800 text-lg">Community</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Basic Icons</h3>
                    <p class="text-gray-600 text-sm">Simple icon with text</p>
                </div>
                
                <!-- Example 2: Badge Icon Title -->
                <div class="card p-6 cursor-pointer" onclick="showExample(10)">
                    <div class="flex flex-col gap-4 mb-4">
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-green-50 border-2 border-green-200">
                            <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white shadow-md">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Achievements</h4>
                                <p class="text-sm text-gray-600">12 badges unlocked</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-yellow-50 border-2 border-yellow-200">
                            <div class="w-12 h-12 rounded-full bg-yellow-500 flex items-center justify-center text-white shadow-md">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Progress</h4>
                                <p class="text-sm text-gray-600">75% completed</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Badge Style</h3>
                    <p class="text-gray-600 text-sm">Icon in circle with description</p>
                </div>
                
                <!-- Example 3: Animated Icon Title -->
                <div class="card p-6 cursor-pointer" onclick="showExample(11)">
                    <div class="flex flex-col gap-4 mb-4">
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-red-50 border-2 border-red-200">
                            <div class="w-12 h-12 rounded-full bg-red-500 flex items-center justify-center text-white shadow-md animate-pulse">
                                <i class="fas fa-fire"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Daily Streak</h4>
                                <p class="text-sm text-gray-600">7 days in a row</p>
                            </div>
                            <span class="ml-auto text-2xl">🔥</span>
                        </div>
                        
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-blue-50 border-2 border-blue-200">
                            <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-md"
                                 style="animation: bounce 2s infinite;">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Notifications</h4>
                                <p class="text-sm text-gray-600">3 new alerts</p>
                            </div>
                            <span class="ml-auto w-3 h-3 rounded-full bg-red-500"></span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Animated Icons</h3>
                    <p class="text-gray-600 text-sm">With animations and indicators</p>
                </div>
                
                <!-- Example 4: Interactive Icon Title -->
                <div class="card p-6 cursor-pointer" onclick="showExample(12)">
                    <div class="flex flex-col gap-4 mb-4">
                        <button class="flex items-center justify-between p-3 rounded-xl bg-white border-2 border-gray-300 
                                    hover:border-green-500 hover:bg-green-50 transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-green-100 group-hover:bg-green-200 
                                          flex items-center justify-center text-green-600 transition-all duration-300">
                                    <i class="fas fa-cog group-hover:rotate-90 transition-transform duration-500"></i>
                                </div>
                                <div class="text-left">
                                    <h4 class="font-bold text-gray-800 group-hover:text-green-700">Settings</h4>
                                    <p class="text-sm text-gray-600">Customize your experience</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-500 
                                      group-hover:translate-x-1 transition-all duration-300"></i>
                        </button>
                        
                        <button class="flex items-center justify-between p-3 rounded-xl bg-white border-2 border-gray-300 
                                    hover:border-yellow-500 hover:bg-yellow-50 transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-yellow-100 group-hover:bg-yellow-200 
                                          flex items-center justify-center text-yellow-600 transition-all duration-300">
                                    <i class="fas fa-question-circle"></i>
                                </div>
                                <div class="text-left">
                                    <h4 class="font-bold text-gray-800 group-hover:text-yellow-700">Help Center</h4>
                                    <p class="text-sm text-gray-600">Get support and guidance</p>
                                </div>
                            </div>
                            <i class="fas fa-external-link-alt text-gray-400 group-hover:text-yellow-500 transition-all duration-300"></i>
                        </button>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Interactive</h3>
                    <p class="text-gray-600 text-sm">With hover effects</p>
                </div>
                
                <!-- Example 5: Gradient Icon Title -->
                <div class="card p-6 cursor-pointer" onclick="showExample(13)">
                    <div class="flex flex-col gap-4 mb-4">
                        <div class="icon-title p-4 border-0 bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg">
                            <i class="fas fa-star text-xl"></i>
                            <span class="font-bold text-lg">Premium Features</span>
                        </div>
                        
                        <div class="icon-title p-4 border-0 bg-gradient-to-r from-green-500 to-teal-500 text-white shadow-lg">
                            <i class="fas fa-bolt text-xl"></i>
                            <span class="font-bold text-lg">Quick Actions</span>
                        </div>
                        
                        <div class="icon-title p-4 border-0 bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-lg">
                            <i class="fas fa-gem text-xl"></i>
                            <span class="font-bold text-lg">Exclusive Content</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Gradient Style</h3>
                    <p class="text-gray-600 text-sm">Colorful gradient backgrounds</p>
                </div>
                
                <!-- Example 6: Floating Icon Title -->
                <div class="card p-6 cursor-pointer" onclick="showExample(14)">
                    <div class="flex flex-col gap-4 mb-4">
                        <div class="icon-title p-4 bg-white shadow-xl border-0 transform hover:scale-105 transition-all duration-300"
                             style="animation: float 3s infinite ease-in-out;">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-pink-500 to-rose-500 flex items-center justify-center text-white">
                                <i class="fas fa-heart"></i>
                            </div>
                            <span class="font-bold text-gray-800 text-lg">Favorites</span>
                        </div>
                        
                        <div class="icon-title p-4 bg-white shadow-xl border-0 transform hover:scale-105 transition-all duration-300"
                             style="animation: float 3s infinite ease-in-out; animation-delay: 0.5s;">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center justify-center text-white">
                                <i class="fas fa-download"></i>
                            </div>
                            <span class="font-bold text-gray-800 text-lg">Downloads</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Floating Icons</h3>
                    <p class="text-gray-600 text-sm">With floating animation</p>
                </div>
            </div>
        </section>
        
        <!-- Code Display Section -->
        <section id="code-display" class="mb-16 hidden">
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl p-6 shadow-2xl">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-code text-green-400 text-2xl"></i>
                        <h3 class="text-2xl font-bold text-white">Code Preview</h3>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="copyCode()" class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold transition-all duration-300">
                            <i class="fas fa-copy mr-2"></i>Copy Code
                        </button>
                        <button onclick="closeCode()" class="px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white font-semibold transition-all duration-300">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div id="code-content" class="code-block">
                    <!-- Code will appear here -->
                </div>
                
                <div class="mt-6 p-4 bg-gray-700 rounded-xl border border-gray-600">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-lightbulb text-yellow-400 mt-1 text-lg"></i>
                        <div>
                            <h4 class="font-bold text-white mb-1">How to Use</h4>
                            <p class="text-gray-300">Copy the HTML and CSS code above. You can customize colors, sizes, and effects to match your design.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Quick Tools Section -->
        <section class="mb-16">
            <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-200">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Quick Customization Tools</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 rounded-xl bg-gradient-to-br from-green-50 to-blue-50 border border-green-100">
                        <i class="fas fa-fill-drip text-4xl text-green-600 mb-4"></i>
                        <h4 class="text-xl font-bold text-gray-800 mb-2">Color Picker</h4>
                        <p class="text-gray-600 mb-4">Try different color combinations</p>
                        <div class="flex justify-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-green-500 cursor-pointer" onclick="changeColor('green')"></div>
                            <div class="w-8 h-8 rounded-full bg-blue-500 cursor-pointer" onclick="changeColor('blue')"></div>
                            <div class="w-8 h-8 rounded-full bg-purple-500 cursor-pointer" onclick="changeColor('purple')"></div>
                            <div class="w-8 h-8 rounded-full bg-red-500 cursor-pointer" onclick="changeColor('red')"></div>
                            <div class="w-8 h-8 rounded-full bg-yellow-500 cursor-pointer" onclick="changeColor('yellow')"></div>
                        </div>
                    </div>
                    
                    <div class="text-center p-6 rounded-xl bg-gradient-to-br from-yellow-50 to-orange-50 border border-yellow-100">
                        <i class="fas fa-expand-arrows-alt text-4xl text-yellow-600 mb-4"></i>
                        <h4 class="text-xl font-bold text-gray-800 mb-2">Size Adjuster</h4>
                        <p class="text-gray-600 mb-4">Change border and icon sizes</p>
                        <div class="flex items-center justify-center gap-4">
                            <button onclick="changeSize('small')" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Small</button>
                            <button onclick="changeSize('medium')" class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow">Medium</button>
                            <button onclick="changeSize('large')" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Large</button>
                        </div>
                    </div>
                    
                    <div class="text-center p-6 rounded-xl bg-gradient-to-br from-purple-50 to-pink-50 border border-purple-100">
                        <i class="fas fa-magic text-4xl text-purple-600 mb-4"></i>
                        <h4 class="text-xl font-bold text-gray-800 mb-2">Effect Toggle</h4>
                        <p class="text-gray-600 mb-4">Toggle animations and effects</p>
                        <div class="flex items-center justify-center gap-4">
                            <button onclick="toggleEffects()" id="effect-toggle" class="px-6 py-2 bg-purple-500 text-white rounded-lg shadow">
                                <i class="fas fa-play mr-2"></i>Enable Effects
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <footer class="text-center py-8 border-t border-gray-300">
        <p class="text-gray-600 mb-2">Made with <i class="fas fa-heart text-red-500 mx-1"></i> for MindWell Design System</p>
        <p class="text-gray-500 text-sm">Frontend Reference Gallery • Click examples to view code</p>
    </footer>

    <script>
        // Example data for code display
        const examples = {
            1: {
                title: "Basic Gradient Border",
                html: `<div class="profile-container">
  <div class="profile-border">
    <span>AB</span>
  </div>
</div>`,
                css: `.profile-border {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: linear-gradient(135deg, #4ade80, #3b82f6);
  border: 4px solid white;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 2rem;
  font-weight: bold;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}`
            },
            2: {
                title: "Animated Border",
                html: `<div class="profile-container">
  <div class="profile-border animated">
    <span>CD</span>
  </div>
</div>`,
                css: `.profile-border.animated {
  background: linear-gradient(white, white) padding-box,
              linear-gradient(45deg, #9b59b6, #e74c3c) border-box;
  border: 4px solid transparent;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.05); }
  100% { transform: scale(1); }
}`
            },
            3: {
                title: "Duolingo Style Border",
                html: `<div class="profile-container">
  <div class="profile-border duolingo">
    <span>EF</span>
    <div class="streak-badge">
      <i class="fas fa-fire"></i>
    </div>
  </div>
</div>`,
                css: `.profile-border.duolingo {
  border-radius: 20px;
  background: white;
  border: 4px solid #58cc70;
  box-shadow: 0 6px 0 #45b259;
  position: relative;
}

.streak-badge {
  position: absolute;
  bottom: -8px;
  right: -8px;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #ffc800;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  box-shadow: 0 3px 0 #e6b400;
}`
            },
            9: {
                title: "Basic Icon Title",
                html: `<div class="icon-title">
  <i class="fas fa-home"></i>
  <span>Dashboard</span>
</div>`,
                css: `.icon-title {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 10px 20px;
  border-radius: 12px;
  background: white;
  border: 2px solid #f1f3f4;
  box-shadow: 0 2px 0 rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.icon-title:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
}

.icon-title i {
  color: #58cc70;
  font-size: 1.25rem;
}

.icon-title span {
  font-weight: bold;
  color: #1f2937;
}`
            },
            10: {
                title: "Badge Icon Title",
                html: `<div class="icon-badge">
  <div class="icon-container">
    <i class="fas fa-trophy"></i>
  </div>
  <div class="text-content">
    <h4>Achievements</h4>
    <p>12 badges unlocked</p>
  </div>
</div>`,
                css: `.icon-badge {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px;
  border-radius: 16px;
  background: #f0fdf4;
  border: 2px solid #bbf7d0;
}

.icon-container {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: #58cc70;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  box-shadow: 0 4px 0 #45b259;
}

.text-content h4 {
  font-weight: bold;
  color: #1f2937;
  margin: 0;
}

.text-content p {
  color: #6b7280;
  font-size: 0.875rem;
  margin: 0;
}`
            }
        };

        // Show code for selected example
        function showExample(exampleId) {
            const example = examples[exampleId];
            if (!example) return;
            
            const codeDisplay = document.getElementById('code-display');
            const codeContent = document.getElementById('code-content');
            
            const highlightedHTML = highlightCode(example.html);
            const highlightedCSS = highlightCode(example.css);
            
            codeContent.innerHTML = `
                <div class="mb-4">
                    <h4 class="text-green-400 font-bold mb-2">${example.title}</h4>
                </div>
                <div class="mb-6">
                    <h5 class="text-blue-400 font-semibold mb-2">HTML:</h5>
                    <pre>${highlightedHTML}</pre>
                </div>
                <div>
                    <h5 class="text-blue-400 font-semibold mb-2">CSS:</h5>
                    <pre>${highlightedCSS}</pre>
                </div>
            `;
            
            codeDisplay.classList.remove('hidden');
            codeDisplay.scrollIntoView({ behavior: 'smooth' });
            
            // Add visual feedback to clicked card
            document.querySelectorAll('.card').forEach(card => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
            });
            
            const clickedCard = event.currentTarget;
            clickedCard.style.transform = 'translateY(-5px)';
            clickedCard.style.boxShadow = '0 8px 0 rgba(0, 0, 0, 0.1)';
        }

        // Syntax highlighting for code
        function highlightCode(code) {
            return code
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/class="/g, '<span class="code-attr">class</span>="')
                .replace(/\.([a-zA-Z\-]+)/g, '<span class="code-tag">.$1</span>')
                .replace(/#([a-fA-F0-9]{3,6})/g, '<span class="code-value">#$1</span>')
                .replace(/rgb[a]?\([^)]+\)/g, '<span class="code-value">$&</span>')
                .replace(/([0-9]+(px|rem|em|%|s))/g, '<span class="code-value">$1</span>')
                .replace(/@keyframes/g, '<span class="code-tag">@keyframes</span>')
                .replace(/animation:/g, '<span class="code-attr">animation</span>:')
                .replace(/transition:/g, '<span class="code-attr">transition</span>:');
        }

        // Copy code to clipboard
        function copyCode() {
            const codeContent = document.getElementById('code-content');
            const text = codeContent.innerText;
            
            navigator.clipboard.writeText(text).then(() => {
                const button = event.target.closest('button');
                const originalHTML = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check mr-2"></i>Copied!';
                button.style.background = 'linear-gradient(to right, #10b981, #059669)';
                
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    button.style.background = '';
                }, 2000);
            });
        }

        // Close code display
        function closeCode() {
            document.getElementById('code-display').classList.add('hidden');
        }

        // Toggle code sections
        function toggleCode(section) {
            alert('In a real implementation, this would show all code for ' + section);
        }

        // Interactive tools functions
        let currentColor = 'green';
        let currentSize = 'medium';
        let effectsEnabled = false;

        function changeColor(color) {
            currentColor = color;
            const colorMap = {
                green: '#58cc70',
                blue: '#3b82f6',
                purple: '#8b5cf6',
                red: '#ef4444',
                yellow: '#f59e0b'
            };
            
            // Update some example elements with new color
            document.querySelectorAll('.icon-title i').forEach(icon => {
                icon.style.color = colorMap[color];
            });
            
            // Show feedback
            showToast(`Changed primary color to ${color}`);
        }

        function changeSize(size) {
            currentSize = size;
            const sizeMap = {
                small: { border: '2px', icon: '1rem' },
                medium: { border: '4px', icon: '1.25rem' },
                large: { border: '6px', icon: '1.5rem' }
            };
            
            // Update profile borders
            document.querySelectorAll('.profile-border').forEach(border => {
                border.style.borderWidth = sizeMap[size].border;
            });
            
            // Update icon sizes
            document.querySelectorAll('.icon-title i').forEach(icon => {
                icon.style.fontSize = sizeMap[size].icon;
            });
            
            // Update buttons
            document.querySelectorAll('[onclick*="changeSize"]').forEach(btn => {
                btn.classList.remove('bg-yellow-500', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-gray-300');
            });
            
            event.target.classList.add('bg-yellow-500', 'text-white');
            event.target.classList.remove('bg-white', 'border', 'border-gray-300');
            
            showToast(`Changed size to ${size}`);
        }

        function toggleEffects() {
            effectsEnabled = !effectsEnabled;
            const button = document.getElementById('effect-toggle');
            const cards = document.querySelectorAll('.card');
            
            if (effectsEnabled) {
                button.innerHTML = '<i class="fas fa-pause mr-2"></i>Disable Effects';
                button.style.background = 'linear-gradient(to right, #8b5cf6, #7c3aed)';
                
                cards.forEach(card => {
                    card.style.animation = 'pulse 3s infinite';
                });
                
                showToast('Animations enabled');
            } else {
                button.innerHTML = '<i class="fas fa-play mr-2"></i>Enable Effects';
                button.style.background = '';
                
                cards.forEach(card => {
                    card.style.animation = '';
                });
                
                showToast('Animations disabled');
            }
        }

        // Toast notification
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 px-6 py-3 rounded-lg bg-gray-800 text-white shadow-xl z-50 transform translate-y-0 opacity-0 transition-all duration-300';
            toast.innerHTML = `
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-400"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateY(0)';
            }, 10);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(20px)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Add click effects to all cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            
            cards.forEach(card => {
                card.addEventListener('mousedown', function() {
                    this.style.transform = 'translateY(2px)';
                    this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                });
                
                card.addEventListener('mouseup', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 8px 0 rgba(0, 0, 0, 0.1)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 0 rgba(0, 0, 0, 0.1)';
                });
            });
            
            // Show welcome message
            setTimeout(() => {
                showToast('Welcome to the Border & Icon Reference Gallery! Click any example to view code.');
            }, 1000);
        });
    </script>
</body>
</html>