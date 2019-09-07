function toggleForm(f, b) {
  var form = document.getElementById(f);
  var button = document.getElementById(b);
  if(form.style.display == 'none')
  {
    form.style.display = 'block';
    button.style.display = 'none';
  }
  else
  {
    form.style.display = 'none';
    button.style.display = 'block';
  }
}

document.getElementById("colorSelect").addEventListener("change", function (e) {
document.body.style.backgroundColor = e.target.value;
});
