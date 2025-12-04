// Profile Border & Icon Script
class ProfileCustomizer {
    constructor() {
        this.currentBorder = 'default';
        this.userLevel = 'intermediate';
        this.init();
    }

    init() {
        this.setupAvatar();
        this.setupUsername();
        this.setupModal();
        this.setupBorderSelector();
        this.setupEventListeners();
        
        // Load saved border from localStorage
        this.loadSavedBorder();
    }

    setupAvatar() {
        const avatarWrapper = document.querySelector('.profile-avatar-wrapper');
        if (!avatarWrapper) return;

        // Apply default border
        this.applyBorder(avatarWrapper, this.currentBorder);
        
        // Add level badge
        this.addLevelBadge(avatarWrapper);
        
        // Add status indicator
        this.addStatusIndicator(avatarWrapper);
    }

    applyBorder(avatarWrapper, borderType) {
        // Remove all border classes
        avatarWrapper.classList.remove(
            'profile-border-default',
            'profile-border-animated',
            'profile-border-premium',
            'profile-border-community',
            'profile-border-minimal',
            'profile-border-float'
        );

        // Add selected border class
        switch(borderType) {
            case 'animated':
                avatarWrapper.classList.add('profile-border-animated');
                break;
            case 'premium':
                avatarWrapper.classList.add('profile-border-premium');
                break;
            case 'community':
                avatarWrapper.classList.add('profile-border-community');
                break;
            case 'minimal':
                avatarWrapper.classList.add('profile-border-minimal');
                break;
            case 'float':
                avatarWrapper.classList.add('profile-border-float');
                break;
            default:
                avatarWrapper.classList.add('profile-border-default');
        }
        
        this.currentBorder = borderType;
        
        // Save to localStorage
        localStorage.setItem('profileBorder', borderType);
    }

    addLevelBadge(avatarWrapper) {
        // Remove existing badge
        const existingBadge = avatarWrapper.querySelector('.profile-level-badge');
        if (existingBadge) existingBadge.remove();

        // Create level badge
        const levelBadge = document.createElement('div');
        levelBadge.className = 'profile-level-badge';
        
        // Set level number
        const levelMap = {
            'beginner': '1',
            'intermediate': '2',
            'advanced': '3',
            'expert': '4',
            'master': '5'
        };
        
        levelBadge.textContent = levelMap[this.userLevel] || '2';
        levelBadge.title = `Level ${this.capitalizeFirstLetter(this.userLevel)}`;

        avatarWrapper.appendChild(levelBadge);
    }

    addStatusIndicator(avatarWrapper) {
        // Remove existing indicator
        const existingIndicator = avatarWrapper.querySelector('.profile-status-indicator');
        if (existingIndicator) existingIndicator.remove();

        // Create status indicator
        const statusIndicator = document.createElement('div');
        statusIndicator.className = 'profile-status-indicator profile-status-online';
        statusIndicator.title = 'Online';

        avatarWrapper.appendChild(statusIndicator);
    }

    setupUsername() {
        const usernameElement = document.querySelector('.profile-username');
        if (!usernameElement) return;

        const username = usernameElement.textContent.trim();
        
        // Create container
        const container = document.createElement('div');
        container.className = 'profile-username-container';

        // Add icon
        const icon = document.createElement('div');
        icon.className = 'profile-user-icon';
        icon.innerHTML = this.getLevelIcon();
        icon.title = this.getLevelTitle();
        container.appendChild(icon);

        // Add username
        const usernameText = document.createElement('h2');
        usernameText.className = 'profile-username';
        usernameText.textContent = username;
        container.appendChild(usernameText);

        // Add badge
        const badge = document.createElement('span');
        badge.className = `profile-user-badge badge-${this.userLevel}`;
        badge.textContent = this.getBadgeText();
        container.appendChild(badge);

        // Replace original username
        usernameElement.parentNode.replaceChild(container, usernameElement);
    }

    getLevelIcon() {
        const iconMap = {
            'beginner': '<i class="fas fa-seedling"></i>',
            'intermediate': '<i class="fas fa-leaf"></i>',
            'advanced': '<i class="fas fa-tree"></i>',
            'expert': '<i class="fas fa-medal"></i>',
            'master': '<i class="fas fa-crown"></i>'
        };
        
        return iconMap[this.userLevel] || '<i class="fas fa-user"></i>';
    }

    getLevelTitle() {
        const titles = {
            'beginner': 'Pengguna Pemula',
            'intermediate': 'Pengguna Aktif',
            'advanced': 'Pengguna Berpengalaman',
            'expert': 'Ahli Kesehatan Mental',
            'master': 'Master Wellness'
        };
        return titles[this.userLevel] || 'Pengguna';
    }

    getBadgeText() {
        const texts = {
            'beginner': 'Pemula',
            'intermediate': 'Aktif',
            'advanced': 'Berpengalaman',
            'expert': 'Ahli',
            'master': 'Master'
        };
        return texts[this.userLevel] || 'Member';
    }

