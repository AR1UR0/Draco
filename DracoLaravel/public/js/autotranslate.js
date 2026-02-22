/**
 * @fileoverview JavaScript for automatic language translation using Google Translate API.
 * Manages language preferences through cookies and initializes the translation interface.
 * @author Arturo/Draco Team
 * @version 1.0.0
 */

/**
 * Immediately Invoked Function Expression (IIFE) that encapsulates the translation
 * initialization logic in its own scope to avoid global namespace pollution.
 */
(function () {
    /**
     * Cookie name for storing the user's language preference.
     * @type {string}
     */
    const COOKIE_NAME = "site_lang";

    /**
     * Default language when no language preference cookie is found.
     * @type {string}
     */
    const DEFAULT_LANG = "en";

    /**
     * Retrieves the value of a cookie by its name.
     *
     * The flow is as follows:
     * 1. Construct the cookie name with "=" appended.
     * 2. Decode all cookies to handle special characters.
     * 3. Split the decoded cookies and iterate through them.
     * 4. If a cookie name matches, extract and return its value.
     * 5. Return null if no matching cookie is found.
     *
     * Side effects: none (pure function).
     *
     * @param {string} name - The name of the cookie to retrieve.
     * @returns {string|null} The cookie value or null if not found.
     */
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

    /**
     * Gets the user's language preference from the cookie or defaults to English.
     * @type {string}
     */
    let lang = getCookie(COOKIE_NAME) || DEFAULT_LANG;

    /**
     * Initializes the Google Translate Element.
     *
     * The flow is as follows:
     * 1. Create a new TranslateElement with Spanish as the page language.
     * 2. Attach it to the "gt" container element.
     * 3. Poll for the language selector dropdown until it appears.
     * 4. Set the dropdown value to the stored user language preference.
     * 5. Trigger a change event to apply the translation.
     * 6. Clear the polling interval once the selector is found and configured.
     *
     * Side effects: modifies the DOM (creates translate UI) and triggers
     * language translation.
     *
     * @returns {void}
     */
    window.googleTranslateElementInit = function () {
        new google.translate.TranslateElement(
            {
                pageLanguage: "es",
                autoDisplay: false,
            },
            "gt",
        );

        // Poll for the language selector dropdown until it appears
        const interval = setInterval(() => {
            const select = document.querySelector(".goog-te-combo");
            if (select) {
                // Set the language selector to the user's preferred language
                select.value = lang;
                // Trigger change event to apply the translation
                select.dispatchEvent(new Event("change"));
                // Stop polling once the selector is found and configured
                clearInterval(interval);
            }
        }, 100);
    };

    /**
     * Dynamically loads the Google Translate API script.
     *
     * The script callback is set to `googleTranslateElementInit`,
     * which will be executed once the script is loaded.
     */
    const s = document.createElement("script");
    s.src =
        "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
    document.head.appendChild(s);
})();
