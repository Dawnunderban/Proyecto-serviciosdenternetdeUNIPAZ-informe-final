let showingLogin = true;

function toggleForms() {
  const formSlider = document.querySelector('.form-slider');
  const loginForm = document.getElementById('login-form');
  const registerForm = document.getElementById('register-form');
  const background = document.getElementById('background');

  if (showingLogin) {
    // Cambiamos a vista de registro
    formSlider.style.left = 'calc(100% - 510px)'; // Mueve el cuadro a la derecha
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
    background.classList.add('register-bg');
  } else {
    // Cambiamos a vista de login
    formSlider.style.left = '130px'; // Posición para el login
    registerForm.style.display = 'none';
    loginForm.style.display = 'block';
    background.classList.remove('register-bg');
  }
  showingLogin = !showingLogin;
}

/* --- Control de estado inicial basado en el parámetro "registro" --- */

const urlParams = new URLSearchParams(window.location.search);
const registroStatus = urlParams.get('registro');

if (registroStatus) {
  // Si existe, es decir, si viene de un registrar.php (por ejemplo, registro exitoso)
  // se muestra la vista de registro de forma estática
  showingLogin = false; // Estado = registro
  const formSlider = document.querySelector('.form-slider');
  const loginForm = document.getElementById('login-form');
  const registerForm = document.getElementById('register-form');
  const background = document.getElementById('background');

  loginForm.style.display = 'none';
  registerForm.style.display = 'block';
  formSlider.style.left = 'calc(100% - 510px)';
  background.classList.add('register-bg');
} else {
  // Estado por defecto: vista de login
  showingLogin = true;
  const formSlider = document.querySelector('.form-slider');
  const loginForm = document.getElementById('login-form');
  const registerForm = document.getElementById('register-form');
  const background = document.getElementById('background');

  loginForm.style.display = 'block';
  registerForm.style.display = 'none';
  formSlider.style.left = '130px';
  background.classList.remove('register-bg');
}
