<?php
$id = $_GET['id'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jawab Detail</title>

<style>
body {
  font-family: Arial, sans-serif;
  background: linear-gradient(135deg,#667eea,#764ba2);
  margin:0;
  padding:15px;
}

/* CENTER CONTAINER */
.container {
  max-width:750px;
  margin:auto;
}

/* CARD */
.card {
  background:white;
  border-radius:12px;
  padding:20px;
  box-shadow:0 5px 20px rgba(0,0,0,0.15);
}

/* TITLE */
h2 {
  margin-top:0;
  color:#333;
}

/* SOAL BOX */
.soal-box {
  background:#f8f9fa;
  padding:15px;
  border-radius:10px;
  margin-bottom:15px;
  line-height:1.7;
  white-space:pre-line;

  border-left:5px solid #667eea;
}

/* META */
.meta {
  font-size:13px;
  color:#666;
  margin-bottom:15px;
}

/* LABEL */
label {
  font-weight:bold;
  display:block;
  margin-bottom:8px;
  color:#444;
}

/* TEXTAREA */
textarea {
  width:100%;
  min-height:220px;
  padding:12px;
  border-radius:10px;
  border:1px solid #ccc;
  font-size:14px;
  line-height:1.6;
  resize:vertical;
  box-sizing:border-box;
}

/* BUTTON */
button {
  width:100%;
  margin-top:15px;
  padding:12px;
  background:#667eea;
  color:white;
  border:none;
  border-radius:8px;
  font-size:15px;
  cursor:pointer;
  transition:0.2s;
}

button:hover {
  background:#5563d6;
}

/* BACK BUTTON */
.back {
  margin-bottom:10px;
  display:inline-block;
  padding:8px 12px;
  background:#444;
  color:white;
  border-radius:6px;
  text-decoration:none;
  font-size:14px;
}

.back:hover {
  background:#222;
}

/* MOBILE */
@media (max-width:600px){
  .card {
    padding:15px;
  }

  textarea {
    min-height:180px;
  }
}
</style>
</head>

<body>

<div class="container">

  <a class="back" href="jawab_soal.php">← Kembali</a>

  <div class="card">

    <h2>Detail Soal</h2>

    <div id="soal" class="soal-box">Loading soal...</div>

    <div id="meta" class="meta"></div>

    <label>Jawaban Anda</label>
    <textarea id="jawaban" placeholder="Tulis jawaban kamu di sini..."></textarea>

    <button onclick="kirim()">Kirim Jawaban</button>

  </div>
</div>

<script>
const URL = "https://script.google.com/macros/s/AKfycbw68aPZL-ZfP_poqXvuGSHYpoWWLKEE8wm0p-uv8q8uXcVSQ3EzE3WMwrPDKa9lYDHh/exec";
const id = "<?= $id ?>";

let data = null;

// LOAD DATA
fetch(URL + "?type=tugas")
.then(r => r.json())
.then(res => {

  data = res.find(d => d.id == id);

  if(!data){
    document.getElementById("soal").innerHTML = "Soal tidak ditemukan";
    return;
  }

  // SOAL
  document.getElementById("soal").innerHTML = data.question;

  // META
  document.getElementById("meta").innerHTML = `
    Tanggal: <b>${data.date || '-'}</b>
  `;

  // JAWABAN LAMA (jika ada)
  if(data.answer){
    document.getElementById("jawaban").value = data.answer;
  }
});

// KIRIM
function kirim(){
  const answer = document.getElementById("jawaban").value.trim();

  if(!answer){
    alert("Jawaban tidak boleh kosong!");
    return;
  }

  fetch(URL,{
    method:"POST",
    headers:{ "Content-Type":"text/plain;charset=utf-8" },
    body: JSON.stringify({
      type:"tugas",
      action:"answer_tugas",
      id:id,
      answer:answer
    })
  })
  .then(res => res.text())
  .then(() => {
    alert("Jawaban berhasil dikirim!");
    window.location.href = "jawab_soal.php";
  });
}
</script>

</body>
</html>