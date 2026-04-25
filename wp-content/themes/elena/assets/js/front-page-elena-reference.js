(function () {
    function initHeroSlider() {
        var wrapper = document.querySelector(".elena-home-hero");
        if (!wrapper) {
            return;
        }

        var slides = wrapper.querySelectorAll(".elena-home-slide");
        if (!slides.length) {
            return;
        }

        var prev = wrapper.querySelector(".elena-home-hero-arrow.is-prev");
        var next = wrapper.querySelector(".elena-home-hero-arrow.is-next");
        var current = 0;
        var timer = null;

        function show(index) {
            slides.forEach(function (slide) {
                slide.classList.remove("is-active");
            });
            current = (index + slides.length) % slides.length;
            slides[current].classList.add("is-active");
        }

        function play() {
            if (slides.length < 2) {
                return;
            }
            timer = setInterval(function () {
                show(current + 1);
            }, 4500);
        }

        function reset() {
            if (timer) {
                clearInterval(timer);
            }
            play();
        }

        if (prev) {
            prev.addEventListener("click", function () {
                show(current - 1);
                reset();
            });
        }
        if (next) {
            next.addEventListener("click", function () {
                show(current + 1);
                reset();
            });
        }

        play();
    }

    function initShowcaseTabs() {
        var sections = document.querySelectorAll(".elena-home-showcase");
        if (!sections.length) {
            return;
        }

        sections.forEach(function (section) {
            var tabs = section.querySelectorAll(".elena-home-tabs li");
            var cards = section.querySelectorAll(".elena-home-product-card");
            if (!tabs.length || !cards.length) {
                return;
            }

            var maxVisible = 6;

            function applyFilter(initial) {
                var activeTab = section.querySelector(".elena-home-tabs li.is-active") || tabs[0];
                var filter = activeTab ? activeTab.getAttribute("data-filter") : "all";
                var visibleCount = 0;
                cards.forEach(function (card) {
                    var matches = !filter || filter === "all" || card.classList.contains(filter);
                    if (matches && visibleCount < maxVisible) {
                        card.style.display = "";
                        visibleCount++;
                    } else {
                        card.style.display = "none";
                    }
                });
            }

            tabs.forEach(function (tab) {
                tab.addEventListener("click", function () {
                    tabs.forEach(function (item) {
                        item.classList.remove("is-active");
                    });
                    tab.classList.add("is-active");
                    applyFilter();
                });
            });

            applyFilter(true);
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        initHeroSlider();
        initShowcaseTabs();
    });
})();
