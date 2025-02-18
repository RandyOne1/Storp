
function toggleMenu() {
    const sidebar = document.querySelector('.sidebar');
    const menuToggle = document.querySelector('.menu-toggle');

    sidebar.classList.toggle('collapsed');
    menuToggle.classList.toggle('active');
  }

  document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.sidebar');
    const menuToggle = document.querySelector('.menu-toggle');

    if (!sidebar.classList.contains('collapsed') && menuToggle.classList.contains('active')) {
      sidebar.classList.toggle('collapsed');

    }
    else{
        menuToggle.classList.toggle('active');
    }
  });







