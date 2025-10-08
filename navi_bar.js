const target = document.querySelector(".target");
const links = document.querySelectorAll(".mynav a");
const colors = ["deepskyblue", "orange", "firebrick", "gold", "magenta", "white", "darkblue"];

function mouseenterFunc() {
if (!this.parentNode.classList.contains("active")) {
for (let i = 0; i < links.length; i++) {
if (links[i].parentNode.classList.contains("active")) {
  links[i].parentNode.classList.remove("active");
}
links[i].style.opacity = "0.25";
}

this.parentNode.classList.add("active");
this.style.opacity = "1";

const width = this.getBoundingClientRect().width;
const height = this.getBoundingClientRect().height;
const left = this.getBoundingClientRect().left + window.pageXOffset;
const top = this.getBoundingClientRect().top + window.pageYOffset;
const color = colors[Math.floor(Math.random() * colors.length)];

target.style.width = `${width}px`;
target.style.height = `${height}px`;
target.style.left = `${left}px`;
target.style.top = `${top}px`;
target.style.borderColor = color;
target.style.transform = "none";
}
}

function mouseleaveFunc() {
for (let i = 0; i < links.length; i++) {
links[i].style.opacity = "1";
}
target.style.width = '0';
target.style.height = '0';
target.style.borderColor = 'transparent';
}

for (let i = 0; i < links.length; i++) {
links[i].addEventListener("mouseenter", mouseenterFunc);
links[i].addEventListener("mouseleave", mouseleaveFunc);
}

function resizeFunc() {
const active = document.querySelector(".mynav li.active");

if (active) {
  const left = active.getBoundingClientRect().left + window.pageXOffset;
  const top = active.getBoundingClientRect().top + window.pageYOffset;

  target.style.left = `${left}px`;
  target.style.top = `${top}px`;
}
}

const dropdown = document.querySelector(".custom-dropdown");
const select = dropdown.querySelector(".custom-select");
const caret = dropdown.querySelector(".custom-caret");
const menu = dropdown.querySelector(".custom-menu");
const options = dropdown.querySelectorAll(".custom-menu li");
const selected = dropdown.querySelector(".custom-selected");
const hiddenInput = document.getElementById("category");

select.addEventListener("click", () => {
select.classList.toggle("custom-select-clicked");
caret.classList.toggle("custom-caret-rotate");
menu.classList.toggle("custom-menu-open");
});

options.forEach(option => {
option.addEventListener("click", () => {
  selected.innerText = option.innerText;
  hiddenInput.value = option.getAttribute("data-value");
  select.classList.remove("custom-select-clicked");
  caret.classList.remove("custom-caret-rotate");
  menu.classList.remove("custom-menu-open");
  options.forEach(option => {
      option.classList.remove("custom-active");
  });
  option.classList.add("custom-active");
});
function resizeFunc() {
  const active = document.querySelector(".mynav li.active");

  if (active) {
      const left = active.getBoundingClientRect().left + window.pageXOffset;
      const top = active.getBoundingClientRect().top + window.pageYOffset;

      target.style.left = `${left}px`;
      target.style.top = `${top}px`;
  }
}

window.addEventListener("resize", resizeFunc);

});