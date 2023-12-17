//!Search
document.addEventListener("DOMContentLoaded", function () {
  input_search = document.querySelector(".input__search");
  if (input_search) {
    input_search.addEventListener("keyup", function (event) {
      if (event.keyCode === 13) {
        search();
      }
    });
  }
});

isSearching = false;

function search() {
  var query = document.querySelector(".input__search").value.toLowerCase();
  var productCards = document.querySelectorAll(".product-card");
  if (isSearching) {
    productCards.forEach(function (card) {
      var productName = card.querySelector("h3").textContent.toLowerCase();

      if (productName.includes(query)) {
        card.style.display = "flex";
      } else {
        card.style.display = "none";
      }
    });
  } else {
    hideSearchbar();
  }
}

function hideSearchbar() {
  var searchbar = document.querySelector(".input__container");
  var inputBar = document.querySelector(".input__search");
  var x_icon = document.querySelector("#x-searchIcon");
  if (isSearching) {
    searchbar.style.width = "20px";
    inputBar.style.display = "none";
    x_icon.style.display = "none";
    isSearching = false;
  } else {
    searchbar.style.width = "400px";
    inputBar.style.display = "block";
    x_icon.style.display = "block";
    isSearching = true;
  }
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
    } else {
      body.style.background = "linear-gradient(to right, #2a475e, #66c0f4)";
      body.style.color = "#000000";
      productInfos.forEach((info) => {
        info.style.background = "linear-gradient(to top, #c7d5e0, #ffffff)";
        info.style.color = "black";
      });
    }

    setTimeout(() => {
      body.classList.remove("theme-transition");
      productInfos.forEach((info) => {
        info.classList.remove("theme-transition");
      });
    }, 500);
  }

  const isDarkMode = toggleSwitch.checked;
  switchTheme({ target: { checked: isDarkMode } });
});

//! Cart
let cart = document.querySelector(".cartTab");
if (cart) {
  cart.style.right = "-100%";
  hideCartAfterAnimation();
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
      cart.addEventListener("transitionend", hideCartAfterAnimation);
    }
  });
}
if (close) {
  close.addEventListener("click", () => {
    cart.style.right = "-100%";
    container.style.transform = "translateX(0)";
    cart.addEventListener("transitionend", hideCartAfterAnimation);
  });
}

function hideCartAfterAnimation() {
  cart.style.display = "none";
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
          const wishlistButtons =
            document.querySelectorAll(".SaveToWishlistBtn");

          wishlistButtons.forEach((button) => {
            button.addEventListener("click", () => {
              const gameID = button.dataset.gameId;
              addToWishlist(gameID);
            });
          });
        } else {
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
    return;
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

window.addEventListener("load", function () {
  checkLoginStatus();
});

//!Remove from Wishlist
function removeFromWishlist(gameID) {
  const confirmed = window.confirm(
    "Are you sure you want to remove this game from your wishlist?"
  );
  if (!confirmed) {
    return;
  }

  const xhr = new XMLHttpRequest();
  const url = "removeFromWishlist.php";
  const params = `gameID=${gameID}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        alert("Removed from wishlist successfully!");
        location.reload();
      } else {
        alert("Failed to remove from wishlist");
      }
    }
  };

  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(params);
}

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
  const url = "addToCart.php";
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

//!Remove from Cart
document.addEventListener("DOMContentLoaded", () => {
  const removeFromCartButtons = document.querySelectorAll(".RemoveFromCartBtn");

  removeFromCartButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      const gameID = event.currentTarget.dataset.gameId;
      console.log(gameID);
      removeFromCart(gameID);
    });
  });

  function removeFromCart(gameID) {
    fetch("removeFromCart.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `gameID=${gameID}`,
    })
      .then((response) => {
        if (response.ok) {
          alert("game removed from cart successfully!");
          location.reload();
        } else {
          alert("Failed to remove the game from cart.");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }
});
