<style>
/* ===== BORDER BASE STYLES ===== */
.my-border {
    padding: 8px;
    margin: 8px;
    border-radius: 12px;
    background-color: rgba(255, 255, 255, 0.95);
    position: relative;
    overflow: hidden;
    min-height: 40px;
    border: 3px solid transparent;
    background-clip: padding-box;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Gradient Border Base */
.my-border::before {
    content: '';
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    background: linear-gradient(45deg, 
        #ff6b6b, #4ecdc4, #45b7d1, #96ceb4,
        #feca57, #ff9ff3, #54a0ff, #5f27cd
    );
    border-radius: 15px;
    z-index: -1;
    background-size: 300% 300%;
    animation: gradientFlow 8s ease infinite;
    filter: brightness(1.1);
}

/* Inner Glow Effect */
.my-border::after {
    content: '';
    position: absolute;
    top: 1px;
    left: 1px;
    right: 1px;
    bottom: 1px;
    border-radius: 10px;
    background: transparent;
    box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.3);
    z-index: -1;
    pointer-events: none;
}

/* ===== ANIMATION KEYFRAMES ===== */
@keyframes gradientFlow {
    0%, 100% {
        background-position: 0% 50%;
        filter: hue-rotate(0deg) brightness(1.1);
    }
    25% {
        background-position: 50% 100%;
        filter: hue-rotate(90deg) brightness(1.15);
    }
    50% {
        background-position: 100% 50%;
        filter: hue-rotate(180deg) brightness(1.2);
    }
    75% {
        background-position: 50% 0%;
        filter: hue-rotate(270deg) brightness(1.15);
    }
}

@keyframes borderPulse {
    0%, 100% {
        box-shadow: 
            0 0 0 3px rgba(255, 107, 107, 0.1),
            0 0 0 6px rgba(78, 205, 196, 0.1),
            0 0 0 9px rgba(69, 183, 209, 0.1);
    }
    33% {
        box-shadow: 
            0 0 0 5px rgba(78, 205, 196, 0.15),
            0 0 0 10px rgba(69, 183, 209, 0.15),
            0 0 0 15px rgba(255, 107, 107, 0.15);
    }
    66% {
        box-shadow: 
            0 0 0 7px rgba(69, 183, 209, 0.2),
            0 0 0 14px rgba(255, 107, 107, 0.2),
            0 0 0 21px rgba(78, 205, 196, 0.2);
    }
}

@keyframes borderGlow {
    0%, 100% {
        opacity: 0.7;
        transform: scale(1);
    }
    50% {
        opacity: 1;
        transform: scale(1.02);
    }
}

/* ===== VARIATIONS ===== */
/* Color Themes */
.my-border.theme-fire::before {
    background: linear-gradient(45deg, 
        #ff0000, #ff4500, #ff8c00, #ffd700,
        #ff8c00, #ff4500, #ff0000
    );
    animation: gradientFlow 4s ease infinite;
    filter: brightness(1.2);
}

.my-border.theme-ice::before {
    background: linear-gradient(45deg, 
        #00ffff, #008b8b, #4682b4, #87ceeb,
        #00bfff, #4682b4, #008b8b, #00ffff
    );
    animation: gradientFlow 6s ease infinite;
    filter: brightness(1.1) saturate(1.2);
}

.my-border.theme-forest::before {
    background: linear-gradient(45deg, 
        #228b22, #32cd32, #006400, #7cfc00,
        #98fb98, #006400, #32cd32, #228b22
    );
    animation: gradientFlow 7s ease infinite;
}

.my-border.theme-galaxy::before {
    background: linear-gradient(45deg, 
        #9400d3, #8a2be2, #9932cc, #ba55d3,
        #dda0dd, #9932cc, #8a2be2, #9400d3
    );
    animation: gradientFlow 5s ease infinite;
    filter: brightness(1.15);
}

/* Border Styles */
.my-border.style-double::before {
    background-size: 200% 200%;
    animation: gradientFlow 10s linear infinite;
    opacity: 0.8;
}

.my-border.style-glow {
    box-shadow: 
        0 0 20px rgba(255, 107, 107, 0.3),
        0 0 40px rgba(78, 205, 196, 0.2),
        0 0 60px rgba(69, 183, 209, 0.1);
}

