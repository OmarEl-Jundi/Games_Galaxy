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
cartWidth = cart.offsetWidth;
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
      cart.style.right = "-725px";
      container.style.transform = "translateX(-30%)";
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

function updateTotalPrice() {
  const listCart = document.querySelector(".listCart");
  if (listCart) {
    const items = listCart.querySelectorAll(".item");
    const totalPrice = document.querySelector(".totalCartPrice");

    if (totalPrice) {
      let total = 0;
      items.forEach((item) => {
        const priceText = item.querySelector(".price").textContent;
        if (priceText.trim() !== "Free!") {
          const price = parseFloat(priceText.replace("$", ""));
          if (!isNaN(price)) {
            total += price;
          }
        }
      });
      totalPrice.innerHTML =
        '<b style="color: #4bacb6;">Total: $' + total.toFixed(2) + "</b>";
    }
  }
}

window.addEventListener("load", updateTotalQuantity);

function checkoutProcess() {
  const xhr = new XMLHttpRequest();
  const url = "checkoutProcess.php";
  xhr.open("GET", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const itemsToRemove = document.querySelectorAll(".item");
        itemsToRemove.forEach((item) => {
          item.remove();
        });
        document.getElementsByClassName("tooltip")[0].textContent =
          "$ " + xhr.responseText;
        alert("Checkout successful!");
        updateTotalQuantity();
        updateTotalPrice();
      } else if (xhr.status === 403) {
        alert("Insufficient funds!");
      } else if (xhr.status === 404) {
        alert("Cart Empty");
      } else {
        alert("Failed to checkout");
      }
    }
  };
  xhr.send();
}

//!add to wishlist
const wishlistButtons = document.querySelectorAll(".SaveToWishlistBtn");

wishlistButtons.forEach((button) => {
  button.addEventListener("click", () => {
    checkLoginStatus();
  });
});

function checkLoginStatus() {
  const xhr = new XMLHttpRequest();
  const url = "checkLoginStatus.php";

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const isLoggedIn = xhr.responseText.trim() === "true";
        if (isLoggedIn == true) {
          const wishlistButtons =
            document.querySelectorAll(".SaveToWishlistBtn");

          wishlistButtons.forEach((button) => {
            button.addEventListener("click", () => {
              const gameID = button.dataset.gameId;
              addToWishlist(gameID);
            });
          });
        } else if (isLoggedIn == false) {
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
        // alert("Added to Wishlist Successfully");
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
        document.getElementById("wishlist-" + gameID).remove();
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
  const xhr = new XMLHttpRequest();
  const url = "addToCart.php";
  const params = `gameID=${gameID}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const cartItem = xhr.responseText;
        const listCart = document.querySelector(".listCart");
        listCart.insertAdjacentHTML("afterbegin", cartItem);
        updateTotalQuantity();
        updateTotalPrice();
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
const removeFromCartButtons = document.querySelectorAll(".RemoveFromCartBtn");

if (removeFromCartButtons) {
  removeFromCartButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      const gameID = event.currentTarget.dataset.gameId;
      removeFromCart(gameID);
    });
  });
}
function removeFromCart(gameID) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "removeFromCart.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        document.getElementById("cart-" + gameID).remove();
        updateTotalQuantity();
        updateTotalPrice();
      } else {
        alert("Failed to remove the game from cart.");
      }
    }
  };

  xhr.onerror = function (error) {
    console.error("Error:", error);
  };

  xhr.send("gameID=" + gameID);
}
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

//!like_dislike
const likeButtons = document.querySelectorAll(".bi-hand-thumbs-up");
const dislikeButtons = document.querySelectorAll(".bi-hand-thumbs-down");

function sendLikeRequest(commentID) {
  const xhr = new XMLHttpRequest();
  const url = "likeprocess.php";
  const params = `commentID=${commentID}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        document.getElementById("like-" + commentID).classList.add("liked");
        var likeCountElement = document.getElementById(
          "like-count-" + commentID
        );
        var currentCount = parseInt(likeCountElement.textContent);
        likeCountElement.textContent = currentCount + 1;

        if (
          document
            .getElementById("dislike-" + commentID)
            .classList.contains("disliked")
        ) {
          document
            .getElementById("dislike-" + commentID)
            .classList.remove("disliked");
          var dislikeCountElement = document.getElementById(
            "dislike-count-" + commentID
          );
          var currentCountDislike = parseInt(dislikeCountElement.textContent);
          dislikeCountElement.textContent = currentCountDislike - 1;
        }
      } else if (xhr.status === 403) {
        alert("Please login to like");
        window.location.href = "login.php";
      } else if (xhr.status === 410) {
        document.getElementById("like-" + commentID).classList.remove("liked");
        var likeCountElement = document.getElementById(
          "like-count-" + commentID
        );
        var currentCount = parseInt(likeCountElement.textContent);
        likeCountElement.textContent = currentCount - 1;
      } else {
        alert("Error liking the comment");
      }
    }
  };

  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(params);
}

