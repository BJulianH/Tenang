<div id="avatarPopup"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    
    <div class="bg-white rounded-3xl p-6 shadow-2xl relative max-w-sm text-center animate-pop">
        
        <!-- Avatar -->
        <img src="{{ asset('assets/icon/icon-2.png') }}" 
             class="w-40 h-40 mx-auto -mt-20 mb-4 drop-shadow-xl" 
             alt="Avatar">

        <!-- Dialog Text -->
        <h2 class="text-xl font-bold mb-2">Hi, commander!</h2>
        <p id="avatarPopupText" class="text-gray-700 text-base leading-relaxed"></p>

        <!-- Button -->
        <button onclick="closeAvatarPopup()"
                class="mt-6 px-6 py-3 bg-primary-700 text-white rounded-xl shadow hover:scale-105 transition">
            Let's Go!
        </button>
    </div>
</div>

<style>
@keyframes pop {
    0% { transform: scale(0.7); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
.animate-pop { animation: pop 0.25s ease-out; }
</style>
<script>
function showAvatarPopup(message) {
    document.getElementById("avatarPopupText").innerText = message;
    document.getElementById("avatarPopup").classList.remove("hidden");
}

function closeAvatarPopup() {
    document.getElementById("avatarPopup").classList.add("hidden");
}

function showDailyAvatarPopup() {
    const today = new Date().toISOString().slice(0, 10);
    const lastShown = localStorage.getItem("bigAvatarPopupLastShown");

    if (lastShown !== today) {
        showAvatarPopup("Welcome back, {{ auth()->user()->name ?? 'Explorer' }}!");
        localStorage.setItem("bigAvatarPopupLastShown", today);
    }
}
</script>