.my-border.style-neon::before {
    filter: brightness(1.5) saturate(2);
    animation: gradientFlow 3s ease infinite;
}

.my-border.style-soft::before {
    opacity: 0.6;
    filter: blur(2px);
    animation: gradientFlow 12s ease infinite;
}

/* Size Variations */
.my-border.size-sm {
    padding: 4px;
    margin: 4px;
    border-radius: 8px;
}

.my-border.size-sm::before {
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    border-radius: 10px;
}

.my-border.size-lg {
    padding: 16px;
    margin: 16px;
    border-radius: 20px;
}

.my-border.size-lg::before {
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    border-radius: 25px;
}

/* ===== STATE CLASSES ===== */
.my-border.active {
    transform: translateY(-2px);
    box-shadow: 
        0 8px 30px rgba(0, 0, 0, 0.15),
        0 0 0 3px rgba(255, 107, 107, 0.2);
}

.my-border.active::before {
    animation: gradientFlow 2s ease infinite;
    filter: brightness(1.3);
}

.my-border.hover-effect:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 
        0 12px 40px rgba(0, 0, 0, 0.2),
        0 0 0 4px rgba(78, 205, 196, 0.3);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.my-border.pulse-effect {
    animation: borderPulse 3s ease-in-out infinite;
}

.my-border.glow-effect::before {
    animation: gradientFlow 4s ease infinite, borderGlow 2s ease-in-out infinite;
}

/* ===== CONTENT INSIDE ===== */
.border-content {
    padding: 16px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    position: relative;
    z-index: 1;
}

.my-border.dark .border-content {
    background: rgba(30, 30, 30, 0.9);
    color: #ffffff;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .my-border {
        padding: 6px;
        margin: 6px;
        border-radius: 10px;
    }
    
    .my-border::before {
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        border-radius: 12px;
    }
}

/* ===== SPECIAL EFFECTS ===== */
.my-border.sparkle::before {
    background-image: 
        linear-gradient(45deg, 
            #ff6b6b, #4ecdc4, #45b7d1, #96ceb4,
            #feca57, #ff9ff3, #54a0ff, #5f27cd
        ),
        repeating-linear-gradient(
            45deg,
            transparent,
            transparent 10px,
            rgba(255, 255, 255, 0.1) 10px,
            rgba(255, 255, 255, 0.1) 20px
        );
}

.my-border.radial::before {
    background: radial-gradient(
        circle at 30% 30%,
        #ff6b6b,
        #4ecdc4,
        #45b7d1,
        #96ceb4
    );
    animation: gradientFlow 15s ease infinite;
}

.my-border.wave::before {
    background: linear-gradient(
        90deg,
        transparent 25%,
        #ff6b6b 25%, #4ecdc4 50%,
        #45b7d1 50%, #96ceb4 75%,
        transparent 75%
    );
    background-size: 200% 100%;
    animation: waveMove 4s linear infinite;
}

@keyframes waveMove {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: 0 0;
    }
}
</style>

<script>
class AnimatedBorder {
    constructor(element) {
        this.element = element;
        this.canvas = null;
        this.ctx = null;
        this.particles = [];
        this.waves = [];
        this.isActive = false;
        this.animationId = null;
        
        this.init();
    }
    
    init() {
        // Cek jika elemen memiliki efek kompleks
        if (this.element.classList.contains('complex-effect')) {
            this.setupCanvas();
            this.setupParticles();
            this.startAnimation();
        }
        
        // Setup event listeners
        this.setupEventListeners();
    }
    
    setupCanvas() {
        // Buat canvas untuk efek partikel
        this.canvas = document.createElement('canvas');
        this.canvas.classList.add('border-canvas');
        this.canvas.style.position = 'absolute';
        this.canvas.style.top = '0';
        this.canvas.style.left = '0';
        this.canvas.style.width = '100%';
        this.canvas.style.height = '100%';
        this.canvas.style.pointerEvents = 'none';
        this.canvas.style.zIndex = '0';
        
        // Set ukuran canvas
        const rect = this.element.getBoundingClientRect();
        this.canvas.width = rect.width;
        this.canvas.height = rect.height;
        
        this.element.style.position = 'relative';
        this.element.appendChild(this.canvas);
        this.ctx = this.canvas.getContext('2d');
    }
    
