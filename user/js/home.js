document.addEventListener('DOMContentLoaded', function () {
  // Fetch reviews from database and display
  let reviewsData = [];
  let currentReview = 0;
  let activeNode = null;
  let previewNode = null;
  const reviewImgDiv = document.querySelector('.review-img');
  const reviewTextDiv = document.querySelector('.review-text p');
  const reviewerNameDiv = document.querySelector('.reviewer-name');
  const dots = document.querySelectorAll('.dir ul li');

  function createImageNode(photoPath, roleClass) {
    const div = document.createElement('div');
    div.className = 'review-img-item';
    if (roleClass) div.classList.add(roleClass);
    const img = document.createElement('img');
    if (photoPath) {
      // If photoPath is an absolute Windows path, extract only the web path part
      let webPath = photoPath;
      // Remove Windows absolute path if present
      const idx = photoPath.indexOf('uploads/review_photos/');
      if (idx !== -1) {
        webPath = photoPath.substring(idx);
      }
      img.src = '../../' + webPath.replace(/^\/+/, '');
    } else {
      img.src = '../assets/img/1.1.png'; // fallback image
    }
    img.alt = 'review image';
    div.appendChild(img);
    return div;
  }

  function initReviewNodes(index) {
    reviewImgDiv.innerHTML = '';
    if (!reviewsData.length) return;
    const safeIndex = ((index % reviewsData.length) + reviewsData.length) % reviewsData.length;
    const nextIndex = (safeIndex + 1) % reviewsData.length;
    activeNode = createImageNode(reviewsData[safeIndex].photo_path, 'active');
    previewNode = createImageNode(reviewsData[nextIndex].photo_path, 'next');
    reviewImgDiv.appendChild(previewNode);
    reviewImgDiv.appendChild(activeNode);
  }

  function animateTo(index) {
    if (!reviewsData.length) return;
    const safeIndex = ((index % reviewsData.length) + reviewsData.length) % reviewsData.length;
    if (safeIndex === currentReview) return;

    const newActive = createImageNode(reviewsData[safeIndex].photo_path, 'active');
    newActive.style.opacity = '0';
    newActive.style.zIndex = '3';
    reviewImgDiv.appendChild(newActive);

    // force layout
    newActive.offsetWidth;

    // fade in newActive and fade out old active
    newActive.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    if (activeNode) {
      activeNode.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      activeNode.style.opacity = '0';
      activeNode.style.transform = 'scale(0.98) translateX(-10px)';
    }
    newActive.style.opacity = '1';

    // when old active finished fading, remove it
    if (activeNode) {
      activeNode.addEventListener('transitionend', function onEnd(e) {
        if (e.propertyName === 'opacity') {
          activeNode.removeEventListener('transitionend', onEnd);
          if (activeNode.parentNode) activeNode.parentNode.removeChild(activeNode);
          activeNode = newActive;
        }
      });
    } else {
      activeNode = newActive;
    }

    // update preview node to the next image after safeIndex
    const previewIndex = (safeIndex + 1) % reviewsData.length;
    if (previewNode) {
      const img = previewNode.querySelector('img');
      if (img) {
        let webPath = reviewsData[previewIndex].photo_path;
        const idx = webPath ? webPath.indexOf('uploads/review_photos/') : -1;
        if (idx !== -1) {
          webPath = webPath.substring(idx);
        }
        img.src = webPath ? '../../' + webPath.replace(/^\/+/, '') : '../assets/img/1.1.png';
      }
    } else {
      previewNode = createImageNode(reviewsData[previewIndex].photo_path, 'next');
      if (activeNode && activeNode.parentNode) activeNode.parentNode.insertBefore(previewNode, activeNode);
      else reviewImgDiv.appendChild(previewNode);
    }

    // update text and dots
    if (reviewTextDiv) reviewTextDiv.textContent = reviewsData[safeIndex].review || '';
    if (reviewerNameDiv) reviewerNameDiv.textContent = reviewsData[safeIndex].customer_name || 'Customer';
    if (dots) dots.forEach((dot, i) => dot.classList.toggle('active', i === safeIndex));

    currentReview = safeIndex;
  }

  // Compatibility wrapper: call the animated transition so any older code using
  // updateReview(...) will get the smooth animation.
  function updateReview(index) {
    animateTo(index);
  }

  // Dot click event
  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      // stop autoplay while user interacts, then resume after a short idle
      if (typeof stopAuto === 'function') stopAuto();
      animateTo(i);
      if (typeof scheduleAutoResume === 'function') scheduleAutoResume(6000);
    });
  });

  // Optional: swipe/arrow support for mobile/keyboard
  let startX = null;
  reviewImgDiv.addEventListener('touchstart', (e) => {
    // user started touch interaction - pause autoplay
    stopAuto();
    startX = e.touches[0].clientX;
  });
  reviewImgDiv.addEventListener('touchend', (e) => {
    if (startX === null) return;
    let endX = e.changedTouches[0].clientX;
    if (!reviewsData.length) return;
    if (endX - startX > 50) {
      // swipe right -> previous
      const newIndex = (currentReview - 1 + reviewsData.length) % reviewsData.length;
      updateReview(newIndex);
    } else if (startX - endX > 50) {
      // swipe left -> next
      const newIndex = (currentReview + 1) % reviewsData.length;
      updateReview(newIndex);
    }
    // restart autoplay after touch interaction
    scheduleAutoResume(6000);
    startX = null;
  });


  // Fetch reviews from backend
  fetch('../php/get_latest_reviews.php')
    .then(res => res.json())
    .then(data => {
      if (data && data.reviews && data.reviews.length) {
        reviewsData = data.reviews;
        initReviewNodes(0);
        if (reviewTextDiv) reviewTextDiv.textContent = reviewsData[0].review || '';
        if (reviewerNameDiv) reviewerNameDiv.textContent = reviewsData[0].customer_name || 'Customer';
        if (dots && dots[0]) dots[0].classList.add('active');
      }
    });

  // --- Autoplay: automatically advance reviews every N ms ------------------
  let autoReviewInterval = null;
  let autoResumeTimeout = null;


  function nextReview() {
    if (!reviewsData.length) return;
    const nextIndex = (currentReview + 1) % reviewsData.length;
    updateReview(nextIndex);
  }

  function startAuto() {
    if (!reviewsData.length) return;
    if (autoReviewInterval) return; // already running
    autoReviewInterval = setInterval(nextReview, 5000);
  }

  function stopAuto() {
    if (autoReviewInterval) {
      clearInterval(autoReviewInterval);
      autoReviewInterval = null;
    }
    if (autoResumeTimeout) {
      clearTimeout(autoResumeTimeout);
      autoResumeTimeout = null;
    }
  }

  function scheduleAutoResume(delayMs) {
    if (autoResumeTimeout) clearTimeout(autoResumeTimeout);
    autoResumeTimeout = setTimeout(() => {
      startAuto();
      autoResumeTimeout = null;
    }, delayMs);
  }
  const review = document.querySelector('.reviews');
  // pause on hover, resume on leave
  reviewImgDiv.addEventListener('mouseenter', stopAuto);
  reviewImgDiv.addEventListener('mouseleave', () => scheduleAutoResume(3000));
  review.addEventListener('mouseenter', stopAuto);
  review.addEventListener('mouseleave', () => scheduleAutoResume(3000));
  // start autoplay
  startAuto();


  const video = document.getElementById('storyVideo');
  if (video) {
    video.muted = true; // Mute video sound
  }
  const videoBtn = document.querySelector('.video-btn');
  const playIcon = videoBtn.querySelector('svg');
  const pauseBtn = videoBtn.querySelector('.pause-btn');

  if (video && videoBtn) {
    // Initially hide pause button
    pauseBtn.style.display = 'none';

    videoBtn.addEventListener('click', function () {
      if (video.paused) {
        video.play();
        playIcon.style.display = 'none';
        pauseBtn.style.display = 'block';
        // pause review autoplay while video plays
        stopAuto();
      } else {
        video.pause();
        playIcon.style.display = 'block';
        pauseBtn.style.display = 'none';
        // resume reviews after video paused
        scheduleAutoResume(3000);
      }
    });

    // Show play button when video ends
    video.addEventListener('ended', function () {
      video.currentTime = 0;
      playIcon.style.display = 'block';
      pauseBtn.style.display = 'none';
      // resume reviews after video ends
      scheduleAutoResume(1000);
    });

    // Update button state on pause/play
    video.addEventListener('pause', function () {
      playIcon.style.display = 'block';
      pauseBtn.style.display = 'none';
      // resume reviews shortly after pause
      scheduleAutoResume(2000);
    });

    video.addEventListener('play', function () {
      playIcon.style.display = 'none';
      pauseBtn.style.display = 'block';
      // stop reviews while playing
      stopAuto();
    });
  }

});