function swser(){
    var rdivstats = document.getElementById('rdivstats');
    var rdivservices = document.getElementById('rdivservices');
    rdivservices.style.display = 'block';
    rdivstats.style.display = 'none';
}
function swint(){
    var rdivstats = document.getElementById('rdivstats');
    var rdivservices = document.getElementById('rdivservices');
    var rdiv2 = document.getElementById('min_transacdiv');
    rdiv2.style.display = 'block';
    rdivservices.style.display = 'none';
    rdivstats.style.display = 'block'; 
}
function swinvback(){
    var rdivinven = document.getElementById('rdivinven');
    var rdivservices = document.getElementById('rdivservices');
    rdivservices.style.display = 'block';
    rdivinven.style.display = 'none';
}
function swinvfor(){
    var rdivinven = document.getElementById('rdivinven');
    var rdivservices = document.getElementById('rdivservices');
    var rdiv2 = document.getElementById('min_transacdiv');
    rdiv2.style.display = 'none';
    rdivservices.style.display = 'none';``
    rdivinven.style.display = 'block';
}
function swinvfor(){
    var rdivinven = document.getElementById('rdivinven');
    var rdivservices = document.getElementById('rdivservices');
    var rdiv2 = document.getElementById('min_transacdiv');
    rdiv2.style.display = 'none';
    rdivservices.style.display = 'none';
    rdivinven.style.display = 'block';
}
function swiaddnvfor(){
    var rdivinven = document.getElementById('rdivinven');
    var rdivaddinven = document.getElementById('rdivaddinven');
    rdivaddinven.style.display = 'block';
    rdivinven.style.display = 'none';
}
function swiaddnvback(){
    var rdivinven = document.getElementById('rdivinven');
    var rdivaddinven = document.getElementById('rdivaddinven');
    rdivaddinven.style.display = 'none';
    rdivinven.style.display = 'block';
}

function swiremnvfor(){
    var rdivinven = document.getElementById('rdivinven');
    var rdivreminven = document.getElementById('rdivreminven');
    rdivreminven.style.display = 'block';
    rdivinven.style.display = 'none';
}

function swiremnvback(){
    var rdivinven = document.getElementById('rdivinven');
    var rdivreminven = document.getElementById('rdivreminven');
    rdivreminven.style.display = 'none';
    rdivinven.style.display = 'block';
}

function manageuserfor(){
    var rdivusers = document.getElementById('rdivusers');
    var rdivservices = document.getElementById('rdivservices');
    var rdiv2 = document.getElementById('min_transacdiv');
    rdiv2.style.display = 'none';
    rdivusers.style.display = 'block';
    rdivservices.style.display = 'none';
}
function manageuserback(){
    var rdivusers = document.getElementById('rdivusers');
    var rdivservices = document.getElementById('rdivservices');
    rdivusers.style.display = 'none';
    rdivservices.style.display = 'block';
}

function managecstmrfor(){
    var rdivcstmr = document.getElementById("cstmr_db");
    var rdivservices = document.getElementById('rdivservices');
    var rdiv2 = document.getElementById('min_transacdiv');
    rdiv2.style.display = 'none';
    rdivservices.style.display ="none";
    rdivcstmr.style.display= "block";
}

function managecstmrback(){
    var rdivcstmr = document.getElementById("cstmr_db");
    var rdivservices = document.getElementById('rdivservices');
    rdivservices.style.display ="block";
    rdivcstmr.style.display= "none";
}
function fdbfor(){
    var rdivfdb = document.getElementById("fdb");
    var rdivservices = document.getElementById('rdivservices');
    var rdiv2 = document.getElementById('min_transacdiv');
    rdiv2.style.display = 'none';
    rdivservices.style.display ="none";
    rdivfdb.style.display= "block";
}
function fdbback(){
    var rdivfdb = document.getElementById("fdb");
    var rdivservices = document.getElementById('rdivservices');
    rdivservices.style.display ="block";
    rdivfdb.style.display= "none";
}
function tddbfor(){
    var rdivtddb = document.getElementById("todo_db");
    var rdivservices = document.getElementById('rdivservices');
        var rdiv2 = document.getElementById('min_transacdiv');
    rdiv2.style.display = 'none';
    rdivservices.style.display ="none";
    rdivtddb.style.display= "block";
}
function tddbback(){
    var rdivtddb = document.getElementById("todo_db");
    var rdivservices = document.getElementById('rdivservices');
    rdivservices.style.display ="block";
    rdivtddb.style.display= "none";
}
function mduesfor(){
    var rdivmdues = document.getElementById("mdues");
    var rdivservices = document.getElementById('rdivservices');
    var rdiv2 = document.getElementById('min_transacdiv');
    rdiv2.style.display = 'none';
    rdivservices.style.display ="none";
    rdivmdues.style.display= "block";
}
function mduesback(){
    var rdivmdues = document.getElementById("mdues");
    var rdivservices = document.getElementById('rdivservices');
    rdivservices.style.display ="block";
    rdivmdues.style.display= "none";
    rdiv2.style.display = 'block';
}
function transac_hist_back(){
    var transac_hist = document.getElementById("transac_hist");
    var rdivservices = document.getElementById('rdivservices');
    rdivservices.style.display ="block";
    transac_hist.style.display= "none";
}

function transac_hist_for(){
    var transac_hist = document.getElementById("transac_hist");
    var rdivservices = document.getElementById('rdivservices');
    var rdiv2 = document.getElementById('min_transacdiv');
    rdiv2.style.display = 'none';
    rdivservices.style.display ="none";
    transac_hist.style.display= "block";
}


function logout(){
    window.location.href= "logout.php";
}

$(document).ready(function() {
    $('#example').DataTable();
} );





function hello(){
    var rem_usrbtn = document.getElementById('ruserbtn');
    var mng_usrbtn = document.getElementById('muserbtn');
    var usr_iframe = document.getElementById('add_usrframe');

    if(rem_usrbtn.checked){
        usr_iframe.src = "addusr.php";
        alert('Hello')
    }else if(ocument.getElementById('muserbtn').checked == true){
        usr_iframe.src = "inventable.php";
    }else{
        usr_iframe.src = "index.php";
    }

}