    setupParticles() {
        const colors = [
            '#ff6b6b', '#4ecdc4', '#45b7d1', 
            '#96ceb4', '#feca57', '#ff9ff3'
        ];
        
        // Buat partikel untuk efek sparkle
        for (let i = 0; i < 20; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                size: Math.random() * 3 + 1,
                speedX: Math.random() * 2 - 1,
                speedY: Math.random() * 2 - 1,
                color: colors[Math.floor(Math.random() * colors.length)],
                life: Math.random() * 100 + 50,
                maxLife: Math.random() * 100 + 50
            });
        }
        
        // Buat wave effects
        for (let i = 0; i < 3; i++) {
            this.waves.push({
                progress: Math.random() * Math.PI * 2,
                speed: Math.random() * 0.02 + 0.01,
                amplitude: Math.random() * 10 + 5,
                frequency: Math.random() * 0.1 + 0.05,
                color: colors[Math.floor(Math.random() * colors.length)],
                width: 2
            });
        }
    }
    
    startAnimation() {
        this.isActive = true;
        this.animate();
    }
    
    stopAnimation() {
        this.isActive = false;
        if (this.animationId) {
            cancelAnimationFrame(this.animationId);
        }
    }
    
    animate() {
        if (!this.isActive || !this.canvas) return;
        
        this.clearCanvas();
        this.updateParticles();
        this.drawParticles();
        this.drawWaves();
        
        this.animationId = requestAnimationFrame(() => this.animate());
    }
    
    clearCanvas() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }
    
    updateParticles() {
        this.particles.forEach(particle => {
            particle.x += particle.speedX;
            particle.y += particle.speedY;
            particle.life--;
            
            // Bounce off edges
            if (particle.x < 0 || particle.x > this.canvas.width) {
                particle.speedX *= -1;
            }
            if (particle.y < 0 || particle.y > this.canvas.height) {
                particle.speedY *= -1;
            }
            
            // Reset particle jika mati
            if (particle.life <= 0) {
                particle.x = Math.random() * this.canvas.width;
                particle.y = Math.random() * this.canvas.height;
                particle.life = particle.maxLife;
            }
        });
        
        // Update waves
        this.waves.forEach(wave => {
            wave.progress += wave.speed;
            if (wave.progress > Math.PI * 2) {
                wave.progress -= Math.PI * 2;
            }
        });
    }
    
    drawParticles() {
        this.particles.forEach(particle => {
            const alpha = particle.life / particle.maxLife;
            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            this.ctx.fillStyle = particle.color.replace(')', `, ${alpha})`).replace('rgb', 'rgba');
            this.ctx.fill();
            
            // Glow effect
            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.size * 3, 0, Math.PI * 2);
            this.ctx.fillStyle = particle.color.replace(')', `, ${alpha * 0.2})`).replace('rgb', 'rgba');
            this.ctx.fill();
        });
    }
    
    drawWaves() {
        const width = this.canvas.width;
        const height = this.canvas.height;
        
        this.waves.forEach(wave => {
            this.ctx.beginPath();
            this.ctx.strokeStyle = wave.color;
            this.ctx.lineWidth = wave.width;
            
            for (let x = 0; x <= width; x += 2) {
                const y = height / 2 + 
                         Math.sin((x * wave.frequency) + wave.progress) * wave.amplitude +
                         Math.cos(wave.progress * 2) * 5;
                
                if (x === 0) {
                    this.ctx.moveTo(x, y);
                } else {
                    this.ctx.lineTo(x, y);
                }
            }
            
            this.ctx.stroke();
        });
    }
    
    setupEventListeners() {
        // Mouse move effect untuk interactive border
        this.element.addEventListener('mousemove', (e) => {
            if (this.element.classList.contains('interactive')) {
                this.handleMouseMove(e);
            }
        });
        
        // Click effect
        this.element.addEventListener('click', (e) => {
            this.handleClick(e);
        });
        
        // Resize handler
        window.addEventListener('resize', () => {
            this.handleResize();
        });
    }
    
    handleMouseMove(e) {
        const rect = this.element.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        // Update gradient position berdasarkan mouse
        const percentX = (x / rect.width) * 100;
        const percentY = (y / rect.height) * 100;
        
        this.element.style.setProperty('--mouse-x', `${percentX}%`);
        this.element.style.setProperty('--mouse-y', `${percentY}%`);
        
        // Tambahkan partikel pada mouse position
        if (this.particles.length < 50) {
            const colors = ['#ff6b6b', '#4ecdc4', '#feca57', '#ff9ff3'];
            this.particles.push({
                x: x,
                y: y,
                size: Math.random() * 2 + 1,
                speedX: Math.random() * 4 - 2,
                speedY: Math.random() * 4 - 2,
                color: colors[Math.floor(Math.random() * colors.length)],
                life: 100,
                maxLife: 100
            });
        }
    }
    
    handleClick(e) {
        // Ripple effect on click
        this.createRipple(e);
        
        // Toggle active state
        this.element.classList.toggle('active');
        
        // Emit custom event
        this.element.dispatchEvent(new CustomEvent('border-click', {
            detail: { element: this.element }
        }));
    }
    
    createRipple(e) {
        const ripple = document.createElement('div');
        ripple.classList.add('border-ripple');
        
        const rect = this.element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, transparent 70%);
            width: ${size}px;
            height: ${size}px;
            top: ${y}px;
            left: ${x}px;
            pointer-events: none;
            z-index: 1;
            transform: scale(0);
            animation: rippleExpand 0.6s ease-out;
        `;
        
        this.element.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
    
    handleResize() {
        if (this.canvas) {
            const rect = this.element.getBoundingClientRect();
            this.canvas.width = rect.width;
            this.canvas.height = rect.height;
        }
    }
    
    // Public methods
    setTheme(theme) {
        const themes = ['theme-fire', 'theme-ice', 'theme-forest', 'theme-galaxy'];
        themes.forEach(t => this.element.classList.remove(t));
        if (theme) {
            this.element.classList.add(theme);
        }
    }
    
    setStyle(style) {
        const styles = ['style-double', 'style-glow', 'style-neon', 'style-soft'];
        styles.forEach(s => this.element.classList.remove(s));
        if (style) {
            this.element.classList.add(style);
        }
    }
    
    toggleEffect(effect) {
        this.element.classList.toggle(effect);
    }
    
    destroy() {
        this.stopAnimation();
        if (this.canvas && this.canvas.parentNode) {
            this.canvas.parentNode.removeChild(this.canvas);
        }
    }
}

// CSS untuk efek ripple
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
    @keyframes rippleExpand {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    /* CSS variable untuk interactive effect */
    .my-border.interactive::before {
        background-position: var(--mouse-x, 50%) var(--mouse-y, 50%);
        transition: background-position 0.3s ease;
    }
`;
document.head.appendChild(rippleStyle);

