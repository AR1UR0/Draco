(function () {
    const COOKIE_NAME = "site_lang"; // usa la cookie que ya tienes
    const DEFAULT_LANG = "en";

    // ===== Cookie helper =====
    function getCookie(name) {
        const cname = name + "=";
        const decoded = decodeURIComponent(document.cookie);
        const ca = decoded.split(";");
        for (let c of ca) {
            c = c.trim();
            if (c.indexOf(cname) === 0) return c.substring(cname.length);
        }
        return null;
    }

    let lang = getCookie(COOKIE_NAME) || DEFAULT_LANG;

    // ===== Google Translate init =====
    window.googleTranslateElementInit = function () {
        new google.translate.TranslateElement(
            {
                pageLanguage: "es",
                autoDisplay: false,
            },
            "gt",
        );

        const interval = setInterval(() => {
            const select = document.querySelector(".goog-te-combo");
            if (select) {
                select.value = lang;
                select.dispatchEvent(new Event("change"));
                clearInterval(interval);
            }
        }, 100);
    };

    // ===== Load Google script =====
    const s = document.createElement("script");
    s.src =
        "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
    document.head.appendChild(s);
})();
