document.addEventListener("DOMContentLoaded", function () {
    const cardsPerPage = 3;
    
    const container = document.getElementById("announcements-container");
    const cards = Array.from(container.querySelectorAll(".card"));
    const paginationContainer = document.getElementById("pagination-container");
    
    const searchInput = document.querySelector(".search-input");
    const selectInput = document.querySelector(".select-input");
    const filterBtn = document.querySelector(".filter-panel .btn-primary");

    let currentPage = 1;
    let filteredCards = [...cards]; 

    function filterCards() {
        const searchText = searchInput.value.toLowerCase().trim();
        const selectedCategory = selectInput.value; // 'news', 'events' или 'info'

        filteredCards = cards.filter(card => {
            const title = card.querySelector(".card-title").innerText.toLowerCase();
            const text = card.querySelector(".card-text").innerText.toLowerCase();
            const matchesSearch = title.includes(searchText) || text.includes(searchText);

            const badge = card.querySelector(".badge");
            let matchesCategory = true;
            
            if (selectedCategory === "news") matchesCategory = badge.classList.contains("badge-news");
            if (selectedCategory === "events") matchesCategory = badge.classList.contains("badge-event");
            if (selectedCategory === "info") matchesCategory = badge.classList.contains("badge-info");

            return matchesSearch && matchesCategory;
        });

        currentPage = 1;
        updateUI();
    }

    function updateUI() {
        cards.forEach(card => card.style.display = "none");

        const totalPages = Math.ceil(filteredCards.length / cardsPerPage);

        if (filteredCards.length === 0) {
            paginationContainer.innerHTML = "<p style='color: var(--text-muted);'>Ничего не найдено по вашему запросу</p>";
            return;
        }

        const start = (currentPage - 1) * cardsPerPage;
        const end = start + cardsPerPage;

        filteredCards.slice(start, end).forEach(card => {
            card.style.display = "flex";
        });

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        paginationContainer.innerHTML = "";
        
        if (totalPages <= 1) return;

        const prevBtn = document.createElement("div");
        prevBtn.innerText = "«";
        prevBtn.classList.add("page-link");
        if (currentPage === 1) prevBtn.classList.add("disabled");
        prevBtn.addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                updateUI();
                window.scrollTo({ top: 350, behavior: 'smooth' }); 
            }
        });
        paginationContainer.appendChild(prevBtn);

        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement("div");
            pageBtn.innerText = i;
            pageBtn.classList.add("page-link");
            if (i === currentPage) pageBtn.classList.add("active");
            
            pageBtn.addEventListener("click", () => {
                currentPage = i;
                updateUI();
                window.scrollTo({ top: 350, behavior: 'smooth' });
            });
            paginationContainer.appendChild(pageBtn);
        }

        const nextBtn = document.createElement("div");
        nextBtn.innerText = "»";
        nextBtn.classList.add("page-link");
        if (currentPage === totalPages) nextBtn.classList.add("disabled");
        nextBtn.addEventListener("click", () => {
            if (currentPage < totalPages) {
                currentPage++;
                updateUI();
                window.scrollTo({ top: 350, behavior: 'smooth' });
            }
        });
        paginationContainer.appendChild(nextBtn);
    }

    filterBtn.addEventListener("click", filterCards);
    selectInput.addEventListener("change", filterCards);
    
    searchInput.addEventListener("input", filterCards);

    updateUI();
});