// Inisialisasi semua border
document.addEventListener('DOMContentLoaded', () => {
    const borders = document.querySelectorAll('.my-border');
    const borderInstances = [];
    
    borders.forEach(border => {
        const instance = new AnimatedBorder(border);
        borderInstances.push(instance);
        
        // Tambahkan data attribute untuk akses instance
        border.animatedBorder = instance;
    });
    
    // Global API
    window.BorderEffects = {
        getInstance: (element) => {
            return element.animatedBorder;
        },
        
        createBorder: (element, options = {}) => {
            element.classList.add('my-border');
            
            if (options.theme) {
                element.classList.add(`theme-${options.theme}`);
            }
            
            if (options.style) {
                element.classList.add(`style-${options.style}`);
            }
            
            if (options.size) {
                element.classList.add(`size-${options.size}`);
            }
            
            if (options.complex) {
                element.classList.add('complex-effect');
            }
            
            if (options.interactive) {
                element.classList.add('interactive');
            }
            
            // Inisialisasi instance baru
            const instance = new AnimatedBorder(element);
            element.animatedBorder = instance;
            borderInstances.push(instance);
            
            return instance;
        },
        
        destroyAll: () => {
            borderInstances.forEach(instance => instance.destroy());
            borderInstances.length = 0;
        }
    };
});
</script>