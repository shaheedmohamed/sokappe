/**
 * 📱 Mobile Enhancements for Sokappe
 * Optimizations for mobile user experience
 */

class MobileEnhancements {
    constructor() {
        this.init();
    }

    init() {
        this.setupViewportHandler();
        this.setupTouchEnhancements();
        this.setupKeyboardOptimizations();
        this.setupPerformanceOptimizations();
        this.setupAccessibilityFeatures();
        this.setupPWAFeatures();
    }

    /**
     * Handle viewport changes and orientation
     */
    setupViewportHandler() {
        // Handle viewport height changes (mobile browser bars)
        const setVH = () => {
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        };

        setVH();
        window.addEventListener('resize', setVH);
        window.addEventListener('orientationchange', () => {
            setTimeout(setVH, 100);
        });

        // Handle safe area insets
        if (CSS.supports('padding: env(safe-area-inset-top)')) {
            document.documentElement.classList.add('has-safe-area');
        }
    }

    /**
     * Enhanced touch interactions
     */
    setupTouchEnhancements() {
        // Add touch feedback to interactive elements
        const addTouchFeedback = (element) => {
            element.addEventListener('touchstart', (e) => {
                element.style.transform = 'scale(0.98)';
                element.style.opacity = '0.8';
                
                // Haptic feedback if supported
                if ('vibrate' in navigator) {
                    navigator.vibrate(10);
                }
            }, { passive: true });

            element.addEventListener('touchend', () => {
                setTimeout(() => {
                    element.style.transform = '';
                    element.style.opacity = '';
                }, 100);
            }, { passive: true });

            element.addEventListener('touchcancel', () => {
                element.style.transform = '';
                element.style.opacity = '';
            }, { passive: true });
        };

        // Apply to buttons and interactive elements
        document.querySelectorAll('button, .btn, .mobile-nav-item, .card').forEach(addTouchFeedback);

        // Prevent double-tap zoom on buttons
        document.querySelectorAll('button, .btn').forEach(button => {
            button.addEventListener('touchend', (e) => {
                e.preventDefault();
                button.click();
            }, { passive: false });
        });

        // Improve scroll momentum
        document.querySelectorAll('.modal-body, .mobile-modal-body').forEach(element => {
            element.style.webkitOverflowScrolling = 'touch';
        });
    }

    /**
     * Keyboard and input optimizations
     */
    setupKeyboardOptimizations() {
        // Handle virtual keyboard
        const handleKeyboard = () => {
            const inputs = document.querySelectorAll('input, textarea, select');
            
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    // Scroll to input when keyboard appears
                    setTimeout(() => {
                        input.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'center' 
                        });
                    }, 300);

