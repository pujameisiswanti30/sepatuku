const searchInput = document.getElementById("searchInput");
const searchButton = document.getElementById("searchButton");
const productBoxes = document.querySelectorAll(".box");

searchButton.addEventListener("click", () => {
  const searchTerm = searchInput.value.toLowerCase();

  productBoxes.forEach((box) => {
    const productTitle = box.querySelector(".content h3").textContent.toLowerCase();

    if (productTitle.includes(searchTerm)) {
      box.style.display = "block";
    } else {
      box.style.display = "none";
    }
  });
});

searchInput.addEventListener("input", () => {
  const searchTerm = searchInput.value.toLowerCase();

  productBoxes.forEach((box) => {
    const productTitle = box.querySelector(".content h3").textContent.toLowerCase();

    if (productTitle.includes(searchTerm)) {
      box.style.display = "block";
    } else {
      box.style.display = "none";
    }
  });
});
