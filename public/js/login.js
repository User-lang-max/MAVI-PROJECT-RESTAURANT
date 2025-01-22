const signInBtnLink = document.querySelector('.signInBtn-link');
const signUpBtnLink = document.querySelector('.signUpBtn-link');
const wrapper = document.querySelector('.wrapper');

// Basculer entre Login et Sign Up
signUpBtnLink?.addEventListener('click', () => wrapper.classList.add('active'));
signInBtnLink?.addEventListener('click', () => wrapper.classList.remove('active'));
