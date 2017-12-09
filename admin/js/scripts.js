tinymce.init({ selector:'textarea' });

if (!!document.getElementById('allCheckboxes')) {
  document.getElementById('allCheckboxes').addEventListener('click', function() {
    var checkboxes = document.getElementsByClassName('checkboxes');
    if (this.checked) {
      for (var i=0; i<checkboxes.length; i++) {
        checkboxes[i].setAttribute('checked', true);
      }
    } else {
      for (var i=0; i<checkboxes.length; i++) {
        checkboxes[i].removeAttribute('checked');
      }
    }
  });
}
