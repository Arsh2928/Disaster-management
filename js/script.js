document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            this.querySelector('i').classList.toggle('fa-times');
            this.querySelector('i').classList.toggle('fa-bars');
        });
        
        // Clone desktop menu to mobile
        const desktopMenu = document.querySelector('nav ul').cloneNode(true);
        mobileMenu.querySelector('ul').replaceWith(desktopMenu);
    }
    
    // Sticky header
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        if (window.scrollY > 50) {
            header.classList.add('header-scrolled');
        } else {
            header.classList.remove('header-scrolled');
        }
    });
    
    // Disaster filtering
    if (document.querySelector('.disaster-list')) {
        const searchInput = document.getElementById('search');
        const typeFilter = document.getElementById('type-filter');
        const severityFilter = document.getElementById('severity-filter');
        const disasterCards = document.querySelectorAll('.disaster-card');
        
        function filterDisasters() {
            const searchTerm = searchInput.value.toLowerCase();
            const typeValue = typeFilter.value;
            const severityValue = severityFilter.value;
            
            disasterCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const type = card.dataset.type;
                const severity = card.dataset.severity;
                
                const matchesSearch = title.includes(searchTerm);
                const matchesType = typeValue === '' || type === typeValue;
                const matchesSeverity = severityValue === '' || severity === severityValue;
                
                if (matchesSearch && matchesType && matchesSeverity) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        }
        
        searchInput.addEventListener('input', filterDisasters);
        typeFilter.addEventListener('change', filterDisasters);
        severityFilter.addEventListener('change', filterDisasters);
    }
    
    // Contact search
    if (document.getElementById('contact-search')) {
        const contactSearch = document.getElementById('contact-search');
        const contactCards = document.querySelectorAll('.contact-card');
        
        contactSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            contactCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    }
    
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('error');
                    isValid = false;
                } else {
                    field.classList.remove('error');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                this.querySelector('.error-message')?.textContent = 'Please fill in all required fields.';
            }
        });
    });
    
});