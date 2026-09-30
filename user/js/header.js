// Run this code only after the page has fully loaded
document.addEventListener('DOMContentLoaded', function () {

  // Get the slider container that holds all slides
  const slider = document.querySelector('.nav-bg-list');

  // Get all individual slide items
  const slides = document.querySelectorAll('.nav-bg-item');

  // Get all dot elements used for navigation
  const dots = document.querySelectorAll('.nav-bg-dots li');

  // Start with the first slide
  let currentSlide = 0;

  // Count how many slides there are
  const slideCount = slides.length;

  // This will store the auto-slide timer
  let autoSlideInterval;

  // Highlight the first dot when the page loads
  dots[0].classList.add('active');

  // Function to go to a specific slide
  function goToSlide(index) {
    try {


      // If index is too big, go back to the first slide
      if (index >= slideCount) {
        index = 0;
      }

      // Move the slider to the correct position
      slider.style.transform = `translateX(-${index * 100}%)`;

      // Remove 'active' class from all dots
      dots.forEach(function (dot) {
        dot.classList.remove('active');
      });

      // Add 'active' class to the current dot
      dots[index].classList.add('active');

      // Update the current slide number
      currentSlide = index;

    } catch (error) {
      console.error('Error in goToSlide:', error);
    }
  }

  // Add click event to each dot
  dots.forEach(function (dot, index) {
    dot.addEventListener('click', function (event) {
      event.preventDefault();      // Stop default link behavior
      event.stopPropagation();     // Stop bubbling up the event

      clearInterval(autoSlideInterval); // Stop auto sliding

      goToSlide(index); // Go to the clicked slide

      // Restart auto sliding after manual click
      autoSlideInterval = setInterval(function () {
        goToSlide(currentSlide + 1);
      }, 5000);
    });
  });

  // Start auto sliding every 5 seconds
  autoSlideInterval = setInterval(function () {
    goToSlide(currentSlide + 1);
  }, 5000);

  const links = document.querySelectorAll('.right-nav-link');
  const currentPath = window.location.pathname.split('/').pop();

  links.forEach(function (link) {
    // Get the href's file name (e.g., design.php)
    const linkPath = link.getAttribute('href').split('/').pop();
    if (linkPath === currentPath) {
      link.classList.add('active');
    }
  });
  const hamburger = document.querySelector('.hamburger');
  const sidebar = document.querySelector('.sidebar');
  const body = document.body;

  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    sidebar.classList.toggle('active');
    body.classList.toggle('no-scroll');
  });

  // Close sidebar when clicking outside
  document.addEventListener('click', (e) => {
    if (!sidebar.contains(e.target) && !hamburger.contains(e.target) && sidebar.classList.contains('active')) {
      hamburger.classList.remove('active');
      sidebar.classList.remove('active');
      body.classList.remove('no-scroll');
    }
  });
  

  
});