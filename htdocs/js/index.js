//SIDE NAV
/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "0";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}


// TEXTAREA FOR INDEX.PHP (add new post)
let textareas = document.querySelectorAll('.txta'),
    hiddenDiv = document.createElement('div'),
    content = null;

for (let j of textareas) {
    j.classList.add('txtstuff');
}
hiddenDiv.classList.add('txta');
hiddenDiv.style.display = 'none';
hiddenDiv.style.whiteSpace = 'pre-wrap';
hiddenDiv.style.wordWrap = 'break-word';
for(let i of textareas) {
    (function(i) {
        i.addEventListener('input', function() {
            i.parentNode.appendChild(hiddenDiv);
            i.style.resize = 'none';
            i.style.overflow = 'hidden';
            content = i.value;
            content = content.replace(/\n/g, '<br>');
            hiddenDiv.innerHTML = content + '<br style="line-height: 3px;">';
            hiddenDiv.style.visibility = 'hidden';
            hiddenDiv.style.display = 'block';
            i.style.height = hiddenDiv.offsetHeight + 'px';
            hiddenDiv.style.visibility = 'visible';
            hiddenDiv.style.display = 'none';
        });
    })(i);
}

// HIDE SHOW PASSWORD LOGIN()
function myFunction() {
    var x = document.getElementById("showPass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function unFollow() {
    var answer = window.confirm("Save data?")
    if (answer) {
        //some code
    }
    else {
        //some code
    }
}