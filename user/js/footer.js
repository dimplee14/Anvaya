// js/main/back-to-top.js
document.addEventListener("DOMContentLoaded", function() {
  const btn = document.getElementById("backToTopBtn");

  // only attach listener if the button exists on the page
  if (btn) {
    btn.addEventListener("click", function() {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }
});