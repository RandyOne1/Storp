function toggleMenu2() {
    const userMenu = document.getElementById('userMenu');
    userMenu.classList.toggle('active');
  }

  document.addEventListener('click', function(event) {
    const userMenu = document.getElementById('userMenu');
    const userAvatar = document.getElementById('userAvatar');

    if (userMenu.classList.contains('active') && !userAvatar.contains(event.target)) {
      userMenu.classList.remove('active');
    }
  });

  function toggleMenu3() {
    const userMenu = document.getElementById('notification-menu');
    userMenu.classList.toggle('active');
  }

  document.addEventListener('click', function(event) {
    const userMenu = document.getElementById('notification-menu');
    const userAvatar = document.getElementById('notifibell');

    if (userMenu.classList.contains('active') && !userAvatar.contains(event.target)) {
        userMenu.classList.remove('active');
    }

  });
