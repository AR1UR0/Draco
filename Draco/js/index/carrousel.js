document.addEventListener("DOMContentLoaded", () => {
    const track = document.getElementById("carouselTrack");
    let isMoving = false;

    function getItemWidth() {
        const item = track.children[0];
        const style = getComputedStyle(item);
        const margin =
            parseFloat(style.marginLeft) + parseFloat(style.marginRight);

        return item.offsetWidth + margin;
    }

    function moveCarousel() {
        if (isMoving) return;
        isMoving = true;

        const itemWidth = getItemWidth();

        track.style.transition = "transform 0.5s ease";
        track.style.transform = `translateX(-${itemWidth}px)`;

        setTimeout(() => {
            track.style.transition = "none";
            track.appendChild(track.firstElementChild);
            track.style.transform = "translateX(0)";
            isMoving = false;
        }, 500);
    }

    setInterval(moveCarousel, 3000);
});
