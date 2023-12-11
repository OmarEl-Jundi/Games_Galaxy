document.addEventListener("DOMContentLoaded", function () {
  input_search = document.querySelector(".input__search");
  if (input_search) {
    input_search.addEventListener("keyup", function (event) {
      // Number 13 is the "Enter" key
      if (event.keyCode === 13) {
        // Trigger the search function
        search();
      }
    });
  }
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

//! dark-light mode
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

//! Cart
let cart = document.querySelector(".cartTab");
if (cart) {
  cart.style.right = "-100%";
}
let iconCart = document.querySelector(".iconCart");
let container = document.querySelector(".container");
let close = document.querySelector(".close");

if (iconCart) {
  iconCart.addEventListener("click", () => {
    if (cart.style.right === "-100%") {
      cart.style.right = "-63%";
      container.style.transform = "translateX(-400px)";
      cart.style.display = "block";
    } else {
      cart.style.right = "-100%";
      container.style.transform = "translateX(0)";
      // Add event listener for transitionend
      cart.addEventListener("transitionend", hideCartAfterAnimation);
    }
  });
}
if (close) {
  close.addEventListener("click", () => {
    cart.style.right = "-100%";
    container.style.transform = "translateX(0)";
    // Add event listener for transitionend
    cart.addEventListener("transitionend", hideCartAfterAnimation);
  });
}

function hideCartAfterAnimation() {
  cart.style.display = "none";
  // Remove the event listener to prevent multiple firings
  cart.removeEventListener("transitionend", hideCartAfterAnimation);
}

function updateTotalQuantity() {
  const listCart = document.querySelector(".listCart");
  if (listCart) {
    const items = listCart.querySelectorAll(".item");
    const totalQuantity = document.querySelector(".totalQuantity");

    if (totalQuantity) {
      totalQuantity.textContent = items.length;
    }
  }
}

window.addEventListener("load", updateTotalQuantity);

//!add to wishlist
function checkLoginStatus() {
  const xhr = new XMLHttpRequest();
  const url = "checkLoginStatus.php";

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const isLoggedIn = xhr.responseText.trim() === "true";
        if (isLoggedIn) {
          // User is logged in - perform the action here
          const wishlistButtons =
            document.querySelectorAll(".SaveToWishlistBtn");

          wishlistButtons.forEach((button) => {
            button.addEventListener("click", () => {
              const gameID = button.dataset.gameId;
              addToWishlist(gameID);
            });
          });
        } else {
          // User is not logged in - show alert or handle accordingly
          const wishlistButtons =
            document.querySelectorAll(".SaveToWishlistBtn");

          wishlistButtons.forEach((button) => {
            button.addEventListener("click", () => {
              alert("Please log in to add to wishlist!");
              window.location.href = "login.php";
            });
          });
        }
      } else {
        alert("Failed to check login status");
      }
    }
  };

  xhr.open("GET", url, true);
  xhr.send();
}

function addToWishlist(gameID) {
  const confirmed = window.confirm(
    "Are you sure you want to add this game to your wishlist?"
  );
  if (!confirmed) {
    return; // If the user cancels, do nothing
  }
  const xhr = new XMLHttpRequest();
  const url = "addToWishlist.php";
  const params = `gameID=${gameID}`;
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        alert("Added to wishlist successfully!");
      } else if (xhr.status === 409) {
        alert("You have already added this game to your wishlist!");
      } else if (xhr.status === 410) {
        alert("You already own the game!");
      } else {
        alert("Failed to add to wishlist");
      }
    }
  };

  xhr.send(params);
}

// Execute the function when the window loads
window.addEventListener("load", function () {
  checkLoginStatus();
});

//!Remove from Wishlist
function removeFromWishlist(gameID) {
  const confirmed = window.confirm(
    "Are you sure you want to remove this game from your wishlist?"
  );
  if (!confirmed) {
    return; // If the user cancels, do nothing
  }

  const xhr = new XMLHttpRequest();
  const url = "removeFromWishlist.php"; // Endpoint to remove from wishlist
  const params = `gameID=${gameID}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        alert("Removed from wishlist successfully!");
        location.reload();
        // Optionally, you can update the UI to reflect the removal
      } else {
        alert("Failed to remove from wishlist");
      }
    }
  };

  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(params);
}

// Add event listeners to RemoveFromWishlistBtn buttons
const removeFromWishlistButtons = document.querySelectorAll(
  ".RemoveFromWishlistBtn"
);
if (removeFromWishlistButtons) {
  removeFromWishlistButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const gameID = button.dataset.gameId;
      removeFromWishlist(gameID);
    });
  });
}
//! Function to add item to cart
function addToCart(gameID) {
  console.log(gameID);
  const xhr = new XMLHttpRequest();
  const url = "addToCart.php"; // Endpoint to handle adding to cart
  const params = `gameID=${gameID}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        alert("Added to cart successfully!");
        location.reload();
      } else if (xhr.status === 409) {
        alert("You already own the game!");
      } else if (xhr.status === 410) {
        alert("You have already added this game to your cart!");
      } else {
        alert("Failed to add to cart");
        console.log(xhr.responseText);
      }
    }
  };

  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(params);
}

// Add event listeners to Add to Cart buttons
const addToCartButtons = document.querySelectorAll(".CartBtn");
if (addToCartButtons) {
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const gameID =
        button.parentElement.querySelector(".CartBtn").dataset.gameId;
      addToCart(gameID);
    });
  });
}
