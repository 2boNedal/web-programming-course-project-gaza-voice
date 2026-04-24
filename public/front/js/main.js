
(function ($) {
    "use strict";

    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 90) {
            $('.header').addClass('header-sticky');
            $('.top-header').addClass('header-hidden');
        } else {
            $('.header').removeClass('header-sticky');
            $('.top-header').removeClass('header-hidden');
        }
    });


    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 768) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Category News Slider
    $('.cn-slider').slick({
        autoplay: false,
        infinite: true,
        dots: false,
        slidesToShow: 2,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    // Latest News Ticker Rotation
    var latestNewsHeadlines = [
        'تطورات جديدة في السياسة الإقليمية: توقعات حول المستجدات القادمة',
        'الأسواق العالمية تشهد تقلبات كبيرة مع اقتراب آخر أعمال السنة المالية',
        'قطاع الصحة يحذر من موجة جديدة وينصح بالالتزام بالإجراءات الوقائية',
        'مؤتمر دولي يبحث سبل تحقيق السلام والاستقرار في منطقة الشرق الأوسط',
        'انطلاق فعاليات ثقافية كبرى تجمع الفنانين والمثقفين من العالم العربي'
    ];
    var headlineIndex = 0;

    function rotateLatestNews() {
        $('.ticker-headline').fadeOut(300, function() {
            $(this).text(latestNewsHeadlines[headlineIndex]).fadeIn(300);
        });
        headlineIndex = (headlineIndex + 1) % latestNewsHeadlines.length;
    }

    // Rotate news every 6 seconds
    setInterval(rotateLatestNews, 6000);

document.addEventListener("DOMContentLoaded", function () {
    const weatherData = {
        gaza: {
            name: "غزة",
            today: { temp: "28°", status: "مشمس" },
            tomorrow: { temp: "25°", status: "غائم جزئيًا" },
            after: { temp: "23°", status: "أمطار خفيفة" }
        },
        jerusalem: {
            name: "القدس",
            today: { temp: "22°", status: "غائم" },
            tomorrow: { temp: "20°", status: "مشمس" },
            after: { temp: "19°", status: "بارد" }
        },
        ramallah: {
            name: "رام الله",
            today: { temp: "21°", status: "غائم جزئيًا" },
            tomorrow: { temp: "19°", status: "أمطار خفيفة" },
            after: { temp: "18°", status: "بارد" }
        },
        bethlehem: {
            name: "بيت لحم",
            today: { temp: "20°", status: "مشمس" },
            tomorrow: { temp: "18°", status: "غائم" },
            after: { temp: "17°", status: "ممطر" }
        },
        hebron: {
            name: "الخليل",
            today: { temp: "19°", status: "بارد" },
            tomorrow: { temp: "18°", status: "غائم" },
            after: { temp: "16°", status: "ممطر" }
        },
        jenin: {
            name: "جنين",
            today: { temp: "24°", status: "مشمس" },
            tomorrow: { temp: "22°", status: "غائم جزئيًا" },
            after: { temp: "20°", status: "أمطار خفيفة" }
        },
        nablus: {
            name: "نابلس",
            today: { temp: "23°", status: "مشمس" },
            tomorrow: { temp: "21°", status: "غائم" },
            after: { temp: "19°", status: "بارد" }
        }
    };

    const currencyData = {
        usd: { name: "الدولار الأمريكي", buy: "3.62", sell: "3.66" },
        eur: { name: "اليورو", buy: "3.95", sell: "4.01" },
        gbp: { name: "الجنيه الإسترليني", buy: "4.58", sell: "4.66" },
        jod: { name: "الدينار الأردني", buy: "5.08", sell: "5.14" },
        egp: { name: "الجنيه المصري", buy: "0.11", sell: "0.13" }
    };

    const weatherTrigger = document.getElementById("weatherTrigger");
    const weatherDropdown = document.getElementById("weatherDropdown");
    const weatherLocation = document.getElementById("weatherLocation");

    const currencyTrigger = document.getElementById("currencyTrigger");
    const currencyDropdown = document.getElementById("currencyDropdown");
    const currencyCode = document.getElementById("currencyCode");

    function updateWeather(locationKey) {
        const item = weatherData[locationKey];
        weatherLocation.textContent = item.name;
        document.getElementById("weatherTodayTemp").textContent = item.today.temp;
        document.getElementById("weatherTodayStatus").textContent = item.today.status;
        document.getElementById("weatherTomorrowTemp").textContent = item.tomorrow.temp;
        document.getElementById("weatherTomorrowStatus").textContent = item.tomorrow.status;
        document.getElementById("weatherAfterTemp").textContent = item.after.temp;
        document.getElementById("weatherAfterStatus").textContent = item.after.status;
    }

    function updateCurrency(currencyKey) {
        const item = currencyData[currencyKey];
        currencyCode.textContent = item.name;
        document.getElementById("buyRate").textContent = item.buy;
        document.getElementById("sellRate").textContent = item.sell;
    }

    if (weatherTrigger && weatherDropdown && currencyDropdown) {
        weatherTrigger.addEventListener("click", function (e) {
            e.stopPropagation();
            weatherDropdown.style.display = weatherDropdown.style.display === "block" ? "none" : "block";
            currencyDropdown.style.display = "none";
        });
    }

    if (currencyTrigger && currencyDropdown && weatherDropdown) {
        currencyTrigger.addEventListener("click", function (e) {
            e.stopPropagation();
            currencyDropdown.style.display = currencyDropdown.style.display === "block" ? "none" : "block";
            weatherDropdown.style.display = "none";
        });
    }

    document.querySelectorAll("#weatherDropdown li").forEach(item => {
        item.addEventListener("click", function () {
            updateWeather(this.dataset.location);
            if (weatherDropdown) {
                weatherDropdown.style.display = "none";
            }
        });
    });

    document.querySelectorAll("#currencyDropdown li").forEach(item => {
        item.addEventListener("click", function () {
            updateCurrency(this.dataset.currency);
            if (currencyDropdown) {
                currencyDropdown.style.display = "none";
            }
        });
    });

    document.addEventListener("click", function (event) {
        if (weatherDropdown) {
            weatherDropdown.style.display = "none";
        }
        if (currencyDropdown) {
            currencyDropdown.style.display = "none";
        }
        const searchPanel = document.getElementById('navSearchPanel');
        if (searchPanel && !searchPanel.contains(event.target)) {
            searchPanel.classList.remove('open');
        }
    });

    let selectedTags = [];
    const searchPanel = document.getElementById('navSearchPanel');
    const searchToggle = document.getElementById('navSearchToggle');
    const searchPanelClose = document.getElementById('searchPanelClose');
    const searchInput = document.getElementById('searchTagInput');
    const suggestionsBox = document.getElementById('tagSuggestions');
    const selectedTagsContainer = document.getElementById('selectedSearchTags');
    const suggestionCache = [];

    function normalizeTag(text) {
        return text.trim().toLowerCase();
    }

    function updateSelectedTagButtons() {
        document.querySelectorAll('.tag-chip').forEach(button => {
            const tag = button.dataset.tag;
            if (selectedTags.includes(tag)) {
                button.classList.add('selected');
            } else {
                button.classList.remove('selected');
            }
        });
    }

    function renderSelectedTags() {
        if (!selectedTagsContainer) return;
        selectedTagsContainer.innerHTML = selectedTags.map(tag => {
            return `<span class="tag-chip selected-tag" data-tag="${tag}">${tag}<i class="fas fa-times"></i></span>`;
        }).join('');
    }

    function renderSuggestions(filter) {
        if (!suggestionsBox) return;
        const query = (filter || '').trim().toLowerCase();

        if (!query) {
            suggestionsBox.innerHTML = '';
            return;
        }

        fetch('/tags/suggest?q=' + encodeURIComponent(filter || ''))
            .then(response => response.json())
            .then(items => {
                suggestionCache.length = 0;
                items.forEach(item => suggestionCache.push(item));

                const matches = items
                    .map(item => item.name)
                    .filter(name => !selectedTags.includes(name));

                if (matches.length === 0) {
                    suggestionsBox.innerHTML = '<div class="suggestion-empty">لا توجد وسوم مطابقة</div>';
                    return;
                }

                suggestionsBox.innerHTML = matches
                    .slice(0, 6)
                    .map(tag => `<button type="button" class="suggestion-item" data-tag="${tag}">${tag}</button>`)
                    .join('');
            })
            .catch(() => {
                suggestionsBox.innerHTML = '<div class="suggestion-empty">تعذر تحميل الاقتراحات</div>';
            });
    }

    function addTag(tag) {
        if (!tag || selectedTags.includes(tag)) return;
        selectedTags.push(tag);
        renderSelectedTags();
        updateSelectedTagButtons();
        renderSuggestions(searchInput ? searchInput.value : '');
    }

    function removeTag(tag) {
        selectedTags = selectedTags.filter(existing => existing !== tag);
        renderSelectedTags();
        updateSelectedTagButtons();
        renderSuggestions(searchInput ? searchInput.value : '');
    }

    function openSearchPanel() {
        if (!searchPanel) return;
        searchPanel.classList.add('open');
        if (searchInput) {
            searchInput.focus();
            renderSuggestions('');
        }
    }

    function closeSearchPanel() {
        if (!searchPanel) return;
        searchPanel.classList.remove('open');
    }

    function navigateToSearchResults() {
        if (selectedTags.length === 0) {
            return;
        }
        const encoded = selectedTags.map(tag => encodeURIComponent(tag)).join('|');
        window.location.href = '/search?tags=' + encoded;
    }

    if (searchToggle) {
        searchToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (searchPanel) {
                searchPanel.classList.toggle('open');
                if (searchPanel.classList.contains('open') && searchInput) {
                    searchInput.focus();
                    renderSuggestions('');
                }
            }
        });
    }

    if (searchPanelClose) {
        searchPanelClose.addEventListener('click', function () {
            closeSearchPanel();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            renderSuggestions(this.value);
        });

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const value = this.value.trim();
                if (value) {
                    const matched = suggestionCache.find(item => normalizeTag(item.name) === normalizeTag(value));
                    if (matched) {
                        addTag(matched.name);
                        this.value = '';
                    }
                }
                if (selectedTags.length > 0) {
                    navigateToSearchResults();
                }
            }
        });
    }

    const searchInputIcon = document.getElementById('searchInputIcon');
    if (searchInputIcon) {
        searchInputIcon.addEventListener('click', function () {
            const input = document.getElementById('searchTagInput');
            if (input) {
                const value = input.value.trim();
                if (value) {
                    const matched = suggestionCache.find(item => normalizeTag(item.name) === normalizeTag(value));
                    if (matched) {
                        addTag(matched.name);
                        input.value = '';
                    }
                }
                if (selectedTags.length > 0) {
                    navigateToSearchResults();
                }
            }
        });
    }

    document.addEventListener('click', function (event) {
        if (suggestionsBox && !suggestionsBox.contains(event.target) && searchInput !== event.target) {
            suggestionsBox.innerHTML = '';
        }
    });

    document.addEventListener('click', function (event) {
        const target = event.target;
        if (target.classList.contains('tag-chip') && target.dataset.tag && !target.classList.contains('selected-tag')) {
            addTag(target.dataset.tag);
        }

        if (target.classList.contains('suggestion-item') && target.dataset.tag) {
            addTag(target.dataset.tag);
            if (searchInput) {
                searchInput.value = '';
            }
            renderSuggestions('');
        }

        if (target.closest('.selected-tag') && target.closest('.selected-tag').dataset.tag) {
            removeTag(target.closest('.selected-tag').dataset.tag);
        }
    });

    renderSelectedTags();
    updateSelectedTagButtons();
});

})(jQuery);

