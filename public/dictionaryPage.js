function toggleForm(f, b){
  console.log(f);
  console.log(b);
    var form = document.getElementById(f);
    var button = document.getElementById(b);
    if(form.style.display == 'none')
    {
        form.style.display = 'block';
        button.style.display = 'none';
    } else
    {
      form.style.display = 'none';
      button.style.display = 'block';
    }
}

function changeColor() {

}
  document.getElementById("colorSelect").addEventListener("change", function (e) {

    document.body.style.backgroundColor = e.target.value;
    console.log(e.target.value);

});
