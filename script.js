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
        alert("Please login to add to cart!");
        window.location.href = "login.php";
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

//!going to game description when clicking on a game
let gameCards = document.querySelectorAll(".product-image, .product-name");
gameCards.forEach((card) => {
  card.addEventListener("click", () => {
    const gameID = card.parentElement.dataset.gameId;
    window.location.href = `gameDescription.php?gameID=${gameID}`;
  });
});

//! loading screen
window.addEventListener("load", function () {
  var spinner = document.querySelector(".spinner");
  spinner.style.display = "none";

  var content = document.querySelector(".content");
  content.style.display = "block";
});

//!like_dislike colors
const likeButtons = document.querySelectorAll(".bi-hand-thumbs-up");
const dislikeButtons = document.querySelectorAll(".bi-hand-thumbs-down");

likeButtons.forEach((like) => {
  const originalPath =
    "M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z";
  const hoverPath =
    "M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z";

  like.addEventListener("mouseover", () => {
    like.querySelector("path").setAttribute("d", hoverPath);
    like.style.color = "green";
  });

  like.addEventListener("mouseout", () => {
    like.querySelector("path").setAttribute("d", originalPath);
    like.style.color = "#1b2838";
  });
});

dislikeButtons.forEach((dislike) => {
  const originalPath =
    "M8.864 15.674c-.956.24-1.843-.484-1.908-1.42-.072-1.05-.23-2.015-.428-2.59-.125-.36-.479-1.012-1.04-1.638-.557-.624-1.282-1.179-2.131-1.41C2.685 8.432 2 7.85 2 7V3c0-.845.682-1.464 1.448-1.546 1.07-.113 1.564-.415 2.068-.723l.048-.029c.272-.166.578-.349.97-.484C6.931.08 7.395 0 8 0h3.5c.937 0 1.599.478 1.934 1.064.164.287.254.607.254.913 0 .152-.023.312-.077.464.201.262.38.577.488.9.11.33.172.762.004 1.15.069.13.12.268.159.403.077.27.113.567.113.856 0 .289-.036.586-.113.856-.035.12-.08.244-.138.363.394.571.418 1.2.234 1.733-.206.592-.682 1.1-1.2 1.272-.847.283-1.803.276-2.516.211a9.877 9.877 0 0 1-.443-.05 9.364 9.364 0 0 1-.062 4.51c-.138.508-.55.848-1.012.964zM11.5 1H8c-.51 0-.863.068-1.14.163-.281.097-.506.229-.776.393l-.04.025c-.555.338-1.198.73-2.49.868-.333.035-.554.29-.554.55V7c0 .255.226.543.62.65 1.095.3 1.977.997 2.614 1.709.635.71 1.064 1.475 1.238 1.977.243.7.407 1.768.482 2.85.025.362.36.595.667.518l.262-.065c.16-.04.258-.144.288-.255a8.34 8.34 0 0 0-.145-4.726.5.5 0 0 1 .595-.643h.003l.014.004.058.013a8.912 8.912 0 0 0 1.036.157c.663.06 1.457.054 2.11-.163.175-.059.45-.301.57-.651.107-.308.087-.67-.266-1.021L12.793 7l.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315l-.353-.354.353-.354c.047-.047.109-.176.005-.488a2.224 2.224 0 0 0-.505-.804l-.353-.354.353-.354c.006-.005.041-.05.041-.17a.866.866 0 0 0-.121-.415C12.4 1.272 12.063 1 11.5 1";
  const hoverPath =
    "M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z";

  dislike.addEventListener("mouseover", () => {
    dislike.querySelector("path").setAttribute("d", hoverPath);
    dislike.style.color = "firebrick";
  });

  dislike.addEventListener("mouseout", () => {
    dislike.querySelector("path").setAttribute("d", originalPath);
    dislike.style.color = "#1b2838";
  });
});

//! like_dislike functionality
likeButtons.forEach((likeBtn) => {
  likeBtn.addEventListener("click", () => {
    const commentID = likeBtn.dataset.commentId;
    sendLikeRequest(commentID);
  });
});

function sendLikeRequest(commentID) {
  const xhr = new XMLHttpRequest();
  const url = "likeprocess.php";
  const params = `commentID=${commentID}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        location.reload();
      } else if (xhr.status === 403) {
        alert("Please login to like");
        window.location.href = "login.php";
      } else if (xhr.status === 410) {
        location.reload();
      } else {
        alert("Error liking the comment");
      }
    }
  };

  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(params);
}

dislikeButtons.forEach((dislikeBtn) => {
  dislikeBtn.addEventListener("click", () => {
    const commentID = dislikeBtn.dataset.commentId;
    sendDislikeRequest(commentID);
  });
});

function sendDislikeRequest(commentID) {
  const xhr = new XMLHttpRequest();
  const url = "dislikeprocess.php";
  const params = `commentID=${commentID}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        location.reload();
      } else if (xhr.status === 403) {
        alert("Please login to dislike");
        window.location.href = "login.php";
      } else if (xhr.status === 410) {
        location.reload();
      } else {
        alert("Error disliking the comment");
      }
    }
  };

  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(params);
}
