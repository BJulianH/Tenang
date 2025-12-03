<style>
    .avatar-message {
    position: fixed;
    bottom: 30px;
    left: 30px;
    display: flex;
    align-items: flex-end;
    gap: 12px;
    z-index: 99999;
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.35s ease;
}

.avatar-message.show {
    opacity: 1;
    transform: translateY(0);
}

.avatar-img {
    width: 72px;
    height: 72px;
    border-radius: 999px;
    object-fit: contain;
    background: white;
    padding: 6px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
}

.avatar-bubble {
    background: white;
    max-width: 260px;
    padding: 14px 18px;
    border-radius: 20px;
    font-size: 15px;
    color: #333;
    position: relative;
    box-shadow: 0 6px 16px rgba(0,0,0,0.16);
    animation: popIn 0.35s ease;
}

.avatar-bubble::before {
    content: "";
    position: absolute;
    left: -10px;
    bottom: 16px;
    width: 0;
    height: 0;
    border-right: 12px solid white;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
}

.bubble-close {
    background: transparent;
    border: none;
    font-size: 18px;
    position: absolute;
    top: 4px;
    right: 10px;
    cursor: pointer;
    color: #888;
}

@keyframes popIn {
    0% { transform: scale(0.8); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

</style>
<div id="avatar-message" class="avatar-message hidden">
    <img src="{{ asset('assets/icon/icon-2.png') }}" class="avatar-img" alt="avatar">
    <div class="avatar-bubble">
        <p id="avatar-text">Hello! I’m here to help you!</p>
        <button id="avatar-close" class="bubble-close">×</button>
    </div>
</div>
<script>
function showAvatarMessage(text = "Hello! I’m here to help you!") {
    const box = document.getElementById("avatar-message");
    const textElement = document.getElementById("avatar-text");

    textElement.innerText = text;

    box.classList.add("show");
    box.classList.remove("hidden");

    // Auto hide after 6 seconds
    setTimeout(() => {
        hideAvatarMessage();
    }, 6000);
}

function hideAvatarMessage() {
    const box = document.getElementById("avatar-message");
    box.classList.remove("show");

    setTimeout(() => {
        box.classList.add("hidden");
    }, 300);
}

document.getElementById("avatar-close").addEventListener("click", hideAvatarMessage);
</script>
