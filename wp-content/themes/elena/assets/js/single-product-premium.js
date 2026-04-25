(function () {
    function syncMainImage(mainSrc, fullSrc) {
        var mainImage = document.querySelector(".elena-sp-main-img");
        var mainLink = document.querySelector(".elena-sp-main-link");
        if (!mainImage || !mainSrc) {
            return;
        }

        mainImage.setAttribute("src", mainSrc);
        if (mainLink && fullSrc) {
            mainLink.setAttribute("href", fullSrc);
        }
    }

    function bindImageButtons(selector) {
        var buttons = document.querySelectorAll(selector);
        if (!buttons.length) {
            return;
        }

        buttons.forEach(function (button) {
            button.addEventListener("click", function () {
                var mainSrc = button.getAttribute("data-main-src");
                var fullSrc = button.getAttribute("data-full-src");

                syncMainImage(mainSrc, fullSrc);

                buttons.forEach(function (btn) {
                    btn.classList.remove("is-active");
                });
                button.classList.add("is-active");
            });
        });
    }

    function buildSizeButtons() {
        var selectWrappers = document.querySelectorAll(".variations_form .value");

        selectWrappers.forEach(function (wrapper) {
            var select = wrapper.querySelector("select");
            if (!select || wrapper.querySelector(".elena-size-buttons")) {
                return;
            }

            var labelCell = wrapper.closest("tr") ? wrapper.closest("tr").querySelector("th.label label") : null;
            var labelText = labelCell ? labelCell.textContent.toLowerCase() : "";
            if (labelText && labelText.indexOf("size") === -1 && labelText.indexOf("pointure") === -1) {
                return;
            }

            var options = Array.from(select.options).filter(function (option) {
                return option.value;
            });
            if (!options.length) {
                return;
            }

            var buttonRow = document.createElement("div");
            buttonRow.className = "elena-size-buttons";

            options.forEach(function (option) {
                var button = document.createElement("button");
                button.type = "button";
                button.className = "elena-size-btn";
                button.textContent = option.text;
                button.dataset.value = option.value;

                if (select.value === option.value) {
                    button.classList.add("is-active");
                }

                button.addEventListener("click", function () {
                    select.value = option.value;
                    select.dispatchEvent(new Event("change", { bubbles: true }));

                    buttonRow.querySelectorAll(".elena-size-btn").forEach(function (btn) {
                        btn.classList.remove("is-active");
                    });
                    button.classList.add("is-active");
                });

                buttonRow.appendChild(button);
            });

            select.style.display = "none";
            wrapper.insertBefore(buttonRow, select.nextSibling);
        });
    }

    function bindSimpleSizeButtons() {
        var buttons = document.querySelectorAll(".elena-size-btn-simple");
        if (!buttons.length) {
            return;
        }

        var form = document.querySelector("form.cart");
        if (!form) {
            return;
        }

        var hidden = form.querySelector('input[name="elena_size"]');
        if (!hidden) {
            hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = "elena_size";
            hidden.value = "";
            form.appendChild(hidden);
        }

        var picker = document.querySelector(".elena-sp-size-picker");

        buttons.forEach(function (button) {
            button.addEventListener("click", function () {
                var value = button.dataset.value || "";
                hidden.value = value;

                buttons.forEach(function (btn) {
                    btn.classList.remove("is-active");
                    btn.setAttribute("aria-checked", "false");
                });
                button.classList.add("is-active");
                button.setAttribute("aria-checked", "true");

                if (picker) {
                    picker.classList.remove("elena-size-missing");
                }
            });
        });

        form.addEventListener("submit", function (event) {
            if (!hidden.value) {
                event.preventDefault();
                if (picker) {
                    picker.classList.add("elena-size-missing");
                    picker.scrollIntoView({ behavior: "smooth", block: "center" });
                }
            }
        });
    }

    function initSingleProductPremium() {
        bindImageButtons(".elena-sp-thumb");
        bindImageButtons(".elena-sp-color-swatch");
        buildSizeButtons();
        bindSimpleSizeButtons();
    }

    document.addEventListener("DOMContentLoaded", initSingleProductPremium);
    document.addEventListener("woocommerce_variation_has_changed", buildSizeButtons);
})();
