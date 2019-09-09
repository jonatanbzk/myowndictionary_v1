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

////////////////////////////////////////////
///////////////////////////////////////////


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
            }
        );
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





////////////////////////////////////////////
////////////////////////////////////////////

/*
var tr = document.getElementById("trHide1");
var check = document.getElementById("checkboxId1");
check.onchange = function() {
    if(check.checked)
    {
      tr.style.display = 'contents';
    }
    else
    {
      tr.style.display = 'none';
    }
};
*/
// show tr change/erase word
/*
for (var i = 1; i <= lengthWordList; i++)
{
var trId = 'trHide' + i;
var checkId = 'checkboxId' + i;
var tr = document.getElementById(trId);
var check = document.getElementById(checkId);
check.onchange = function() {
    if(check.checked)
    {
      tr.style.display = 'contents';
    }
    else
    {
      tr.style.display = 'none';
    }
};
}
*/
