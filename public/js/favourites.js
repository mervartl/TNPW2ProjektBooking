document.addEventListener("DOMContentLoaded", () => {
    const favBtnClass = "fav-btn";
    const favKey = "favourites";
    let favourites = JSON.parse(localStorage.getItem(favKey)) || [];

    // Označíme oblíbené
    document.querySelectorAll(".listing").forEach(listing => {
        const id = listing.dataset.id;
        const favBtn = listing.querySelector("." + favBtnClass);
        if (!favBtn) return;

        if (favourites.includes(id)) {
            favBtn.textContent = "💔 Odebrat z oblíbených";
            listing.classList.add("favourite");
        }

        favBtn.addEventListener("click", (e) => {
            e.preventDefault();
            if (favourites.includes(id)) {
                favourites = favourites.filter(favId => favId !== id);
                favBtn.textContent = "❤ Přidat do oblíbených";
                listing.classList.remove("favourite");
            } else {
                favourites.push(id);
                favBtn.textContent = "💔 Odebrat z oblíbených";
                listing.classList.add("favourite");
            }
            localStorage.setItem(favKey, JSON.stringify(favourites));
        });
    });

    // Filtrování podle checkboxu
    const showOnlyFavs = document.getElementById("show-favourites-only");
    if (showOnlyFavs) {
        showOnlyFavs.addEventListener("change", () => {
            document.querySelectorAll(".listing").forEach(listing => {
                const id = listing.dataset.id;
                const shouldShow = !showOnlyFavs.checked || favourites.includes(id);
                listing.style.display = shouldShow ? "flex" : "none";
            });
        });

        // Spustíme jednou při načtení
        showOnlyFavs.dispatchEvent(new Event("change"));
    }
});

console.log("Favourites script loaded.");