    setupModal() {
        // Check if modal already exists
        if (document.getElementById('profileAvatarModal')) return;

        // Get avatar image source
        const avatarImg = document.querySelector('.profile-avatar-img');
        if (!avatarImg) return;

        // Create modal HTML
        const modalHTML = `
            <div class="profile-avatar-modal" id="profileAvatarModal">
                <div class="profile-avatar-modal-content">
                    <div class="profile-modal-header">
                        <h3 class="m-0 font-bold text-lg text-gray-800">Ubah Border Profil</h3>
                        <button class="close-modal bg-transparent border-none text-xl cursor-pointer text-gray-600 hover:text-gray-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="profile-modal-body">
                        <img src="${avatarImg.src}" alt="Avatar" class="profile-modal-avatar" id="modalAvatarImg">
                        <div class="profile-border-selector">
                            <h4 class="font-medium text-gray-700 mb-2">Pilih Gaya Border</h4>
                            <div class="profile-border-options">
                                <div class="profile-border-option border-option-default active" data-border="default" title="Default"></div>
                                <div class="profile-border-option border-option-animated" data-border="animated" title="Animated"></div>
                                <div class="profile-border-option border-option-premium" data-border="premium" title="Premium"></div>
                                <div class="profile-border-option border-option-community" data-border="community" title="Community"></div>
                                <div class="profile-border-option border-option-minimal" data-border="minimal" title="Minimal"></div>
                                <div class="profile-border-option border-option-float" data-border="float" title="Floating"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-3">Klik untuk memilih border yang berbeda</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Setup modal event listeners
        this.setupModalEvents();
    }

    setupModalEvents() {
        const modal = document.getElementById('profileAvatarModal');
        const closeBtn = modal.querySelector('.close-modal');
        const modalAvatarImg = document.getElementById('modalAvatarImg');

        // Update modal avatar with current border
        const updateModalAvatar = () => {
            const avatarImg = document.querySelector('.profile-avatar-img');
            if (avatarImg && modalAvatarImg) {
                modalAvatarImg.src = avatarImg.src;
            }
        };

        // Close modal handlers
        closeBtn.addEventListener('click', () => {
            this.closeAvatarModal();
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                this.closeAvatarModal();
            }
        });

        // Close with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('show')) {
                this.closeAvatarModal();
            }
        });

        // Update modal when opened
        const avatarWrapper = document.querySelector('.profile-avatar-wrapper');
        avatarWrapper.addEventListener('click', () => {
            updateModalAvatar();
            this.openAvatarModal();
        });
    }

    openAvatarModal() {
        const modal = document.getElementById('profileAvatarModal');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    closeAvatarModal() {
        const modal = document.getElementById('profileAvatarModal');
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    setupBorderSelector() {
        const borderOptions = document.querySelectorAll('.profile-border-option');
        
        borderOptions.forEach(option => {
            option.addEventListener('click', () => {
                // Remove active class from all options
                borderOptions.forEach(opt => opt.classList.remove('active'));
                
                // Add active class to clicked option
                option.classList.add('active');
                
                // Get border type
                const borderType = option.getAttribute('data-border');
                
                // Apply border to avatar
                const avatarWrapper = document.querySelector('.profile-avatar-wrapper');
                this.applyBorder(avatarWrapper, borderType);
                
                // Show success message
                this.showMessage(`Border "${option.title}" telah diterapkan!`, 'success');
            });
        });
    }

    loadSavedBorder() {
        const savedBorder = localStorage.getItem('profileBorder');
        if (savedBorder) {
            this.currentBorder = savedBorder;
            const avatarWrapper = document.querySelector('.profile-avatar-wrapper');
            if (avatarWrapper) {
                this.applyBorder(avatarWrapper, savedBorder);
                
                // Update active border in modal
                const borderOptions = document.querySelectorAll('.profile-border-option');
                borderOptions.forEach(option => {
                    option.classList.remove('active');
                    if (option.getAttribute('data-border') === savedBorder) {
                        option.classList.add('active');
                    }
                });
            }
        }
    }

    setupEventListeners() {
        // Hover effect on avatar
        const avatarWrapper = document.querySelector('.profile-avatar-wrapper');
        if (avatarWrapper) {
            avatarWrapper.addEventListener('mouseenter', () => {
                avatarWrapper.style.transform = 'scale(1.05)';
            });
            
            avatarWrapper.addEventListener('mouseleave', () => {
                avatarWrapper.style.transform = 'scale(1)';
            });
        }
    }

    showMessage(text, type = 'info') {
        // Remove existing message
        const existingMessage = document.querySelector('.profile-message');
        if (existingMessage) existingMessage.remove();

        // Create message element
        const message = document.createElement('div');
        message.className = `profile-message fixed top-4 right-4 px-4 py-3 rounded-lg shadow-lg text-white font-medium z-50 ${
            type === 'success' ? 'bg-green-500' : 'bg-blue-500'
        }`;
        message.textContent = text;
        message.style.animation = 'fadeIn 0.3s ease';
        
        document.body.appendChild(message);
        
        // Remove after 3 seconds
        setTimeout(() => {
            message.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => {
                if (message.parentNode) {
                    message.remove();
                }
            }, 300);
        }, 3000);
    }

    // Helper method
    capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ProfileCustomizer();
    
    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
    `;
    document.head.appendChild(style);
});