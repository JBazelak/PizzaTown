function smoothScroll(targetId, event) {
  const targetElement = document.getElementById(targetId);

  if (targetElement) {
    event.preventDefault();
    targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}

function smoothScrollD(target, event) {
  event.preventDefault();

  var targetElement = document.getElementById(target);

  if (targetElement) {
    window.scrollTo({
      top: targetElement.offsetTop,
      behavior: 'smooth'
    });
  }
}

document.querySelectorAll('.dropdown-option').forEach(function (item) {
  item.addEventListener('click', function (event) {
    var target = this.getAttribute('href').substring(1);
    smoothScroll(target, event);
  });
});

