document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const imageContainers = document.querySelectorAll('.img-box > div');

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            const selectedCategory = this.textContent.trim();

            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Show/hide images
            imageContainers.forEach(container => {
                const imageCategory = container.getAttribute('data-category');

                if (selectedCategory === 'All') {
                    // Show every image (even uncategorized)
                    container.style.display = 'block';
                    container.style.opacity = '0';
                    setTimeout(() => { container.style.opacity = '1'; }, 50);
                } else if (imageCategory === selectedCategory) {
                    // Show only matching category
                    container.style.display = 'block';
                    container.style.opacity = '0';
                    setTimeout(() => { container.style.opacity = '1'; }, 50);
                } else {
                    // Hide others
                    container.style.opacity = '0';
                    setTimeout(() => { container.style.display = 'none'; }, 300);
                }
            });
        });
    });

    // Initialize with All
    filterButtons[0].click();
});