function sendDislikeRequest(commentID) {
  const xhr = new XMLHttpRequest();
  const url = "dislikeprocess.php";
  const params = `commentID=${commentID}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        document
          .getElementById("dislike-" + commentID)
          .classList.add("disliked");
        var dislikeCountElement = document.getElementById(
          "dislike-count-" + commentID
        );
        var currentCount = parseInt(dislikeCountElement.textContent);
        dislikeCountElement.textContent = currentCount + 1;

        if (
          document
            .getElementById("like-" + commentID)
            .classList.contains("liked")
        ) {
          document
            .getElementById("like-" + commentID)
            .classList.remove("liked");
          var likeCountElement = document.getElementById(
            "like-count-" + commentID
          );
          var currentCountLike = parseInt(likeCountElement.textContent);
          likeCountElement.textContent = currentCountLike - 1;
        }
      } else if (xhr.status === 403) {
        alert("Please login to dislike");
        window.location.href = "login.php";
      } else if (xhr.status === 410) {
        document
          .getElementById("dislike-" + commentID)
          .classList.remove("disliked");
        var dislikeCountElement = document.getElementById(
          "dislike-count-" + commentID
        );
        var currentCount = parseInt(dislikeCountElement.textContent);
        dislikeCountElement.textContent = currentCount - 1;
      } else {
        alert("Error disliking the comment");
      }
    }
  };

  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(params);
}

//!Delete Comment
deleteCommentButtons = document.querySelectorAll(".deleteComment");

deleteCommentButtons.forEach((button) => {
  const originalPath =
    "M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5";
  const hoverPath =
    "M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5";
  button.addEventListener("mouseover", () => {
    button.querySelector("path").setAttribute("d", hoverPath);
    button.style.color = "firebrick";
  });

  button.addEventListener("mouseout", () => {
    button.querySelector("path").setAttribute("d", originalPath);
    button.style.color = "#1b2838";
  });
});

function deleteComment(commentID) {
  const confirmed = window.confirm("Are you sure you want to delete this?");
  if (!confirmed) {
    return;
  }

  const xhr = new XMLHttpRequest();
  const url = "deleteComment.php";
  const params = `commentID=${commentID}`;

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status == 200) {
        document.getElementById("comment-" + commentID).remove();
      } else {
        alert("Failed to delete comment");
      }
    }
  };

  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(params);
}

//!Edit Comment

function editComment(commentID, commentText) {
  document.getElementById("editCommentModal").style.display = "block";
  document.getElementById("editedComment").value = commentText;
  document.getElementById("saveChangesBtn").addEventListener("click", () => {
    const editedComment = document.getElementById("editedComment").value;
    editedComment = sanitizeComment(editedComment);
    const xhr = new XMLHttpRequest();
    const url = "editComment.php";
    const params = `commentID=${commentID}&editedComment=${encodeURIComponent(
      editedComment
    )}`;

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          document
            .getElementById("comment-" + commentID)
            .querySelector(".comment_text").innerHTML = editedComment;
          document.getElementById("editCommentModal").style.display = "none";
        } else {
          console.error("Failed to edit comment. Status: " + xhr.status);
          console.error("Response: " + xhr.responseText);
          alert("Failed to edit comment");
        }
      }
    };

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
  });
}

document
  .querySelectorAll(".close_editComment ,.close_editComment_Alt")
  .forEach((button) => {
    button.addEventListener("click", () => {
      document.getElementById("editCommentModal").style.display = "none";
    });
  });

const commentSection = document.querySelector(".commentsContainer");

if (commentSection) {
  commentSection.addEventListener("click", (event) => {
    let clickedElement = event.target;

    if (clickedElement.nodeName === "path") {
      const svgElement = clickedElement.closest("svg");
      if (svgElement) {
        clickedElement = svgElement;
      }
    }

    const commentID = clickedElement.dataset.commentId;

    if (clickedElement.classList.contains("bi-hand-thumbs-up")) {
      sendLikeRequest(commentID);
    } else if (clickedElement.classList.contains("bi-hand-thumbs-down")) {
      sendDislikeRequest(commentID);
    } else if (clickedElement.classList.contains("deleteComment")) {
      deleteComment(commentID);
    } else if (clickedElement.classList.contains("editComment")) {
      editComment(
        commentID,
        clickedElement.parentElement.parentElement.parentElement.querySelector(
          ".comment_text"
        ).innerHTML
      );
    }
  });
}
function sanitizeComment(comment) {
  // Replace special characters with HTML entities
  const sanitized = comment
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");

  return sanitized;
}

//!Wallet
const CreateWallet = document.querySelector("#createWallet");

if (CreateWallet) {
  CreateWallet.addEventListener("click", () => {
    const xhr = new XMLHttpRequest();
    const url = "createWallet.php";
    xhr.open("GET", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          alert("Wallet created successfully!");
          location.reload();
        } else {
          alert("Failed to create wallet");
        }
      }
    };
    xhr.send();
  });
}

//!Add Funds
const AddFunds = document.querySelector("#addFundsBtn");

if (AddFunds) {
  AddFunds.addEventListener("click", () => {
    const xhr = new XMLHttpRequest();
    const url = "addFunds.php";
    const params = `amount=${document.querySelector("#addFundsBar").value}`;
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          document.getElementById("amount").textContent =
            " " + xhr.responseText + " $";
        } else {
          alert("Failed to add funds");
        }
      }
    };
    xhr.send(params);
  });
}

//!Change Username
const editUsernameBtn = document.querySelector("#editUsernameBtn");
let isEditingUsername = false;
let oldUsername;
if (editUsernameBtn) {
  editUsernameBtn.addEventListener("click", () => {
    if (isEditingUsername) {
      if (document.getElementById("editUsernameBar").value == oldUsername) {
        alert("Please enter a new username!");
        return;
      } else {
        changeUsername(document.getElementById("editUsernameBar").value);
      }
    } else {
      document.getElementById("editUsernameBar").disabled = false;
      isEditingUsername = true;
      oldUsername = document.getElementById("editUsernameBar").value;
    }
  });
}

function changeUsername(username) {
  const xhr = new XMLHttpRequest();
  const url = "changeUsername.php";
  const params = `username=${username}`;
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        alert("Username changed successfully!");
        document.getElementById("editUsernameBar").disabled = true;
        isEditingUsername = false;
      } else if (xhr.status === 400) {
        alert("username already taken");
      } else {
        alert("Failed to change username");
      }
    }
  };
  xhr.send(params);
}

//!Change Email
const editEmailBtn = document.querySelector("#editEmailBtn");
let isEditingEmail = false;

if (editEmailBtn) {
  editEmailBtn.addEventListener("click", () => {
    if (isEditingEmail) {
      if (document.getElementById("editEmailBar").value == oldEmail) {
        alert("Please enter a new email!");
        return;
      } else {
        changeEmail(document.getElementById("editEmailBar").value);
      }
    } else {
      document.getElementById("editEmailBar").disabled = false;
      isEditingEmail = true;
      oldEmail = document.getElementById("editEmailBar").value;
    }
  });
}

function changeEmail(email) {
  const xhr = new XMLHttpRequest();
  const url = "changeEmail.php";
  const params = `email=${email}`;
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        alert("Email changed successfully!");
        document.getElementById("editEmailBar").disabled = true;
        isEditingEmail = false;
      } else if (xhr.status === 400) {
        alert("Email already taken");
      } else {
        alert("Failed to change email");
      }
    }
  };
  xhr.send(params);
}

//!Change Password

function changePassword() {
  const currentPassword = document.getElementById("currentPassword").value;
  const newPassword = document.getElementById("newPassword").value;
  const confirmPassword = document.getElementById("confirmPassword").value;

  if (newPassword !== confirmPassword) {
    alert("Passwords do not match");
    return;
  } else if (newPassword.length < 8 || !/\d/.test(newPassword)) {
    alert(
      "Password must be at least 8 characters long and contain at least 1 number"
    );
    return;
  } else {
    const xhr = new XMLHttpRequest();
    const url = "changePassword.php";
    const params = `oldPassword=${currentPassword}&newPassword=${newPassword}&confirmPassword=${confirmPassword}`;
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          alert("Password changed successfully!");
          document.getElementById("oldPassword").value = "";
          document.getElementById("newPassword").value = "";
          document.getElementById("confirmPassword").value = "";
        } else if (xhr.status === 400) {
          alert("Incorrect password");
        } else if (xhr.status === 401) {
          alert("Passwords do not match");
        } else {
          alert("Failed to change password");
        }
      }
    };
    xhr.send(params);
  }
}

const friendsIcon = document.querySelector(".friendsIcon");

if (friendsIcon) {
  friendsIcon.addEventListener("click", () => {
    window.location.href = "friends.php";
  });

  function updateNotifications() {
    getNotifications();
  }

  updateNotifications();

  setInterval(updateNotifications, 1000);
}

function getNotifications() {
  const xhr = new XMLHttpRequest();
  const url = "getNotifications.php";
  xhr.open("GET", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const notificationsCount = xhr.responseText;
        if (notificationsCount > 0) {
          const notificationsContainer = document.querySelector(
            ".notificationsCount"
          );
          if (!notificationsContainer) {
            document
              .querySelector(".friendsIcon")
              .appendChild(
                document
                  .createElement("div")
                  .classList.add("notificationsCount")
              );
          }
          notificationsContainer.innerHTML = notificationsCount;
        }
      }
    }
  };
  xhr.send();
}

document.addEventListener("DOMContentLoaded", function () {
  checkBan();
});

function checkBan() {
  const xhr = new XMLHttpRequest();
  const url = "checkBan.php";

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 201) {
        window.location.href = "banned.html";
      } else {
        console.error("Error checking ban status:", xhr.responseText);
      }
    }
  };

  xhr.open("GET", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send();
}
