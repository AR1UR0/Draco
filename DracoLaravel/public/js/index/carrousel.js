/**
 * @fileoverview JavaScript for the image carousel on the main page.
 * @author Arturo/Draco Team
 * @version 1.1.0
 */

/**
 * Initializes the carousel behavior when the page is ready.
 */
document.addEventListener("DOMContentLoaded", () => {
    /**
     * Container element (track) that groups carousel items.
     * @type {HTMLElement|null}
     */
    const track = document.getElementById("carouselTrack");

    /**
     * Flag to avoid re-entrancy: prevents starting another animation while
     * the current one is not finished.
     * @type {boolean}
     */
    let isMoving = false;

    /**
     * Calculates the width in pixels of a carousel element including
     * the left and right margins calculated by CSS.
     *
     * @returns {number} Total width of the item in pixels (offsetWidth + margin).
     */
    function getItemWidth() {
        if (!track || !track.children.length) return 0;

        const item = track.children[0];
        const style = getComputedStyle(item);
        const margin =
            parseFloat(style.marginLeft) + parseFloat(style.marginRight);

        return item.offsetWidth + margin;
    }

    /**
     * Moves the carousel one position to the left.
     *
     * The flow is as follows:
     * 1. If already moving (`isMoving`), exit to avoid collisions.
     * 2. Calculate the width of the first element.
     * 3. Apply a CSS transition to slide the track to the left
     *    by the item width.
     * 4. After the animation finishes, disable the transition, move the
     *    first element to the end of the track and reset the transform.
     *
     * Side effects: modifies the DOM (reorders track children) and
     * inline styles (`transition`, `transform`).
     *
     * @returns {void}
     */
    function moveCarousel() {
        if (!track) return;
        if (isMoving) return;
        isMoving = true;

        const itemWidth = getItemWidth();

        // Animate the track to slide the first item to the left
        track.style.transition = "transform 0.5s ease";
        track.style.transform = `translateX(-${itemWidth}px)`;

        // When the animation finishes, we reorder the elements and reset
        setTimeout(() => {
            track.style.transition = "none";
            // Move the first child to the end to create a loop effect
            track.appendChild(track.firstElementChild);
            // Reset the transformation to leave the track in place
            track.style.transform = "translateX(0)";
            isMoving = false;
        }, 500);
    }

    // Start the automatic cycle every 3 seconds (3000 ms).
    setInterval(moveCarousel, 3000);
});

document.addEventListener("DOMContentLoaded", function () {
    var popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]'),
    );

    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            // THIS IS THE KEY: The container is the direct parent
            container: popoverTriggerEl.parentElement,
            trigger: "click",
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".popoverTema").forEach((el) => {
        const pop = new bootstrap.Popover(el, {
            content: "PRÓXIMAMENTE",
            placement: "top",
            trigger: "manual",
            animation: false,
        });

        el.addEventListener("click", () => {
            // Hides any other open popover
            document.querySelectorAll(".popoverTema").forEach((other) => {
                if (other !== el) {
                    bootstrap.Popover.getInstance(other)?.hide();
                }
            });

            pop.show();

            // Closes itself after 1 second
            setTimeout(() => pop.hide(), 1000);
        });
    });

    // Click outside = close everything
    document.addEventListener("click", (e) => {
        if (!e.target.closest(".popoverTema")) {
            document.querySelectorAll(".popoverTema").forEach((el) => {
                bootstrap.Popover.getInstance(el)?.hide();
            });
        }
    });
});
