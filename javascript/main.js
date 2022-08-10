// --------------------menu-----------------------
let menu = document.getElementById("menu");
let sections = document.getElementById("sections");
menu.onclick = function () {
  if (menu.classList.contains("menu-opened")) {
    menu.classList.remove("menu-opened");
    sections.style.display = "none";
  } else {
    menu.classList.add("menu-opened");
    sections.style.display = "flex";
  }
};
// --------------------menu-----------------------
// --------------------social-----------------------
let links = document.getElementById("links");
let social = document.getElementById("social");
links.onclick = function () {
  if (links.classList.contains("link-opened")) {
    links.classList.remove("link-opened");
    links.classList.add("link-closed");
    social.classList.remove("visible");
  } else {
    links.classList.remove("link-closed");
    links.classList.add("link-opened");
    social.classList.add("visible");
  }
};
// --------------------menu-----------------------
// --------------------loader-----------------------
let landing = document.getElementById("landing");
let mountain = document.getElementById("mountain");
var loader = document.getElementById("preloader");

window.addEventListener("load", function () {
  loader.style.display = "none";
  landing.classList.add("animation");
  mountain.classList.add("animate-mountain");
});
// --------------------loader-----------------------
// --------------------up-----------------------
let span = document.querySelector(".up");

window.onscroll = function () {
  window.scrollY >= 500
    ? span.classList.add("show")
    : span.classList.remove("show");
};

span.onclick = function () {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
};
// --------------------up-----------------------
let skills = document.querySelector(".skills");
let spans = document.querySelectorAll(".skills .box span");
let box = document.querySelectorAll(".skills .box");
window.addEventListener("scroll", function () {
  if (window.scrollY >= skills.offsetTop - 100) {
    console.log("Reached Section Three");
    spans.forEach((span) => {
      span.classList.add("animate-progress");
    });
  }
});
//tabs=================================================
let allButt = document.querySelector(".all-butt");
let designButt = document.querySelector(".design-butt");
let webButt = document.querySelector(".web-butt");
let allTabs = document.querySelectorAll(".tabs button");
let allBoxes = document.querySelectorAll(".work .container .box");
allTabs.forEach((e) => {
  e.addEventListener("click", function (e) {
    allTabs.forEach((e) => {
      e.classList.remove("active");
    });
    e.currentTarget.classList.add("active");
    if (e.currentTarget.classList.contains("all-butt")) {
      allBoxes.forEach((e) => {
        e.style.display = "block";
      });
    } else if (e.currentTarget.classList.contains("design-butt")) {
      allBoxes.forEach((e) => {
        e.style.display = "none";
        if (e.classList.contains("design")) {
          e.style.display = "block";
        }
      });
    } else {
      allBoxes.forEach((e) => {
        e.style.display = "none";
        if (e.classList.contains("web")) {
          e.style.display = "block";
        }
      });
    }
  });
});
//animated name===========================================
let text = document.querySelector(".animated-name");
let arr = text.innerText.split("");
let newarr = [];
let counter = 0;
text.innerText = "H";
window.onload = function () {
  let counting = setInterval(() => {
    text.innerText = "";
    newarr.push(arr[counter]);
    console.log(newarr.join(""));
    counter++;
    text.innerHTML = newarr.join("");
    if (arr.length === counter) {
      clearInterval(counting);
    }
  }, 300);
};