                    // Add focused state
                    input.closest('.form-group')?.classList.add('focused');
                });

                input.addEventListener('blur', () => {
                    input.closest('.form-group')?.classList.remove('focused');
                });

                // Optimize input types for mobile keyboards
                if (input.type === 'email') {
                    input.setAttribute('inputmode', 'email');
                }
                if (input.type === 'tel') {
                    input.setAttribute('inputmode', 'tel');
                }
                if (input.type === 'number') {
                    input.setAttribute('inputmode', 'numeric');
                }
            });
        };

        handleKeyboard();

        // Re-apply when new content is loaded
        const observer = new MutationObserver(handleKeyboard);
        observer.observe(document.body, { childList: true, subtree: true });
    }

    /**
     * Performance optimizations for mobile
     */
    setupPerformanceOptimizations() {
        // Lazy loading for images
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            lazyImages.forEach(img => imageObserver.observe(img));
        }

        // Reduce motion for users who prefer it
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.classList.add('reduce-motion');
        }

        // Optimize animations based on device capabilities
        const isLowEndDevice = navigator.hardwareConcurrency <= 2 || 
                              navigator.deviceMemory <= 2;
        
        if (isLowEndDevice) {
            document.documentElement.classList.add('low-end-device');
        }

        // Preload critical resources
        this.preloadCriticalResources();
    }

    /**
     * Accessibility features for mobile
     */
    setupAccessibilityFeatures() {
        // Improve focus management
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-navigation');
        });

        // Announce page changes for screen readers
        const announcePageChange = (message) => {
            const announcement = document.createElement('div');
            announcement.setAttribute('aria-live', 'polite');
            announcement.setAttribute('aria-atomic', 'true');
            announcement.className = 'sr-only';
            announcement.textContent = message;
            
            document.body.appendChild(announcement);
            
            setTimeout(() => {
                document.body.removeChild(announcement);
            }, 1000);
        };

        // Monitor for route changes (if using SPA)
        let currentPath = window.location.pathname;
        const checkForRouteChange = () => {
            if (window.location.pathname !== currentPath) {
                currentPath = window.location.pathname;
                announcePageChange('تم تغيير الصفحة');
            }
        };

        setInterval(checkForRouteChange, 500);
    }

    /**
     * Progressive Web App features
     */
    setupPWAFeatures() {
        // Install prompt handling
        let deferredPrompt;
        
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Show install button if desired
            const installButton = document.querySelector('.install-app-btn');
            if (installButton) {
                installButton.style.display = 'block';
                installButton.addEventListener('click', () => {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the install prompt');
                        }
                        deferredPrompt = null;
                    });
                });
            }
        });

        // Handle app installation
        window.addEventListener('appinstalled', () => {
            console.log('App was installed');
            // Hide install button
            const installButton = document.querySelector('.install-app-btn');
            if (installButton) {
                installButton.style.display = 'none';
            }
        });

        // Service Worker registration (if available)
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('SW registered: ', registration);
                    })
                    .catch((registrationError) => {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
    }

    /**
     * Preload critical resources
     */
    preloadCriticalResources() {
        const criticalRoutes = [
            '/dashboard',
            '/projects',
            '/services'
        ];

        // Preload on user interaction
        let hasInteracted = false;
        const preloadOnInteraction = () => {
            if (hasInteracted) return;
            hasInteracted = true;

            criticalRoutes.forEach(route => {
                const link = document.createElement('link');
                link.rel = 'prefetch';
                link.href = route;
                document.head.appendChild(link);
            });
        };

        document.addEventListener('touchstart', preloadOnInteraction, { once: true });
        document.addEventListener('mousedown', preloadOnInteraction, { once: true });
    }

    /**
     * Network-aware loading
     */
    setupNetworkAwareLoading() {
        if ('connection' in navigator) {
            const connection = navigator.connection;
            
            // Adjust quality based on connection
            if (connection.effectiveType === 'slow-2g' || connection.effectiveType === '2g') {
                document.documentElement.classList.add('slow-connection');
            }
            
            // Monitor connection changes
            connection.addEventListener('change', () => {
                if (connection.effectiveType === 'slow-2g' || connection.effectiveType === '2g') {
                    document.documentElement.classList.add('slow-connection');
                } else {
                    document.documentElement.classList.remove('slow-connection');
                }
            });
        }
    }

    /**
     * Battery-aware optimizations
     */
    setupBatteryOptimizations() {
        if ('getBattery' in navigator) {
            navigator.getBattery().then((battery) => {
                const updateBatteryStatus = () => {
                    if (battery.level < 0.2 || !battery.charging) {
                        // Enable power saving mode
                        document.documentElement.classList.add('power-saving');
                    } else {
                        document.documentElement.classList.remove('power-saving');
                    }
                };

                updateBatteryStatus();
                battery.addEventListener('levelchange', updateBatteryStatus);
                battery.addEventListener('chargingchange', updateBatteryStatus);
            });
        }
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new MobileEnhancements();
    });
} else {
    new MobileEnhancements();
}

// Export for use in other modules
window.MobileEnhancements = MobileEnhancements;
