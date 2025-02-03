let currentIndex = 0;

function moveSlide(direction) {
  const images = document.querySelectorAll(".carousel-image");
  const totalImages = images.length;

  currentIndex += direction;

  if (currentIndex < 0) {
    currentIndex = totalImages - 1; // Loop back to last image
  } else if (currentIndex >= totalImages) {
    currentIndex = 0; // Loop back to first image
  }

  updateCarouselPosition();
}

function updateCarouselPosition() {
  const carousel = document.querySelector(".carousel-images");
  const imageWidth = document.querySelector(".carousel-image").offsetWidth;
  carousel.style.transform = `translateX(${-currentIndex * imageWidth}px)`; // Move carousel based on index
}

// Optionally, set the carousel to auto slide every 2 seconds
setInterval(() => moveSlide(1), 2000);
