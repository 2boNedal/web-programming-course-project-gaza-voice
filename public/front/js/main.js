
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
    const staticTickerHeadlines = [
        '\u062a\u0637\u0648\u0631\u0627\u062a \u062c\u062f\u064a\u062f\u0629 \u0641\u064a \u0627\u0644\u0633\u0627\u062d\u0629 \u0627\u0644\u0625\u0642\u0644\u064a\u0645\u064a\u0629 \u0648\u0633\u0637 \u0645\u062a\u0627\u0628\u0639\u0629 \u0645\u0633\u062a\u0645\u0631\u0629',
        '\u0627\u0644\u0623\u0633\u0648\u0627\u0642 \u0627\u0644\u0639\u0627\u0644\u0645\u064a\u0629 \u062a\u062a\u0631\u0642\u0628 \u0642\u0631\u0627\u0631\u0627\u062a \u0627\u0642\u062a\u0635\u0627\u062f\u064a\u0629 \u0645\u0624\u062b\u0631\u0629 \u062e\u0644\u0627\u0644 \u0627\u0644\u0633\u0627\u0639\u0627\u062a \u0627\u0644\u0645\u0642\u0628\u0644\u0629',
        '\u0627\u0644\u0642\u0637\u0627\u0639 \u0627\u0644\u0635\u062d\u064a \u064a\u062f\u0639\u0648 \u0625\u0644\u0649 \u0627\u0644\u0627\u0644\u062a\u0632\u0627\u0645 \u0628\u0627\u0644\u0625\u062c\u0631\u0627\u0621\u0627\u062a \u0627\u0644\u0648\u0642\u0627\u0626\u064a\u0629 \u0641\u064a \u0627\u0644\u0645\u0646\u0627\u0637\u0642 \u0627\u0644\u0645\u0632\u062f\u062d\u0645\u0629',
        '\u0645\u0628\u0627\u062d\u062b\u0627\u062a \u062f\u0648\u0644\u064a\u0629 \u062c\u062f\u064a\u062f\u0629 \u0644\u0628\u062d\u062b \u0633\u0628\u0644 \u0627\u0644\u062a\u0647\u062f\u0626\u0629 \u0648\u0627\u0644\u0627\u0633\u062a\u0642\u0631\u0627\u0631 \u0641\u064a \u0627\u0644\u0645\u0646\u0637\u0642\u0629',
        '\u0641\u0639\u0627\u0644\u064a\u0627\u062a \u062b\u0642\u0627\u0641\u064a\u0629 \u0639\u0631\u0628\u064a\u0629 \u062a\u062c\u0645\u0639 \u0643\u062a\u0651\u0627\u0628\u0627\u064b \u0648\u0641\u0646\u0627\u0646\u064a\u0646 \u0645\u0646 \u0639\u062f\u0629 \u062f\u0648\u0644'
    ];
    const $tickerHeadline = $('.ticker-headline');
    const bannerTickerItems = Array.isArray(window.breakingNewsItems)
        ? window.breakingNewsItems.filter(item => typeof item === 'string' && item.trim() !== '')
        : [];
    if ($tickerHeadline.length) {
        if (bannerTickerItems.length === 1) {
            $tickerHeadline.text(bannerTickerItems[0]);
        } else if (bannerTickerItems.length > 1) {
            let bannerTickerIndex = 0;
            setInterval(function () {
                bannerTickerIndex = (bannerTickerIndex + 1) % bannerTickerItems.length;
                $tickerHeadline.fadeOut(250, function () {
                    $(this).text(bannerTickerItems[bannerTickerIndex]).fadeIn(250);
                });
            }, 5000);
        } else if ($tickerHeadline.data('source') !== 'banners') {
            let headlineIndex = 0;
            setInterval(function () {
                headlineIndex = (headlineIndex + 1) % staticTickerHeadlines.length;
                $tickerHeadline.fadeOut(250, function () {
                    $(this).text(staticTickerHeadlines[headlineIndex]).fadeIn(250);
                });
            }, 6000);
        }
    }

