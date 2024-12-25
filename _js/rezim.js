
if (!Cookies.get('theme_manual') || Cookies.get('theme') == null) {
  Cookies.set('theme', (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) ? "dark" : "light");
  // document.getElementById('thema_url').href = (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) ? "/_css/bootstrap-dark.css" : "/_css/bootstrap-light.css";
}

document.addEventListener("DOMContentLoaded", function () {
  if (Cookies.get("theme") == 'dark') {
    document.getElementById('fgztD_slider').checked = false;

  } else {
    document.getElementById('fgztD_slider').checked = true;

  }
});

function nastavittema() {
  var checkBox = document.getElementById('fgztD_slider');
  if (checkBox.checked == true) {
    Cookies.set("theme_manual", true);
    Cookies.set("theme", 'light');
    document.querySelector('body').classList.add('light-mode');
    document.querySelector('body').classList.remove('dark-mode');

    document.querySelector('.navbar').classList.add('navbar-light');
    document.querySelector('.navbar').classList.remove('navbar-dark');

    document.querySelector('.main-sidebar').classList.add('sidebar-light-primary');
    document.querySelector('.main-sidebar').classList.remove('sidebar-dark-primary');
  } else {
    Cookies.set("theme_manual", true);
    Cookies.set("theme", 'dark');

    document.querySelector('body').classList.add('dark-mode');
    document.querySelector('body').classList.remove('light-mode');

    document.querySelector('.navbar').classList.add('navbar-dark');
    document.querySelector('.navbar').classList.remove('navbar-light');

    document.querySelector('.main-sidebar').classList.add('sidebar-dark-primary');
    document.querySelector('.main-sidebar').classList.remove('sidebar-light-primary');
  }
}