var swiper = new Swiper(".review-slider", {
    spaceBetween: 20,
    loop: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false
    },
    breakpoints: {
        640: {
            slidesPerView: 1
        },
        768: {
            slidesPerView: 2
        },
        1024: {
            slidesPerView: 3
        }
    }
});
document.querySelectorAll(".video-card").forEach(card => {
    let video = card.querySelector("video");
    let overlay = card.querySelector(".video-overlay");

    card.addEventListener("click", () => {
        if(video.paused){
            video.play();
            overlay.style.opacity = "0";
        } else {
            video.pause();
            overlay.style.opacity = "1";
        }
    });

    video.addEventListener("ended", () => {
        overlay.style.opacity = "1";
    });
});
