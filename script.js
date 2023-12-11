document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelector(".input__search")
    .addEventListener("keyup", function (event) {
      // Number 13 is the "Enter" key
      if (event.keyCode === 13) {
        // Trigger the search function
        search();
      }
    });
});
function search() {
  // Get the value of the search bar
  var query = document.querySelector(".input__search").value.toLowerCase();

  // Select all product cards
  var productCards = document.querySelectorAll(".product-card");

  // Iterate over each product card
  productCards.forEach(function (card) {
    // Get the product name from the h3 element
    var productName = card.querySelector("h3").textContent.toLowerCase();

    // Check if the product name includes the search query
    if (productName.includes(query)) {
      // If it does, display the product card
      card.style.display = "flex";
    } else {
      // Otherwise, hide the product card
      card.style.display = "none";
    }
  });
}

// dark-light mode
document.addEventListener("DOMContentLoaded", function () {
  const toggleSwitch = document.getElementById("darkmode-toggle");

  toggleSwitch.addEventListener("change", switchTheme, false);

  function switchTheme(e) {
    const body = document.body;
    const productInfos = document.querySelectorAll(".product-info");
    const isDarkMode = !e.target.checked;

    body.classList.add("theme-transition");
    productInfos.forEach((info) => {
      info.classList.add("theme-transition");
    });

    if (isDarkMode) {
      body.style.background = "linear-gradient(to right, #171a21, #1b2838)";
      body.style.color = "#ffffff";
      productInfos.forEach((info) => {
        info.style.background = "linear-gradient(to top, #171a21, #1b2838)";
        info.style.color = "white";
      });
      // Apply dark theme here
    } else {
      body.style.background = "linear-gradient(to right, #2a475e, #66c0f4)";
      body.style.color = "#000000";
      productInfos.forEach((info) => {
        info.style.background = "linear-gradient(to top, #c7d5e0, #ffffff)";
        info.style.color = "black";
      });
      // Apply light theme here
    }

    setTimeout(() => {
      body.classList.remove("theme-transition");
      productInfos.forEach((info) => {
        info.classList.remove("theme-transition");
      });
    }, 500);
  }

  // Initialize theme based on toggle's current state
  const isDarkMode = toggleSwitch.checked;
  switchTheme({ target: { checked: isDarkMode } });
});

// Cart
let cart = document.querySelector(".cartTab");
cart.style.right = "-100%"; // Ensure the initial state is set off-screen
let iconCart = document.querySelector(".iconCart");
let container = document.querySelector(".container");
let close = document.querySelector(".close");

iconCart.addEventListener("click", () => {
  if (cart.style.right == "-100%") {
    cart.style.right = "-63%";
    container.style.transform = "translateX(-400px)";
  } else {
    cart.style.right = "-100%";
    container.style.transform = "translateX(0)";
  }
});

close.addEventListener("click", () => {
  cart.style.right = "-100%";
  container.style.transform = "translateX(0)";
});
