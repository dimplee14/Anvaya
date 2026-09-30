document.addEventListener('DOMContentLoaded', function () {
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
      let webPath = photoPath;
      const idx = photoPath.indexOf('uploads/review_photos/');
      if (idx !== -1) {
        webPath = photoPath.substring(idx);
      }
      img.src = '../../' + webPath.replace(/^\/+/, '');
    } else {
      img.src = '../assets/img/1.1.png';
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
    newActive.offsetWidth;
    newActive.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    if (activeNode) {
      activeNode.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      activeNode.style.opacity = '0';
      activeNode.style.transform = 'scale(0.98) translateX(-10px)';
    }
    newActive.style.opacity = '1';
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
    if (reviewTextDiv) reviewTextDiv.textContent = reviewsData[safeIndex].review || '';
    if (reviewerNameDiv) reviewerNameDiv.textContent = reviewsData[safeIndex].customer_name || 'Customer';
    if (dots) dots.forEach((dot, i) => dot.classList.toggle('active', i === safeIndex));
    currentReview = safeIndex;
  }

  function updateReview(index) {
    animateTo(index);
  }

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      if (typeof stopAuto === 'function') stopAuto();
      animateTo(i);
      if (typeof scheduleAutoResume === 'function') scheduleAutoResume(6000);
    });
  });

  let startX = null;
  reviewImgDiv.addEventListener('touchstart', (e) => {
    stopAuto();
    startX = e.touches[0].clientX;
  });
  reviewImgDiv.addEventListener('touchend', (e) => {
    if (startX === null) return;
    let endX = e.changedTouches[0].clientX;
    if (!reviewsData.length) return;
    if (endX - startX > 50) {
      const newIndex = (currentReview - 1 + reviewsData.length) % reviewsData.length;
      updateReview(newIndex);
    } else if (startX - endX > 50) {
      const newIndex = (currentReview + 1) % reviewsData.length;
      updateReview(newIndex);
    }
    scheduleAutoResume(6000);
    startX = null;
  });

  // Fetch reviews from backend (use story-specific endpoint)
  fetch('../php/get_story_reviews.php')
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

  let autoReviewInterval = null;
  let autoResumeTimeout = null;

  function nextReview() {
    if (!reviewsData.length) return;
    const nextIndex = (currentReview + 1) % reviewsData.length;
    updateReview(nextIndex);
  }

  function startAuto() {
    if (!reviewsData.length) return;
    if (autoReviewInterval) return;
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
  reviewImgDiv.addEventListener('mouseenter', stopAuto);
  reviewImgDiv.addEventListener('mouseleave', () => scheduleAutoResume(3000));
  review.addEventListener('mouseenter', stopAuto);
  review.addEventListener('mouseleave', () => scheduleAutoResume(3000));
  startAuto();
});