document.addEventListener("DOMContentLoaded", function () {
        const weatherData = {
        gaza: {
            name: "\u063a\u0632\u0629",
            today: { temp: "28\u00B0", status: "\u0645\u0634\u0645\u0633" },
            tomorrow: { temp: "25\u00B0", status: "\u063a\u0627\u0626\u0645 \u062c\u0632\u0626\u064a\u0627\u064b" },
            after: { temp: "23\u00B0", status: "\u0623\u0645\u0637\u0627\u0631 \u062e\u0641\u064a\u0641\u0629" }
        },
        jerusalem: {
            name: "\u0627\u0644\u0642\u062f\u0633",
            today: { temp: "22\u00B0", status: "\u063a\u0627\u0626\u0645" },
            tomorrow: { temp: "20\u00B0", status: "\u0645\u0634\u0645\u0633" },
            after: { temp: "19\u00B0", status: "\u0628\u0627\u0631\u062f" }
        },
        ramallah: {
            name: "\u0631\u0627\u0645 \u0627\u0644\u0644\u0647",
            today: { temp: "21\u00B0", status: "\u063a\u0627\u0626\u0645 \u062c\u0632\u0626\u064a\u0627\u064b" },
            tomorrow: { temp: "19\u00B0", status: "\u0623\u0645\u0637\u0627\u0631 \u062e\u0641\u064a\u0641\u0629" },
            after: { temp: "18\u00B0", status: "\u0628\u0627\u0631\u062f" }
        },
        bethlehem: {
            name: "\u0628\u064a\u062a \u0644\u062d\u0645",
            today: { temp: "20\u00B0", status: "\u0645\u0634\u0645\u0633" },
            tomorrow: { temp: "18\u00B0", status: "\u063a\u0627\u0626\u0645" },
            after: { temp: "17\u00B0", status: "\u0645\u0645\u0637\u0631" }
        },
        hebron: {
            name: "\u0627\u0644\u062e\u0644\u064a\u0644",
            today: { temp: "19\u00B0", status: "\u0628\u0627\u0631\u062f" },
            tomorrow: { temp: "18\u00B0", status: "\u063a\u0627\u0626\u0645" },
            after: { temp: "16\u00B0", status: "\u0645\u0645\u0637\u0631" }
        },
        jenin: {
            name: "\u062c\u0646\u064a\u0646",
            today: { temp: "24\u00B0", status: "\u0645\u0634\u0645\u0633" },
            tomorrow: { temp: "22\u00B0", status: "\u063a\u0627\u0626\u0645 \u062c\u0632\u0626\u064a\u0627\u064b" },
            after: { temp: "20\u00B0", status: "\u0623\u0645\u0637\u0627\u0631 \u062e\u0641\u064a\u0641\u0629" }
        },
        nablus: {
            name: "\u0646\u0627\u0628\u0644\u0633",
            today: { temp: "23\u00B0", status: "\u0645\u0634\u0645\u0633" },
            tomorrow: { temp: "21\u00B0", status: "\u063a\u0627\u0626\u0645" },
            after: { temp: "19\u00B0", status: "\u0628\u0627\u0631\u062f" }
        }
    };
    const currencyData = {
        usd: { name: "\u0627\u0644\u062f\u0648\u0644\u0627\u0631 \u0627\u0644\u0623\u0645\u0631\u064a\u0643\u064a", buy: "3.62", sell: "3.66" },
        eur: { name: "\u0627\u0644\u064a\u0648\u0631\u0648", buy: "3.95", sell: "4.01" },
        gbp: { name: "\u0627\u0644\u062c\u0646\u064a\u0647 \u0627\u0644\u0625\u0633\u062a\u0631\u0644\u064a\u0646\u064a", buy: "4.58", sell: "4.66" },
        jod: { name: "\u0627\u0644\u062f\u064a\u0646\u0627\u0631 \u0627\u0644\u0623\u0631\u062f\u0646\u064a", buy: "5.08", sell: "5.14" },
        egp: { name: "\u0627\u0644\u062c\u0646\u064a\u0647 \u0627\u0644\u0645\u0635\u0631\u064a", buy: "0.11", sell: "0.13" }
    };    const weatherTrigger = document.getElementById("weatherTrigger");
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

    weatherTrigger.addEventListener("click", function (e) {
        e.stopPropagation();
        weatherDropdown.style.display = weatherDropdown.style.display === "block" ? "none" : "block";
        currencyDropdown.style.display = "none";
    });

    currencyTrigger.addEventListener("click", function (e) {
        e.stopPropagation();
        currencyDropdown.style.display = currencyDropdown.style.display === "block" ? "none" : "block";
        weatherDropdown.style.display = "none";
    });

    document.querySelectorAll("#weatherDropdown li").forEach(item => {
        item.addEventListener("click", function () {
            updateWeather(this.dataset.location);
            weatherDropdown.style.display = "none";
        });
    });

    document.querySelectorAll("#currencyDropdown li").forEach(item => {
        item.addEventListener("click", function () {
            updateCurrency(this.dataset.currency);
            currencyDropdown.style.display = "none";
        });
    });

    document.addEventListener("click", function (event) {
        weatherDropdown.style.display = "none";
        currencyDropdown.style.display = "none";
        const searchPanel = document.getElementById('navSearchPanel');
        if (searchPanel && !searchPanel.contains(event.target)) {
            searchPanel.classList.remove('open');
        }
    });

    const availableTags = Array.from(document.querySelectorAll('.tag-chip[data-tag]')).map(tag => ({
        id: tag.dataset.tagId || null,
        name: tag.dataset.tag
    }));

    let selectedTags = Array.isArray(window.initialSelectedTags) ? window.initialSelectedTags.slice() : [];
    let currentSuggestions = [];
    const searchPanel = document.getElementById('navSearchPanel');
    const searchToggle = document.getElementById('navSearchToggle');
    const searchPanelClose = document.getElementById('searchPanelClose');
    const searchInput = document.getElementById('searchTagInput');
    const suggestionsBox = document.getElementById('tagSuggestions');
    const selectedTagsContainer = document.getElementById('selectedSearchTags');
    const searchResultsActiveTags = document.getElementById('searchResultsActiveTags');

    function normalizeTag(text) {
        return text.trim().toLowerCase();
    }

    function tagNameExists(name) {
        return availableTags.some(tag => normalizeTag(tag.name) === normalizeTag(name));
    }

    function findTagByName(name) {
        return availableTags.find(tag => normalizeTag(tag.name) === normalizeTag(name)) || null;
    }

    function updateSelectedTagButtons() {
        document.querySelectorAll('.tag-chip').forEach(button => {
            const tag = button.dataset.tag;
            if (selectedTags.some(selectedTag => normalizeTag(selectedTag.name) === normalizeTag(tag))) {
                button.classList.add('selected');
            } else {
                button.classList.remove('selected');
            }
        });
    }

    function renderSelectedTags() {
        if (selectedTagsContainer) {
            selectedTagsContainer.innerHTML = selectedTags.map(tag => {
                return `<span class="tag-chip selected-tag" data-tag="${tag.name}">${tag.name}<i class="fas fa-times"></i></span>`;
            }).join('');
        }

        if (searchResultsActiveTags) {
            searchResultsActiveTags.innerHTML = selectedTags.map(tag => `<span class="tag-chip selected-tag">${tag.name}</span>`).join('');
        }
    }

    function renderSuggestions(filter) {
        if (!suggestionsBox) return;
        const query = (filter || '').trim();

        if (!query) {
            currentSuggestions = [];
            suggestionsBox.innerHTML = '';
            return;
        }

        fetch('/tags/suggest?q=' + encodeURIComponent(query))
            .then(response => response.ok ? response.json() : [])
            .then(matches => {
                currentSuggestions = Array.isArray(matches) ? matches : [];

                const filteredMatches = currentSuggestions.filter(tag => {
                    return !selectedTags.some(selectedTag => normalizeTag(selectedTag.name) === normalizeTag(tag.name));
                });

                if (filteredMatches.length === 0) {
                    suggestionsBox.innerHTML = '<div class="suggestion-empty">\u0644\u0627 \u062a\u0648\u062c\u062f \u0648\u0633\u0648\u0645 \u0645\u0637\u0627\u0628\u0642\u0629</div>';
                    return;
                }

                suggestionsBox.innerHTML = filteredMatches.slice(0, 6).map(tag => {
                    return `<button type="button" class="suggestion-item" data-tag="${tag.name}" data-tag-id="${tag.id}">${tag.name}</button>`;
                }).join('');
            })
            .catch(() => {
                currentSuggestions = [];
                suggestionsBox.innerHTML = '<div class="suggestion-empty">\u0644\u0627 \u062a\u0648\u062c\u062f \u0648\u0633\u0648\u0645 \u0645\u0637\u0627\u0628\u0642\u0629</div>';
            });
    }

    function addTag(tag) {
        const tagObject = typeof tag === 'string' ? findTagByName(tag) || { id: null, name: tag } : tag;

        if (!tagObject || !tagObject.name || !tagNameExists(tagObject.name)) return;
        if (selectedTags.some(existing => normalizeTag(existing.name) === normalizeTag(tagObject.name))) return;

        selectedTags.push({ id: tagObject.id || null, name: tagObject.name });
        renderSelectedTags();
        updateSelectedTagButtons();
        renderSuggestions(searchInput ? searchInput.value : '');
    }

    function removeTag(tag) {
        selectedTags = selectedTags.filter(existing => normalizeTag(existing.name) !== normalizeTag(tag));
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

        const params = new URLSearchParams();
        selectedTags.forEach(tag => params.append('tags[]', tag.name));
        window.location.href = '/search?' + params.toString();
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
                    const matched = currentSuggestions.find(tag => normalizeTag(tag.name) === normalizeTag(value)) || findTagByName(value);
                    if (matched) {
                        addTag(matched);
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
                    const matched = currentSuggestions.find(tag => normalizeTag(tag.name) === normalizeTag(value)) || findTagByName(value);
                    if (matched) {
                        addTag(matched);
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
            addTag({
                id: target.dataset.tagId || null,
                name: target.dataset.tag
            });
        }

        if (target.classList.contains('suggestion-item') && target.dataset.tag) {
            addTag({
                id: target.dataset.tagId || null,
                name: target.dataset.tag
            });
            if (searchInput) {
                searchInput.value = '';
            }
            renderSuggestions('');
        }

        const selectedTag = target.closest('.selected-tag');
        if (selectedTag && selectedTag.dataset.tag) {
            removeTag(selectedTag.dataset.tag);
        }
    });

    renderSelectedTags();
    updateSelectedTagButtons();
});

})(jQuery);


