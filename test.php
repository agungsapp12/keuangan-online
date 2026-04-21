<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tugas Essay</title>

<style>
body {
  font-family: Arial;
  background: linear-gradient(135deg,#667eea,#764ba2);
  padding:20px;
}
.container {
  max-width:800px;
  margin:auto;
}
.card {
  background:white;
  padding:20px;
  border-radius:10px;
  margin-bottom:20px;
}
textarea {
  width:100%;
  padding:10px;
  margin-top:10px;
  border-radius:6px;
  border:1px solid #ccc;
}
button {
  margin-top:10px;
  padding:10px;
  border:none;
  background:#667eea;
  color:white;
  border-radius:6px;
  cursor:pointer;
}
button:hover {
  opacity:0.9;
}
.item {
  background:#f5f5f5;
  padding:15px;
  margin-top:10px;
  border-radius:10px;
}

/* Tombol Back */
.back-btn {
  background:#444;
}
</style>
</head>

<body>

<div class="container">

<!-- BUTTON BACK -->
<div style="margin-bottom:15px;">
  <button class="back-btn" onclick="goBack()">⬅ Kembali</button>
</div>

<div class="card">
<h2>Tambah Soal</h2>
<textarea id="question" placeholder="Tulis soal..."></textarea>
<button onclick="addTugas()">Tambah</button>
</div>

<div class="card">
<h2>List Soal</h2>
<div id="list"></div>
</div>

</div>

<script>
const URL = "https://script.google.com/macros/s/AKfycbw68aPZL-ZfP_poqXvuGSHYpoWWLKEE8wm0p-uv8q8uXcVSQ3EzE3WMwrPDKa9lYDHh/exec";

/* ================= BACK ================= */
function goBack(){
  window.location.href = "index.php";
}

/* ================= LOAD DATA ================= */
function loadTugas(){
  fetch(URL + "?type=tugas")
  .then(res => res.json())
  .then(data => {
    console.log("DATA:", data);
    render(data);
  })
  .catch(err => {
    console.error("ERROR LOAD:", err);
    alert("Gagal load data");
  });
}

/* ================= RENDER ================= */
function render(data){
  const list = document.getElementById("list");
  list.innerHTML = "";

  if(!data || data.length === 0){
    list.innerHTML = "<p>Belum ada soal</p>";
    return;
  }

  data.forEach(t => {
    list.innerHTML += `
    <div class="item">
      <b>${t.question}</b><br>
      <small>${t.date}</small><br><br>

      <textarea id="ans_${t.id}" placeholder="Jawaban...">${t.answer || ""}</textarea>
      <button onclick="jawab(${t.id})">Kirim Jawaban</button>
    </div>`;
  });
}

/* ================= TAMBAH SOAL ================= */
function addTugas(){
  const question = document.getElementById("question").value;

  if(!question){
    alert("Soal tidak boleh kosong!");
    return;
  }

  console.log("KIRIM:", question);

  fetch(URL,{
    method:"POST",
    headers:{
      "Content-Type":"text/plain;charset=utf-8"
    },
    body: JSON.stringify({
      type:"tugas",
      action:"create_tugas",
      question:question
    })
  })
  .then(res => res.text())
  .then(res => {
    console.log("RESP:", res);

    if(res.includes("error")){
      alert(res);
      return;
    }

    alert("Soal berhasil ditambahkan!");
    document.getElementById("question").value = "";
    loadTugas();
  })
  .catch(err => {
    console.error("ERROR POST:", err);
    alert("Gagal kirim data!");
  });
}

/* ================= JAWAB ================= */
function jawab(id){
  const answer = document.getElementById("ans_" + id).value;

  if(!answer){
    alert("Jawaban kosong!");
    return;
  }

  fetch(URL,{
    method:"POST",
    headers:{
      "Content-Type":"text/plain;charset=utf-8"
    },
    body: JSON.stringify({
      type:"tugas",
      action:"answer_tugas",
      id:id,
      answer:answer
    })
  })
  .then(res => res.text())
  .then(res => {
    console.log("RESP JAWAB:", res);

    if(res.includes("error")){
      alert(res);
      return;
    }

    alert("Jawaban tersimpan!");
  })
  .catch(err => {
    console.error(err);
    alert("Error kirim jawaban!");
  });
}

/* INIT */
loadTugas();
</script>

</body>
</html>