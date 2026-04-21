<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vocabulary App</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
  font-family: 'Segoe UI';
  background: linear-gradient(135deg,#667eea,#764ba2);
  padding:20px;
}

.container {
  max-width:900px;
  margin:auto;
}

/* NAV */
.nav {
  display:flex;
  gap:10px;
  margin-bottom:20px;
}

.nav button {
  flex:1;
  padding:12px;
  border:none;
  border-radius:10px;
  cursor:pointer;
  background:white;
}

.nav .active {
  background:#667eea;
  color:white;
}

/* BACK BUTTON */
.back-wrapper {
  margin-bottom:15px;
}
.back-btn {
  padding:10px 15px;
  border:none;
  border-radius:8px;
  background:#444;
  color:white;
  cursor:pointer;
}

/* CARD */
.card {
  background:white;
  padding:20px;
  border-radius:12px;
}

.hidden {display:none;}

input,textarea {
  width:100%;
  padding:10px;
  margin-top:10px;
  border-radius:8px;
  border:1px solid #ccc;
}

button.submit {
  margin-top:15px;
  width:100%;
  padding:12px;
  background:#667eea;
  color:white;
  border:none;
  border-radius:8px;
}

.item {
  background:#f9f9f9;
  padding:15px;
  margin-top:10px;
  border-radius:10px;
}

.actions button {
  margin-top:10px;
  margin-right:5px;
}
</style>
</head>

<body>

<div class="container">

<!-- BACK BUTTON -->
<div class="back-wrapper">
  <button class="back-btn" onclick="goBack()">⬅ Kembali</button>
</div>

<div class="nav">
  <button id="btnAdd" class="active" onclick="showPage('add')">Add</button>
  <button id="btnView" onclick="showPage('view')">View</button>
</div>

<div id="addPage" class="card">
  <h2 id="formTitle">Add Vocabulary</h2>

  <input id="word" placeholder="Word">
  <input id="meaning" placeholder="Meaning">
  <textarea id="example" placeholder="Example"></textarea>

  <button class="submit" onclick="submitData()">Save</button>
</div>

<div id="viewPage" class="card hidden">
  <h2>Vocabulary List</h2>
  <div id="list"></div>
</div>

</div>

<script>
const URL = "https://script.google.com/macros/s/AKfycbyykyAjKUG-QDEhcfqMllTsO3kASj7OwWRMLaPDiS6DEFv76qDd3uHmM0Am7ZBDDFTf/exec";

let editId = null;
let dataList = [];

/* BACK */
function goBack(){
  window.location.href = "index.php";
}

function showPage(page){
  addPage.classList.add("hidden");
  viewPage.classList.add("hidden");

  btnAdd.classList.remove("active");
  btnView.classList.remove("active");

  if(page==='add'){
    addPage.classList.remove("hidden");
    btnAdd.classList.add("active");
  } else {
    viewPage.classList.remove("hidden");
    btnView.classList.add("active");
    loadData();
  }
}

function submitData(){
  const word = document.getElementById("word").value;
  const meaning = document.getElementById("meaning").value;
  const example = document.getElementById("example").value;

  const action = editId ? "update" : "create";

  fetch(URL,{
    method:"POST",
    headers: {
      "Content-Type": "text/plain;charset=utf-8"
    },
    body: JSON.stringify({
      action,
      id: editId,
      word,
      meaning,
      example
    })
  }).then(()=>{
    alert(editId ? "Updated!" : "Saved!");
    resetForm();
  });
}

function loadData(){
  fetch(URL)
  .then(res=>res.json())
  .then(data=>{
    dataList = data;
    render();
  });
}

function render(){
  list.innerHTML="";

  dataList.forEach(item=>{
    list.innerHTML+=`
      <div class="item">
        <b>${item.word}</b><br>
        ${item.meaning}<br>
        <i>${item.example||""}</i>

        <div class="actions">
          <button onclick="edit(${item.id})">Edit</button>
          <button onclick="del(${item.id})">Delete</button>
        </div>
      </div>
    `;
  });
}

function edit(id){
  const item = dataList.find(i=>i.id==id);

  word.value=item.word;
  meaning.value=item.meaning;
  example.value=item.example;

  editId=id;
  formTitle.innerText="Edit Vocabulary";

  showPage('add');
}

function del(id){
  if(!confirm("Delete data?")) return;

  fetch(URL,{
    method:"POST",
    headers: {
      "Content-Type": "text/plain;charset=utf-8"
    },
    body: JSON.stringify({
      action:"delete",
      id:id
    })
  }).then(()=>loadData());
}

function resetForm(){
  word.value="";
  meaning.value="";
  example.value="";
  editId=null;
  formTitle.innerText="Add Vocabulary";
}
</script>

</body>
</html>