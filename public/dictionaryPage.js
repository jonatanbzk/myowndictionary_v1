// Show/Hide element
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


// change background color
document.getElementById("colorSelect").addEventListener("change", function (e) {
document.body.style.backgroundColor = e.target.value;
var color = e.target.value;
localStorage.setItem('color', color);
});
window.onload = function() {
    var color = localStorage.getItem('color');
    if(color !== undefined){
      var data = localStorage.getItem('color');
         document.body.style.backgroundColor = data;
    }
  }


// keep dictionary words list open when window refresh event
    document.getElementById('show_words_button').addEventListener("click", function(event){
      localStorage.setItem('wordsList', true);
    });
    document.getElementById('hide_words_button').addEventListener("click", function(event){
      localStorage.setItem('wordsList', false);
    });
    document.getElementById('logOutButton').addEventListener("click", function(event){
    sessionStorage.removeItem('wordsList');
    });
//  Essai methode 1 basique /////////////////////////////
window.addEventListener('DOMContentLoaded', function() {             //  load
    var show = localStorage.getItem('wordsList');
    console.log(show + "B");
    if(show === 'true'){
         document.getElementById('show_words_div').style.display = "block";
         document.getElementById('show_words_button').style.display = "none";
    }
    else if (show === 'false') {
      document.getElementById('show_words_div').style.display = "none";
    }
});


// show form to edit/erase word when checkbox is checked
var element=[];
    for (var i = 1; i <= lengthWordList; i++)     //lengthWordList
    {
      var trId = 'trHide' + i;
      var checkId = 'checkboxId' + i;
      console.log(trId);
      element.push(
      {
        tr:document.getElementById(trId),
        check:document.getElementById(checkId),
        event:function(){}
      });
      console.log(element[(i-1)]);
      element[(i-1)].check.setAttribute('element',(i-1));
      element[(i-1)].event = element[(i-1)].check.onchange = function() {
      var valor = this.getAttribute('element');
      if(element[valor].check.checked)
      {
        element[valor].tr.style.display = 'contents';
      }
      else
      {
        element[valor].tr.style.display = 'none';
      }
      };
    }
