const body = document.body;
const theme = localStorage.getItem('theme')
const navbar = document.querySelector("nav");

if (theme){
  document.documentElement.setAttribute('data-bs-theme', theme)
  navbar.classList.add('fixed-top', theme);
} 


